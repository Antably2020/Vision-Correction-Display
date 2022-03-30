from wsgiref.util import request_uri
import os
from recolor import Core
import sys
from werkzeug.utils import secure_filename

image = sys.argv[1]
Core.correct(input_path=image,
			return_type='save',
			save_path=image,
			protanopia_degree=0.9,
			deutranopia_degree=0.9)

print(image.split('/')[-1])

