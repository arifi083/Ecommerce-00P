<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
 
<?php
 $filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../classes/Cart.php');
$ct = new Cart();
$fm = new Format();

?>

<?php 
     if (isset($_GET['shiftid'])) {
     	$id = $_GET['shiftid'];
     	$shift = $ct->productShifted($id);
     }


     if (isset($_GET['delshiftid'])) {
        $id = $_GET['delshiftid'];
        $delshift = $ct->delproductShifted($id);
    }

?>







        <div class="grid_10">
            <div class="box round first grid">
                <h2>Customer Order</h2>
                <?php
                   if (isset($shift)) {
         	            echo $shift;
                    }

                   if (isset($delshift)) {
         	           echo $delshift;
                    }

                ?>



                <div class="block">        
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>Id</th>
							<th>Order Date</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>price</th>
                            <th>Address</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
                       <?php
                          $getOrder = $ct->getAllOrderProduct();
                          if($getOrder){
                              while($result = $getOrder->fetch_assoc()){

                       ?>

						<tr class="odd gradeX">
                            <td><?php echo $result['id']; ?></td>
							<td><?php echo  $fm->formatDate($result['date']);  ?></td>
                            <td><?php echo $result['productName'] ?> </td>
                            <td><?php echo $result['quantity'] ?> </td>
                            <td><?php echo $result['price'] ?> </td>
                            <td><a href="customer.php?custId=<?php echo $result['cmrId']; ?>"> View Address</a></td> 

	                        <?php if ($result['status'] == '0') { ?>

                                <td><a href="?shiftid=<?php echo $result['id']; ?>">Shifted</a></td>
						    <?php	} else {    ?>
		                         <td><a href="?delshiftid=<?php echo $result['id']; ?>">Remove</a></td>
                           <?php } ?>
							
						</tr>	


                      <?php } }  ?>  
					</tbody>
				</table>
               </div>
            </div>
        </div>
<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();

        $('.datatable').dataTable();
        setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php';?>
