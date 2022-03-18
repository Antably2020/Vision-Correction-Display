<?php
class A_ordersModel extends model{
public $title="Orderes";




public function readorder()
{
    $this->dbh->query("SELECT * FROM orders");
    return $this->dbh->resultSet();
    
}
public function readproduct($id)
{
    $this->dbh->query("SELECT * FROM products where id=:id");
    $this->dbh->bind(':id', $id);
    return $this->dbh->resultSet();    
}


}


?>