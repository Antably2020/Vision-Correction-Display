<?php 
class A_products extends view{
    public function output (){
        $title = $this->model->title;
        ?><div style="margin-left: 160px;"><?php require APPROOT . '/views/inc/adminHeader.php';  ?></div ><?php
        require APPROOT . '/views/inc/sidebar.php';
    ?>
   
   <head>
<script>


    $(document).ready(function() {
    $('#datatable').dataTable();
    
     $("[data-toggle=tooltip]").tooltip();
    
} );



    </script>



</head>
<div class="main">





       <div class="container">
	<div class="row" style="padding-bottom:20px">
    <div class="col-md-12">
			<h2>ALL<b> PRODUCTS</b></h2>
            
      <hr class="hr2" >

</div>
	</div>

  
    
        <div class="row"> 
        <form action="add_product">
        <input type="submit" class="login-btn" id="Login" name="Login"  value="Add New" class="login-button">
         </form>
    

            <div class="col-md-12">
            
            
<table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
    				<thead>
						<tr>
              <th>Featured</th>
              <th>Image</th>
							<th>Name</th>
							<th>Description</th>
							<th>Price</th>
							
                                 <th>Delete</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
              <th>Featured</th>
							<th>Image</th>
							<th>Name</th>
							<th>Description</th>
							<th>Price</th>
							
                                 <th>Delete</th>
						</tr>
					</tfoot>

					<tbody>

           
  <?php
  foreach($this->model->readProd() as $product){
    ?>

						<tr>
               <td><b><?php if ($product->featured==1 ) { echo 'YES';}  else{ echo 'NO';}?></b></td>
             <td><img class="img-fluid" src="<?php echo URLROOT . $product->img; ?>"  width="90" height="90" ></td>
                        
							<td><?php echo $product->name; ?></td>
							<td><?php echo  $product->description; ?></td>
							<td> EGP&nbsp;<?php echo  $product->price; ?>&nbsp;</td>
							
    <td><form method="post" action=''><button class="order-btn  btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete"  style="background-color:#FF7A00; color:white;" name="del" id="del" value=<?php echo $product->id;?>><span class="glyphicon glyphicon-trash" ></span></button></form></td>	</tr>
						
             


<?php
  }
  ?>
                        
					</tbody>
				</table>

	
	</div>
	</div>
</div>
    
         </div>

</section>

</div>
<?php
 require APPROOT . '/views/inc/footer.php';
  }
}
?>