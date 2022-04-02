from wsgiref.util import request_uri
import os
from recolor import Core
import sys
from werkzeug.utils import secure_filename

image = sys.argv[1]
kind = sys.argv[2]
degree = sys.argv[3]
degree=float(degree)

if kind=='1':
	Core.correct(input_path=image,
			return_type='save',
			save_path=image,
			protanopia_degree=degree,
			deutranopia_degree=0)

elif kind=='2':
	Core.correct(input_path=image,
			return_type='save',
			save_path=image,
			protanopia_degree=0,
			deutranopia_degree=degree)
else :
	print ('noooo')
print(image.split('/')[-1])

