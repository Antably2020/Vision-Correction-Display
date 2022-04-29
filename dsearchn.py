import numpy as np
import numpy.matlib as mat
def dsearchn(x,v):
    xi = v
    t = np.zeros((len(xi),1))
    d = np.zeros((len(xi),1))    
    for i in range(len(xi)):
        yi = mat.repmat(xi[i],len(x),1)
        p = (x-yi)**2
        u = np.argmin(p)
        t[i] = u+1
    return t
