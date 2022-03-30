<?php
    include('../classes/DB.php');
    session_start();
    $object = new stdClass();
    $heighest = 0;
    $i= 0;
    $heighestIndex=0;
    foreach($_SESSION['results'] as $r){
        if($r > $heighest){
            $heighest = $r;
            $heighestIndex=$i;
        }
        $i++;
    }
    
    if($_SESSION['results'][0]>5)
    {
        switch(true)
        {
        case $_SESSION['results'][1]>$_SESSION['results'][2]:
            $heighestIndex = 2;
            break;
        case $_SESSION['results'][1]<$_SESSION['results'][2]:
            $heighestIndex = 3;
            break;
        }
    }
    else{
        $heighestIndex++;
    }
    $results = DB::query("SELECT * FROM results WHERE id=:id",array(':id'=>$heighestIndex))[0];
    $object->username = $_SESSION['name'];
    $object->name = $results['name'];
    $object->description = $results['description'];
    $object->image = $results['image'];
    $object->share_link = explode(" ", $_SESSION['name'])[0]."/".$results['id'];
    echo json_encode($object);
?>