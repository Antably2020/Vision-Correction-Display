<?php
require_once 'ProductDescriptionModel.php';
class ProductDescriptionModel extends model
{
    public  $title = 'ProductDescription';
    protected $productID;
    protected $category;
    
    public function getproductID()
    {
        return $this->productID;
    }
    public function setproductID($productID)
    {
        $this->productID = $productID;
    }

    public function getcategory()
    {
        return $this->category;
    }
    public function setcategory($category)
    {
        $this->category = $category;
    }

	public function readProd($id)   {
        
        $this->dbh->query('SELECT * from products where id= :id ' );
        $this->dbh->bind(':id', $id);
        return $this->dbh->resultSet();   
}

    public function addCart($id,$quantity,$total){
       

        $this->dbh->query("INSERT INTO cart (productID, userID, quantity,sum ) VALUES(:productID, :userID, :quantity, :total)" );
        $this->dbh->bind(':productID', $id);
        $this->dbh->bind(':userID', $_SESSION['ID']);
        $this->dbh->bind(':quantity', $quantity);
        $this->dbh->bind(':total', $total);
         return $this->dbh->execute();
    }

    public function readrelativeProd($product){

        $this->dbh->query('SELECT * FROM products where category= :category');
        $this->dbh->bind(':category', $product);
        return $this->dbh->resultSet();
        
        }
    
}