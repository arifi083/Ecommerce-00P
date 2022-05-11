<?php 
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/Database.php');
    include_once ($filepath.'/../helpers/Format.php');

?>


<?php

 
class User{
    private $db; 
    private $fm;

    public function __construct(){
        $this->db = new Database(); 
        $this->fm = new Format(); 
        
    }

    public function UserRegistration($data){
        //print_r($data);
        $name    =  mysqli_real_escape_string($this->db->link, $data['name'] );
        $address    =  mysqli_real_escape_string($this->db->link, $data['address'] );
        $city    =  mysqli_real_escape_string($this->db->link, $data['city'] );
        $country    =  mysqli_real_escape_string($this->db->link, $data['country'] );
        $zip    =  mysqli_real_escape_string($this->db->link, $data['zip'] );
        $email    =  mysqli_real_escape_string($this->db->link, $data['email'] );
        $phone    =  mysqli_real_escape_string($this->db->link, $data['phone'] );
        $pass        =  mysqli_real_escape_string($this->db->link, $data['pass']);

        if($name == "" || $address == "" || $city == "" || $country == "" || $zip == "" || $email == "" || $phone == "" || $password=""){
           $msg = "<span class='error' style='color:red'> Feild must not be empty </span>";
           return $msg;
        }
        $mailquery = "SELECT * FROM user WHERE email ='$email' LIMIT 1";
        $mailCheck = $this->db->select($mailquery);

        if($mailCheck != false){
            $msg = "<span class='error' style='color:red'> Email Already Exist </span>";
            return $msg;
        }
        else{
            $query = "INSERT INTO user(name,email,password,address,city,country,zip)
            VALUES ('$name','$email','$pass','$address','$city','$country','$zip') ";

             $userInsert = $this->db->insert($query);
             if($userInsert){
                 $msg = "<span class='success' style='color:green'> User Inserted Successfully </span>";
                 return $msg;
             }
             else{
                 $msg = "<span class='error'> User Not Inserted Successfully </span>";
                 return $msg;
             }
        }
       
    }// end function


    public function UserLogin($data){
        $email    =  mysqli_real_escape_string($this->db->link, $data['email'] );
        $pass    =  mysqli_real_escape_string($this->db->link, $data['pass'] );

        if($email =="" || $pass ==""){
            $msg = "<span class='error' style='color:red'> Feild must not be empty </span>";
            return $msg;
        }
        $query = "SELECT * FROM user WHERE email='$email' AND password='$pass' ";
        $result = $this->db->select($query);
        if($result !=false){
            $value = $result->fetch_assoc();
            Session::set("cuslogin",true);
            Session::set("cmrId",$value['id']);
            Session::set("cmrName",$value['name']); 
            header("Location:cart.php");
        }
        else{
            $msg = "<span class='error'> Email and Password not Match</span>";
            return $msg;
        }

    }



    public function getUserData($id){
        $query ="SELECT * FROM user WHERE id ='$id'";
        $result = $this->db->select($query);
        return $result;

    }

    public function UpdateUser($data,$cmrId){
        //print_r($data);
        $name    = mysqli_real_escape_string($this->db->link, $data['name'] );
        $phone    = mysqli_real_escape_string($this->db->link, $data['phone'] );
        $email    = mysqli_real_escape_string($this->db->link, $data['email'] );
        $zip    = mysqli_real_escape_string($this->db->link, $data['zip'] );
        $address    = mysqli_real_escape_string($this->db->link, $data['address']);
        $city    = mysqli_real_escape_string($this->db->link, $data['city'] );
        $country    = mysqli_real_escape_string($this->db->link, $data['country']);
       

        if($name == "" || $phone == "" || $email == "" || $zip == "" || $address == "" || $city == "" || $country==""){
            $msg = "<span class='error'> Feild must not be empty </span>";
            return $msg;
        }
        else{
            $query = "UPDATE user
            SET
            name 		= '$name',
            address 	= '$address',
            city 		= '$city',
            country 	= '$country',
            zip 		= '$zip',
            phone		= '$phone',
            email 		= '$email'
            WHERE id    = '$cmrId' "; 
            $update_row = $this->db->update($query);
            if($update_row){
                $msg = "<span class='success'> User Update Successfully </span>";
                return $msg;
            }
            else{
                $msg = "<span class='error'> User Not update Successfully </span>";
                return $msg;
            }
        }
        
        
    }  //end function

    public function getCustomerData($id){
        $query ="SELECT * FROM  user WHERE id='$id' ";
        $result = $this->db->select($query);
        return $result;
    }

}

?>