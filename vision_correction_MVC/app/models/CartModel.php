<?php
require_once 'productsModel.php';
class CartModel extends model
{
    public  $title = 'Cart';
    protected $userID;
    protected $productID;
    protected $quantity;
    protected $sum;

    public function __construct()
    {
        parent::__construct();
        $this->userID    = '';
        $this->productID = '';
        $this->type    = '';

        $this->quantity    = '';
        $this->sum= '';
    }

    public function getuserID()
    {
        return $this->userID;
    }
    public function setuserID($userID)
    {
        $this->userID = $userID;
    }

    public function getproductID()
    {
        return $this->productID;
    }
    public function setproductID($productID)
    {
        $this->productID = $productID;
    }


    public function getquantity()
    {
        return $this->quantity;
    }
    public function setquantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getsum()
    {
        return $this->sum;
    }
    public function setsum($sum)
    {
        $this->sum= $sum;
    }

    public function readCart($userID)
    {       
        $this->dbh->query('select * from cart where userID= :userID ' );
        $this->dbh->bind(':userID', $userID);

        return $this->dbh->resultSet(); 
}
public function readProductFromCart($id)
    {
        
        $this->dbh->query('select * from products where id= :id ' );
        $this->dbh->bind(':id', $id);

        return $this->dbh->resultSet();   
}

public function productSum($quantity,$price)
    {
        return $quantity*$price;  
    }

    public function insertSum($sum,$id)
    {
        $this->dbh->query('Update cart set sum = :sum where id= :id ' );
        $this->dbh->bind(':sum', $sum);
        $this->dbh->bind(':id', $id);
        return $this->dbh->execute();
  
    }

    public function cartPoints($total,$userID)
    {
     
        $this->dbh->query('Update users set Points = :total where ID= :userid ' );
        $this->dbh->bind(':total', $total);
        $this->dbh->bind(':userid', $userID);
        return $this->dbh->execute();  
    }

    public function userPoints($id)
    {
     
        $this->dbh->query('select * from users where ID= :id ' );
        $this->dbh->bind(':id', $id);

        return $this->dbh->single();
    }
    function deleteCartProduct($id) {

        $this->dbh->query( "DELETE FROM cart WHERE productID = :id ");
            $this->dbh->bind(':id', $id);
            
        return $this->dbh->execute();
    }

}