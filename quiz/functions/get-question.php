<?php
    include('../classes/DB.php');
    session_start();
    if(!isset($_SESSION['question'])){
        $_SESSION['question'] = 1;
        $_SESSION['results'] = [];
        $_SESSION['results'][0] = 0;
        $_SESSION['results'][1] = 0;
        $_SESSION['results'][2] = 0;
        $_SESSION['results'][3] = 0;
    }
    $object = new stdClass();
    if(DB::query('SELECT question FROM questions WHERE id=:id OR id>:id',array(':id'=>$_SESSION['question']))){
        $question = DB::query('SELECT question FROM questions WHERE id=:id OR id>:id',array(':id'=>$_SESSION['question']))[0]['question'];
        $answers = DB::query('SELECT * FROM answers WHERE question_id=:id',array(':id'=>$_SESSION['question']));
        $answers_array = [];
        foreach($answers as $a){
            $answer = new stdClass();
            $answer->id = $a['result_id'];
            $answer->answer = $a['answer'];
            array_push($answers_array,$answer);
        }
        $object = new stdClass();
        $object->question = $question;
        $object->answers = $answers_array;
        $object->question_number = $_SESSION['question'];
    }else{
        $object->finish = 1;
    }
    echo json_encode($object);
   
?>