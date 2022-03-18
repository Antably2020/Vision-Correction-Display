<?php
class A_userviewModel extends model{
public $title="Orderes";




public function readuser()
{

    $this->dbh->query("SELECT * FROM users");
    return $this->dbh->resultSet();
    
}
function deleteUser($id) {

    $this->dbh->query( "DELETE FROM users WHERE ID = :id ");
        $this->dbh->bind(':id', $id);
        
    return $this->dbh->execute();



}
}

?>