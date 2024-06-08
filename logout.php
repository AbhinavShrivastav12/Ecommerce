<?php
session_start();
unset($_SESSION['cart']);

session_destroy();

header('location:login.php')

?>