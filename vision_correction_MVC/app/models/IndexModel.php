<?php
class IndexModel extends model{
     public $title = 'MIU SE305 Blog V1.0';
     public $subtitle = 'Example of MVC PHP framework';

      
	public function readProd(){

          $this->dbh->query("SELECT * FROM products");
          return $this->dbh->resultSet();
          
          }

          public function readcat(){

               $this->dbh->query("SELECT * FROM categories");
               return $this->dbh->resultSet();
               
               }
}