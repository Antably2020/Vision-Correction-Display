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

    $photo_result=null;
    $type='';
    $path='';
    global $photo_result;
    global $path;
    global $type;
    if(isset($_FILES['Img'])){
      $path="C:/xampp/htdocs/Vision-Correction-Display/vision_correction_MVC/images/tmp/".time().".".pathinfo($_FILES['Img']['name'], PATHINFO_EXTENSION);
      $type=2;
      move_uploaded_file($_FILES['Img']['tmp_name'],$path);
      $path=escapeshellarg($path);
      $type=escapeshellarg($type);
      $photo_result = shell_exec('python C:/xampp/htdocs/Vision-Correction-Display/vision_correction_MVC/app/controllers/testAPI2.py "'.$path.'" "'.$type.'" 2>&1');
 
     echo $type;
      echo $photo_result;

    }
  
    
    $CorrectImageModel = $this->getModel();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $CorrectImageModel->setImage($photo_result);
         
      if (isset($input->post->form2)){

        
      }
       
        if($CorrectImageModel->uploadhistory()){
           
        }
        else{
            die('Error has occured');
        }


    }
    
        $viewPath = VIEWS_PATH . 'pages/Correctimage.php';
        require_once $viewPath;
        $correctimageView = new Correctimage($this->getModel(), $this);
        $correctimageView->output();
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




public function image_history()
{

    global $photo_result;
    $image_historyModel = $this->getModel();
    echo $photo_result;
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $image_historyModel->readhistory($_SESSION['ID']);
        //process form
        if(isset($_POST['del']))
            {
                $image_historyModel->deleteimage($_POST['del']);
                echo'<script>alert("Image Deleted")</script>';
            }
            
           
            
    }

    
    $viewPath = VIEWS_PATH . 'pages/image_history.php';
    require_once $viewPath;
    $adminView = new image_history($this->getModel(), $this);
    $adminView->output();
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
