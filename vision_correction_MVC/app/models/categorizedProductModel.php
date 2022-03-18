<?php
require_once 'categorizedProductModel.php';
class categorizedproductModel extends model{

    public $title="products";

    protected $category;

    public function getcategory()
    {
        return $this->category;
    }
    public function setcategory($category)
    {
        $this->category = $category;
    }

    



    public function readrelativeProd($category){

        $this->dbh->query('SELECT * FROM products where category= :category');
        $this->dbh->bind(':category', $category);
        return $this->dbh->resultSet();
        
        }
}