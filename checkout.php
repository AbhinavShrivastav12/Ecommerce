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
$total = 0;
if(isset($_SESSION['cart'])){
	 $cart = $_SESSION['cart'];
	foreach($cart as $key => $value){
	 // echo $key ." : ". $value['quantity'] . "<br>";
	 
	 $sql_cart = "SELECT * FROM products where product_id = $key";
	$result_cart = mysqli_query($conn, $sql_cart);
	$row_cart = mysqli_fetch_assoc($result_cart);
	$total = $total +  ($row_cart['price'] * $value['quantity']);
}
}


$message  = '';
$_POST['agree'] = 'false';

if(isset($_POST['submit'])){
	if($_POST['agree'] == true){
	$country = $_POST['country'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$companyName = $_POST['companyName'];
	$addr1 = $_POST['addr1'];
	$addr2 = $_POST['addr2'];
	$city = $_POST['city'];
	$state = '';
	$Postcode = $_POST['Postcode'];
	$Email = '';
	$Phone = $_POST['Phone'];
	$payment = $_POST['payment'];
	$agree = $_POST['agree'];
	$cid = $_SESSION['customerid']; 
	$sql = "SELECT * FROM user_data where user_id = $cid";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);


if (mysqli_num_rows($result) == 1) {
//   update query
$up_sql = "UPDATE user_data SET firstname='$fname', lastname='$lname', company='$companyName', address1='$addr1', address2='$addr2', city='$city', country='$country', zip='$Postcode', mobile='$Phone'  WHERE user_id=$cid";

$Updated = mysqli_query($conn, $up_sql);
if($Updated){

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


	// echo 'order table and order items - updated';

	$insertOrder = "INSERT INTO orders (user_id, totalprice, orderstatus, paymentmode )
	VALUES ('$cid', '$total', 'Order Placed', '$payment')";  

	if(mysqli_query($conn, $insertOrder)){
	 
		$orderid = mysqli_insert_id($conn); 
		foreach($cart as $key => $value){ 
			$sql_cart = "SELECT * FROM products where product_id = $key";
		   $result_cart = mysqli_query($conn, $sql_cart);
		   $row_cart = mysqli_fetch_assoc($result_cart); 
			$price_product = $row_cart["price"];
			 $q  = $value["quantity"];
		   $insertordersItems = "INSERT INTO orderitems (order_id, product_id, quantity, productprice) 
		    VALUES ('$orderid', '$key', '$q', '$price_product')";
		   
		   if(mysqli_query($conn, $insertordersItems)){
			//    echo 'inserted on both table orders and ordersItems';
			unset($_SESSION['cart']);
			// header("location:myaccount.php");
			echo '<script>window.location.href = "myaccount.php";</script>';

		
		   }


	   }

	

	}
}
} else {
  // insert 
 


  $ins_sql = "INSERT INTO user_data (user_id, firstname, lastname, company, address1, address2, city, country, zip, mobile)
  VALUES ('$cid', '$fname', '$lname', '$companyName', '$addr1', '$addr2', '$city', '$country', '$Postcode', '$Phone')"; 
$inserted = mysqli_query($conn, $ins_sql);
if($inserted){
	// echo 'order table and order items - inserted';
	
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


	// echo 'order table and order items - updated';

	$insertOrder = "INSERT INTO orders (user_id, totalprice, orderstatus, paymentmode )
	VALUES ('$cid', '$total', 'Order Placed', '$payment')";  

	if(mysqli_query($conn, $insertOrder)){
	 
		$orderid = mysqli_insert_id($conn); 
		foreach($cart as $key => $value){ 
			$sql_cart = "SELECT * FROM products where product_id = $key";
		   $result_cart = mysqli_query($conn, $sql_cart);
		   $row_cart = mysqli_fetch_assoc($result_cart); 
			$price_product = $row_cart["price"];
			 $q  = $value["quantity"];
		   $insertordersItems = "INSERT INTO orderitems (order_id, product_id, quantity, productprice) 
		    VALUES ('$orderid', '$key', '$q', '$price_product')";
		   
		   if(mysqli_query($conn, $insertordersItems)){
			//    echo 'inserted on both table orders and ordersItems';
			unset($_SESSION['cart']);
			// header("location:myaccount.php");
			echo '<script>window.location.href = "myaccount.php";</script>';

		
		   }


	   }

	

	}
}

}
}else{
	$message =  'agreen to terms and condition';
}


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
						<h2>Shop - Checkout</h2>
						<p>Get the best kit for smooth shave</p>
					</div>
<form method='post'>
<?php echo $message ?>
<div class="container ">
			<div class="row">
				<div class="offset-md-2 col-md-8">
					<div class="billing-details">
						<h3 class="uppercase">Billing Details</h3>
						<div class="space30"></div>
					 
							<label class="">Country </label>
							<select class="form-control" name='country'>
								<option value="">Select Country</option>
								
								<option value="NP">Nepal</option>
								<option value="IN">India</option>
							</select>
							<div class="clearfix space20"></div>
							<div class="row">
								<div class="col-md-6">
									<label>First Name </label>
									<input class="form-control" name='fname' placeholder="" value="<?php if(isset($row['firstname'])) { echo $row['firstname']; } ?>" type="text">
								</div>
								<div class="col-md-6">
									<label>Last Name </label>
									<input class="form-control" name='lname' placeholder="" value="<?php if(isset($row['lastname'])) {echo $row['lastname']; } ?>" type="text">
								</div>
							</div>
							<div class="clearfix space20"></div>
							<label>Company Name</label>
							<input class="form-control" name='companyName' placeholder="" value="<?php if(isset($row['company'])) {echo $row['company']; } ?>" type="text">
							<div class="clearfix space20"></div>
							<label>Address </label>
							<input class="form-control" name='addr1' placeholder="Street address" value="<?php if(isset($row['address1'])) {echo $row['address1']; } ?>" type="text">
							<div class="clearfix space20"></div>
							<input class="form-control" name='addr2' placeholder="Apartment, suite, unit etc. (optional)" value="<?php if(isset($row['address2'])) {echo $row['address2'];  } ?>" type="text">
							<div class="clearfix space20"></div>
							<div class="row">
								<div class="col-md-4">
									<label>Town / City </label>
									<input class="form-control" name='city' placeholder="Town / City" value="<?php if(isset($row['city'])) {echo $row['city']; } ?>" type="text">
								</div>
 
								<div class="col-md-4">
									<label>Postcode </label>
									<input class="form-control" name='Postcode' placeholder="Postcode / Zip" value="<?php if(isset($row['zip'])) {echo $row['zip']; } ?>" type="text">
								</div>
							</div>
							<div class="clearfix space20"></div>
							<!-- <label>Email Address </label>
							<input class="form-control" name='Email' placeholder="" value="-" type="text"> -->
							<div class="clearfix space20"></div>
							<label>Phone </label>
							<input class="form-control" name='Phone'  id="billing_phone" placeholder="" value="<?php if(isset($row['mobile'])) {echo $row['mobile']; } ?>" type="text">
						 
					</div>
				</div>
				
			 
			</div>
			
			<div class="space30"></div>
			<h4 class="heading">Your order</h4>
			
			<table class="table table-bordered extra-padding bg-white text-dark">
				<tbody>
					<tr>
						<th>Cart Subtotal</th>
						<td><span class="amount"><?php echo $total?>.00/-</span></td>
					</tr>
					<tr>
						<th>Shipping and Handling</th>
						<td>
							Free Shipping				
						</td>
					</tr>
					<tr>
						<th>Order Total</th>
						<td><strong><span class="amount"><?php echo $total?>.00/-</span></strong> </td>
					</tr>
				</tbody>
			</table>
			
			<div class="clearfix space30"></div>
			<h4 class="heading">Payment Method</h4>
			<div class="clearfix space20"></div>
			
			<div class="payment-method mt-5">
             
				<div class="row d-flex">
				
						<div class="col-md-4">
							<input name="payment" value='COD'  id="radio1" class="mr-2 css-checkbox" type="radio"><span>COD</span>
							<div class="space20"></div>
							<p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won't be shipped until the funds have cleared in our account.</p>
						</div>
						<div class="col-md-4">
							<input name="payment" value='Cheque'  id="radio2" class="mr-2 css-checkbox" type="radio"><span>Cheque Payment</span>
							<div class="space20"></div>
							<p>Please send your cheque to BLVCK Fashion House, Oatland Rood, UK, LS71JR</p>
						</div>
						<div class="col-md-4">
							<input name="payment" value='Paypal'  id="radio3" class="mr-2 css-checkbox" type="radio"><span>Paypal</span>
							<div class="space20"></div>
							<p>Pay via PayPal; you can pay with your credit card if you don't have a PayPal account</p>
						</div>
				
                </div>
           
				<div class="space30"></div>
			 
					<input name="agree" value='true' id="checkboxG2" class="mr-2 css-checkbox " type="checkbox"><span>I've read and accept the <a href="#">terms &amp; conditions</a></span>
			 
				<div class="space30"></div>
				<a href="#" class="button btn-lg">Pay Now</a>
			</div>
        </div>		
        
        <div class="row">
            <div class="col-md-12 text-center">
                <input type='submit' name='submit' value='Pay Now' class="btn">
            </div>
        </div>
		
		</div>
	</section>
</div>

</form>







<?php include('inc/footer.php');  ?>


