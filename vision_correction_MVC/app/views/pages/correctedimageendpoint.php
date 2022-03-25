
<html>
<?php 
class correctimage extends view{

   
 <head>
 <link rel= "stylesheet" type= "text/css" href= "{{ url_for('static',filename='styles/style.css') }}">
<meta name="viewport" content="width=device-width, initial-scale=1">    



</head>
<body>


{% 
  if filename
%}
<div class="row">
		<div class="col-md-12">
                      <img  class="view-img" src="{{ url_for('static', filename='Images/'+filename) }}" alt="Image" style="width: 500px;">
								</div></div>
                            

{% 
  else 
%}
                <div class="row">
		<div class="col-md-12">
                      <img  class="view-img" src="{{ url_for('static', filename='Images/logo.png') }}" alt="Logo" style="width: 500px;">
								</div></div>
                    
{%
  endif 
%}           

<div class="row">
<div class="col-md-12">             
<button  class="upload-btn login-btn" onClick="window.location.href='http://localhost:80/Vision-Correction-Display/vision_correction_MVC/public/pages/Correctimage';">  
TRY AGAIN
</button>   
    </div></div>
</body>

 <?php
  require APPROOT . '/views/inc/footer.php';

  }
}
?>
</html>