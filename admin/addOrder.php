<?php

session_start();
include('../config/db.php');
if(!isset($_SESSION['email']) && empty($_SESSION['email']) ){
 header('location:login.php');
}
?>

<?php include('inc/header.php') ?>
<?php include('inc/nav.php') ?>



<?php include('inc/footer.php') ?>