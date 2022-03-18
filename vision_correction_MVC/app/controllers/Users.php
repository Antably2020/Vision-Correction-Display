<?php
class Users extends Controller
{
    protected $t;
    public function register()
    {   
        $registerModel = $this->getModel();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $fullname=$_POST['fname'].' '.$_POST['lname'];
            $registerModel->setName($fullname);
            $registerModel->setEmail(trim($_POST['email']));
            $registerModel->setPassword(trim($_POST['password']));
            $registerModel->setConfirmPassword(trim($_POST['C_password']));
            $registerModel->setAge(trim($_POST['age']));

            //validation
            if (empty($registerModel->getName())) {
                $registerModel->setNameErr('Please enter a name');
            }
            if (empty($registerModel->getEmail())) {
                $registerModel->setEmailErr('Please enter an email');
            } elseif ($registerModel->emailExist($_POST['email'])) {
                $registerModel->setEmailErr('Email is already registered');
            }
            if (empty($registerModel->getPassword())) {
                $registerModel->setPasswordErr('Please enter a password');
            } elseif (strlen($registerModel->getPassword()) < 4) {
                $registerModel->setPasswordErr('Password must contain at least 4 characters');
            }

            if ($registerModel->getPassword() != $registerModel->getConfirmPassword()) {
                $registerModel->setConfirmPasswordErr('Passwords do not match');
            }

            if (
                empty($registerModel->getNameErr()) &&
                empty($registerModel->getEmailErr()) &&
                empty($registerModel->getPasswordErr()) &&
                empty($registerModel->getConfirmPasswordErr())
            ) {
                //Hash Password
                $registerModel->setPassword($_POST['password']);

                if ($registerModel->signup()) {
                    header('location: ' . URLROOT . 'public/users/login');
                } else {
                    die('Error in sign up');
                }
            }
        }
        // Load form
        //echo 'Load form, Request method: ' . $_SERVER['REQUEST_METHOD'];
        $viewPath = VIEWS_PATH . 'users/Register.php';
        require_once $viewPath;
        $view = new Register($this->getModel(), $this);
        $view->output();
    }

    public function addeyeinputs()
    {   
        $eyeinputsModel = $this->getModel();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $eyeinputsModel->setFocal(trim($_POST['focal']));
            $eyeinputsModel->setFocus(trim($_POST['focus']));
            $eyeinputsModel->setDo(trim($_POST['do']));
            $eyeinputsModel->setFstop(trim($_POST['fstop']));
            $eyeinputsModel->setConfirmPassword(trim($_POST['resolution']));
            $eyeinputsModel->setDtype(trim($_POST['dtype']));

            //validation
            
            if (empty($eyeinputsModel->getFocal())) {
                $eyeinputsModel->setFocalErr('Please focal length');
            }
            if (empty($eyeinputsModel->getFocus())) {
                $eyeinputsModel->setFocusErr('Please enter focus');
            }
            if (empty($eyeinputsModel->getDo())) {
                $eyeinputsModel->setDoErr('Please enter Do');
            }
            if (empty($eyeinputsModel->getFstop())) {
                $eyeinputsModel->setFstopsErr('Please enter Fstop');
            }
            if (empty($eyeinputsModel->getResolution())) {
                $eyeinputsModel->setResolutionErr('Please enter Resolution');
            }
            if (empty($eyeinputsModel->getDtype())) {
                $eyeinputsModel->setDtyprErr('Please enter Device Type');
            }
           

            if (
                empty($eyeinputsModel->getFocal()) &&
                empty($eyeinputsModel->getFocus()) &&
                empty($eyeinputsModel->getDo()) &&
                empty($eyeinputsModel->getFstop())
            ) {
                //Hash Password
                $eyeinputsModel->setFstop($_POST['fstop']);

                if ($eyeinputsModel->addeyeinputs()) {
                    header('location: ' . URLROOT . 'public/users/login');
                } else {
                    die('Error in sign up');
                }
            }
        }
        // Load form
        //echo 'Load form, Request method: ' . $_SERVER['REQUEST_METHOD'];
        $viewPath = VIEWS_PATH . 'users/eye_inputs.php';
        require_once $viewPath;
        $view = new Eyeinputs($this->getModel(), $this);
        $view->output();
    }

    public function login()
    {
        $userModel = $this->getModel();

        if(!isset($_SESSION['ID'])){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //process form
            $userModel->setEmail(trim($_POST['email']));
            $userModel->setPassword(trim($_POST['password']));
            //validate login form
            if (empty($userModel->getEmail())) {
                $userModel->setEmailErr('Please enter an email');
            } elseif (!($userModel->emailExist($_POST['email']))) {
                $userModel->setEmailErr('No user found');
            }

            if (empty($userModel->getPassword())) {
                $userModel->setPasswordErr('Please enter a password');
            } elseif (strlen($userModel->getPassword()) < 4) {
                $userModel->setPasswordErr('Password must contain at least 4 characters');
            }


            if ($result=$userModel->findUserByEmail($_POST['email'],$_POST['password'])) {
                //Check login is correct

                $t= $result->Type;
               $_SESSION['ID']=$result->ID;
               if($t=='user')
               {
                header('location: ' . URLROOT . 'public/pages/Correctimage');
               }
               else if($t=='admin')
               {
                header('location: ' . URLROOT . 'public/admin/Correctimage');
               }

            }
            else{ 
                echo '<script> window.location = "login";
                alert("Incorrect Username or Password");
              </script>';
               // header('location: ' . URLROOT . 'public/users/login');
                   
            }
        }
    }
    else{
        header('location: ' . URLROOT . 'public/pages/index');
    }
        // Load form
        //echo 'Load form, Request method: ' . $_SERVER['REQUEST_METHOD'];
        $viewPath = VIEWS_PATH . 'users/Login.php';
        require_once $viewPath;
        $view = new Login($userModel, $this);
        $view->output();
    }

}
