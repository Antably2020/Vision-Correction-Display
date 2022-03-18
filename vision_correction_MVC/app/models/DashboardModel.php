<?php
class DashboardModel extends model{
    public  $title = "Dashboard";
  
    protected $Uname;
    protected $Uemail;
    protected $Upassword;

    public function __construct()
    {
        parent::__construct();
        $this->Uname  = "";
        $this->Uemail = "";
        $this->Upassword = "";
    }

    public function setUName($Uname)
    {
        $this->Uname = $Uname;
    }
    public function setUEmail($Uemail)
    {
        $this->Uemail = $Uemail;
    }
    public function setUPassword($Upassword)
    {
        $this->Upassword = $Upassword;
    }
   
    public function setID($id){
        $this->id=$id;
    }
    public function getID(){
        return $this->id;
    }


    
public function readuser($id)
{

    $this->dbh->query("SELECT * FROM users  WHERE id = :ids");
    $this->dbh->bind(':ids', $id);
    return $this->dbh->resultSet();
    
}


function editProduct() {

    $this->dbh->query( "UPDATE `users` SET `Name` = :name, `Email` = :email , `Password` = :password WHERE `ID` = :id; ");
        $this->dbh->bind(':id', $_SESSION['ID']);
        $this->dbh->bind(':name', $this->Uname);
        $this->dbh->bind(':email', $this->Uemail);
        $this->dbh->bind(':password', $this->Upassword);

    return $this->dbh->execute();
}

}
