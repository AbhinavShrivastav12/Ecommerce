<?php  

include('inc/header.php'); 
 include('inc/nav.php');  
 
include('config/db.php');
if(!isset($_SESSION['customer']) && empty($_SESSION['customer']) ){
 header('location:login.php');
}

 
if(!isset($_SESSION['customerid'])){
	echo '<script>window.location.href = "login.php";</script>';

}

// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
 


$message  = '';
$_POST['agree'] = 'false';

if(isset($_POST['submit'])){
	 
	 
	$orderid = $_POST['orderid'];
    $reason = $_POST['reason'];
    $status = 'cancelled';

 
    $insertCancel = "INSERT INTO orderstracking (order_id,status, reason )
	VALUES ('$orderid', '$status', '$reason')";  

	if(mysqli_query($conn, $insertCancel)){
    $up_sql = "UPDATE orders SET orderstatus='Cancelled'  WHERE id=$orderid";
 mysqli_query($conn, $up_sql);
 header('location:myaccount.php');

    }
//   update query
// $up_sql = "UPDATE user_data SET firstname='$fname', lastname='$lname', company='$companyName', address1='$addr1', address2='$addr2', city='$city', country='$country', zip='$Postcode', mobile='$Phone'  WHERE userid=$cid";

// $Updated = mysqli_query($conn, $up_sql);
     
 

}
 

 


$cid =$_SESSION['customerid'];

$sql = "SELECT * FROM user_data where user_id = $cid";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);


 ?>



 
 

<div class="container text-white">

<?php
// echo "<pre>";
// print_r($_SESSION['cart']);
// echo "</pre>";



if(isset($_SESSION['cart'])){
	$total = 0;
	foreach($cart as $key => $value){
	 // echo $key ." : ". $value['quantity'] . "<br>";
	 
	 $sql_cart = "SELECT * FROM products where product_id = $key";
	$result_cart = mysqli_query($conn, $sql_cart);
	$row_cart = mysqli_fetch_assoc($result_cart);
	$total = $total +  ($row_cart['price'] * $value['quantity']);
}
}



?>

    <section id="content">
		<div class="content-blog">
					<div class="page_header text-center  py-5">
						<h2>Cancel Order</h2>
						 
					</div>
<form method='post'>
<?php echo $message ?>
<div class="container ">
			<div class="row">
				<div class="offset-md-2 col-md-8">
					<div class="billing-details">
                    <table class="cart-table account-table table table-bordered bg-white text-dark">
				<thead>
					<tr>
						<th>Product</th>
						<th>Quantity</th>
						<th>price</th>
						<th>Total Price</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php
				$c_id = $_SESSION['customerid'];

 if(isset($_GET['id'])){
     $o_id = $_GET['id'];
 }


 $sql_orders = "SELECT * FROM orders WHERE id='$o_id' AND user_id='$c_id'";
 $result_orders = mysqli_query($conn, $sql_orders);

 $row_orders = mysqli_fetch_assoc($result_orders);
  
				$sql = "SELECT * FROM orderitems WHERE order_id='$o_id'";
				$result = mysqli_query($conn, $sql);
			  
				if (mysqli_num_rows($result) > 0) {
			 
				 while($row = mysqli_fetch_assoc($result)) {
                  $prodID = $row["product_id"] 
 			?>
					<tr>
						<td>

                        <?php 
                        
                        $sql_product = "SELECT * FROM products  WHERE product_id='$prodID'";
                        $result_prod = mysqli_query($conn, $sql_product);
                      
                     $row_prod = mysqli_fetch_assoc($result_prod);
                     
                      
                        
                        ?>


<a href="single.php?id=<?php echo $prodID ;?>"><?php echo $row_prod['product_name'];?></a>
					 
						</td>
						<td>
						<?php echo $row["quantity"] ?>
						</td>
						<td>
						<?php echo $row["productprice"] ?>		
						</td>
						<td>
						<?php echo $row["quantity"] * $row["productprice"] ?>		
						</td>
					 
					</tr>
				 
			
			<?php
				}
			   } else {
				 echo "0 results";
			   }
			 
			 
			 ?>




				
				</tbody>
                <tfooer>
					<tr>
						 
						<th></th>
						<th></th>
						<th>Total Price</th>
						<th><?php echo  $row_orders['totalprice'] ?></th>
					</tr>
                    <tr>
					 
						<th></th>
						<th></th>
						<th>Order Status</th>
						<th><?php echo  $row_orders['orderstatus'] ?></th>
					</tr>
                    <tr>
					 
						<th></th>
						<th></th>
						<th>Date</th>
						<th><?php echo  $row_orders['timestamp'] ?></th>
					</tr>
				</tfooer>
			</table>
						<div class="space30"></div>
					 
						 
				 
						 
							<div class="clearfix space20"></div>
							<label>Reason</label>
 						 <textarea class="form-control" name='reason' id="" cols="30" rows="10"></textarea>
					 
					 
					</div>
				</div>
				
			 
			</div>
			
		 
	 
		 
        </div>		
        
        <div class="row">
            <div class="col-md-12 text-center">
                <input type="hidden" name='orderid' value='<?php echo $_GET['id'] ?>'>
                <input type='submit' name='submit' value='Cancel Order' class="btn">
            </div>
        </div>
		
		</div>
	</section>
</div>

</form>







<?php include('inc/footer.php');  ?>


