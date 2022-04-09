<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/Category.php';  ?>

<?php
  $cat = new Category();
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $catName = $_POST['catName'];
      $catInsert = $cat->CategoryInsert($catName);  
  }

?>
 



    <div class="grid_10">
         <div class="box round first grid">
             <h2>Add New Category</h2>
              <div class="block copyblock"> 
                <?php
                   if(isset($catInsert)){ 
                      echo $catInsert;
			       }
                ?>
                 <form action="" method="post">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" name="catName" placeholder="Enter Category Name..." class="medium" />
                            </td>
                        </tr>
						<tr> 
                            <td>
                                <input type="submit" name="submit" Value="Submit" />
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
            </div>
        </div>
<?php include 'inc/footer.php';?>