
  <head>

      <style>
          .breadcrumb {
  padding: 8px 15px;
  margin-bottom: 20px;
  list-style: none;
  background-color: #f5f5f500;
  /* border-radius: 4px; */
}
.logout-btn{
background-color:#fff;
border-color:#fff;
border:none;
margin-top:8px;
color:#000;
}
.breadcrumb>.active {
  color: #000;
}

          </style>
          <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

      </head>
  
  
  <?php




 if(isset($_POST['logout'])){
    unset($_SESSION['ID']);
    header('location: ' . URLROOT . 'public/pages/index');
    
}

?>




<nav class="navbar navbar-expand-md ">
    
<ul class="navbar-nav">
<li class="nav-item ">
<li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT . 'public/pages/image_history'; ?>">Image History</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="<?php echo URLROOT . 'public/pages/Correctimage'; ?>">Correct Image</a>
            </li>
            </li>
            </ul>
  
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon justify-content-end"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarNav">
        
    
    <ul class="navbar-nav mr-auto ">

<div class="box">
<a class="" href="<?php echo URLROOT . 'public/pages/index'; ?>">

<img src="<?php echo URLROOT . 'images/logo.png'; ?>" alt="Logo" style="width: 100px;">
</a>
    </div>



           
        </ul>


        <ul class="navbar-nav">
     
        
        
            <?php if(!isset($_SESSION['ID'])){ ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo URLROOT . 'public/users/login'; ?>">Login/Register</a>
            </li>
            <?php
            }
            else{
                ?>
                 <li class="nav-item">
                <a class="nav-link" href="<?php echo URLROOT . 'public/pages/profile'; ?>">My Account</a>
            </li>
                   <form  method="post" >    
                <li class="nav-item">
              
                    <button  name="logout"  class="nav-link logout-btn"> Logout</button>
                    
                            </li>

                            </form>

                            <?php
            }
            ?>
           
        </ul>
        


 


    </div>
    <hr class="navhr">
    
</nav>

