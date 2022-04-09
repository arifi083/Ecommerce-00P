<?php include 'inc/header.php' ?>


<?php

 if(isset($_GET['delcart'])){
	 $id = $_GET['delcart'];
	 $delCart = $ct->delCartById($id); 
 }

?>




<?php 

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
	  $id = $_POST['id'];
      $quantity = $_POST['quantity'];
      $updateCart = $ct->updateCartQuantity($id,$quantity);

	  if($quantity <=0){
		$delCart = $ct->delCartById($id); 
	  }
  }
?> 

<?php
    if (!isset($_GET['id'])) {
        echo "<meta http-equiv='refresh' content='0;URL=?id=live'/> ";
    }
?>




 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    	<h2>Your Cart</h2>

				<?php 
				   if(isset($updateCart)){
					   echo $updateCart;
				   }

				   if(isset($$delCart)){
					echo $$delCart;
				}
				?>
						<table class="tblone">
							<tr>
							    <th width="5%">SL</th>
								<th width="30%">Product Name</th>
								<th width="10%">Image</th>
								<th width="15%">Price</th>
								<th width="15%">Quantity</th>
								<th width="10%">Total Price</th>
								<th width="10%">Action</th>
							</tr>

                           <?php
						     $getPro = $ct->getCartProduct();
							 if($getPro){
								 $i = 0;
								 $qty = 0;
								 $sum = 0;
								 while($result = $getPro->fetch_assoc()){
									 $i++;
						   ?>


							<tr>
						    	<td><?php echo $i ?> </td>
								<td><?php echo $result['productName'] ?></td>
								<td><img src="admin/<?php echo $result['image'] ?>" alt=""/></td>
								<td>$<?php echo $result['price'] ?></td>
								<td>
									<form action="" method="post">

                                <input type="hidden" name="id" value="<?php echo $result['id']; ?>"/>
								<input type="number" name="quantity" value="<?php echo $result['quantity']; ?>"/>
								<input type="submit" name="submit" value="Update"/>
									</form>
								</td>
								<td>$
									<?php 
									   $total = $result['price'] * $result['quantity'];
									   echo $total;
									?>
								</td>
								<td><a href="?delcart=<?php echo $result['id'] ?>" onclick="return confirm('are you sure to delete')">X</a></td>
							</tr>
							<?php 
							  $sum = $sum + $total;
							  $qty = $qty + $result['quantity'];
							  Session::set("qty",$qty);
							  Session::set("sum",$sum);
							?>
					
							
							
					   <?php  }  }  ?>
							
							
						</table>
						 <?php
						  	$getData =$ct->checkCartTable();
							if($getData){
						?>
						  
						<table style="float:right;text-align:left;" width="40%">
							<tr>
								<th>Sub Total : </th>
								<td>$<?php echo $sum ; ?></td>
							</tr>
							<tr>
								<th>VAT : </th>
								<td>
									10%
								</td>
							</tr>
							<tr>
								<th>Grand Total :</th>
								<td>$
									<?php 
									  $vat = $sum * 0.1;
									  $gtotal = $sum + $vat;
									  echo $gtotal;

									?>
								</td>
								
							</tr>
					   </table>
					   <?php } else { 
                   	     header("Location:index.php");
                          // echo "Cart Empty";

                       } ?>
                      
				
					</div>
					<div class="shopping">
						<div class="shopleft">
							<a href="index.php"> <img src="images/shop.png" alt="" /></a>
						</div>
						<div class="shopright">
							<a href="payment.php"> <img src="images/check.png" alt="" /></a>
						</div>
					</div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>
</div>
 

<?php include 'inc/footer.php' ?>