<?php
    session_start();
    if(isset($_POST['names'])){
        $name = $_POST['names'];
        echo $name;
        $_SESSION['name'] = $name;
    }
?>