<?php
session_start();
include('config/db.php');
if(!isset($_SESSION['customerid'])){
    
header('location:index.php');
}else{
 $c_id = $_SESSION['customerid']; 
 $p_id = $_GET['id'];

 $sql_Check = "SELECT * FROM wishlist where product_id = $p_id AND user_id = $c_id";
 $result_check = mysqli_query($conn, $sql_Check);

 if (mysqli_num_rows($result_check) == 1) { 
    echo 'product already exist in wishlist';
    header('location:show-wishlist.php');
    
 }else{

    $insertWishlist = "INSERT INTO wishlist (product_id, user_id) VALUES ('$p_id', '$c_id')";   
	if(mysqli_query($conn, $insertWishlist)){
        header('location:show-wishlist.php');

    }

 }
//  $total = $total +  ($row_cart['price'] * $value['quantity']);

}
?>