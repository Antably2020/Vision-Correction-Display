<body >
<?php
class Login extends view
{
  public function output()
  {
    $title = $this->model->title;

    require APPROOT . '/views/inc/header.php';
    echo breadcrumbs(); 
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
		<h2 ><a class="login-head1" href="<?php echo URLROOT . 'public/users/login'; ?>">Login</a> <li class="or">Or</li> <b> <a class="login-head2" style=" color: #000;" href="<?php echo URLROOT . 'public/users/register'; ?>">Register</a></b></h2>
     
    </div></div>

    

    
      <form class="form" method="post" action="" name="Login"  >

        <div  style=" padding-top: 50px; ">
        <div class="container" style="width:40%">
        <div class="row">
<div class="col">
               <div > <label >Email</label></div>
                <input class=" form-contro " style="width:100%" type="text"  required="true"  name="email" placeholder="Email Adress" autofocus="false">
         
          
                <div ><label >Password</label></div>
          
                <input class="form-contro "   style="width:100%"type="password" required="true" name="password" placeholder="password" autofocus="false">
              
</div></div></div>
              </div>
     
              
              
   <div class="row" style=" padding-top: 50px; ">
		<div class="col-md-12">
            <input type="submit" class="login-btn" id="Login" name="Login"onsubmit="return false" value="Submit" class="login-button">
            
</div></div>
        </form>    
    <?php

    require APPROOT . '/views/inc/footer.php';
  }


  }
?>
</body>