from wsgiref.util import request_uri
from flask import Flask,request,render_template,redirect
import os
from recolor import Core
app = Flask(__name__,template_folder= "../views/pages",static_folder="../views/static")


app.config["IMAGE_UPLOADS"] = "C:/xampp2/htdocs/Vision-Correction-Display/vision_correction_MVC/app/views/static/Images"
app.config["ALLOWED_IMAGE_EXTENSIONS"] = ["PNG","JPG","JPEG"]

from werkzeug.utils import secure_filename


@app.route('/home',methods = ['POST' , "GET"])
def upload_image():
	
	if request.method == "POST":
		
		image = request.files['file']
		print(request.files)
		if image.filename == '':
			print("Image must have a file name")
			return redirect(request.url)
		filename = secure_filename(image.filename)
		print(os.path.dirname(__file__))
		basedir = os.path.abspath(os.path.dirname(__file__))
		path = os.path.join(basedir,app.config["IMAGE_UPLOADS"],filename)
		image.save(path)
		Core.correct(input_path=path,
                 return_type='save',
                 save_path=path,
                 protanopia_degree=0.9,
                 deutranopia_degree=0.9)

		return render_template("Correctimage.php",filename=filename)
		
	return render_template('Correctimage.php')




app.run(debug=True,port=80)