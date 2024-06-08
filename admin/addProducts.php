<?php

session_start();
include('../config/db.php');
if(!isset($_SESSION['email']) && empty($_SESSION['email']) ){
 header('location:login.php');
}
?>

<?php include('inc/header.php') ?>
<?php include('inc/nav.php') ;

if(isset($_POST['submit'])){
    $productname = $_POST['productname'];
    $productdescription = $_POST['productdescription'];
    $productcategory = $_POST['productcategory'];
    $productprice = $_POST['productprice']; 

    
		if(isset($_FILES) & !empty($_FILES)){
			$name = $_FILES['productimage']['name'];
			$size = $_FILES['productimage']['size'];
			$type = $_FILES['productimage']['type'];
			$tmp_name = $_FILES['productimage']['tmp_name'];

			$max_size = 10000000;
			$extension = substr($name, strpos($name, '.') + 1);

			if(isset($name) && !empty($name)){
				if(($extension == "jpg" || $extension == "jpeg" || $extension == "png") && $type == "image/jpeg" && $size<=$max_size){
					$location = "uploads/";
					if(move_uploaded_file($tmp_name, $location.$name)){
						//$smsg = "Uploaded Successfully";
						$sql2 = "INSERT INTO products (product_name, cat_id, price, product_description, thumb)
                        VALUES ('$productname', '$productcategory', '$productprice', '$productdescription','$location$name')";
						$res = mysqli_query($conn, $sql2);
						if($res){
							//echo "Product Created";
							$message = 'Saved Successfully with image';
						}else{
                            $message = "Failed to Create Product";
                            echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
						}
					}else{
						$message = "Failed to Upload File";
					}
				}else{
					$message = "Only JPG/PNG files are allowed and should be less that 1MB";
				}
			}else{
				$message = "Please Select a File";
			}
		}else{
    $sql = "INSERT INTO products (product_name, cat_id, price, product_description) VALUES ('$productname', '$productcategory', '$productprice', '$productdescription' )";

if (mysqli_query($conn, $sql)) {
   
$message = 'Saved Successfully';
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

}

}


 



?>

<div class="container">
<div class="card">
<div class="card-header">
Add Products
</div>
<div class="card-body">
<section id="content ">
	<div class="content-blog bg-white py-3">
		<div class="container"> 
        <?php
        if(isset($message)){
            ?>
    <div class="alert alert-success"><?php echo $message ?></div>
        <?php
        }
        ?>
        		<form method="post" enctype="multipart/form-data" action='addProducts.php'>
			  <div class="form-group">
			    <label for="Productname">Product Name</label>
			    <input type="text" class="form-control" name="productname" id="Productname" placeholder="Product Name">
			  </div>
			  <div class="form-group">
			    <label for="productdescription">Product Description</label>
			    <textarea class="form-control" name="productdescription" rows="3"></textarea>
			  </div>

			  <div class="form-group">
			    <label for="productcategory">Product Category</label>
			    <select class="form-control" id="productcategory" name="productcategory">
				  <option value="" selected disabled>---SELECT CATEGORY---</option>

                  <?php
                  
        
                  $sql = "SELECT * FROM Category";
                  $result = mysqli_query($conn, $sql);
              
                
                      // output data of each row
                      while($row = mysqli_fetch_assoc($result)) {
              
                          ?> 
                 <option value="<?php echo $row["cat_id"] ?>"><?php echo  $row["cat_name"] ?></option> 
                      <?php
                      }
                  
                  ?>
				 
				
			 
				</select>
			  </div>
			  

			  <div class="form-group">
			    <label for="productprice">Product Price</label>
			    <input type="text" class="form-control" name="productprice" id="productprice" placeholder="Product Price">
			  </div>
			  <div class="form-group">
			    <label for="productimage">Product Image</label>
			    <input type="file" name="productimage" id="productimage">
			    <p class="help-block">Only jpg/png are allowed.</p>
			  </div>
			  
			  <button type="submit"  name ='submit' class="btn btn-primary">Submit</button>
			</form>
			
		</div>
	</div>

</section>
</div>
</div>


</div>


<?php include('inc/footer.php'); ?>