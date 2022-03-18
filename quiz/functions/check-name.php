<?php
    session_start();
    if(isset($_SESSION['name'])){
        if(strlen($_SESSION['name']) > 0){
            echo "1";
        }
    }
?>