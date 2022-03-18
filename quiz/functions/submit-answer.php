<?php
    session_start();
    if(isset($_POST['answer'])){
        if($_POST['answer'] != 5 && $_POST['answer'] != "5"){
        $_SESSION['results'][intval($_POST['answer'])-1]++;
    }
    $_SESSION['question']++;
}

?>