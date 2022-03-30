<?php
class contact extends view{

 public function output(){
    $title = $this->model->title;
    require APPROOT . '/views/inc/header.php';
 ?>

  <head>
  <style>
  footer{
    bottom:0px;
  }
  </style>
  </head>

  <div class="row">
    <div class="col-md-12">
      <!-- heading -->
      <h2>CONTACT <b>US</b></h2>
      </div>
      </div>
      
<div class="login-container ">
    
    <form class="form" method="post" action="post" name="Contact" style="padding: 18px;" >
         <div style="margin-top:10px;">
<select class="btn  dropdown-toggle" name="choice" style="width:60%; border:5px solid #000;">
  <option value="none" selected disabled hidden>Select</option>
  <option value="1">problem at system</option>
  <option value="2">Idea recommendation</option>
  <option value="3">reaching out</option>
  <option value="4">more</option>
</select>
         </div>
      <div  style=" padding-top: 30px; ">
              <div ><label >Description</label></div>
              <textarea class="form-control center-block" style="width:60% ;border:5px solid #000;" type="text" required="true" name="" ></textarea>
            </div>
          
            
            
            
          <input type="submit" class="login-btn" id="Login" name="Login"onsubmit="return false" value="Submit" class="login-button">
          
        
      </form>     </div>

 <?php
  require APPROOT . '/views/inc/footer.php';

  }
}
?>