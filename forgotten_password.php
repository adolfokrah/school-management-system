<!DOCTYPE html>
<html lang="en">
  
    	<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="application-name" content="Astage">
	<meta name="description" content="EASYSKUL, as the name goes easy. Its a cloud base school management  system built to eleminate the tedous work of managing a school throug technology.">
	<meta name="keywords" content="school, EASYSKUL, school software, school management system">
	<meta name="author" content="pectra solutions">
	<title>EASYSKUL - Forgotten Password</title>
            
<link href="bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet" type="text/css"/>
<link href="css/header_style.css" rel="stylesheet" type="text/css"/>
<link href="web_images/logo2.png" rel="icon"/>
<link href="css/cms_style.css" rel="stylesheet" type="text/css"/>
<link href="css/web_styles.css" type="text/css" rel="stylesheet"/>
<script src="js/jQuery-v2.1.3.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/login.js"></script>
<script src="sweetalert2-master/dist/sweetalert2.all.min.js">
</script>
           
    </head>
    <style>
       @import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700";


body {
    font-family: 'Poppins', sans-serif;
    background: #fafafa;
}
        
    </style>
    <body>
        <?php 
            session_start();
            
            //redirect user to registration stage if user is in registration stage
            if(isset($_SESSION['email']) && !empty($_SESSION['email']) && isset($_SESSION['stage']) && !empty($_SESSION['stage'])){
                $stage = $_SESSION['stage']; 
                echo '<script>
                    
                    window.open(\''.$stage.'\',\'_self\');
                </script>';
            }
            else if(isset($_SESSION['email']) && !empty($_SESSION['email']) || isset($_SESSION['USER ID']) && !empty($_SESSION['USER ID'])){
                echo '<script>
                    
                    window.open(\'cms/\',\'_self\');
                </script>';
            }
       
       include 'includes/header.php';
            
            
        ?>
        
        <div id="box">
            <div class="row">
                <div class="content">
            <div class="col-sm-12 col-md-4 col-md-offset-4 col-sm-offset-0">
                <div class="box box-primary">
            
            <!-- /.box-header -->
                    
            <div class="box-body pad">
                <?php
                     include 'includes/mailing.php';

                    $form = '<div class="form-group">
                        <label>Please input you user ID here</label>
                        <input type="text" class="form-control" placeholder="USER ID HERE" required name="userid"/>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Continue</button>
                    </div>
';
                    
                   
                    
                    if(isset($_POST['userid']) && !empty($_POST['userid'])){
                        $userid = $_POST['userid'];
                        
                        $query = mysqli_query($conn,"select * from users where `USER ID`='$userid'");
                        if($fetch = mysqli_fetch_assoc($query)){
                           mysqli_query($conn,"update users set `PASSWORD`='',`PASSWORD RECOVERY`='YES' where `USER ID`='$userid'");
                            
                            $str_pos = strpos($userid,'-');
                            $initials = substr($userid,0,$str_pos);
                            
                            
                            $query_pick = mysqli_query($conn,"select * from `main admins` where `ADMIN ID`='$userid'");
                            if($fetch_admin = mysqli_fetch_assoc($query_pick)){
                                $number = $fetch_admin['ADMIN NUMBER'];
                                $email = $fetch_admin['ADMIN EMAIL'];
                                $admin_name= $fetch_admin['ADMIN NAME'];
                                $v_code = md5(rand(0,900));
                                mysqli_query($conn,"update users set `PASSWORD`='$v_code' where `USER ID`='$userid'");
                                
                                $message = 'Dear '.$admin_name.', Please click on the link provided to reset your password. https://easyskul.com/resetpwd?v_code='.$v_code.'&user='.$userid;
                                
                                include 'includes/ZenophSMSGH/examples/non_personalised2.php';
                                
                                $message =' Please click on the link provided to reset your password. https://easyskul.com/resetpwd?v_code='.$v_code.'&user='.$userid;
                                mail_admin($conn,$email,$message,'PASSWORD RECOVERY');
                                
                                echo "<script>
                                    swal('','A message has been set to you via email and SMS, please check and follow the instructions given to reset your password.','success');
                                </script>";
                                
                            }else{
                             
                           $pick_admin = mysqli_query($conn,"select * from users where `SCHOOL`='$initials' and `POSITION`='MAIN ADMIN' or `SCHOOL`='$initials' and `POSITION`='administrator'");
                            
                            while($fetch = mysqli_fetch_assoc($pick_admin)){
                                $number = $fetch['CONTACT'];
                                $email = $fetch['EMAIL'];
                                $id = $fetch['USER ID'];
                                if($fetch['POSITION']=='MAIN ADMIN'){
                                    $query_pick = mysqli_query($conn,"select * from `main admins` where `ADMIN ID`='$id'");
                                    if($fetch_admin = mysqli_fetch_assoc($query_pick)){
                                        $number = $fetch_admin['ADMIN NUMBER'];
                                        $email = $fetch_admin['ADMIN EMAIL'];
                                    }
                                }
                                
                                $message = 'A User with the user ID '. $userid.' has forgotten his/her password. Kindly check your portal to recover the password.';
                                
                                include 'includes/ZenophSMSGH/examples/non_personalised2.php';
                                
                                mail_admin($conn,$email,$message,'PASSWORD RECOVERY');
                                
                                echo "<script>
                                    swal('','A message has been set to your administrators, you will receive an sms as soon as they solve the problem','success');
                                </script>";
                            }   
                            }
                            
                        }else{
                             echo "<script>
                                    swal('','Incorrect user ID','error');
                                </script>";
                           
                        }
                    }
                ?>
                <form action="forgotten_password.php" method="post">
                    <?php echo $form ?>
                </form>
               
            </div>            
            </div>
            </div>
        </div>
            </div>
        </div>
           
        <?php //include 'includes/footer.php'?>
        
    </body>

    <script>
       // document.getElementById("home").className="active";
    </script>
    
</html>