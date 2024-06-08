<?php include('inc/header.php');
session_start();
include('../config/db.php');
 
if(isset($_POST['submit'])){
     $email = mysqli_real_escape_string($conn, $_POST['email']);
     $password = md5($_POST['pswd']);
    
     $sql = "SELECT * FROM admin_data WHERE email='$email' and password='$password'";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {
     $_SESSION['email'] = $email;
     header('location:index.php');
  } else {
   $message =  'incorrect Credentials';
  }
  


   
    
}




?>
 
<div class="container pt-5">
    <h2 class='text-center text-white text-uppercase'>Admin Login</h2>

    <div class="row text-white mt-5">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="box-content">
                <div class="clearfix space40"></div>
                <form class="logregform" method='post'>
                    <div class="row">
                        <div class="col-md-12">
                           <?php 
                            if(isset($message)){
                                echo  "<div class='alert alert-danger'>".$message. "</div>";
                            }
                           ?>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Username or E-mail Address</label>
                                <input type="text" value="" class="form-control" name='email'>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix space20"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a class="pull-right text-white" href="#">(Lost Password?)</a>
                                <label>Password</label>
                                <input type="password" value="" class="form-control" name='pswd'>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix space20"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <span class="remember-box checkbox">
                            <label for="rememberme">
                            <input type="checkbox" id="rememberme" name="rememberme" class='mr-2'>Remember Me
                            </label>
                            </span>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" name='submit' class="btn button btn-md pull-right">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

  

   
</div>





<?php include('inc/footer.php') ?>
 