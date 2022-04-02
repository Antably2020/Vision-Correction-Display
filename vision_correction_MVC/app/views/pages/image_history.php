<?php 
class image_history extends view{
    public function output (){
        $title = $this->model->title;
        ?><?php
        require APPROOT . '/views/inc/header.php';
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
			<h2>IMAGE<b> HISTORY</b></h2>
            
      <hr class="hr2" >

</div>
	</div>

  
    
        <div class="row"> 
    

            <div class="col-md-12">
            
            
<table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
    				<thead>
						<tr>
              <th>Image</th>
							<th>Date</th>
              <th>Type</th>
              <th>Degree</th>
               <!--<th>Delete</th>-->
							
						</tr>
					</thead>

					<tfoot>
						<tr>
            
              <th>Image</th>
							<th>Date</th>
              <th>Type</th>
              <th>Degree</th>
            <!--   <th>Delete</th>-->
						</tr>
					</tfoot>

					<tbody>

           

           <?php
  foreach($this->model->readhistory($_SESSION['ID']) as $userID){

    ?>
						<tr>
             
             <td><a href=" http://localhost/Vision-Correction-Display/vision_correction_MVC/images/tmp/<?php echo  $userID->Img; ?>"><img class="img-fluid" src="http://localhost/Vision-Correction-Display/vision_correction_MVC/images/tmp/<?php echo  $userID->Img; ?>"  width="90" height="90" ></a></td>
                        
							<td><?php echo  $userID->created_at; ?></td>
										
							<td><?php echo  $userID->type; ?></td>
							<td><?php echo  $userID->degree; ?></td>
    <!--<td><form method="post" action=''><button class="order-btn  btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete"  style="background-color:#FF7A00; color:white;" name="del" id="del" value=<?php echo $userID->Img;?>><span class="glyphicon glyphicon-trash" ></span></button></form></td>	</tr>
				
  -->
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