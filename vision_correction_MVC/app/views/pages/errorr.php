<?php 
class  Errorr extends view{
    public function output (){
        $title = $this->model->title;
    require APPROOT . '/views/inc/header.php';
    ?>  
    <div style="background-color: #FF7A00 ; width:100%; margin-top:147px">
    <div class="row  justify-content-center align-items-center" style="margin-bottom:-40px;">
    <label style="font-size:40px; ">OOPS!!</label><br>
    </div>
        <div class="row  justify-content-center align-items-center"style="margin-bottom:-40px;">

           
            <label style="font-size:150px; ">4</label> 
            <img src=<?php echo URLROOT . 'images/Wheel.png';?> alt="Wheel" style="width : 100px; height:100px;"> 
            <label style="font-size:150px;">4</label>
    
</div>    
<div class="row  justify-content-center align-items-center">
<label style="font-size:20px;  "><b>ERROR</b> The requested page does not exist</label>
</div>
    </div>  
 <?php

require APPROOT . '/views/inc/footer.php';

  }
}
?>
