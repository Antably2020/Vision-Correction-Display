<?php 
class A_Messages extends view{
    public function output (){
        $title = $this->model->title;
?>

<head>
  <style>
    footer{
      bottom:0
    }
    </style>
    </head>

        <div >
        <?php require APPROOT . '/views/inc/adminHeader.php';  ?>
        </div >

        <div class="main">


<div class="container">
	<div class="row" style="padding-bottom:20px">
    <div class="col-md-12">
			<h2>ALL<b> MESSAGES</b></h2>
            
      <hr class="hr2" >

</div>
	</div>
    
        <div class="row">
		
            <div class="col-md-12">
            
            
<table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
    	<thead>
			<tr>
                            
                <th>Email</th>
			    <th>Complain</th>
                <th>Description</th>
			
			</tr>
		</thead>
        <tfoot>
			<tr>
            
                <th>Email</th>
			    <th>Complain</th>
				<th>Description</th>
            </tr>
		</tfoot>

		<tbody>

          <?php
    foreach($this->model->readmessage() as $contact)
    {
           ?>

						<tr>
              
               <td><?php echo $contact->email; ?></td>
               <td><?php echo $contact->complain; ?></td>
               <td><?php echo $contact->description; ?></td>

                     	</tr>
					
<?php
  }
  ?>	
          
                        
					</tbody>
				</table>

	
	</div>
	</div>
</div>

</div>
   
   <?php
  require APPROOT . '/views/inc/footer.php';
  }
}
?>