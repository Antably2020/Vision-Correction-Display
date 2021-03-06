<?php
class correctimageModel extends model{
public $title="correct image";


protected $photo_result;


protected $userID;
protected $type;

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
public function setType($type){
    $this->type=$type;

}
public function setDegree($degree){
    $this->degree=$degree;

}


public function uploadhistory(){
    $this->dbh->query("INSERT INTO history (`userID`, Img, type,degree) VALUES(:userID, :photo_result, :type,:degree) ");
    $this->dbh->bind(':photo_result',$this->photo_result);
    $this->dbh->bind(':userID', $_SESSION['ID']);
    $this->dbh->bind(':type', $this->type);
     $this->dbh->bind(':degree', $this->degree);
    return $this->dbh->execute();
}


}
?>