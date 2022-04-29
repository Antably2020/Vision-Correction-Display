import numpy as np

def composite2(L,R):

    [m,n] = L.shape
    ret  = np.zeros((m,n*2))

    for n in range(n):
        ret[:,n*2+1] = R[:,n]
        ret[:,n*2+2] = L[:,n]
    return ret
 
def composite3(L,M,R):

    [m,n,c] = L.shape
    ret  = np.zeros((m,n*3,c))

    for n in range(n):
        ret[:,n*3+1] = R[:,n,:]
        ret[:,n*3+2] = M[:,n,:]
        ret[:,n*3+3] = L[:,n,:]

    return ret

def composite4(L1,L2,R1,R2):

    [m,n] = L1.shape
    ret  = np.zeros((m,n*4))

    for n in range(n):
        ret[:,n*4+1] = R2[:,n]
        ret[:,n*4+2] = R1[:,n]
        ret[:,n*4+3] = L1[:,n]
        ret[:,n*4+4] = L2[:,n]

    return ret

def composite5(L1,L2,M,R1,R2):

    [m,n] = L1.shape
    ret  = np.zeros((m,n*5))

    for n in range(n):
        ret[:,n*5+1] = R2[:,n]
        ret[:,n*5+2] = R1[:,n]
        ret[:,n*5+3] = M[:,n]
        ret[:,n*5+4] = L1[:,n]
        ret[:,n*5+5] = L2[:,n]
    return ret

def composite7(L3,L2,L1,M,R1,R2,R3):

    [m,n] = L3.shape
    ret  = np.zeros((m,n*7))

    for n in range(n):
        ret[:,n*7+1] = R3[:,n]
        ret[:,n*7+2] = R2[:,n]
        ret[:,n*7+3] = R1[:,n]
        ret[:,n*7+4] = M[:,n]
        ret[:,n*7+5] = L1[:,n]
        ret[:,n*7+6] = L2[:,n]
        ret[:,n*7+7] = L3[:,n]


    return ret
