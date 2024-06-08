<?php
session_start();
include('../config/db.php');
if(!isset($_SESSION['email']) && empty($_SESSION['email']) ){
 header('location:login.php');
}


if(isset($_GET['id']) & !empty($_GET['id'])){
    $id = $_GET['id'];


    $sql = "SELECT thumb FROM products WHERE product_id=$id";
    $res = mysqli_query($conn, $sql);
    $r = mysqli_fetch_assoc($res);
 

    if(!empty($r['thumb'])){
        if(unlink($r['thumb'])){
            $delsql = "UPDATE products SET thumb='' WHERE product_id=$id";
            if(mysqli_query($conn, $delsql)){
                header("location:editproducts.php?id={$id}");
            }
        }else{
            $delsql = "UPDATE products SET thumb='' WHERE product_id=$id";
            if(mysqli_query($conn, $delsql)){
                header("location:editproducts.php?id={$id}");
            }
        }

}
}



// if(isset($_GET['id'])){
//    $product_id = $_GET['id'];

   


   

// //   $sql = "DELETE FROM products WHERE product_id='$product_id'";
// //   $result = mysqli_query($conn, $sql);
// //   header('location:products.php');


// }


