<?php 
     $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/Database.php');
    include_once ($filepath.'/../helpers/Format.php');
?>


<?php
class Cart{
    private $db; 
    private $fm;

    public function __construct(){
        $this->db = new Database();
        $this->fm = new Format(); 
        
    }

    public function addToCart($quantity,$id){
        $quantity = $this->fm->validation($quantity);
        $quantity = mysqli_real_escape_string($this->db->link,$quantity);
        $proId =  mysqli_real_escape_string($this->db->link,$id);
        $sId = session_id();

        $query = "SELECT * FROM product WHERE id='$proId'";
        $result = $this->db->select($query)->fetch_assoc();
        
        $productName = $result['productName'];
        $price = $result['price'];
        $image = $result['image'];

        $chquery = "SELECT * FROM cart WHERE product_id = '$proId' AND sId ='$sId'";
        $getPro = $this->db->select($chquery);
        if($getPro){
            $msg = "Product Already Added!";
    	    return $msg;
        }
        else{
            $query = "INSERT INTO cart(sid,	product_id,productName,price,quantity,image)
            VALUES ('$sId','$proId','$productName','$price','$quantity','$image') ";

             $cartInsert = $this->db->insert($query);
             if($cartInsert){
                header("Location:cart.php");
             }
             else{
                header("Location:404.php");
             }
        }

    }//end function

    public function getCartProduct(){
        $sid = session_id();
        $query ="SELECT * FROM cart WHERE sid ='$sid'";
        $result = $this->db->select($query);
        return $result;
    }

    public function updateCartQuantity($id,$quantity){
        $id = mysqli_real_escape_string($this->db->link,$id);
        $quantiy = mysqli_real_escape_string($this->db->link,$quantity);
       
        $query = "UPDATE cart
          SET 
          quantity = '$quantity'
          WHERE id = '$id' ";
          $update_row = $this->db->update($query);
          if($update_row){
            header("Location:cart.php");
          }
          else{
               $msg = "<span class='error'>Quantity Not Updated .</span> ";
              return $msg;
            }
      


    }//end function


    public function delCartById($id){
        $query = "DELETE FROM cart WHERE id = '$id' ";
        $delete_row = $this->db->delete($query);
        if($delete_row){
             echo "<script>window.location = 'cart.php';</script> ";
        }
        else{
            $msg = "<span class='error'>Product Not Deleted .</span> ";
            return $msg;
        }
    }


    public function checkCartTable(){
        $sid = session_id();
        $query ="SELECT * FROM cart WHERE sid ='$sid'";
        $result = $this->db->select($query);
        return $result;
    }

    public function delCustomerCart(){
        $sid = session_id();
        $query ="DELETE FROM cart WHERE sid ='$sid'";
        $this->db->delete($query);
    }


    public function orderProduct($cmrId){
        $sId = session_id();
        $query = "SELECT * FROM cart WHERE sId ='$sId' ";
        $getPro = $this->db->select($query);
         if ($getPro) {
         while ($result = $getPro->fetch_assoc()) {
           $product_id     = $result['product_id'];
           $productName   = $result['productName'];
           $quantity      = $result['quantity'];
           $price         = $result['price'];
           $image         = $result['image'];
       
            $query = "INSERT INTO orders(cmrId, product_id, productName, quantity, price, image) 
                VALUES ('$cmrId','$product_id','$productName','$quantity','$price','$image')";  
       
                $inserted_row = $this->db->insert($query); 
           }
         } 
       
         }



}

?>