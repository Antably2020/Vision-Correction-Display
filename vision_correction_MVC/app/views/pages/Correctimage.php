
<?php 
$photo_result=null;
function play(){
    global $photo_result;
    if(isset($_FILES['file'])){
      $path="C:/xampp/htdocs/Vision-Correction-Display/vision_correction_MVC/images/tmp/".time().".".pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
      move_uploaded_file($_FILES['file']['tmp_name'],$path);
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
    echo breadcrumbs(); 
 ?>
   
 <head>
 <link rel= "stylesheet" type= "text/css" href= "{{ url_for('static',filename='styles/style.css') }}">
<meta name="viewport" content="width=device-width, initial-scale=1">    

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
      //  alert("Selected file(s) :\n____________________\n"+filenames);
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

<form method="post" action="http://localhost/Vision-Correction-Display/vision_correction_MVC/public/pages/Correctimage" enctype="multipart/form-data">
<div id="outer">
      <div class="upload-container" >
        <input accept="image/*" type="file" autocomplete="off"  name="file" id="file_upload" onchange="loadFile(event)" multiple required />
     
    </div>
    </div>
    <div class="row" style=" padding-top: 50px; ">
		<div class="col-md-12">
    <img  id="output" width=100px/>
</div></div>
    <div class="row"  style=" padding-top: 20px; ">
		<div class="col-md-12">
		<input type="submit" class="upload-btn login-btn"  onclick="runpy()uploadFiles()" value="Submit">
    </div></div>
</form>
<?php
if(isset($_FILES['file'])){
?>
<div class="row">
		<div class="col-md-12">
                      <img  class="view-img" src="http://localhost/Vision-Correction-Display/vision_correction_MVC/images/tmp/<?php echo $photo_result;?>" alt="Image" style="width: 500px;">
								</div></div>
                <?php } ?>
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

<?php 
function runtestapi() {
$command = "python C:/xampp/htdocs/Vision-Correction-Display/vision_correction_MVC/app/controllers/testAPI.py 2>&1";
$pid = popen( $command,"r");
while( !feof( $pid ) )
{
 echo fread($pid, 256);
 flush();
 ob_flush();
 usleep(100000);
}
pclose($pid);
}
?>


<?php  

function runpy() {

$command = escapeshellcmd('C:/xampp/htdocs/Vision-Correction-Display/vision_correction_MVC/app/controllers/testAPI.py') ;
$results = json_decode (exec ($command) , true) ; 
}


?>
<script>  
   <?php 
    # runtestapi();
    print (json_encode ($results)) ;?>
    alert("done!");
  
</script> 



</html>