<?php 
     $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/Database.php');
    include_once ($filepath.'/../helpers/Format.php');
?>




<?php
class Category{
    private $db; 
    private $fm;

    public function __construct(){
        $this->db = new Database();
        $this->fm = new Format(); 
        
    }

    public function CategoryInsert($catName){
        $catName = $this->fm->validation($catName); 
       

        $catName = mysqli_real_escape_string($this->db->link,$catName);
       
        if(empty($catName) ){
            $catmsg = "<span class='error'> Category must not be empty </span>";
            return $catmsg;
        }
        else{
            $query = "INSERT INTO category(catName) VALUES ('$catName')";
            $catInsert = $this->db->insert($query);
            if($catInsert){
                $catmsg = "<span class='success'> Category Inserted Successfully </span>";
                return $catmsg;
            }
            else{
                $catmsg = "<span class='error'> Category Not Inserted Successfully </span>";
                return $catmsg;
            }
            
            
            
        }

    } //end function

    public function getAllCat(){
        $query ="SELECT * FROM category ORDER BY id DESC"; 
        $result = $this->db->select($query);
        return $result;
    }

    public function getCatById($id){
        $query = "SELECT * FROM category WHERE id='$id' ";
        $result = $this->db->select($query);
        return $result;
    }

    public function updateCategory($catName,$id){
        $catName = $this->fm->validation($catName);
        $catName = mysqli_real_escape_string($this->db->link,$catName);
        $id = mysqli_real_escape_string($this->db->link,$id);

        if(empty($catName)){
            $catmsg = "<span class='error'> Category must not be empty </span>";
            return $catmsg;
        }
        else{
            $query = "UPDATE category 
            SET 
            catName = '$catName'
            WHERE id = '$id' ";
            $update_row = $this->db->update($query);
            if($update_row){
                $catmsg = "<span class='success'> Category Update Successfully </span>";
                return $catmsg;
            }
            else{
                $catmsg = "<span class='error'> Category Not update Successfully </span>";
                return $catmsg;
            }
        }

    }//end function

    public function delCatById($id){
        $query = "DELETE FROM category WHERE id='$id' ";
        $delete_row = $this->db->delete($query);
        if($delete_row){
            $catmsg = "<span class='success'> Category Deleted Successfully </span>";
            return $catmsg;
        }
        else{
            $catmsg = "<span class='error'> Category Not Deleted Successfully </span>";
            return $catmsg;
        }

    }




}
?> 