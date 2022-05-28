import math
import numpy as np
import numpy.matlib as mat
from tqdm import tqdm, trange
from scipy import sparse


class Display:
    def __init__(self, angular_res, screen_pixel_pitch, screen_pixels, padding, depth,gamma):
        self.angular_res = angular_res
        self.screen_pixel_pitch = screen_pixel_pitch
        self.screen_pixels = screen_pixels
        self.screen_pitch = angular_res * screen_pixel_pitch
        self.padding = padding
        self.depth = depth
        self.resolution = screen_pixels + padding
        self.screen_size = self.screen_pitch * self.resolution
        self.gamma = gamma
    def sampling(self):
        return sampling(self.screen_size, self.resolution)


class Camera:
    Do = 250  # distance between camera and screen

    def __init__(self, f, fStop, focus, resolution, display):
        self.f = f  # focal length
        self.fStop = fStop
        self.focus = focus
        self.aperture = f / fStop
        self.Di = self.f * self.focus / (self.focus-self.f)
        # distance between camera sensor and lens
        self.sensor_width = display.screen_pitch * display.screen_pixels / self.Do * self.Di
        self.resolution = resolution
        self.display = display
        
    def sampling(self):
        return sampling(self.sensor_width, self.resolution)


def sampling(size, resolution):
    S = np.linspace(-size/2, size/2, resolution+1)
    return (S[:-1] + S[1:]) / 2


def camera2screen(X, Y, camera: Camera):
    f, Di, Do = camera.f, camera.Di, camera.Do
    delta = 1/Do + 1/Di - 1/f  # delta rule in transport equation
    T = np.array([[-Do/Di, Do*delta],
                  [1/Di, 1/f-1/Di]])  # transport equation
    x, y = T @ np.vstack([X, Y])
    return x, y


def dsearchn(x, v):
    d2 = (x.reshape(-1, 1) - v) ** 2
    return np.argmin(d2, axis=0)  # same shape as v



def Angular_BoundaryExt2(nView, SPP, Depth, XtraPix):
    if nView == 1:
        BVals = np.array([-90, 90])
    else:
        if nView % 2 == 1:
            i = np.arange((nView-1)//2 + 1 + nView*(XtraPix-1)//2)
        else:
            i = np.arange(nView*XtraPix//2)
        BVals = np.arctan(SPP * i / Depth) / np.pi * 180
        if nView % 2 == 1:
            BVals = np.hstack([-np.flipud(BVals), BVals])
        else:
            BVals = np.hstack([-np.flipud(BVals), [0], BVals])
    return BVals


def BackwardTransportExt3(offset, Bvals, Display, Camera, Vs, XtraPix=5):
    # Vs is the posisions of the sampling created in the camera aperature
    # 
    Yo = np.zeros((len(Vs), Camera.resolution))
    Vo = np.zeros((len(Vs), Camera.resolution))
    Ang_Res = Display.angular_res
    camera_sampling = Camera.sampling() # Grid of posistion of immitted rays
    display_sampling = Display.sampling() # Grid of position of screen pixels
        #create sampling on the camera
    Ys = mat.repmat(camera_sampling, len(Vs), 1).T # repeate each value in camera sampling len(Vs) times

    
    for j in range(Camera.resolution):
        # transport the camera pixels indecies to the display screen
        Yo[:,j], Vo[:,j] = camera2screen(Ys[j], Vs, Camera) #Yo spatial index  Vo angular index
        # finding the nearest display samples that can recive the rays coming from the transportation
        Yo[:,j] = dsearchn(display_sampling, Yo[:,j])   
        
    if Ang_Res == 1:
        return Yo, np.zeros_like(Vo)
    
    Vo = Vo/math.pi*180 + offset
    S = Vo.copy()
    for a in range(len(Bvals)-1):
        Vo[(S >= Bvals[a]) & (S < Bvals[a+1])] = a - Ang_Res*XtraPix # comparing vo to each in interval in Bvals

    Yo[Vo <= Ang_Res*(-XtraPix+1)] += -XtraPix
    for m in range(-XtraPix+1, XtraPix):
        Yo[(Vo <= Ang_Res*(m+1)) & (Vo > Ang_Res*m)] += m
    Yo[Vo > Ang_Res*XtraPix] += XtraPix
    Vo = (Vo + Ang_Res) % Ang_Res
    
    return Yo, Vo


