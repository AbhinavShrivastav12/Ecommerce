<?php include('inc/header.php');
 
include('config/db.php');
 
if(isset($_POST['submit'])){
     $email = mysqli_real_escape_string($conn, $_POST['email']);
     $password =  password_hash($_POST['password'], PASSWORD_DEFAULT); 
    //  $sql = "SELECT * FROM users WHERE email='$email' and password='$password'";

    $sql = "INSERT INTO users (email, password ) VALUES ('$email', '$password' )";
    
// $result = mysqli_query($conn, $sql); 
 
  

  if (mysqli_query($conn, $sql)) {
    $_SESSION['customer'] = $email;
    $_SESSION['customerid'] = mysqli_insert_id($conn);
    header('location:index.php');
  } else {
    header('location:login.php?message=2');
    echo("Error description: " . mysqli_error($conn));
  }
 



   
    
}




?>