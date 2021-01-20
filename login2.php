<!DOCTYPE html>
<html lang="en">
    <?php
      $message ='';
       include 'includes/school_ini_user_id.php';
    
        if(isset($_SESSION['login']) && !empty($_SESSION['login'])){
             echo "<script>window.open('cms/admin_dashboard','_self')</script>";
        }
        if(isset($_POST['submit']) && !empty($_POST['submit'])){
           $password = md5($_POST['password']);
            $userid = $_POST['userid'];
            $ip =  $_SERVER['REMOTE_ADDR'];
            $query=mysqli_query($conn,"select * from `main admins` where `ADMIN EMAIL`='$userid' and `ADMIN PASSWORD` ='$password' or `ADMIN ID`='$userid' and `ADMIN PASSWORD` ='$password' ");
            if($fetch = mysqli_fetch_assoc($query)){
                
                $_SESSION['login']='true';
                $date = date('Y-m-d');
                $time = new datetime('now',new DateTimeZone('Europe/London'));
                $current_time = $time->format('h:i:s a');
                mysqli_query($conn,"update users set `LOGIN DATE`='$date', `LOGIN TIME`='$current_time', `IP ADDRESS` ='$ip' where `USER ID`='$userid'");
                $ip =  $_SERVER['REMOTE_ADDR'];
                $date = date('Y-m-d');
                mysqli_query($conn,"update visitors set `LOGIN IN`='YES' where `USER IP ADDRESS`='$ip' and `DATE`='$date'");
                echo "<script>window.open('cms/admin_dashboard','_self')</script>";
                
            }else{
                $query=mysqli_query($conn,"select * from `users` where `PASSWORD`='$password'");
                if($fetch = mysqli_fetch_assoc($query)){
                    
                        
                        $date = date('Y-m-d');
                        $time = new datetime('now',new DateTimeZone('Europe/London'));
                        $current_time = $time->format('h:i:s a');
                        mysqli_query($conn,"update users set `LOGIN DATE`='$date', `LOGIN TIME`='$current_time', `IP ADDRESS` ='$ip' where `USER ID`='$userid'");
                        
                        $date = date('Y-m-d');
                        mysqli_query($conn,"update visitors set `LOGIN IN`='YES' where `USER IP ADDRESS`='$ip' and `DATE`='$date'");
                    
                    if(strpos($userid,'-AC')){
                        $_SESSION['login']='true';
                       echo "<script>window.open('cms/accountant_dashboard','_self')</script>";
                    }else if(strpos($userid,'-DE')){
                        $_SESSION['login']='true';
                       echo "<script>window.open('cms/data_entry_dashboard','_self')</script>";
                    }else if(strpos($userid,'-LB')){
                        $_SESSION['login']='true';
                        echo "<script>window.open('cms/libarian_dashboard','_self')</script>";
                    }else if(strpos($userid,'-HD')){
                        $_SESSION['login']='true';
                         echo "<script>window.open('cms/head_dashboard','_self')</script>";
                    }else if(strpos($userid,'-TCH')){
                        $_SESSION['login']='true';
                         echo "<script>window.open('cms/teacher_dashboard','_self')</script>";
                    }else if(strpos($userid,'-STD')){
                        //check if student has completed school
                        $query = mysqli_query($conn,"select * from admitted_students where `ADMISSION NO / ID`='$userid' and `PRESENT CLASS` ='COMPLETED STUDENTS'");
                        if(mysqli_num_rows($query) > 0){
                             $message = '<div class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Error!</strong> Sorry Your session for using this system has ended
                          </div>';
                            //echo 'Sorry Your session for using this system has ended';
                        }else{
                            $_SESSION['login']='true';
                            echo "<script>window.open('cms/student_dashboard','_self')</script>";
                        }
                    }else if(strpos($userid,'-PT')){
                        //check if student has completed school
                        $userid= str_replace('-PT','-STD',$userid);
                        $query = mysqli_query($conn,"select * from admitted_students where `ADMISSION NO / ID`='$userid' and `PRESENT CLASS` ='COMPLETED STUDENTS'");
                        if(mysqli_num_rows($query) > 0){
                             $message = '<div class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Error!</strong> Sorry Your session for using this system has ended
                          </div>';
                           
                        }else{
                            $_SESSION['login']='true';
                            echo "<script>window.open('cms/parent_dashboard','_self')</script>";
                        }
                    }
                    
                }else{
                $message = '<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error!</strong>  Password not correct.
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
				<form class="login100-form validate-form" method="POST" action="login2">
                    <img src="web_images/receipt_logo.png" width="150px;">
                    <?php
                       
                        if(isset($_SESSION['email']) && !empty($_SESSION['email'])){
                            $userid = $_SESSION['email'];
                            $username = '';
                            $school = '';
                            $crest ='';
                            $query=mysqli_query($conn,"select * from `main admins` where `ADMIN EMAIL`='$userid' or `ADMIN ID`='$userid'");
                            if($fetch = mysqli_fetch_assoc($query)){
                                $username = $fetch['ADMIN NAME'];
                                $userid = $fetch['ADMIN ID'];
                            }else{
                                $query=mysqli_query($conn,"select * from `users` where `USER ID`='$userid'");
                                if($fetch = mysqli_fetch_assoc($query)){
                                    $username = $fetch['USER NAME'];
                                }
                            }
                           
                            $query2 = mysqli_query($conn,"select * from `school_details` where `INITIALS`='$initials'");
                            if($fetch = mysqli_fetch_assoc($query2)){
                                    $school = $fetch['SCHOOL NAME'];
                                    $crest = $fetch['CREST'];
                                }
                        }
                    ?>
                    <?php echo $message;?>
                   <div style="float:none; clear:both; "> <p style="line-height:25px;"><span id="sigin">Hi <?php echo $username?></span><br/><span id="signin2"><img src="web_images/avatar.png" style="border-radius:100px; width:20px; float:left; margin-right:20px;"> <?php echo $userid;?></span></p></div>
					<div style="float:none; clear:both;"><center><img src="image_uploads_crests/<?php echo $crest;?>" width="150px;">
                    <p style="line-height:20px;"><?php echo $school;?></p></center></div>
                    
					<div id="form">
                       <div class="wrap-input100 validate-input" data-validate="Enter password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="password">
						
						<span class="focus-input100" data-placeholder="Password" required></span>
                           
                           <input  type="hidden" name="userid" value="<?php echo $userid;?>">
					</div>
                    </div>
                    

<!--
					
-->
<div id="form1">
    
     <button id="button" class="android-btn" type="submit" style=" margin-top:-10px;" name="submit" value="submit"></button></div>
                 
                    <div id="form2" style="font-size:14px; margin-top:-25px;"><a href="forgotten_password.php">Forgot password?</a>
</div>
					<div class="text-center p-t-115" style="margin-top:-55px;">
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