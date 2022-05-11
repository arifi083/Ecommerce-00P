<?php include 'inc/header.php'; ?>
<?php 
  $login = Session::get("cuslogin");
  if($login == false){
	  header("Location:login.php");
  }
?>



 <div class="main">
    <div class="content">
    	 
     <div class="section group">
<div class="notfound"> 
    <h2> <span>Your Order Details</span></h2>
 
    <table class="tblone">
		<tr>
			 <th width="5%">SL</th>
			 <th width="30%">Product Name</th>
			 <th width="10%">Image</th>
			 <th width="15%">Price</th>
			 <th width="15%">Quantity</th>
			 <th width="10%">Total Price</th>
			 <th width="10%">Date</th>
             <th width="10%">Status</th>
			 <th width="10%">Action</th>
		</tr>

         <?php
            $cmrId =  Session::get("cmrId");
			$getOrder = $ct->getOrderProduct($cmrId);
			if($getOrder){
			  $i = 0;
			  while($result = $getOrder->fetch_assoc()){
			  $i++;
		?>


		<tr>
			<td><?php echo $i ?> </td>
			<td><?php echo $result['productName'] ?></td>
			<td><img src="admin/<?php echo $result['image'] ?>" alt=""/></td>
			<td>$<?php echo $result['price'] ?></td>
			<td><?php echo $result['quantity'] ?></td>
			<td>$
				<?php 
					 $total = $result['price'] * $result['quantity'];
					 echo $total;
				?>
			</td>
		    <td>
				<?php echo $fm->formatDate($result['date']); ?>
			</td>
            <td>
                <?php
                    if($result['status'] =='0'){
                       echo "Pending";
                    }
                    else{
                       echo "Shifted";
                    }
                ?>
            </td>
                <?php
                  if ($result['status'] == '1') { ?>
             <td><a onclick="return confirm('Are you sure to Delete');" href=" ">X</a></td>
               <?php }else {  ?>
            <td>N/A </td>
 
            <?php } ?>							
	</tr>
	
							
	 <?php  }  }  ?>
							
</table>
						



   </div>
 </div>
       <div class="clear"></div>
    </div>
 </div>
</div>
   
    <?php include 'inc/footer.php'; ?>