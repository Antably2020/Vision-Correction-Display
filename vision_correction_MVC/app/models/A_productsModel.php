
<?php
class A_productsModel extends model{
public $title="Products";


    protected $Pname;
    protected $Pdescription;
    protected $Pprice;


public function readProd()
{
    $this->dbh->query("SELECT * FROM products");
    return $this->dbh->resultSet();
}

    public function __construct()
    {
        parent::__construct();
        $this->Pname     = "";
        $this->Pdescription = "";
        $this->Pprice = "";
    }

    
    public function setPName($Pname)
    {
        $this->Pname = $Pname;
    }
    public function setDescription($Pdescription)
    {
        $this->Pdescription = $Pdescription;
    }
    public function setPprice($Pprice)
    {
        $this->Pprice = $Pprice;
    }
   

    

function deleteProduct($id) {

    $this->dbh->query( "DELETE FROM products WHERE id = :id ");
        $this->dbh->bind(':id', $id);
        
    return $this->dbh->execute();
}

function editProduct($id) {

    $this->dbh->query( "UPDATE `products` SET `name` = :name, `description` = :desc , `price` = :price WHERE `id` = :id; ");
        $this->dbh->bind(':id', $id);
        $this->dbh->bind(':name', $this->Pname);
        $this->dbh->bind(':description', $this->Pdescription);
        $this->dbh->bind(':price', $this->Pprice);

    return $this->dbh->execute();
}

}







?>

