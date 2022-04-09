<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/Product.php'; ?>
<?php include_once '../helpers/Format.php';?>

<?php
    $pd = new Product();
	$fm = new Format()
?>

<?php

 if(isset($_GET['delproduct'])){
	 $id = $_GET['delproduct'];
	 $delProduct = $pd->delProductById($id); 
 }

?>


<div class="grid_10">
    <div class="box round first grid">
        <h2>Product List</h2>
        <div class="block">  
		<?php
         if (isset($delProduct)) {
         	echo  $delProduct;
         }
          ?>
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>SL</th>
					<th>Product Name</th>
					<th>Category</th>
					<th>Brand</th>
					<th>Description</th>
					<th>Price</th>
					<th>Image</th>
					<th>Type</th> 
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
             <?php 
			
			   $getProduct = $pd->getAllProduct();
			   if($getProduct){
				   $i = 0;
                   while($result = $getProduct->fetch_assoc()){
					   $i++
             ?>

				<tr class="odd gradeX">
					<td><?php echo $i ?></td>
					<td><?php echo $fm->textShorten($result['productName'],15) ?></td>
					<td><?php echo $result['catName'] ?> </td>
					<td ><?php echo $result['brandName'] ?></td>
					<td ><?php echo $fm->textShorten($result['description'],30) ?></td>
					<td ><?php echo $result['price'] ?></td>
					<td><img src="<?php echo $result['image'];?>" height="40px; width="60px;"></td>
					<td>
						<?php
						  if($result['type'] == 0){
							  echo "Featured";
						  }
						  else{
							  echo "general";
						  }
						?>
				   </td>
					<td><a href="productedit.php?id=<?php echo $result['id'] ?> ">Edit</a> || <a onclick="return confirm('are you sure to delete')" href="?delproduct=<?php echo $result['id'] ?>">Delete</a></td>
				</tr>
				
				
				
				
			<?php } } ?>
				
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
