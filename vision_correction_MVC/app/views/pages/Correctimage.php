
<?php 

?>
<html>
<?php 
class correctimage extends view{

  public function output(){
    global $photo_result;
    $title = $this->model->title;
    require APPROOT . '/views/inc/header.php';
 
 ?>
   
 <head>
<meta name="viewport" content="width=device-width, initial-scale=1">    
<style>
  
     </style>
<script>
             
    function uploadFiles() {
        var files = document.getElementById('file_upload').files;
        if(files.length==0){
            alert("Please first choose or drop any file(s)...");
            return;
        }
        var filenames="";
        for(var i=0;i<files.length;i++){
            filenames+=files[i].name+"\n";
        }
     
    }
            
    var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
    document.getElementById('imageBox').src = filenames ;
  };

</script>



</head>
<body>
<div class="row" style=" padding-top: 50px; ">
<div class="center-block">
<form method="post" action="" enctype="multipart/form-data">



<h1  style="margin-top: 30px;margin-bottom: 20px;">CHOOSE <b>TYPE</b></h1>

  <select name="type" id="" class="upload-btn login-btn" >
  <option value="1"class>Protanopia</option>
  <option value="2">Dutranopia</option>
  </select>

  <h1  style="margin-top: 30px;margin-bottom: 20px;">CHOOSE <b>DEGREE</b></h1>

  <select name="degree" id="" class="upload-btn login-btn" >
  <option value="0"class>0</option>
  <option value="0.1">0.1</option>
  <option value="0.2">0.2</option>
  <option value="0.3">0.3</option>
  <option value="0.4">0.4</option>
  <option value="0.5">0.5</option>
  <option value="0.6">0.6</option>
  <option value="0.7">0.7</option>
  <option value="0.8">0.8</option>
  <option value="0.9">0.9</option>
  </select>


<h1  style="margin-top: 10px;">CHOOSE <b>IMAGE</b></h1>

<div id="outer">
      <div class="upload-container" >
      <input accept="image/*" type="file" autocomplete="off"  name="Img" id="file_upload" onchange="loadFile(event)" multiple required />
    
    </div> 
    </div>

   <!-- <input value="<?php //echo $photo_result;?>" name="Img"hidden />-->
   


<div class="row" style=" padding-top: 50px; ">
		<div class="col-md-12">
<img  id="output" width=100px/>
</div></div>

		<input type="submit" class="upload-btn login-btn"  onclick="uploadFiles()" value="Submit">
   
</form></div>

                  
<div class="vl" style=" height: 700px !important;background-color: #000000;border: 5px solid #000000;"></div>
<?php
if(isset($_FILES['Img'])){
 ?>
<div class="center-block">
  <a href="http://localhost/Vision-Correction-Display/vision_correction_MVC/images/tmp/<?php echo $photo_result;?>">
                      <img  class="view-img" src="http://localhost/Vision-Correction-Display/vision_correction_MVC/images/tmp/<?php echo $photo_result;?>" alt="Image" style="width: 500px;">
                      </a></div></div>
                <?php } 
                
                else{?>
<div class="center-block">
<img  class="view-img" src="http://localhost/Vision-Correction-Display/vision_correction_MVC/images/logo.png" alt="Image" style="width: 500px;">
</div></div>
             <?php   }
                
                
                ?>
<!--
{% 
  if filename
%}
<div class="row">
		<div class="col-md-12">
                			<a href="">
                      <img  class="view-img" src="{{ url_for('static', filename='Images/'+filename) }}" alt="Image" style="width: 500px;">
								</div></div>
{% 
  else 
%}
                <div class="row">
		<div class="col-md-12">
                			<a href="">
                      <img  class="view-img" src="{{ url_for('static', filename='Images/logo.png') }}" alt="Logo" style="width: 500px;">
								</div></div>
                <% end %>
{%
  endif 
%}        
-->

</body>


 <?php
  require APPROOT . '/views/inc/footer.php';

  }
}

?>
</html>