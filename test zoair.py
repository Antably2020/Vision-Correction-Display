#import lbfgsb
import spare 
from imshift import *
import cv2 
from turtle import shape
import numpy as np
import math
from scipy.sparse import coo_matrix, csc_matrix
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
            p  = ds(display_sampling,Yo[:,j]) #change Yo[:,j] to P
            Yo[:,j] = p[:,0] 
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
#        camera = Camera(50,8,375,128)
 #       display = Display(5,0.078,128,12)
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
            print('Progress = %d', j/self.camera.resolution*100)
            for i in range(0,self.camera.resolution): 
                xo, yo = np.meshgrid(Yo[:,j], Xo[:,i])          
                pixels = np.array([yo.reshape(-1),xo.reshape(-1)]).transpose()
                uo, vo = np.meshgrid(Uo[:,j] , Vo[:,i])
                angles = np.array([vo.reshape(-1),uo.reshape(-1)]).transpose()
                samples = np.concatenate([pixels, angles],1)
 #               print (self.camera.resolution**2)
#                print (self.display.resolution()**2 * 25) 
#                exit()
                samples = samples[Z.reshape(-1) != 0,:]
            
                w = np.shape(samples)[0]
                
                b, n= np.unique(samples,return_counts=True,axis = 0)
                X0 =n.reshape((len(n),1))
   #             print (b)
  #              print (X0)
                CELL =np.concatenate([b, X0],1)
 #               print (CELL)
#                exit()   
                Angular_Res=5
                Angular_VRes=Angular_Res
                Angular_HRes=Angular_Res
                               
                
                for r in range(0,b.shape[0]):
                    index0 = i * self.camera.resolution + j
                    index1 = ((CELL[r,1]-1) * self.display.resolution() + (CELL[r,0]-1)) * Angular_VRes*Angular_HRes
                    index2 = (CELL[r,3]-1) * Angular_VRes + CELL[r,2]-1
                    ind_r[index] = index0+1
                    ind_c[index] = index1+index2+1
                    val_s[index] = CELL[r,4]/w 
                    index = index + 1
        #aa = np.concatenate([ind_r, ind_c],1) 
        #aaa = np.concatenate([aa,val_s],1)        
        r = ind_r.T
        r = r[0]
  #      print(r)
        c = ind_c.T
        c = c[0]   
 #       print(c)
        s = val_s.T
        s = s[0]  
#        print(s)  
        
        print('start making sparse system matrix')
        A = csc_matrix((s,(r,c)),(815599,815599)).toarray()
#        A = np.reshape(A,(self.camera.resolution**2,self.display.resolution()**2 * 25))
        np.save('sparse',A)
        print (A)        
 #       exit()
      #  return ind_r,ind_c,val_s
#        A = spare.spares(s,r,c,self.camera.resolution**2,self.display.resolution()**2 * 25)
        return A 


#def main():
img = '/Users/rahulkumar/Downloads/kareem/images/Balloon1_256.png'    
Do = 250
    
display=Display(5,0.078,128,12,5.514)
camera=Camera(50,8,375,128,display)
#print (camera)
angular = Angular_Boundary(5, display.screen_pixel_pitch,display.depth , 5)

Vs = np.linspace(-camera.aperture()/2,camera.aperture()/2,int((camera.aperture()*20)+1)) # used in matrix length,concatination
Us = np.linspace(-camera.aperture()/2,camera.aperture()/2,int((camera.aperture()*20)+1)) # used in matrix length,concatination

HBvals= Angular_Boundary(5, display.screen_pixel_pitch, display.depth, 5).Angular_BoundaryExt2()

backword_object = BackwardTransport(0,HBvals,display,camera,Vs,250,angular.XtraPix)

bm = BuildMatrix(display,camera,250,0,0,angular,backword_object)
A1 = bm.build_matrix()
    ############### MY ###################

LAMDA = 0.08
SPEEDY = True
if LAMDA:
   B = sparse.eye(display.resolution()**2*25)*0.08
   A = [A1,B]
   bb = np.zeros((display.resolution()**2*25,1))*0.08
   #A = np.concatenate(A1,B, 1)
if SPEEDY == True:
   A = np.array(A)
   AtA = np.transpose(A)*A;
   print ('Done with ATA')

############################################
img = cv2.imread(img)
#print(img.shape[0]*camera.resolution/img.shape[0])

IMG = cv2.resize(img,(int(img.shape[0]*camera.resolution/img.shape[0]),int(img.shape[1]*camera.resolution/img.shape[0])))    ######****
CONTRAST = 1.0
BIAS = (1-CONTRAST)/CONTRAST
rows = IMG.shape[0]
cols = IMG.shape[1]
color = IMG.shape[2]
REC = np.zeros((rows,cols,color))
num = 0 
optRange = 0

for ch in range(color):
     img = IMG[:,:,ch]
     b = []
#    for offset_y in range(-optRange,optRange,1):
 #       for offset_x in range(-optRange,optRange,1):
     img0 = cv2.resize(imshift(img),(1,img.shape[0]*img.shape[1]))
     print (img0)
     b.append(img0)
     print (b)
#     b = b+BIAS
     if LAMDA:
        b = [b,bb]
        print (b)
        fcn = lambda x: np.linalg.norm(A*x-b)**2
     if SPEEDY == True:
        Ab = A.T*b
        grad = lambda x : 2*(AtA*x-Ab)
     else:
        grad  = lambda x : 2*A.T*(A*x-b)

     l = np.zeros((display.resolution()**2*25,1))
     u = np.ones((display.resolution()**2*25,1))*np.inf

     fun = lambda x : fminunc_wrapper(x,fcn,grade)
     opts = {'factr': 1e3,'pgtol': 1e-6, 'm': 10}
     opts.update({'printEvery':10})
     opts.update({'maxIts':100})
     #opts.update({'xo':np.zeros((display.resolution()**2*25,1))})
     xo = np.zeros((display.resolution()**2*25,1))
     opts['m']= 50

     #tic
     lf, dummy, info = lbfgsb.L_BFGS_B(xo, fcn,grad,l,u)
     maxlf = np.max(LF[:])
     minlf = np.min(LF[:])
     #toc

     rec = A*LF-BIAS
     rec = rec[0:len(img[:])]
     rec = np.reshape(rec, (camera.rsolution,camera.resoluton))
     rec = cv2.imshift(rec,(offsetx/0.5), (offsety/0.5))

     REC[:,:,ch] = rec
     mlf = 1


     if (max(LF[:])) > mlf:
        mlf = max(LF[:])


MAXI = max(IMG[:])
MSE = sum((IMG[:]-REC[:])**2)/len((IMG[:]))
PSNR = np.round (20*log10(MAXI(sqrt(MSE))))
print ('MAXI',MAXI)
print ('MSE', MSE)
print ('PSNR', PSNR)









#np.savetxt("1.csv",a , delimiter=",") 





if __name__ == '__main__':
     main()





