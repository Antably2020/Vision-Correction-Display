<body>
<?php
class Eyeinputs extends view
{
  public function output()
  {
    $title = $this->model->title;

    require APPROOT . '/views/inc/header.php';
    echo breadcrumbs(); 
    ?>
   
  

   


  <form class="form" method="post" action="" name="Login" >
  <div class="container ">
<div class="row">
   
  <div class="col">
            <div><label>Focal Length</label></div>
             <input class="form-contro "style="width:100%"  type="text"  required="true"  name="focal" placeholder="Focal Length" autofocus="false">
          
             <div > <label>Focus</label></div>
             <input class="form-contro "style="width:100%"  type="text"  required="true"  name="focus" placeholder="Focus" autofocus="false">

  
            <div > <label>Do</label></div>
            <input class="form-contro "style="width:100%"   type="text"  required="true"  name="do" placeholder="Do" autofocus="false">
 </div>
  <div class="col">		
            <div > <label>F-stop</label></div>
            <input class="form-contro "style="width:100%"   type="text"  required="true"  name="fstop" placeholder="F-stop" autofocus="false">
    
            <div > <label>Resolution</label></div>
            <input class="form-contro "style="width:100%" type="text" required="true" name="resolution" placeholder="Resolution" autofocus="false">

            <div > <label>Device-Type</label></div>
						<input class="form-contro "style="width:100%"  type="text" required="true" name="dtype" placeholder="Device-Typ" autofocus="false">
			
 </div>
					</div>	
          </div>
<div style="margin-top:50px;">
  </div>
          
   <div class="row">
		<div class="col-md-12">
        <input type="submit" class="login-btn" id="Login" name="Login"onsubmit="return false" value="Submit" style="font-size: 26px;">
  </div>
  </div>

	  </form>  

<?php

  }

 
  }?>
</body>
