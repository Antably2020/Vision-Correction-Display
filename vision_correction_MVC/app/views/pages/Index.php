<?php
class Index extends view{
  public function output(){
    $title = $this->model->title;
    $subtitle = $this->model->subtitle;
    require APPROOT . '/views/inc/header.php';
    
    ?>

<head>
	<style>
		footer{
			bottom: 0
		}
		</style>
	</head>



  <?php if(!isset($_SESSION['ID'])){ ?>
	
	<section class="products-content">
  <div class="container">
	<div class="row">
    <div class="col-md-12">
      <!-- heading -->
      
     <h1  style="margin-top: 30px;margin-bottom: 60px;">LOGIN <b>TO</b> START</h1>


	 <a style="margin-top: 30px; padding:20px;"class="upload-btn login-btn" class="nav-link" href="<?php echo URLROOT . 'public/users/login'; ?>">Login/Register</a>
            
            
		<h1 style="margin-top: 30px;margin-bottom: 60px;">	<b>OR</b></h1>

		
		<h1  style="margin-top: 30px;margin-bottom: 60px;">TEST <b>COLOR BLINDNESS</b> </h1>
		<a style="margin-top: 30px; padding:20px;"class="upload-btn login-btn" class="nav-link" href="http://localhost/Vision-Correction-Display/quiz/">Color Blindness Test</a>
            
            
		
		</div></div>
    </section >
            <?php
            }
            else{
			echo	'<script>window.location.href = "http://localhost/Vision-Correction-Display/vision_correction_MVC/public/pages/Correctimage";</script>';
			}
			?>
    <?php
  require APPROOT . '/views/inc/footer.php';


  }
  }
  ?>