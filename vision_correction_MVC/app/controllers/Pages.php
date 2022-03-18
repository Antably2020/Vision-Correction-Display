<?php
class Pages extends Controller
{

    public function index()
    {
        $viewPath = VIEWS_PATH . 'pages/Index.php';
        require_once $viewPath;
        $indexView = new Index($this->getModel(), $this);
        $indexView->output();
    }

    public function correctimage()
    {
        $viewPath = VIEWS_PATH . 'pages/Correctimage.php';
        require_once $viewPath;
        $correctimageView = new Correctimage($this->getModel(), $this);
        $correctimageView->output();
    }



    public function products()
    {
        $viewPath = VIEWS_PATH . 'pages/products.php';
        require_once $viewPath;
        $productView = new products($this->getModel(), $this);
        $productView->output();
    }

    public function errorr()
    {
        $viewPath = VIEWS_PATH . 'pages/Errorr.php';
        require_once $viewPath;
        $errorrView = new Errorr($this->getModel(), $this);
        $errorrView->output();
    }
    
    public function dashboard()
    {
        $DashboardModel = $this->getModel();
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
            if(isset($_POST['update']))
            {
                $DashboardModel->setUName(trim($_POST['name']));
                $DashboardModel->setUEmail(trim($_POST['email']));
                $DashboardModel->setUPassword(trim($_POST['password']));

                $DashboardModel->editProduct();
                echo'<script>alert("Profile Updated")</script>';
            }
        }
        $viewPath = VIEWS_PATH . 'admin/dashboard.php';
        require_once $viewPath;
        $dashboardView = new Dashboard($this->getModel(), $this);
        $dashboardView->output();
    }




    public function profile()
    {

        $ProfileView = $this->getModel();
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
            if(isset($_POST['update']))
            {
                $ProfileView->setUName(trim($_POST['name']));
                $ProfileView->setUEmail(trim($_POST['email']));
                $ProfileView->setUPassword(trim($_POST['password']));

                $ProfileView->editProduct();
                echo'<script>alert("Profile Updated")</script>';
            }
        }

        $viewPath = VIEWS_PATH . 'pages/profile.php';
        require_once $viewPath;
        $profileView = new profile($this->getModel(), $this);
        $profileView->output();

    
    }
    public function contact(){
        $contactModel = $this->getModel();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //process form
            $contactModel->setEmail(trim($_POST['email']));
            $contactModel->setComplain(trim($_POST['choice']));
            $contactModel->setDesc(trim($_POST['desc']));

            if($contactModel->contactus()){
                echo '<script>';  
                echo 'alert("Complain sent successfully!!!")';  
                echo '</script>'; 
            }
            else{
                die('Error has occured');
            }


        }
        $viewPath=VIEWS_PATH. 'pages/contact.php';
        require_once $viewPath;
        $contactView=new contact($this->getModel(),$this);
        $contactView->output();

    }



    public function checkout(){
        $checkoutModel = $this->getModel();
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            //process form
            if(isset($_POST['order']))
            {
                foreach($checkoutModel->readCart($_SESSION['ID']) as $product)
                {
            $checkoutModel->setname(trim($_POST['name']));
            $checkoutModel->setemail(trim($_POST['email']));
            $checkoutModel->setphone(trim($_POST['phone']));
            $checkoutModel->setcity(trim($_POST['city']));
            $checkoutModel->setaddress(trim($_POST['address']));
            $checkoutModel->setstreet(trim($_POST['street']));
            $checkoutModel->setbuilding(trim($_POST['building']));
            $checkoutModel->setfloor(trim($_POST['floor']));

            $checkoutModel->Checkout($product->productID);
            $checkoutModel->deleteAllCart($product->id);
                }

                
                echo'<script>alert("Order Added")</script>';
            }
        }


        $viewPath=VIEWS_PATH. 'pages/checkout.php';
        require_once $viewPath;
        $checkoutView=new checkout($this->getModel(), $this);
        $checkoutView->output();
        /*if($checkoutModel->checkout()){
            echo '<script>';  
            echo 'alert("Order Placed successfully!!!")';  
            echo '</script>'; 
        }
        else{
            die('Error has occured');
        }
*/

    }


        
    public function add_product(){
        $add_producttModel = $this->getModel();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $path='images/'.$_POST['img'];
            //process form
            $add_producttModel->setName(trim($_POST['name']));
            $add_producttModel->setDesc(trim($_POST['description']));
            $add_producttModel->setoldPrice(trim($_POST['oldprice']));
            $add_producttModel->setPrice(trim($_POST['price']));
            $add_producttModel->setimage($path);
            $add_producttModel->setFeatured(trim($_POST['featured']));
            $add_producttModel->setCategory(trim($_POST['choice']));

            if($add_producttModel->contactus()){
                echo '<script>';  
                echo 'alert("Item added successfully!!!")';  
                echo '</script>'; 
            }
            else{
                die('Error has occured');
            }


        }
        $viewPath=VIEWS_PATH. 'admin/add_product.php';
        require_once $viewPath;
        $add_productView=new contact($this->getModel(),$this);
        $add_productView->output();




    }
    public function cart()
    {
        
        $cartModel = $this->getModel();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $cartModel->readCart($_SESSION['ID']);
            if(isset($_POST['del']))
            {
                $cartModel->deleteCartProduct($_POST['del']);
                echo'<script>alert("Product Deleted")</script>';
            }
        }
        // Load form
        //echo 'Load form, Request method: ' . $_SERVER['REQUEST_METHOD'];
        $viewPath = VIEWS_PATH . 'pages/cart.php';
        require_once $viewPath;
        $cartView = new Cart($this->getModel(), $this);
        $cartView->output();
        

    }


public function productdescription()
{
    $descModel = $this->getModel();
    if(isset($_POST['addC'])){
        if(isset($_SESSION['ID'])){
        $quan=$_POST['quantity'];
        $pri;
        $PID=$_POST['addC'];
        foreach ($descModel->readProd($PID) as $product){
            $pri=$product->price;
        }
        $total=$quan*$pri;
        if($descModel->addCart($PID,$quan,$total)){
            
            echo '<script> window.location = "products";
            alert("ADDED TO CART!");
          </script>';
        }
    }
    else{
                header('location: ' . URLROOT . 'public/users/login');

    }

    }

    $viewPath = VIEWS_PATH . 'pages/ProductDescription.php';
    require_once $viewPath;
    $proddesc = new productdescription($this->getModel(), $this);
    $proddesc->output();
}

public function categorizedProduct()
{
    $viewPath = VIEWS_PATH . 'pages/categorizedProduct.php';
    require_once $viewPath;
    $prodcat = new categorizedProduct($this->getModel(), $this);
    $prodcat->output();
}

public function A_products()
{
    $A_productsModel = $this->getModel();
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        //process form
        if(isset($_POST['del']))
            {
                $A_productsModel->deleteProduct($_POST['del']);
                echo'<script>alert("Product Deleted")</script>';
            }
            
            if(isset($_POST['edit']))
            {
                $A_productsModel->setPName(trim($_POST['name']));
                $A_productsModel->setDescription(trim($_POST['desc']));
                $A_productsModel->setPprice(trim($_POST['price']));

                $A_productsModel->updateProduct($_POST['edit']);
                echo'<script>alert("Product Updated")</script>';
            }
            
    }

    
    $viewPath = VIEWS_PATH . 'admin/A_products.php';
    require_once $viewPath;
    $adminView = new A_products($this->getModel(), $this);
    $adminView->output();
}


public function A_orders()
{
    $viewPath = VIEWS_PATH . 'admin/A_orders.php';
    require_once $viewPath;
    $adminOrdersView = new A_orders($this->getModel(), $this);
    $adminOrdersView->output();
}
public function A_Messages()
{
    $viewPath = VIEWS_PATH . 'admin/A_Messages.php';
    require_once $viewPath;
    $adminmessagesView = new A_Messages($this->getModel(), $this);
    $adminmessagesView->output();
}



public function A_userview()
{
    $A_usersModel = $this->getModel();
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        //process form
        $A_usersModel->deleteUser($_POST['del']);
        echo'<script>alert("User Deleted")</script>';
    }
    $viewPath = VIEWS_PATH . 'admin/A_userview.php';
    require_once $viewPath;
    $adminuserview = new A_Userview($this->getModel(), $this);
    $adminuserview->output();
}




}
