<?php 
     $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/Database.php');
    include_once ($filepath.'/../helpers/Format.php');
?>





<?php
class Brand{
    private $db; 
    private $fm;

    public function __construct(){
        $this->db = new Database();
        $this->fm = new Format(); 
        
    }

    public function brandInsert($brandName){
        $brandName = $this->fm->validation($brandName);
        $brandName = mysqli_real_escape_string($this->db->link,$brandName);
       
        if(empty($brandName) ){
            $brandmsg = "<span class='error'> Brand  must not be empty </span>";
            return $brandmsg;
        }
        else{
            $query = "INSERT INTO brand(brandName) VALUES ('$brandName')"; 
            $brandInsert = $this->db->insert($query);
            if($brandInsert){
                $brandmsg = "<span class='success'> Brand Inserted Successfully </span>";
                return $brandmsg;
            }
            else{
                $brandmsg = "<span class='error'> Brand Not Inserted Successfully </span>";
                return $brandmsg;
            }
            
            
            
        }

    } //end function

    public function getAllBrand(){
        $query = "SELECT * FROM brand ORDER BY id DESC";
        $result = $this->db->select($query);
        return $result;
    }

    public function getBrandById($id){
        $query = "SELECT * FROM brand WHERE id ='$id' ";
        $result = $this->db->select($query);
        return $result;
    }

    public function brandUpdate($id,$brandName){
        $brandName = $this->fm->validation($brandName);
        $brandName = mysqli_real_escape_string($this->db->link,$brandName);
        $id = mysqli_real_escape_string($this->db->link,$id);

        if(empty($brandName)){
            $brandmsg = "<span class='error'> Brand  must not be empty </span>";
            return $brandmsg;
        }
        else{
            $query = "UPDATE brand
            SET 
            brandName = '$brandName'
            WHERE id = '$id' ";
            $update_row = $this->db->update($query);
             if($update_row){
                $brandmsg = "<span class='success'> Brand Updated Successfully </span>";
                return $brandmsg;
            }
            else{
                $brandmsg = "<span class='error'> Brand Not Updated Successfully </span>";
                return $brandmsg;
            }
        }

    } //end function

    public function delBrandById($id){
        $query = "DELETE FROM brand WHERE id = '$id' ";
        $delete_row = $this->db->delete($query);
        if($delete_row){
            $brandmsg = "<span class='success'> Brand Deleted Successfully </span>";
            return $brandmsg;
        }
        else{
            $brandmsg = "<span class='error'> Brand Not Deleted Successfully </span>";
            return $brandmsg;
        }
        
    }

    

  
  




}
?> 