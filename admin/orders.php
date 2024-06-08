
<?php

session_start();
include('../config/db.php');
if(!isset($_SESSION['email']) && empty($_SESSION['email']) ){
 header('location:login.php');
}
?>
<?php include('inc/header.php') ?>
<?php include('inc/nav.php') ?>






<div class="container">

<div class="card">
<div class="card-header">
All Orders
</div>
<div class="card-body">
<section id="content mt-5">
	<div class="content-blog  bg-white">
		<div class="container">
			<table class="table table-striped">
				<thead>
					<tr> 
						<th>Customer Name</th>
						<th>Total Price</th>
						<th>Order Status</th>
						<th>Payment Mode </th>
                        <th>Order Placed On</th>
                        <th>Operations</th> 
					</tr>
				</thead>
				<tbody>

                <?php
    $sql = "SELECT orders.totalprice, orders.orderstatus, orders.paymentmode, orders.timestamp, orders.id, user_data.firstname, user_data.lastname 
     FROM orders JOIN user_data ON orders.user_id=user_data.user_id ORDER BY `orders`.`id` DESC    ";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {

            ?>
      
        <tr>
            <td><?php echo $row["firstname"] ." ".$row["lastname"] ?></td>
            <td><?php echo $row["totalprice"] ?></td>
            <td><?php echo $row["orderstatus"] ?></td>
            <td><?php echo $row["paymentmode"] ?></td>
            <td><?php echo date('M j g:i A', strtotime($row["timestamp"]));  ?>		</td>
            
            <td><a href='order-process.php?id=<?php echo $row["id"] ?>'>Change Status</a> 
            
        </tr>

        
        <?php
        }
      } else {
        echo "0 results";
      }


?>

			 
				</tbody>
			</table>
			
		</div>
	</div>

</section>
</div>
</div>


</div>




<?php include('inc/footer.php') ?>