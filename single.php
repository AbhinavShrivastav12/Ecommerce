<?php include('inc/header.php');  ?>

<?php include('inc/nav.php');  

include('config/db.php');
$message =  '';

if(isset($_POST['submit'])){
    $product_id = $_GET['id'];
    $c_id = $_SESSION['customerid']; 

        // $name  = $_POST['name']; 
        // $email  = $_POST['email']; 
    $review  = $_POST['review']; 

    $insertReview = "INSERT INTO reviews (product_id, user_id, review)
	VALUES ('$product_id','$c_id' ,'$review' )";  

	if(mysqli_query($conn, $insertReview)){
        $message = 'Review Submitted';
    }


}



if(isset($_GET['id'])){
    $product_id = $_GET['id'];
   $sql = "SELECT * FROM products  WHERE product_id='$product_id'";
   $result = mysqli_query($conn, $sql);
 
$row = mysqli_fetch_assoc($result);

$product_name  = $row['product_name'];
$cat_id  = $row['cat_id']; 
$price  = $row['price'];
$product_description  = $row['product_description'];
$thumb  = $row['thumb'];
}


?>
 
 
 
<div class="container">

    <div class="row text-white">
        <div class="col-md-6 ">
            <img src="admin/<?php echo $thumb ?>" alt="" class='img-fluid' style='height:500px;width:500px;'>
        </div>
        <div class="col-md-6 pt-5">
        <h3><b><?php echo $product_name ?></b></h3>
        <h2><b>NPR <?php echo  $price ?>.00 </b></h2>
<p>     <?php echo $product_description ?></p>            
       
<div class="row">
    <div class="col-md-2">
        Quantity:
    </div>
    <div class="col-md-2">
    <form action='addToCart.php'>  
    <input type="hidden" name='id' value='<?php echo  $product_id ?>'>
        <input type="number" class='form-control' name='quantity' value='1'> 
       
    </div>
    
</div>
<div class="row ">
    <div class="col-md-12 category">

    <?php
                  
        
                  $sql2 = "SELECT * FROM Category where cat_id = '$cat_id'";
                  $result2 = mysqli_query($conn, $sql2); 
                      // output data of each row
                      $row2 = mysqli_fetch_assoc($result2)
                          ?> 
     Categories - <a href="index.php?id=<?php echo $cat_id ?>"><?php echo $row2["cat_name"] ?></a>   
                
     
    </div>
    <!-- <div class="col-md-12 category">
        Tags - <a href="#">Tag 1</a>, <a href="#">Tag 2</a>, <a href="#">Tag 3</a>
    </div> -->
</div>
<div class="row mt-4">
    <div class="col-md-4">
    <button  type='submit' class="btn btn-default btn-xs pull-right"  >
                        <i class="fa fa-cart-arrow-down"></i> Add To Cart
                    </button>
    </div>
  
    <!-- <div class="col-md-4">
    <a href="show-wishlist.php" class="btn btn-default btn-xs pull-left"><i class="fa fa-heart" aria-hidden="true"></i> Wishlist</a>
    </div>
</div> -->
</form>


</div>
        
        </div>






        <!-- <div class="tab mt-5">
  <button id='defaultOpen' class="tablinks" onclick="openCity(event, 'London')"> Details </button>
  <button class="tablinks" onclick="openCity(event, 'Paris')">Reviews</button> 
</div> -->

<div id="London" class="tabcontent bg-white">
<p>     <?php echo $product_description ?></p>   
 
</div>

<div id="Paris" class="tabcontent bg-white">
 
   
    
								<div class="col-md-12">
							 
									<h6 class="uppercase space35" > Reviews for </h6>
									<ul class="comment-list">

<?php
  $sql_allReview = "SELECT * FROM reviews JOIN user_data ON user_data.user_id=reviews.user_id";
                                    $result_allReview = mysqli_query($conn, $sql_allReview);
                                
                                 if (mysqli_num_rows($result_allReview) > 0) {
                                     
                                    while($row_nameEmail = mysqli_fetch_assoc($result_allReview)) {
?>

	                                     <li> 
											<div class="comment-meta">
											    	<a href="#">   <?php echo $row_nameEmail['firstname'] ?></a>
												<span>
												    <em><?php echo $row_nameEmail['timestamp'] ?></em>
                                                </span>
                                                     <p><?php echo $row_nameEmail['review'] ?></p>
                                            </div> 
                                        </li>
  

<!-- <?php
}
                                    }
?></ul> -->
								 
                                   
                                    

<?php
 $proid = $_GET['id'];
 if(isset($_SESSION['customerid'])){
     $c_id = $_SESSION['customerid']; 
$sql_count = "SELECT * FROM reviews where product_id='$proid' AND user_id='$c_id '";
$result_count = mysqli_query($conn, $sql_count);
if (mysqli_num_rows($result_count) > 0) { 

echo '<h3 class="text-center">You Already Submitted Review for this product</h3>' ;
}else{
?>


<h6 class="uppercase space20">Add a review</h6>
									<form id="form" class="review-form" method="post">
                                 <?php
                                    
                                    $name  ='' ;
                                    $email  ='' ;

                                 if(isset($_SESSION['customerid'])){
                                    $c_id = $_SESSION['customerid']; 
                                    $sql_nameEmail = "SELECT users.email, user_data.firstname, user_data.lastname FROM users JOIN user_data ON users.user_id=user_data.user_id AND user_data.user_id = '$c_id'";
                                    $result_nameEmail = mysqli_query($conn, $sql_nameEmail);
                                
                                 if (mysqli_num_rows($result_nameEmail) > 0) { 
                                     $row_nameEmail = mysqli_fetch_assoc($result_nameEmail);
                                      $name = $row_nameEmail['firstname'] ." ". $row_nameEmail['lastname']  ;
                                      $email = $row_nameEmail['email'];
                                    }
                                }
                                 
                                 ?>
										<div class="row">
											<div class="col-md-6 space20">
												<input name="name" value='<?php echo  $name ?>' class="form-control" placeholder="Name *"  required="" type="text" <?php if($name != ''){echo 'disabled';} else{echo " ";}    ?> >
											</div>
											<div class="col-md-6 space20">
												<input name="email" value='<?php echo  $email ?>' class="form-control" placeholder="Email *" required="" type="text"  <?php if($email != ''){echo 'disabled';} else{echo " ";}  ?> >
											</div>
										</div>
								 
										<div class="space20 mt-2">
											<textarea name="review" id="text" class="input-md form-control" rows="6" placeholder="Add review.." maxlength="400"></textarea>
										</div>
										<button type="submit" name='submit' class="btn btn-primary  mt-2">
										Submit Review
                                        </button>
                                        <?php echo $message  ?>
                                    </form>
                                    <?php
                                    }
                                }
                                    
                                    ?>
								 
								</div>
							 
						 
</div>



<div class="card">
<div class="card-header">
Related Products

</div>
<div class="card-body">
    
<div class="mt-5">
<ul class="rig columns-4">

 <?php
 $sql_related = "SELECT * FROM products where product_id != $product_id  order by rand() limit 3";
//  if(isset($_GET['id'])){
//      $catID = $_GET['id'];
//      $sql .= " WHERE cat_id = '$catID'";
//  }
 
 
 $result_related = mysqli_query($conn, $sql_related);
  
   while($row_related = mysqli_fetch_assoc($result_related)) {
     // echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
 
 
 ?>

                <li>
                    <a href="#"><img class="product-image" src="admin/<?php echo $row_related['thumb']; ?>    "></a>
                    <h4><?php echo $row_related['product_name']; ?></h4>

                    <p>     <?php echo $row_related['product_description']; ?>             </p>
                    <div class="price"> <b><?php echo $row_related['price']; ?> </b></div>
                    
                    <hr>
                    <!-- <button class="btn btn-default btn-xs pull-right" type="button">
                        <i class="fa fa-cart-arrow-down"></i> Add To Cart
                    </button> -->
                    <div class="text-center"> 
                    <a href="single.php?id=<?php echo $row_related['product_id']; ?>" class="btn btn-default btn-xs pull-left">
                        <i class="fa fa-eye"></i> Details
                    </a>
                    </div>
                   
                </li>

<?php

}

?>
                 
 
             
            </ul>


</div>

</div>
</div>



















































</div>





<?php include('inc/footer.php');  ?>



