<?php
require_once("DB.class.php");

class UploadImage
{
    private $imgName;
    private $imgType;
    private $imgTemp;

    public function __construct($name, $tmp, $type)
    {
        $this->imgName = $name;
        $this->imgType = $type;
        $this->imgTemp = $tmp;
    }

    /**
     * Move uploaded image to the folder
     * @return bool
     */
    public function Upload()
    {
        if (empty($this->imgName)) return 0;
        $isuploaded =  move_uploaded_file($this->imgTemp, "uploads/" . $this->imgName);
        if ($isuploaded) return 1;
        return 0;
    }
}


class User
{
    private $ID;
    private $db;
    private $Con;
    private $Userdata;
    public function __construct()
    {
        $this->db = new DB();
        $this->Con = $this->db->Con;
    }

    /**
     * Create new account 
     * @param $name
     * @param $email
     * @param $password
     * @param $gender
     * @param $pics
     */
    public function CreateAccount($name, $email, $password, $gender, $pics = array())
    {
        $Insert = "INSERT INTO `user` VALUES (NULL,?,?,?,?,?)";
        $Query = $this->Con->prepare($Insert);
        if ($pics[0] != NULL) {
            $up = new UploadImage($pics[0], $pics[1], $pics[2]);
            $up->Upload();
        }
        $Query->bind_param('sssis', $name, $password, $email, $gender, $pics[0]);
        $Check = $Query->execute();
        if ($Check) echo "Your account is created succussfuly";
        else echo "Failed to create your account";
    }

    /**
     * Check if user data exists in DB 
     * @param $name
     * @param $password
     * @return bool
     */
    public function LogIn($name, $password)
    {
        $Select = "SELECT * FROM `user` WHERE `Name` = ? and `Password` = ?";
        $Query = $this->Con->prepare($Select);
        $Query->bind_param('ss', $name, $password);
        $Check = $Query->execute();
        if (!$Check) return 0;
        $Result = $Query->get_result();
        if ($Result->num_rows) {
            $this->Userdata = $Result->fetch_assoc();
            return true;
        }
        return false;
    }

    /**
     * Edit data of an account 
     * @param $ID
     * @param $name
     * @param $email
     * @param $password
     * @param $gender
     * @param $pics
     * @return bool
     */
    public function EditAccount($ID, $name, $email, $password, $gender, $pics = array())
    {
        $cnt = 0;
        $Update = "UPDATE `user` SET `Name` = ? , `Email` = ? , `Gender` = ? , `Password` = ?";
        if ($pics[0] != "") {
            $Update .= " , Pic = ?";
            $cnt = 1;
        }
        $Update .= " WHERE `ID` = ?";
        $Query = $this->Con->prepare($Update);
        if (!$cnt) $Query->bind_param('ssssi', $name, $email, $gender, $password, $ID);
        else $Query->bind_param('sssssi', $name, $email, $gender, $password, $pics[0], $ID);
        $Check = $Query->execute();
        if (!$Check) return false;
        $up = new UploadImage($pics[0], $pics[1], $pics[2]);
        $up->Upload();
        return true;
    }

    /**
     * Get all data of a user
     * @param $ID
     * @return array
     */
    public function GetDataFromDB($ID)
    {
        $Select = "SELECT * FROM `user` WHERE `ID` = ? ";
        $Query = $this->Con->prepare($Select);
        $Query->bind_param('i', $ID);
        $Check = $Query->execute();
        if (!$Check) return 0;
        $Result = $Query->get_result();
        if ($Result->num_rows) {
            $this->Userdata = $Result->fetch_assoc();
            return $this->GetUserData();
        }
    }

    /**
     * @return array
     */
    public function GetUserData()
    {
        return $this->Userdata;
    }

    public function __destruct()
    {
        $this->db->Close();
    }
}
