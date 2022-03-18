<?php 
class correctimage extends view{

  public function output(){
    $title = $this->model->title;
    require APPROOT . '/views/inc/header.php';
    echo breadcrumbs(); 
 ?>
 
 <head>
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
</head>
<body>
<div id="outer">

    <div class="upload-container" >
        <input accept="image/*" type="file" id="file_upload" onchange="loadFile(event)" multiple />
     
    </div>
    
    <br></div>
    <div class="row" style=" padding-top: 50px; ">
		<div class="col-md-12">
    <img  id="output" width=100px/>
</div></div>
    <div class="row"  style=" padding-top: 20px; ">
		<div class="col-md-12">
    <button class="upload-btn login-btn"  onclick="uploadFiles()">Submit</button>  
</div></div>


                <div class="row">
		<div class="col-md-12">
                			<a href="">
                      <img  class="view-img" src="<?php echo URLROOT . 'images/logo.png'; ?>" alt="Logo" style="width: 500px;">
								</div></div>
              
</body>


 <?php
  require APPROOT . '/views/inc/footer.php';

  }
}
?>