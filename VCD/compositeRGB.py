import numpy as np
from utils import Camera, Display
import matplotlib.pyplot as plt


def composite(arrays):
    # arrays = np.flip(arrays, axis=-1)
    m, n, c = arrays.shape
    ret = np.zeros((m,n*5))
    for i in range(n):
        ret[:,i*c:(i+1)*c] = arrays[:,i,:]
    return ret

def composite_rgb(imgs, camera: Camera, display: Display):
    Collector = np.array(imgs)
    # Collector -= Collector.min()
    Collector /= Collector.max()
    
    Angular_Res         = display.angular_res
    Angular_HRes        = Angular_Res
    Angular_VRes        = Angular_Res
    Padding             = display.padding
    Screen_Pixels       = display.screen_pixels
    Angular_Area        = Angular_HRes * Angular_VRes
    Rows   =   Cols     = display.resolution 
    GAMMA               = display.gamma
    if Padding:
        # s = Padding // 2 * factor * Angular_Res
        # e = (Padding // 2 + Screen_Pixels) * factor * Angular_Res
        s = 0
        e = Screen_Pixels * Angular_Res

    LF_RGB = []
    for ch in range(3):
        IMG = Collector[ch].reshape(Rows, Cols, Angular_VRes, Angular_HRes)
        # print(IMG)
        # print(IMG.shape)
        
        LF = np.swapaxes(IMG, -2, -1).reshape(Rows, Cols, Angular_Area)
        # print(LF)
        # print(LF.shape)
        
        IMG_H = np.zeros((Rows,Cols*Angular_HRes,Angular_VRes))
        #print(IMG_H)
        for i in range(Angular_VRes):
            IMG_H[:,:,i] = composite(LF[:,:,i*5:(i+1)*5])
        LF = composite(IMG_H.transpose(1, 0, 2))
        LF = LF[s:e, s:e]
        LF = np.abs(LF) ** (1/GAMMA)
        LF = np.flip(LF, axis=(0, 1))
        LF_RGB.append(LF)
    
    LF_RGB
    return np.stack(LF_RGB, axis=-1)