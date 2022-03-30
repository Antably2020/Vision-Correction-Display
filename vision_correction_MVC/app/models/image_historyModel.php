
<?php
class image_historyModel extends model{
public $title="history";


    protected $Img;
    protected $id;
    protected $created_at;


public function readProd()
{
    $this->dbh->query("SELECT * FROM history WHERE userID= :userID ");
    return $this->dbh->resultSet();
    $this->dbh->bind(':id', $_SESSION['ID']);
}



    public function __construct()
    {
        parent::__construct();
        $this->id     = "";
        $this->Img = "";
        $this->created_at = "";
    }

    
    public function setPImg($Img)
    {
        $this->Img = $Img;
    }
    public function getImg()
    {
        return $this->Img;
    }
    public function setcreated_at($created_at)
    {
        $this->created_at = $created_at;
    }
  


    
    public function getuserID()
    {
        return $this->userID;
    }
    public function setuserID($userID)
    {
        $this->userID = $userID;
    }


    public function readhistory($userID)
    {       
        $this->dbh->query('select * from history where userID= :userID ' );
        $this->dbh->bind(':userID', $userID);

        return $this->dbh->resultSet(); 
}
    

function deleteimage($Img) {

    $this->dbh->query( "DELETE FROM history WHERE Img = :Img ");
        $this->dbh->bind(':Img', $Img);
        
    return $this->dbh->execute();
}



}







?>

