<body>
<?php 

class  profile extends view{
    public function output (){
        $title = $this->model->title;
    require APPROOT . '/views/inc/header.php';
    
    
    ?> 
    
    <head>
        <style>
            a{
                color:#000000
            }
   
            </style>
            

            </head>


			<div class="container">
   
   <div class="row">
   <div class="col-md-12">
	 <!-- heading -->
	 <h2>MY <b>Profile</b></h2>
      
	 
	 <hr class="hr2" >
	 <br><br>
	
 </div>

  </div></div>
	  <?php
  foreach($this->model->readuser($_SESSION['ID']) as $user){
    ?>



   







    <div class="container profile-body" style="padding-bottom:5%">
<div class="row gutters">
<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
<div class="card">
	<div class="card-body">
		<div class="account-settings">
			<div class="user-profile">
				<div class="user-avatar">
					<img src="<?php echo URLROOT . $user->profileIMG; ?>" alt="Maxwell Admin">
				</div>
				<h3 class="user-name"><?php echo $user->Name; ?></h3>
				<h6 class="user-email"><?php echo  $user->Email; ?></h6>
			</div>
			
		</div>
	</div>
</div>


<div class="card">
<div class="card-body">
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<h5 class="mb-2" style="color:#000000;">Personal Details</h5>
			</div>

			
			<form class="form" method="post" action="" name="update" >
       
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="fullName">Full Name</label>
					<input type="text" name="name" class="form-control" id="fullName" placeholder="Enter full name">
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="eMail">Email</label>
					<input type="email"name="email" class="form-control" id="eMail" placeholder="Enter email ID">
				</div>
			</div>

			
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="password">Password</label>
					<input type="text"name="password" class="form-control" id="Street" placeholder="Password">
				</div>
			</div>

         
		
		
		</div>
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div >
					<button  id="submit" name="update" style="margin-top:20px; "class=" login-btn">Update</button>
				</div>
			</div>
		</div>
  </form>


</div>
	</div>	
</div>



<?php
}
?>
<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
<div class="card ">
	<div class="card-body">
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<h5 class="mb-2" style="color:#000000;">Personal Details</h5>
			</div>

			
			<form class="form" method="post" action="" name="update" >
       
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="fullName">Full Name</label>
					<input type="text" name="name" class="form-control" id="fullName" placeholder="Enter full name">
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="eMail">Email</label>
					<input type="email"name="email" class="form-control" id="eMail" placeholder="Enter email ID">
				</div>
			</div>

			
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="password">Password</label>
					<input type="text"name="password" class="form-control" id="Street" placeholder="Password">
				</div>
			</div>

         
		
		
		</div>
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div >
					<button  id="submit" name="update" style="margin-top:20px; "class=" login-btn">Update</button>
				</div>
			</div>
		</div>
  </form>


</div>
</div>



<div class="card ">
	<div class="card-body">
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<h5 class="mb-2" style="color:#000000;">Personal Details</h5>
			</div>

			
			<form class="form" method="post" action="" name="update" >
       
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="fullName">Full Name</label>
					<input type="text" name="name" class="form-control" id="fullName" placeholder="Enter full name">
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="eMail">Email</label>
					<input type="email"name="email" class="form-control" id="eMail" placeholder="Enter email ID">
				</div>
			</div>

			
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="password">Password</label>
					<input type="text"name="password" class="form-control" id="Street" placeholder="Password">
				</div>
			</div>

         
		
		
		</div>
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div >
					<button  id="submit" name="update" style="margin-top:20px; "class=" login-btn">Update</button>
				</div>
			</div>
		</div>
  </form>


</div>
</div>
</div>
</div>







        </div>


		

 <?php
require APPROOT . '/views/inc/footer.php';

  }
}
?>
</body>