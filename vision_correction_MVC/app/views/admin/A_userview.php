<?php 
class A_Userview extends view{
    public function output (){
        $title = $this->model->title;
        ?><div style="margin-left: 160px;"><?php require APPROOT . '/views/inc/adminHeader.php';  ?></div >




<head>
<script>


    $(document).ready(function() {
    $('#datatable').dataTable();
    
     $("[data-toggle=tooltip]").tooltip();
    
} );

    </script>

<style>
  footer{
    bottom:0;
  } 
  </style>

</head>
<div class="main">


<div class="container">
	<div class="row" style="padding-bottom:20px">
    <div class="col-md-12">
			<h2>ALL<b> USERS</b></h2>
            
      <hr class="hr2" >

</div>
	</div>
    
        <div class="row">
		
            <div class="col-md-12">
            
            
<table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
    				<thead>
						<tr>
                            
                            <th>User #</th>
							<th>Name</th>
							<th>Email</th>
							<th>Age</th>
							<th>Type</th>
                           
							<th>DELETE</th>

						</tr>
					</thead>

					<tfoot>
						<tr>
            
            
                            <th>User #</th>
							<th>Name</th>
							<th>Email</th>
							<th>Age</th>
							<th>Type</th>
                           
							<th>DELETE</th>
							
                         
						</tr>
					</tfoot>

					<tbody>
                    <?php
  foreach($this->model->readuser() as $user){
    ?>

						<tr>
              
               <td><?php echo $user->ID; ?></td>
               <td><?php echo $user->Name; ?></td>
			   <td><?php echo  $user->Email; ?></td>
            <!--<td><?php // if ( $user->status==0 ) { echo 'Not Delivered';}  else{ echo 'Delivered';}?></td>  -->
              <td><?php echo  $user->Age; ?></td>
              <td><?php echo  $user->Type; ?></td>
              <td><form method="post" action='' ><?php echo '<button class="order-btn  btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete"  style="background-color:#FF7A00; color:white;" name="del" id="del" value="'.$user->ID.'"><span class="glyphicon glyphicon-trash" ></span></button>';?></td>	</tr>
					


                         	</tr>
					
                             <?php
  }
  ?>	
                
					</tbody>
				</table>

                </div>
	</div>
</div>

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit"aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header" >
          <h3 style="text-align:center"class="modal-title custom_align" id="Heading">Edit</h3>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        
      </div>
          <div class="modal-body">
            
          <div class="form-group">
        <input class="form-control " type="text" name="Pname" placeholder="Name">
        </div>


  

        <div class="form-group">
        <input class="form-control " type="text" name="Pdescription" placeholder="Description">
        </div>
       
        <div class="form-group">
        <input class="form-control " type="text" name="Pprice" placeholder="Price">
        </div>
        <div class="form-group">
      
      <select class="dropdown-toggle form-control" name="role"placeholder="Role">
        <option value="1" >User</option>
        <option value="2">Admin </option>
        
      </select>
      </div>
      </div>
          <div class="modal-footer ">
        <input type="submit" class="btn btn-warning btn-lg" id="Update" name="UopdateProduct" onsubmit="return false" value="UPDATE" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> 
        
      </div>

   
        </div>
    <!-- /.modal-content --> 
  </div>
      <!-- /.modal-dialog --> 
    </div>
    
    
    
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
          <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

      </div>
          <div class="modal-body">
       
       <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Record?</div>
       
      </div>
        <div class="modal-footer ">
        <button type="button" class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
      </div>
        </div>
    <!-- /.modal-content --> 
  </div>
      <!-- /.modal-dialog --> 
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