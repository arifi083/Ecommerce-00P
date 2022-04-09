<?php 
     $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/Database.php');
    include_once ($filepath.'/../helpers/Format.php');
?>

<?php
  class Product{
    private $db; 
    private $fm;

    public function __construct(){
        $this->db = new Database();
        $this->fm = new Format(); 
        
    }

    public function ProductInsert($data,$file){

        $productName    =  mysqli_real_escape_string($this->db->link, $data['productName'] );
        $category_id    =  mysqli_real_escape_string($this->db->link, $data['category_id'] );
        $brand_id       =  mysqli_real_escape_string($this->db->link, $data['brand_id'] );
        $description    =  mysqli_real_escape_string($this->db->link, $data['description'] );
        $price          =  mysqli_real_escape_string($this->db->link, $data['price'] );
        $type	        =  mysqli_real_escape_string($this->db->link, $data['type'] );


        $permited = array('jpg','png','jpeg','gif');
        $file_name = $file['image']['name'];
        $file_size = $file['image']['size'];
        $file_temp = $file['image']['tmp_name'];
   
        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
        $uploaded_image = "upload/".$unique_image;

        if($productName == "" || $category_id == "" || $brand_id == "" || $description == "" || $price == "" || $type == ""){
            $msg = "<span class='error'> Feild must not be empty </span>";
            return $msg;
        }
        else{
            move_uploaded_file($file_temp, $uploaded_image);
            $query = "INSERT INTO product(productName,category_id,brand_id,description,price,image,type)
            VALUES ('$productName','$category_id','$brand_id','$description','$price','$uploaded_image','$type') ";

             $productInsert = $this->db->insert($query);
             if($productInsert){
                 $msg = "<span class='success'> Product Inserted Successfully </span>";
                 return $msg;
             }
             else{
                 $msg = "<span class='error'> Product Not Inserted Successfully </span>";
                 return $msg;
             }
            
        }

    } //end function

    public function getAllProduct(){
        $query = "SELECT product.*,category.catName,brand.brandName
                 FROM product
                 INNER JOIN category ON product.category_id = category.id
                 INNER JOIN brand ON product.brand_id = brand.id
                 ORDER BY product.id DESC ";
        $result = $this->db->select($query);
        return $result;
    }

    public function getProductById($id){
       $query ="SELECT * FROM product WHERE id='$id' ";
       $result = $this->db->select($query);
       return $result;
    }


    public function productUpdate($data,$file,$id){

        $productName    =  mysqli_real_escape_string($this->db->link, $data['productName'] );
        $category_id    =  mysqli_real_escape_string($this->db->link, $data['category_id'] );
        $brand_id       =  mysqli_real_escape_string($this->db->link, $data['brand_id'] );
        $description    =  mysqli_real_escape_string($this->db->link, $data['description'] );
        $price          =  mysqli_real_escape_string($this->db->link, $data['price'] );
        $type	        =  mysqli_real_escape_string($this->db->link, $data['type'] );


        $permited = array('jpg','png','jpeg','gif');
        $file_name = $file['image']['name'];
        $file_size = $file['image']['size'];
        $file_temp = $file['image']['tmp_name'];
   
        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
        $uploaded_image = "upload/".$unique_image;

        if($productName == "" || $category_id == "" || $brand_id == "" || $description == "" || $price == "" || $type == ""){
            $msg = "<span class='error'> Feild must not be empty </span>";
            return $msg;
        }
        else{
            if(!empty($file_name)){
                if ($file_size > 1054589) {
                    echo "<span class='error'>Image Size should be less then 1MB .</span>";
                }
                elseif (in_array($file_ext, $permited) === false) {
                    echo "<span class='error'> You can Upload Only".implode(',', $permited)."</span>";
                }
                else{
                    move_uploaded_file($file_temp, $uploaded_image);
                    $query = "UPDATE product 
                    SET
                      productName = '$productName',
                      category_id = '$category_id',
                      brand_id    = '$brand_id',
                      description = '$description',
                      price       = '$price',
                      image 	  = '$uploaded_image',
                      type        = '$type'
                      WHERE id    = '$id' ";
                      $update_row = $this->db->update($query);
                      if($update_row){
                           $msg = "<span class='success'> Product Updated Successfully </span>";
                           return $msg;
                       }
                       else{
                           $msg = "<span class='error'> Product Not Updated Successfully </span>";
                           return $msg;
                       }
                }
            }
            else{

                $query = "UPDATE product 
                SET
                  productName = '$productName',
                  category_id = '$category_id',
                  brand_id    = '$brand_id',
                  description = '$description',
                  price       = '$price',
                  type        = '$type'
                  WHERE id    = '$id' ";
                  $update_row = $this->db->update($query);
                  if($update_row){
                       $msg = "<span class='success'> Product Updated Successfully </span>";
                       return $msg;
                   }
                   else{
                       $msg = "<span class='error'> Product Not Updated Successfully </span>";
                       return $msg;
                   }

            }

            
        }

    } //end function


    public function delProductById($id){
        $query = "SELECT * FROM product WHERE id = '$id' ";
        $getData = $this->db->select($query);
        if($getData){
            while($delImg = $getData->fetch_assoc()){
                $delLink = $delImg['image'];
                unlink($delLink);
            }
        }
        $deletequery = "DELETE FROM product WHERE id ='$id'";
        $deleteData = $this->db->delete($deletequery);
        if($deleteData){
            $msg = "<span class='success'> Product Deleted Successfully </span>";
            return $msg;
        }
        else{
            $catmsg = "<span class='error'> Product Not Deleted Successfully </span>";
            return $msg;
        }
    } //end function


    public function getFeatureProduct(){
        $query = "SELECT * FROM product WHERE type='0' ORDER BY id DESC LIMIT 4";
        $result = $this->db->select($query);
        return $result;
    }

    public function getNewProduct(){
        $query ="SELECT * FROM product ORDER BY id DESC LIMIT 4"; 
        $result =$this->db->select($query);
        return $result;
    }

    public function getSingleProduct($id){
        $query ="SELECT product.*,category.catName,brand.brandName
                 FROM product
                 INNER JOIN category ON product.category_id = category.id
                 INNER JOIN brand ON product.brand_id = brand.id
                 AND product.id = '$id'
                 ORDER BY product.id DESC ";
        $result = $this->db->select($query);
        return $result;
                
    }

    public function firstBrand(){
        $query ="SELECT * FROM product WHERE brand_id ='1' ORDER BY id DESC LIMIT 1 ";
        $result = $this->db->select($query);
        return $result;
    }

    public function secondBrand(){
        $query ="SELECT * FROM product WHERE brand_id ='2' ORDER BY id DESC LIMIT 1 ";
        $result = $this->db->select($query);
        return $result;
    }


    public function thirdBrand(){
        $query ="SELECT * FROM product WHERE brand_id ='3' ORDER BY id DESC LIMIT 1 ";
        $result = $this->db->select($query);
        return $result;
    }


    public function fourBrand(){
        $query ="SELECT * FROM product WHERE brand_id ='4' ORDER BY id DESC LIMIT 1 ";
        $result = $this->db->select($query);
        return $result;
    }

    public function productByOnlyCat($id){
        $query = "SELECT * FROM category WHERE id ='$id' ";
        $result = $this->db->select($query);
        return $result;
    }

    public function producutByCat($id){
        $query = "SELECT * FROM product WHERE category_id ='$id' ";
        $result = $this->db->select($query);
        return $result;
    }






  }
?>