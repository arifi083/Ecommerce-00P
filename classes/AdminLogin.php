<?php

  include '../lib/Session.php';
  Session::checkLogin();

  include_once '../lib/Database.php';
  include_once '../helpers/Format.php';

?>
 



<?php
class AdminLogin{
    private $db; 
    private $fm;

    public function __construct(){ 
        $this->db = new Database();
        $this->fm = new Format();
        
    }

    public function adminLogin($adminUser,$adminPass){
        $adminUser = $this->fm->validation($adminUser);
        $adminPass = $this->fm->validation($adminPass);

        $adminUser = mysqli_real_escape_string($this->db->link,$adminUser);
        $adminPass = mysqli_real_escape_string($this->db->link,$adminPass);

        if(empty($adminUser) || empty($adminPass)){
            $loginmsg = "User  name and password must not be empty";
            return $loginmsg;
        }
        else{
            $query = "SELECT * FROM admin WHERE adminUser='$adminUser' AND password='$adminPass' ";
            $result = $this->db->select($query);
            
            if($result != false){
                $value = $result->fetch_assoc();
                Session::set("adminlogin",true);
                Session::set("id",$value['id']);
                Session::set("adminUser",$value['adminUser']);
                Session::set("name",$value['name']);
                header("Location:dashboard.php");

            }
            else{
                $loginmsg = "username or password not match";
                return $loginmsg;
            }
            
        }

    }
}
?> 