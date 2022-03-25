
<html>
<?php 
class correctimage extends view{

  public function output(){
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
        alert("Selected file(s) :\n____________________\n"+filenames);
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


<script type="text/javascript">
    document.getElementById("myButton").onclick = function () {
        location.href = "http://localhost:80/Vision-Correction-Display/vision_correction_MVC/public/pages/Correctimage";
    };
</script>
</head>
<body>


{% 
  if filename
%}
<div class="row">
		<div class="col-md-12">
                			<a href="http://localhost:80/Vision-Correction-Display/vision_correction_MVC/public/pages/Correctimage">
                      <img  class="view-img" src="{{ url_for('static', filename='Images/'+filename) }}" alt="Image" style="width: 500px;">
								</div></div>
                            

{% 
  else 
%}
                <div class="row">
		<div class="col-md-12">
                			<a href="http://localhost:80/Vision-Correction-Display/vision_correction_MVC/public/pages/Correctimage">
                      <img  class="view-img" src="{{ url_for('static', filename='Images/logo.png') }}" alt="Logo" style="width: 500px;">
								</div></div>
                    
                <% end %>
{%
  endif 
%}           

<div class="row">
		<div class="col-md-12">
                                <button id="myButton"  class="upload-btn login-btn" >TRY AGAIN</button>
                                </div></div>
</body>

 <?php
  require APPROOT . '/views/inc/footer.php';

  }
}
?>
</html>