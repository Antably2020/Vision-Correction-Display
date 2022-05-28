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


def build_matrix(display: Display, camera: Camera, Epsilon_x, Epsilon_y,
                 sampling=20, psf_size=240, XtraPix=5):
    ind_r = np.zeros(camera.resolution**2*psf_size*2)
    ind_c = np.zeros(camera.resolution**2*psf_size*2)
    val_s = np.zeros(camera.resolution**2*psf_size*2)

    # get samples
    Vs = np.arange(-camera.aperture/2, camera.aperture/2+1/sampling, 1/sampling)
    Us = np.arange(-camera.aperture/2, camera.aperture/2+1/sampling, 1/sampling)

    us, vs = np.meshgrid(Us, Vs) #represents the camera lens(pupil size)
    Z = np.zeros(np.shape(us))
    # we only need the rays that pass through the lens
    Z[us**2 + vs**2 < (camera.aperture/2)**2] = 1 # circle x^2 + y^2 < z^2
    
    # angular resolution
    HBVals = Angular_BoundaryExt2(display.angular_res, display.screen_pixel_pitch, display.depth, XtraPix)
    VBVals = Angular_BoundaryExt2(display.angular_res, display.screen_pixel_pitch, display.depth, XtraPix)

    print('start y-v backward transport')
    Yo, Vo = BackwardTransportExt3(Epsilon_y, HBVals, display, camera, Vs)
    print('start x-u backward transport')
    Xo, Uo = BackwardTransportExt3(Epsilon_x, VBVals, display, camera, Vs)
    
    ##############
    Xo[Xo < 0] = 0
    Xo[Xo >= display.resolution] = display.resolution - 1
    Yo[Yo < 0] = 0
    Yo[Yo >= display.resolution] = display.resolution - 1

    Angular_HRes = Angular_VRes = display.angular_res
    Angular_Area = Angular_VRes * Angular_HRes
    Camera_Area = camera.resolution ** 2
    Display_Area = display.resolution ** 2
    
    print('start sampling and build projection matrix')
    index = 0
    for j in trange(0, camera.resolution):
        for i in range(0, camera.resolution):
            #add x to y to collect spatial pixels
            xo, yo = np.meshgrid(Yo[:, j], Xo[:, i])
            pixels = np.array([yo.reshape(-1), xo.reshape(-1)]).T
            #add u to v to collect angular pixels
            uo, vo = np.meshgrid(Uo[:, j], Vo[:, i])
            angles = np.array([vo.reshape(-1), uo.reshape(-1)]).T
            # remove the samples that are out of the camera aprature
            samples = np.concatenate([pixels, angles], 1)
            samples = samples[Z.reshape(-1) != 0]

            w = np.shape(samples)[0]
            b, n = np.unique(samples, return_counts=True, axis=0)
            
            CELL = np.hstack([b, n.reshape(-1, 1)])

            for r in range(b.shape[0]):
                index0 = i * camera.resolution + j
                index1 = (CELL[r, 1] * display.resolution + CELL[r, 0]) * Angular_Area
                index2 = CELL[r, 3] * Angular_VRes + CELL[r, 2]
                ind_r[index] = index0
                ind_c[index] = index1 + index2
                val_s[index] = CELL[r, -1] / w
                index = index + 1

    print('start making sparse system matrix')
    A = sparse.csc_matrix(
        (val_s, (ind_r, ind_c)),
        shape=(Camera_Area, Display_Area*Angular_Area))
    return A


