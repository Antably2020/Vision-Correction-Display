# %%
import cv2
import numpy as np
from utils import *
from scipy import sparse
from scipy.sparse.linalg import lsqr
import matplotlib.pyplot as plt


# %%
#upload image from folder images
img_name = '0084'
img_path = 'images/%s.png' % img_name
img = cv2.imread(img_path)
plt.imshow(img)

# %%
display = Display(
    angular_res=5, screen_pixel_pitch=0.078,
    screen_pixels=128, padding=12, depth=5.514, gamma=2.2)

camera = Camera(
    f=50, fStop=8, focus=375,
    resolution=128, display=display)

# %%
A = None
fname = f'stored/pmat_{img_name}{0}{0}.npz'
try:
    A1 = sparse.load_npz(fname)
except FileNotFoundError:
    A1 = build_matrix(display, camera, Epsilon_x=0, Epsilon_y=0)
    sparse.save_npz(fname, A1)
A = A1 if A is None else sparse.hstack([A, A1])

# %%
############################################
SCALE = camera.resolution / img.shape[0]
IMG = np.stack([
    cv2.resize(img[..., c], (0, 0), fx=SCALE, fy=SCALE)
    for c in range(img.shape[-1])], axis=-1)
plt.imshow(IMG)
IMG.shape

# %%
CONTRAST = 1.0
BIAS = (1 - CONTRAST) / CONTRAST
rows, cols, colors = IMG.shape
REC = np.zeros_like(IMG)

prefiltered = []


for ch in range(colors):
    im = IMG[..., ch]
    b = []

    b = np.hstack(im.reshape(-1).astype(float))
    b += BIAS

    print('solving least squares')
    # solve A @ x == b
    x = lsqr(A, b)[0]

    prefiltered.append(x)
