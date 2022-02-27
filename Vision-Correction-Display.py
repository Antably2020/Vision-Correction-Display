import numpy as np

class Display:
    def __init__(self,angular_res,screen_pixel_pitch,screen_pixels,padding):
        self.angular_res=angular_res
        self.screen_pixel_pitch=screen_pixel_pitch
        self.screen_pixels=screen_pixels
        self.padding=padding


    def screen_pitch(self):
        return(self.angular_res*self.screen_pixel_pitch)

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
    def sensor_width(self,Do,screen_pixels,screen_pitch):
        return (screen_pixels*screen_pitch/Do*self.di())    
    def sampling(self):
        x = np.zeros((self.resolution,1))
        S = np.linspace(self.sensor_width(self.Do,self.display.screen_pixels,self.display.screen_pitch())/2, -self.sensor_width(self.Do,self.display.screen_pixels,self.display.screen_pitch())/2, self.resolution+1)
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

class BuildMatrix:
    def __init__(self,display,camera,Do):
        #self.f=f # focal length
        self.display=display
        self.camera=camera
        self.Do=Do
    def backword_transpose(self):  
        '''
        Sampling = 20
        #camera = Camera(50,8,375,128)
        #display = Display(5,0.078,128,12)
        Vs = np.linspace(-self.camera.aperture()/2,self.camera.aperture()/2,int((self.camera.aperture()*Sampling)+1)) # used in matrix length,concatination
        Yo=np.zeros((len(Vs),self.camera.resolution))
        Vo=np.zeros((len(Vs),self.camera.resolution))
        camera_sampling=self.camera.sampling()

        for i in range(1,self.camera.resolution):
            Yss = np.dot(np.ones((len(Vs),1)),camera_sampling[i])
            Ys = Yss[np.newaxis]
            camera2object = Camera2Screen(Ys,Vs[np.newaxis],self.camera.Do,self.camera.f,self.camera.di())
            Yo[:,i],Vo[:,i] = camera2object.camera2screen()
            Vo[:,i] = Vo[:,i] / (3.14*180)

        return Ys 
        '''  
        Sampling = 20
        #camera = Camera(50,8,375,128)
        #display = Display(5,0.078,128,12)
        Vs = np.linspace(-self.camera.aperture()/2,self.camera.aperture()/2,int((self.camera.aperture()*Sampling)+1)) # used in matrix length,concatination
        Yo=np.zeros((len(Vs),self.camera.resolution))
        Vo=np.zeros((len(Vs),self.camera.resolution))
        camera_sampling=self.camera.sampling()

        for i in range(self.camera.resolution):
            Yss = np.dot(np.ones((len(Vs),1)),camera_sampling[i])
            Ys = Yss[np.newaxis]
            camera2object = Camera2Screen(Ys,Vs[np.newaxis],self.camera.Do,self.camera.f,self.camera.di())
            Yo[:,i],Vo[:,i] = camera2object.camera2screen()
            Vo[:,i] = Vo[:,i] / (3.14*180)

        return Yo 

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
        Ang_Res=self.Display.angular_res
        for j in range(self.Camera.resolution):
            #Ys=np.ones(len(self.Vs),1)*self.Camera.sampling(j)
            Yss = np.dot(np.ones((len(Vs),1)),camera_sampling[j])
            Ys = Yss[np.newaxis]
            camera2object = Camera2Screen(Ys,self.Vs[np.newaxis],self.Camera.Do,self.Camera.f,self.Camera.di())
            Yo[:,j],Vo[:,j] = camera2object.camera2screen()
            Vo[:,j]=Vo[:,j]/(3.14*180)
            Yo[:,j]=Yo[:,j]+self.offset
            #line 12 BackwardTransportExt3 fe matlab
            
            Yo[:,j] = BackwardTransport.dsearchn(display_sampling,Yo[:,j]) 
            #S=Vo[:,j]
            #K=S
        return Yo       
    '''
            if(Ang_Res==1):
                K[:]=1
            else:
                for a in range(1,len(self.Bvals)-1):
                     K=S
                    #line 20 BackwardTransportExt3 fe matlap makan K=S
                #line 23 BackwardTransportExt3 fe matlap
            Vo[:,j]=K
        #if(Ang_Res==1):#approximately equal
            #from 29 to 35 BackwardTransportExt3
    '''
    
xx=Display(5,0.078,128,12)
yy=Camera(50,8,375,128,xx)

#print (np.shape(xx.sampling()))

Vs = np.linspace(-yy.aperture()/2,yy.aperture()/2,int((yy.aperture()*20)+1)) # used in matrix length,concatination
xjj = BackwardTransport(0,0,xx,yy,Vs,250,0)
print(xjj.BackwardTransportExt3())
