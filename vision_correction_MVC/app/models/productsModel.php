<?php
class productsModel extends model{

    public $title="products";

    
	public function readProd(){

        $this->dbh->query("SELECT * FROM products");
        return $this->dbh->resultSet();
        
        }
}