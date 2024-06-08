<?php 
include('config/db.php');
 

include('inc/header.php');  


include('inc/nav.php'); 

 

 
 



?>
 
 
 
 
<div class="container text-white">
    <h2 class='text-center text-white'>My Account</h2>

    <section id="content">
		<div class="content-blog content-account">
			<div class="container">
				<div class="row">
				 
					<div class="col-md-12">

			<h3>Recent Orders</h3>
			<br>
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
						<th><?php echo date('M j g:i A', strtotime($row_orders["timestamp"]));  ?></th>
					</tr>
				</tfooer>
			</table>		

		 

			<div class="ma-address">
						<h3>My Addresses</h3>
						<p>The following addresses will be used on the checkout page by default.</p>

			<div class="row  bg-white text-dark px-5 py-3">
				<div class="col-md-6">
								<h4>Billing Address <a href="update_address.php?id=<?php echo $c_id ?>">Edit</a></h4>
                                <?php  
                        $sql_add = "SELECT * FROM user_data  WHERE user_id='$c_id'";
                        $result_add = mysqli_query($conn, $sql_add);
                      
                     $row_add = mysqli_fetch_assoc($result_add); 
                        echo $row_add['firstname'] ." ". $row_add['lastname'] . "<br>";
                        echo $row_add['company'] . "<br>";
                        echo $row_add['address1'] . "<br>";
                        echo $row_add['address2'] . "<br>";
                        echo $row_add['city'] . "<br>";
                        echo $row_add['zip'] . "<br>";
                        echo $row_add['country'] . "<br>";
                        echo $row_add['mobile'] . "<br>";

                        ?>

 
				</div>

			 
			</div>



			</div>

					</div>
				</div>
			</div>
		</div>
	</section>
	
 
</div>







<?php include('inc/footer.php');  ?>


