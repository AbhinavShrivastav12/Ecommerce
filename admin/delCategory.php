<?php
 session_start();
 include('../config/db.php');
 if(!isset($_SESSION['email']) && empty($_SESSION['email']) ){
  header('location:login.php');
 }
 

if(isset($_GET['id'])){
    $catid = $_GET['id'];
   $sql = "DELETE FROM Category WHERE cat_id='$catid'";
   $result = mysqli_query($conn, $sql);
   header('location:categories.php');


}


?>