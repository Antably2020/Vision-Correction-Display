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
        return(self.screen_pitch()*self.screen_pixels)     
         
    def sampling(self):
        x = np.zeros((self.resolution(),1))
        S = np.linspace(-self.size()/2, self.size()/2, self.resolution()+1)
        for i in range(len(S)-1):
            x[i] = (S[i] + S[i+1])/2
        return x;            
