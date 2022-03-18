<?php 
class add_productModel extends model{

    public $title="Add product model";
    protected $name ;
    protected $desc;
    protected $oldprice;
    protected $price;
    protected $image;
    protected $featured;
    protected $Category;

    public function __construct()
    {
        parent::__construct();
      $this->email="";
      $this->complain="";
      $this->desc="";

    }


    public function setName($name)
    {
        $this->name=$name;

    }
    
    public function setDesc($desc){
        $this->desc=$desc;

    }
    public function setoldPrice($oldprice){
        $this->oldprice=$oldprice;

    }

    public function setPrice($price){
        $this->price=$price;

    }
    public function setImage($image){
        $this->image=$image;

    }
    public function setFeatured($featured){
        $this->featured=$featured;

    }
    public function setCategory($category){
        $this->Category=$category;

    }

    public function contactus(){
        $this->dbh->query("INSERT INTO products (name, description, oldPrice, price, img, featured , category) VALUES(:name, :description , :oldprice, :price, :image, :featured , :category)");
        $this->dbh->bind(':name',$this->name);
        $this->dbh->bind(':description',$this->desc);
        $this->dbh->bind(':oldprice', $this->oldprice);
        $this->dbh->bind(':price', $this->price);
        $this->dbh->bind(':image',$this->image);
        $this->dbh->bind(':featured',$this->featured);
        $this->dbh->bind(':category',$this->Category);
        return $this->dbh->execute();
    }

}