import numpy as np
import math
import scipy.io as sc
import os
import cv2
from scipy import sparse

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
        return(self.screen_pitch()*self.screen_pixels)     
         
    def sampling(self):
        x = np.zeros((self.resolution(),1))
        S = np.linspace(-self.size()/2, self.size()/2, self.resolution()+1)
        for i in range(len(S)-1):
            x[i] = (S[i] + S[i+1])/2
        return x;           

class Camera:
    Do=250 #distance between camera and screen
    def _init_(self,f,fStop,focus,resolution,display):
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
        S = np.linspace(self.sensor_width(self.Do,self.display.size())/2, -self.sensor_width(self.Do,self.display.size())/2, self.resolution+1)
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
                BVals=np.zeros((Z+2,1))
                for i in range(int(math.floor((self.nView - 1)/2) + 1 + self.nView*(self.XtraPix-1)/2)+1):
                    BVals[i,0] = math.atan( (self.SPP/2 + self.SPP*(i-1))/self.Depth  )/math.pi*180
                BVals = [[-np.flipud(BVals), BVals]] 
                return BVals

class BackwardTransport:
    def __init__(self,offset,Bvals,Display, Camera,Vs,Do,XtraPix):
        self.offset=offset
        self.Bvals=Bvals
        self.Display=Display
        self.Camera=Camera
        self.Vs=Vs
        self.Do=Do
        self.xtrapix=XtraPix

    def dsearchn(x, v):
        return np.where(np.abs(x-v) == np.abs(x-v).min())[0]   


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
            #Yo[:,j] = BackwardTransport.dsearchn(display_sampling,Yo[:,j]) 
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
        return Vo

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

        ind_r = np.zeros(37359783)
        print(ind_r.shape)
        ind_c = np.zeros(37359783)
        val_s = np.zeros(37359783)
        index=0
        #camera = Camera(50,8,375,128)
        #display = Display(5,0.078,128,12)
        Vs = np.linspace(-camera.aperture()/2,camera.aperture()/2,int((camera.aperture()*20)+1)) # used in matrix length,concatination
        Us = np.linspace(-camera.aperture()/2,camera.aperture()/2,int((camera.aperture()*20)+1)) # used in matrix length,concatination
        
        
        us, vs =np.meshgrid(Us,Vs)
        Z = np.zeros(np.shape(us))               
        Z [us**2 + vs**2 < (self.camera.aperture()/2)**2 ] = 1
        HBVals = self.angular.Angular_BoundaryExt2()
        #VBVals = self.angular.Angular_BoundaryExt2()
        
      
        #BackwardTransport(self.Epsilon_y, HBVals, display, camera, Vs, self.Do, self.angular.XtraPix)
        #BackwardTransport(self.Epsilon_x, VBVals, display, camera, Us, self.Do, self.angular.XtraPix)
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
           #print('Progress = %3.0f %%', j/self.camera.resolution*100)
            for i in range(0,self.camera.resolution):

                xo, yo = np.meshgrid(Yo[:,j], Xo[:,i])          
                pixels = np.array([yo.reshape(-1),xo.reshape(-1)]).transpose()
                uo, vo = np.meshgrid(Uo[:,j] , Vo[:,i])
                angles = np.array([vo.reshape(-1),uo.reshape(-1)]).transpose()
        
                
                samples = np.concatenate([pixels, angles],1)
                
                samples = samples[Z.reshape(-1) != 0,:]
            
                w = np.shape(samples)[0]
                b, n= np.unique(samples,return_index= True,axis = 0)
                X0 = np.ones((len(n),1))
                CELL =np.concatenate([b, X0],1)   
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
        print(ind_r.shape)   
        print(ind_c.shape)  
        print(val_s.shape)  
        print('start making sparse system matrix')
        A = sparse.coo_matrix((val_s,(ind_r,ind_c)),(self.camera.resolution**2,self.display.resolution()**2 * 25)).toarray()
       #(37359783,self.display.resolution()**2 * 25)
        return A
        
class CompositeRGB:

    def __init__(self,num,MAX,GAMMA):
        self.num=num
        self.MAX=MAX
        self.GAMMA=GAMMA
        
    def Composite(self,LF):
        Factor=1 #size/resolution factor base is 128
        chR=sc.loadmat('output/CONTRAST_1.000000_Channel_1.mat')
        LF_R = LF
        chG=sc.loadmat('output/CONTRAST_1.000000_Channel_2.mat')
        LF_G = LF
        chB=sc.loadmat('output/CONTRAST_1.000000_Channel_3.mat')
        LF_B = LF
        
        m,n=len(LF_R)
        Collector=np.zeros(m,n,3)
        Collector[:,:,1]=LF_R/self.MAX
        Collector[:,:,2]=LF_G/self.MAX
        Collector[:,:,3]=LF_B/self.MAX
        np.savetxt("foo.csv", Collector, delimiter=",")
        
        os.chdir('output/Composite_Code')
        max(LF[:])
        
        LF_RGB=np.zeros(Display.screen_pixels*Display.Angular_HRes, Display.screen_pixels*Display.Angular_HRes,3)
        
        for ch in range(1,3):
            
            IMG=Collector[:,:,ch]
            ROWS=(Display.screen_pixels+Display.padding)*Factor
            COLS=(Display.screen_pixels+Display.padding)*Factor
            IMGS=np.zeros(ROWS,COLS,Display.Angular_HRes*Display.Angular_HRes)
            for r in range (1,ROWS):
                for c in range(1,COLS):
                    index= ((r-1)*COLS+ c-1)*Display.Angular_HRes*Display.Angular_HRes
                    IMGS[c,r,:]=IMG[index+1:index+Display.Angular_HRes*Display.Angular_HRes]
                    
            IMG_LF=np.zeros(ROWS,COLS,Display.Angular_HRes*Display.Angular_HRes)
            for i in range(1,Display.Angular_HRes*Display.Angular_HRes):
                R=np.mod(i-1,Display.Angular_HRes)+1
                C=math.floor((i-1)/Display.Angular_HRes)+1
            
                viewNum=(R-1)*Display.Angular_HRes+C
                target=IMGS[:,:,i]
                IMG_LF[:,:,viewNum]=target
            IMG_H=np.zeros(ROWS,COLS*Display.Angular_HRes,Display.Angular_HRes)
            for i in range(1,Display.Angular_HRes):
                comp=Composite5(IMG_LF[:,:,(i-1)*5+1], IMG_LF[:,:,(i-1)*5+2], IMG_LF[:,:,(i-1)*5+3], IMG_LF[:,:,(i-1)*5+4], IMG_LF[:,:,(i-1)*5+5])
                IMG_H[:,:,i]=comp.comp5()
            if(Display.Angular_HRes==5):
                comp=Composite5(IMG_H[:,:,1], IMG_H[:,:,2], IMG_H[:,:,3], IMG_H[:,:,4], IMG_H[:,:,5])
                IMG_V=comp.comp5()
            
            LF=IMG_V
        
            if(Display.padding !=0):
                s=(Display.padding/2*Factor)*Display.Angular_HRes+1
                e=(Display.padding/2+Display.screen_pixels)*Factor*Display.Angular_HRes
                LF=LF[s:e,s:e,:]
        
            LF=LF**(1/self.GAMMA)
            m,n=len(LF)
            img=np.zeros(m,n,1)
            LF_RGB[:,:,ch]=LF
        
        cv2.imwrite(LF_RGB,'output/LF_RGB_04d.png' )
    
class Composite5:
    def __init__(self,L2,L1,M,R1,R2):
        self.L2=L2
        self.L1=L1
        self.M=M
        self.R1=R1
        self.R2=R2
    def comp5(self):
        m,n=len(self.L1)
        ret=np.zeros(m,n*5)
        for i in range(1,n):
            ret[:,(n-1)*5+1] = self.R2[:,n]
            ret[:,(n-1)*5+2] = self.R1[:,n]
            ret[:,(n-1)*5+3] = self.M[:,n]
            ret[:,(n-1)*5+4] = self.L1[:,n]
            ret[:,(n-1)*5+5] = self.L2[:,n]
            
        
        
        

    
         
        


display=Display(5,0.078,128,12)
camera=Camera(50,8,375,128,display)

#print (np.shape(xx.sampling()))

#Vs = np.linspace(-yy.aperture()/2,yy.aperture()/2,int((yy.aperture()*20)+1)) # used in matrix length,concatination
#xjj = BackwardTransport(0,0,xx,yy,Vs,250,0)
#print(xjj.BackwardTransportExt3())
img = cv2.imread('D:/MIU/Graduation Project/Code/supplement/CODE/images/original/0084.png', cv2.IMREAD_UNCHANGED)  # Fill in the image read function here
print(np.shape(img))
##scale image to camera resolution
dim = (int(np.shape(img)[0]*camera.resolution/np.shape(img)[1]),int(np.shape(img)[1]*camera.resolution/np.shape(img)[1]))
IMG = cv2.resize(img,dim)
print(np.shape(IMG))
CONTRAST            = 1.0
BIAS                = (1-CONTRAST)/CONTRAST;    
rows, cols, color = np.shape(img)
REC                 = np.zeros((rows, cols, color))
num = 0

#cv2.imshow('original',img)
#cv2.waitKey(0)
#cv2.destroyAllWindows()
