<?php 

include('inc/header.php');
include('config/db.php');
  ?>

<?php include('inc/nav.php'); 


$cart =  $_SESSION['cart'];


//  print_r($cart);

?>
 
 
<div class="container">
    <h2 class='text-center text-white'>Cart</h2>

   <table class="table table-bordered bg-white">
       <tr>
           <th>Image</th>
           <th>Product</th>
           <th>Price</th>
           <th>Quantity</th>
           <th>Total</th>
           <th>Action</th>
       </tr>

       <?php
       $total = 0;
       foreach($cart as $key => $value){
        // echo $key ." : ". $value['quantity'] . "<br>";
        
        $sql = "SELECT * FROM products where product_id = $key";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result)
        ?>


            <tr>
           <td><img src="admin/<?php echo $row['thumb']?> " alt=""></td>
           <td><a href="single.php?id=<?php echo $row['product_id']?>"><?php echo $row['product_name']?></a></td>
           <td><?php echo $row['price']?> </td>
           <td><?php echo $value['quantity']?></td>
           <td><?php echo $row['price'] * $value['quantity'] ?> </td>
            <td><a href='deleteCart.php?id=<?php echo $key; ?>'>Remove</a></td>
            </tr>

        <?php

$total = $total +  ($row['price'] * $value['quantity']);
    }
    
    ?>
      
   </table>

   <div class="text-right">
    <!-- <button class="btn mr-3">Update Cart</button> -->

    <a class="btn" href='checkout.php'>Checkout</a>
</div>
<div class="card">
<div class="card-header">Total</div>
<div class="card-body">
Total Amount: NPR <?php echo $total; ?>.00/-
</div>
</div>

</div>








<?php include('inc/footer.php');  ?>


