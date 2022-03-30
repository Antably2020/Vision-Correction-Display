<?php
class correctimageModel extends model{
public $title="correct image";


protected $photo_result;


protected $userID;


public function __construct()
{
    parent::__construct();
    $this->userID    = '';
    
}
public function getuserID()
{
    return $this->userID;
}
public function setuserID($userID)
{
    $this->userID = $userID;
}
public function setImage($photo_result){
    $this->photo_result=$photo_result;

}

public function uploadhistory(){
    $this->dbh->query("INSERT INTO history (`userID`, Img) VALUES(:userID, :photo_result) ");
    $this->dbh->bind(':photo_result',$this->photo_result);
    $this->dbh->bind(':userID', $_SESSION['ID']);
    return $this->dbh->execute();
}


}
?>