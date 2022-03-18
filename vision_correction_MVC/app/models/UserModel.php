<?php
class UserModel extends model
{
    protected $email;
    protected $password;
    protected $type;

    protected $emailErr;
    protected $passwordErr;

    public function __construct()
    {
        parent::__construct();
        $this->email    = '';
        $this->password = '';
        $this->type    = '';

        $this->emailErr    = '';
        $this->passwordErr = '';
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getType()
    {
        return $this->type;
    }
    public function setType($type)
    {
        $this->type = $type;
    }

    public function getEmailErr()
    {
        return $this->emailErr;
    }
    public function setEmailErr($emailErr)
    {
        $this->emailErr = $emailErr;
    }

    public function getPasswordErr()
    {
        return $this->passwordErr;
    }
    public function setPasswordErr($passwordErr)
    {
        $this->passwordErr = $passwordErr;
    }

    public function findUserByEmail($email,$password)
    {
        $this->dbh->query('select * from users where Email= :email and Password= :pass ' );
        $this->dbh->bind(':email', $email);
        $this->dbh->bind(':pass', $password);

        $userRecord = $this->dbh->single();
        return $this->dbh->single();
       
    }


    public function emailExist($email)
    {
        return $this->findUserByEmail($email,$password) > 0;
    }
}
