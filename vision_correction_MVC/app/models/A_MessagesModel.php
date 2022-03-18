<?php
class A_MessagesModel extends model{
public $title="Messages";


public function readmessage()
{
    $this->dbh->query("SELECT * FROM contact");
    return $this->dbh->resultSet();   
}

}
?>