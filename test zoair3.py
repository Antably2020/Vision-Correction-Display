from tkinter.tix import CELL
from turtle import shape
import numpy as np
import math
from scipy import sparse
from dsearchn import dsearchn as ds
class Display:
    def __init__(self,Angular_HRes,screen_pixel_pitch,screen_pixels,padding,depth):
        self.Angular_HRes=Angular_HRes
        self.screen_pixel_pitch=screen_pixel_pitch
        self.screen_pixels=screen_pixels
        self.padding=padding
        self.depth=depth

    def screen_pitch(self):
        return(self.Angular_HRes*self.screen_pixel_pitch)

    def resolution(self):
        return(self.screen_pixels+self.padding)

    def size(self):
        return(self.screen_pitch()*self.resolution())

    def sampling(self):
        x = np.zeros((self.resolution(),1))
        S = np.linspace(-self.size()/2, self.size()/2, self.resolution()+1)
        for i in range(len(S)-1):
            x[i] = (S[i] + S[i+1])/2
        return x;           

class Camera:
    Do=250 #distance between camera and screen
    def __init__(self,f,fStop,focus,resolution,display):
        self.f=f # focal length
        self.fStop=fStop
        self.focus=focus
        self.resolution=resolution
        self.display=display
    def aperture(self):
        return(self.f/self.fStop)
    def di(self):  # distance between camera sensor and lens 
        return(self.f*self.focus/(self.focus-self.f))
    def sensor_width(self,Do,screen_size):
        return (screen_size/Do*self.di())    
    def sampling(self):
        x = np.zeros((self.resolution,1))
        S = np.linspace(self.sensor_width(self.Do,self.display.screen_pitch()*self.display.screen_pixels)/2, -self.sensor_width(self.Do,self.display.screen_pitch()*self.display.screen_pixels)/2, self.resolution+1)
        for i in range(len(S)-1):
            x[i] = (S[i] + S[i+1])/2
        return x; 

class Camera2Screen:
    def __init__(self,X,Y,Do,f,Di):
        self.f=f # focal length
        self.X=X
        self.Y=Y
        self.Do=Do
        self.Di=Di
    def camera2screen(self):
        delta = 1/self.Do + 1/self.Di - 1/self.f # delta rule in transport equation
        T = np.array([[-self.Do/self.Di , self.Do*delta],[ 1/self.Di , 1/self.f-1/self.Di]]) # transport equation
        arr1 = np.array(self.X[:])
        arr2 = np.array(self.Y[:])
        concat = np.concatenate((arr1, arr2))
        R = np.dot(T,concat)
        x = R[0,:][np.newaxis]
        y = R[1,:][np.newaxis]
        x = x.reshape(np.shape(self.X))
        y = y.reshape(np.shape(self.Y))
       
        return x,y

class Angular_Boundary:
        def __init__(self,nView, SPP, Depth, XtraPix):
            self.nView = nView
            self.SPP = SPP
            self.Depth = Depth
            self.XtraPix = XtraPix   
        
        def Angular_BoundaryExt2(self):
            Z=int(self.nView*self.XtraPix/2)
            BVals = []
            if np.mod(self.nView,2) == 0 :
                BVals=np.zeros((Z+1,1))
                for i in range(int(self.nView*self.XtraPix/2)+1):
                    BVals[i,0]=math.atan( self.SPP*i/self.Depth )/math.pi*180
                BVals = [[-np.flipud(BVals), 0, BVals]] 
                return BVals
            elif self.nView == 1:
                BVals=[-90,90]
                return BVals    
            else :
                BVals=np.zeros((int(math.floor(self.nView - 1)/2 + 1 + self.nView*(self.XtraPix-1)/2),1))
                for i in range(int(math.floor(self.nView - 1)/2 + 1 + self.nView*(self.XtraPix-1)/2)):
                    BVals[i] = math.atan( (self.SPP/2 + self.SPP*(i))/self.Depth  )/math.pi*180
                   
                BVals = np.concatenate((-np.flipud(BVals), BVals))
                return BVals


class BackwardTransport:
    def __init__(self,offset,Bvals,Display, Camera,Vs,Do,XtraPix):
        self.offset=offset
        self.Bvals=Bvals
        self.Display=Display
        self.Camera=Camera
        self.Vs=Vs
        self.Do=Do
        self.Xtrapix=XtraPix

   
    def BackwardTransportExt3(self):
        Yo=np.zeros((len(self.Vs),self.Camera.resolution))
        Vo=np.zeros((len(self.Vs),self.Camera.resolution))
        camera_sampling=self.Camera.sampling()
        display_sampling=self.Display.sampling()
        Ang_Res=self.Display.Angular_HRes
        for j in range(self.Camera.resolution):
            #Ys=np.ones(len(self.Vs),1)*self.Camera.sampling(j)
            Yss = np.dot(np.ones((len(self.Vs),1)),camera_sampling[j])
            Ys = Yss[np.newaxis]
           
           
            camera2object = Camera2Screen(Ys,self.Vs[np.newaxis],self.Camera.Do,self.Camera.f,self.Camera.di())
            Yo[:,j],Vo[:,j] = camera2object.camera2screen()
            Vo[:,j]=Vo[:,j]/math.pi*180
            
            
            
            Yo[:,j]=Yo[:,j]+self.offset
            print (Yo[:,j].shape)
            print (display_sampling.shape)
            #print (p)
                     
            Yo[:,j]  = ds(display_sampling,Yo[:,j]) #change Yo[:,j] to P
            
            S=Vo[:,j]
            K=S
            
            if(Ang_Res==1):
                K[:]=1
            else:
                for a in range(1,len(self.Bvals)-1): 
                    K[np.logical_and(S >= self.Bvals[a] , S < self.Bvals[a+1])] = a - Ang_Res * self.Xtrapix +1 

            Vo[:,j]=K
        

        if(Ang_Res!=1):
            Yo[Vo <= Ang_Res*(-self.Xtrapix+1)] = Yo[Vo <= Ang_Res*(-self.Xtrapix+1)] - self.Xtrapix
            for m in range(-self.Xtrapix+1,self.Xtrapix,1):
                Yo[np.logical_and(Vo <= Ang_Res*(m+1) , Vo > Ang_Res*m)] = Yo[np.logical_and(Vo <= Ang_Res*(m+1) , Vo > Ang_Res*m)] + m
        
        Yo[Vo >  Ang_Res*self.Xtrapix] = Yo[Vo >  Ang_Res*self.Xtrapix] + self.Xtrapix
        Vo = ((Vo+Ang_Res-1)%Ang_Res)+1
        return Yo,Vo
    



class BuildMatrix:
    def __init__(self,display,camera,Do, Epsilon_x , Epsilon_y,angular,Backward):
        #self.f=f # focal length
        self.display=display
        self.camera=camera
        self.Do=Do
        self.Epsilon_x=Epsilon_x
        self.Epsilon_y=Epsilon_y
        self.angular = angular
        self.Backward=Backward
    def build_matrix(self):   
        Sampling = 20
        psf_size = 240

        ind_r = np.zeros((self.camera.resolution**2*psf_size*2,1))
        ind_c = np.zeros((self.camera.resolution**2*psf_size*2,1))
        val_s = np.zeros((self.camera.resolution**2*psf_size*2,1))
        
        index=0
        #camera = Camera(50,8,375,128)
        #display = Display(5,0.078,128,12)
        Vs = np.linspace(-camera.aperture()/2,camera.aperture()/2,int((camera.aperture()*20)+1)) # used in matrix length,concatination
        Us = np.linspace(-camera.aperture()/2,camera.aperture()/2,int((camera.aperture()*20)+1)) # used in matrix length,concatination
        
        
        us, vs =np.meshgrid(Us,Vs)
        Z = np.zeros(np.shape(us))               
        Z [us**2 + vs**2 < (self.camera.aperture()/2)**2 ] = 1

        print('start y-v backward transport')
        Yo, Vo = self.Backward.BackwardTransportExt3()

        print('start x-u backward transport')
        Xo, Uo = self.Backward.BackwardTransportExt3()
        ''''''
        Xo[Xo < 1] = 1    
        Xo[Xo > display.resolution()] = display.resolution()
        Yo[Yo < 1] = 1    
        Yo[Yo > display.resolution()] = display.resolution()
        
        print('start sampling and build projection matrix')
        for j in range(0,self.camera.resolution):
#            print('Progress = %3.0f %%', j/self.camera.resolution*100)
            for i in range(0,self.camera.resolution):

                xo, yo = np.meshgrid(Yo[:,j], Xo[:,i])          
                print (Yo)
                exit()
                pixels = np.array([yo.reshape(-1),xo.reshape(-1)]).transpose()
                uo, vo = np.meshgrid(Uo[:,j] , Vo[:,i])
                angles = np.array([vo.reshape(-1),uo.reshape(-1)]).transpose()
        
                
                samples = np.concatenate([pixels, angles],1)
                print(samples)
                exit()
                samples = samples[Z.reshape(-1) != 0,:]
            
                w = np.shape(samples)[0]
                
                b, n= np.unique(samples,return_index= True,axis = 0)
                print ("b size is:", b)
                exit()
                X0 = np.ones((len(n),1))
                CELL =np.concatenate([b, X0],1)   
                Angular_Res=5
                Angular_VRes=Angular_Res
                Angular_HRes=Angular_Res
                               
                
                for r in range(0,b.shape[0]):
                    index0 = i * self.camera.resolution + j
                    index1 = ((CELL[r,1]-1) * self.display.resolution() + (CELL[r,0]-1)) * Angular_VRes*Angular_HRes
                    index2 = (CELL[r,3]-1) * Angular_VRes + CELL[r,2]-1

                    print ("index0 is:",index0)
                    print ("index1 is:",index1)
                    print ("index2 is:",index2)

                    ind_r[index] = index0+1
                    ind_c[index] = index1+index2+1
                    val_s[index] = CELL[r,4]/w 
                    index = index + 1
        #aa = np.concatenate([ind_r, ind_c],1) 
        #aaa = np.concatenate([aa,val_s],1)        
        print(ind_r.shape)   
        print(ind_c.shape)  
        print(val_s.shape)  
        print('start making sparse system matrix')
        #A = sparse.coo_matrix((val_s,(ind_r,ind_c)),(self.camera.resolution**2,self.display.resolution()**2 * 25))
        #(self.camera.resolution**2,self.display.resolution()**2 * 25)
        
        
        
       
        return ind_r,ind_c,val_s
        


display=Display(5,0.078,128,12,5.514)

camera=Camera(50,8,375,128,display)
angular = Angular_Boundary(5, display.screen_pixel_pitch,display.depth , 5)

Vs = np.linspace(-camera.aperture()/2,camera.aperture()/2,int((camera.aperture()*20)+1)) # used in matrix length,concatination
Us = np.linspace(-camera.aperture()/2,camera.aperture()/2,int((camera.aperture()*20)+1)) # used in matrix length,concatination

HBvals= Angular_Boundary(5, display.screen_pixel_pitch, display.depth, 5).Angular_BoundaryExt2()

backword_object = BackwardTransport(0,HBvals,display,camera,Vs,250,angular.XtraPix)

bm = BuildMatrix(display,camera,250,0,0,angular,backword_object)
a,b,c = bm.build_matrix()


#np.savetxt("1.csv",a , delimiter=",")  
  





