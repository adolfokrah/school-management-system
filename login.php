<!DOCTYPE html>
<html lang="en">
<?php 
    $message = '';
    $userid = '';
    include 'includes/mysql_connect.php';
    if(isset($_SESSION['login']) && !empty($_SESSION['login'])){
             echo "<script>window.open('cms/admin_dashboard','_self')</script>";
        }
    if(isset($_POST['userid']) && !empty($_POST['userid'])){
        $userid = $_POST['userid'];
        $query=mysqli_query($conn,"select * from `main admins` where `ADMIN EMAIL`='$userid' and `ADMIN PASSWORD` !='' or `ADMIN ID`='$userid' and `ADMIN PASSWORD` !='' ");
        if($fetch = mysqli_fetch_assoc($query)){
           session_start();
           $_SESSION['email'] = $userid;
          
           $stage = $fetch['REGISTRATION STAGE'];
            
            if($stage == 'school_details'){
                $_SESSION['stage']='register2.php';
                echo "<script>window.open('register2','_self')</script>";

            }else if($stage == 'verification'){
                $_SESSION['stage']='verify_registration.php';
                 echo "<script>window.open('verify_registration','_self')</script>";
            }else{
                 echo "<script>window.open('login2','_self')</script>";
            }
        }else{
            $query=mysqli_query($conn,"select * from `users` where `USER ID`='$userid' and `PASSWORD` !=''");
            if($fetch = mysqli_fetch_assoc($query)){
            session_start();
            $_SESSION['email'] = $userid;
               echo "<script>window.open('login2','_self')</script>";
            }else{
                $message = '<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error!</strong> Incorrect Email / User ID
  </div>';
            }
        }
        
    }
?>
<head>
	<title>Login V2</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="icon" href="web_images/logo2.png">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
        
		<div class="container-login100">
            
			<div class="wrap-login100">
                
				<form class="login100-form validate-form" method="POST" action="login.php">
					<img src="web_images/receipt_logo.png" width="150px;"><?php echo $message;?>
                    <p style="line-height:20px;"><span id="sigin">Sign in</span><br/><span id="signin2">to your portal</span></p>
                    
					<div id="form">
                        <div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c or user ID">
						<input class="input100" type="text" name="userid" value="<?php echo $userid?>">
						<span class="focus-input100" data-placeholder="Email or User ID" required></span>
					</div>
                    </div>
                    

<!--
					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="pass">
						<span class="focus-input100" data-placeholder="Password"></span>
					</div>
-->
<div id="form1">
    
    <button id="button" class="android-btn" type="submit"></button></div>
        <a href="add_account.php" class="pull-left">Add account</a>            
                    <div id="form2">Don’t have an account?<a href="register.php"> Create account</a>
</div>
					<div class="text-center p-t-115">
						<span class="txt1">
							Copyright © Easyskul. All rights reserved.
						</span>
<center style="font-size:14px;"><a href="index">Back to home</a></center>
						
					</div>
				</form>
			</div>
           
		</div>
       
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>
    <script>
var button = document.getElementById('button');

button.addEventListener('click', function () {
  this.setAttribute('class', 'android-btn active');

  var self = this;
  setTimeout(function () {
    self.removeAttribute('class', 'active');
    self.setAttribute('class', 'android-btn');
  }, 300)
});</script>
</body>
</html>