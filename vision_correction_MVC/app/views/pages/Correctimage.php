
<?php 
$photo_result=null;
$path='';
function play(){

    global $photo_result;
    global $path;
    
    if(isset($_FILES['Img'])){
      $path="C:/xampp/htdocs/Vision-Correction-Display/vision_correction_MVC/images/tmp/".time().".".pathinfo($_FILES['Img']['name'], PATHINFO_EXTENSION);
      move_uploaded_file($_FILES['Img']['tmp_name'],$path);
      $photo_result = shell_exec('python C:/xampp/htdocs/Vision-Correction-Display/vision_correction_MVC/app/controllers/testAPI2.py '.$path.' 2>&1');
      
    }
  }
     play();
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
   footer{
     bottom: 0
   }
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

<form method="post" action="" enctype="multipart/form-data">
<div id="outer">
      <div class="upload-container" >
        <input accept="image/*" type="file" autocomplete="off"  name="Img" id="file_upload" onchange="loadFile(event)" multiple required />
    
    </div> <input value="<?php echo $photo_result;?>" name="Img"hidden />
     
    </div>
    <div class="row" style=" padding-top: 50px; ">
		<div class="col-md-12">
    <img  id="output" width=100px/>
</div></div>
    <div class="row"  style=" padding-top: 20px; ">
		<div class="col-md-12">
		<input type="submit" class="upload-btn login-btn"  onclick="uploadFiles()" value="Submit">
    </div></div>
</form>
<?php
if(isset($_FILES['Img'])){
 ?>
<div class="row">
		<div class="col-md-12">
                      <img  class="view-img" src="http://localhost/Vision-Correction-Display/vision_correction_MVC/images/tmp/<?php echo $photo_result;?>" alt="Image" style="width: 500px;">
								</div></div>
                <?php } 
                
                
                
                
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