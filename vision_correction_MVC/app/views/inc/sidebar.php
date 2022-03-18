<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>


hr {
   margin-top: 0px;
   position: absolute;
   
    left: 0px;
     background: #FF7A00; 
   border: 1px solid #FF7A00; 
}

</style>
</head>
<body>
    <script>
    /*
$(document).scroll(function() {
       if($(window).scrollTop() > 50){

        document.getElementById("sidenav").style.top = "0px";
        

       }else if($(window).scrollTop() < 50){

        document.getElementById("sidenav").style.top = "87px";

       }
});*/
</script>

<?php
if(isset($_POST['logout'])){
  unset($_SESSION['ID']);
  header('location: ' . URLROOT . 'public/pages/index');
  
}
?>
<div class="sidenav" id="sidenav">
 
<a  href="<?php echo URLROOT . 'public/pages/dashboard'; ?>">PROFILE</a>
        
        <hr>
 <a  href="<?php echo URLROOT . 'public/admin/A_orders'; ?>">ORDERS</a>
        
 <hr>
 
 <a  href="<?php echo URLROOT . 'public/admin/A_userview'; ?>">USERS</a>
 <hr>

   <a  href="<?php echo URLROOT . 'public/admin/A_products'; ?>">VIEW PRODUCTS</a>
 
 <hr>

 <a  href="<?php echo URLROOT . 'public/admin/add_product'; ?>">ADD PRODUCTS</a>
 <hr>
 <a  href="<?php echo URLROOT . 'public/admin/A_Messages'; ?>">MESSAGES</a>
 <hr>


 <form  method="post" >    
            
              
                    <button class="admin-logout-btn text-left"  name="logout"> Logout</button>
                    
                            

                            </form>
                            <hr>
</div>


   
</body>
</html> 
