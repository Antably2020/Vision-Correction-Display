import cv2
import numpy as np
import scipy as sc
import math
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


class CompositeRGB:

    def __init__(self,num=0000,MAX = 0,GAMMA=2.2):
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
        
        max(LF[:])
        
        LF_RGB=np.zeros(Display.screen_pixels*Display.Angular_HRes, Display.screen_pixels*Display.Angular_HRes,3)
        
        for ch in range(3):
            
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
     
