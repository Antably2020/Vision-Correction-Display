<body>
<?php
class Register extends view
{
  public function output()
  {
    $title = $this->model->title;

    require APPROOT . '/views/inc/header.php';
    echo breadcrumbs(); 
    ?>
   
  

   <div class="row">
		<div class="col-md-12">
		<h2 ><a class="register-head1" href="<?php echo URLROOT . 'public/users/login'; ?>">Login</a> <li class="or">Or</li> <b> <a class="register-head2" style=" color: #000000;" href="<?php echo URLROOT . 'public/users/register'; ?>">Register</a></b></h2>
     
 </div></div>


  <form class="form" method="post" action="" name="Login" >
  <div class="container ">
<div class="row">
   
  <div class="col">
            <div><label>First Name</label></div>
             <input class="form-contro "style="width:100%"  type="text"  required="true"  name="fname" placeholder="First Name" autofocus="false">
          
             <div > <label>Last Name</label></div>
             <input class="form-contro "style="width:100%"  type="text"  required="true"  name="lname" placeholder="Last Name" autofocus="false">

  
            <div > <label>Email Address</label></div>
            <input class="form-contro "style="width:100%"   type="text"  required="true"  name="email" placeholder="Email Address" autofocus="false">
 </div>
  <div class="col">		
            <div > <label>Age</label></div>
            <input class="form-contro "style="width:100%"   type="text"  required="true"  name="age" placeholder="Age" autofocus="false">
    
            <div > <label>Password</label></div>
            <input class="form-contro "style="width:100%" type="password" required="true" name="password" placeholder="password" autofocus="false">
            <div > <label>Confirm Password</label></div>
						<input class="form-contro "style="width:100%"  type="password" required="true" name="C_password" placeholder="confirm password" autofocus="false">
			
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
