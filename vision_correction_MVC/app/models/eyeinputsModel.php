<?php
require_once 'UserModel.php';
class EyeinputsModel extends UserModel
{
    public  $title = 'User eye inputs Page';
    protected $focal;
    protected $focalErr;
    protected $focus;
    protected $focusErr;
    protected $do;
    protected $dtype;

    public function __construct()
    {
        parent::__construct();
        $this->focal     = "";
        $this->focalErr = "";

        $this->focus = "";
        $this->focusErr = "";
    }

    public function getfocal()
    {
        return $this->focal;
    }

    public function setFocal($focal)
    {
        $this->focal = $focal;
    }
    public function setDo($do)
    {
        $this->do = $do;
    }

    public function getFocalErr()
    {
        return $this->focalErr;
    }

    public function setFocalErr($focalErr)
    {
        $this->focalErr = $focalErr;
    }

    public function getFocus()
    {
        return $this->focus;
    }
    public function setFocus($focus)
    {
        $this->focus = $focus;
    }

    public function getFocusErr()
    {
        return $this->focusErr;
    }
    public function setFocusErr($focusErr)
    {
        $this->focusErr = $focusErr;
    }

public function eye_inputs()
    {
        $this->dbh->query("INSERT INTO eyeinputs (focal, focus, do,fstop,resolution,dtype) VALUES(:focal, :focus, :do, :fstop, :resolution, :dtype)");
        $this->dbh->bind(':focal', $this->focal);
        $this->dbh->bind(':focus', $this->focus);
        $this->dbh->bind(':do', $this->do);
        $this->dbh->bind(':fstop', $this->fstop);
        $this->dbh->bind(':resolution', $this->resolution); 
        $this->dbh->bind(':dtype', $this->dtype);
        return $this->dbh->execute();
    }
}
