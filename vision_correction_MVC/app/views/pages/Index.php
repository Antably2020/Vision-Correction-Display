<?php
class Index extends view{
  public function output(){
    $title = $this->model->title;
    $subtitle = $this->model->subtitle;
    require APPROOT . '/views/inc/header.php';
    
    ?>





   <section class="products-content">
  <div class="container">
   
	<div class="row">
    <div class="col-md-12">
      <!-- heading -->
      <h2>FEATURED <b>CATEGORIES</b></h2>
      
      <hr class="hr2" >
      <br><br>
     
  </div>
      <div class="row">
        <!-- categories -->
        <?php  foreach($this->model->readcat() as $cat){ ?>
                                                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                  <!-- categories -->
                  <div class="product">
                      <article style="padding-bottom:30px;">
                        <div class="module">
                          <div class="cat-thumb">
                              <img class="img-fluid" src="<?php echo URLROOT . $cat->catImage; ?> " style="Height: 200px; width: 200px;" alt="Spare Parts">
                          </div>
                          <form action="categorizedProduct" id="my_form" method="post" name="category">     

 <button  name="category" value=" <?php echo  $cat->categoryID; ?>" class="cat-title" style="border:none">   <?php echo  $cat->category; ?> </button>
</form>
                         
						
                         
                        </div>
                      </article>
                  </div>
                </div>
                              
   <?php
        }?>
                                                                                                                                                                                                        
      </div>
    </div>


  </div>
</section>






        

    <div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2>FEATURED<b> PRODUCTS</b></h2>
      
      <hr class="hr2">

			<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="0">
			<!-- Carousel indicators -->
			<ol class="carousel-indicators">
				<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				<li data-target="#myCarousel" data-slide-to="1"></li>
				<li data-target="#myCarousel" data-slide-to="2"></li>
			</ol>   
			<!-- Wrapper for carousel items -->
			<div class="carousel-inner">
			


  
   
		 	<div class="item active">
		<?php	
		$count=0;
			foreach($this->model->readProd() as $product){
				if ($product->featured==1 ) { 
    
		 while($count%4==0){
		if($count==0){
			break;
		}
		?>
		</div>
			<div class="item ">
			
<?php

	break;
		 }
?>
						

						
						<div class="col-sm-3">
							<div class="thumb-wrapper">
								<div class="img-box">
								<a href="" class="cat-title">
									<img src="<?php echo URLROOT . $product->img; ?>" class="img-responsive" alt="">
								</div>
								<div class="thumb-content">
									<h4><?php echo $product->name?></h4>
									<p class="item-price"><strike>EGP<?php echo $product->oldPrice?></strike> <span>EGP<?php echo $product->price?></span></p></a>
								
                  <form action="ProductDescription" method="post" name="addToCart">                                            
              <?php echo'<a><button id="addtocart" name="addtocart" class="btn btn-primary"  value="'.$product->id.'">Details</button></a>';?>
          </form>
								</div>						
							</div>
						</div>
					
				
				<?php
			$count++;
				
				} 
			} 
				?>

		</div>
				
				
			</div>
			<!-- Carousel controls -->
			<a class="carousel-control left" style=" background-image: linear-gradient(to right,rgba(0,0,0,.0001) 0,rgb(0 0 0 / 0%) 100%);" href="#myCarousel" data-slide="prev">
				<i class="fa fa-angle-left"></i>
			</a>
			<a class="carousel-control right "  style=" background-image: linear-gradient(to right,rgba(0,0,0,.0001) 0,rgb(0 0 0 / 0%) 100%);"href="#myCarousel" data-slide="next">
				<i class="fa fa-angle-right"></i>
			</a>
		</div>
		</div>
	</div>
</div>





    
    <div class="container-fluid" style="background-color:rgba(0, 0, 0, 0.1);height: 290px;">
    
      <h1>Over 3.5 million genuine NEW spare parts</h1>
      <img class="img2" src="<?php echo URLROOT . 'images/im.png'; ?>" alt="Pineapple" width="200" height="200" style="float: right;">
    <br>
	  <P>When it comes to squeezing every ounce of grin inducing, neck snapping enjoyment out of your two-wheeled thrill machine the first place to stop is the after-market market. Here you will find a plethora of performance parts that are engineered specifically to make your scoot shoot. From exotic exhaust systems to the latest in crash protection, BigBoysToys has a curated selection of premium add-ons to take your ride to the next level. Whether you're strictly street or a track day junkie RevZilla is here to keep kids off stock bikes. </P>
        <h3 style="padding-top:50px;">Delivered all over Egypt</h3>
    </div>
          
    
          <br>
          
          
    </section >
    <?php
  require APPROOT . '/views/inc/footer.php';


  }
  }
  ?>