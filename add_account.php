<!DOCTYPE html>
<html lang="en">
  
    	<head>
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="application-name" content="Astage">
	<meta name="description" content="EASYSKUL, as the name goes easy. Its a cloud base school management  system built to eleminate the tedous work of managing a school throug technology.">
	<meta name="keywords" content="school, EASYSKUL, school software, school management system">
	<meta name="author" content="pectra solutions">
	<title>EASYSKUL :: Add Your Account</title>
            
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
     <script src="//code.tidio.co/oc6tcjthxgtesxrtpwutqwmcbl4txaih.js"></script>
      
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
                    $form = '<div class="form-group">
                        <label>Please input your user ID here</label>
                        <input type="text" class="form-control" placeholder="USER ID HERE" required name="userid"/>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Continue</button>
                    </div>
';
                    
                   if(isset($_POST['userid']) && !empty($_POST['userid'])&&isset($_POST['password']) && !empty($_POST['password'])&&isset($_POST['cpassword']) && !empty($_POST['cpassword'])){
                       $userid = $_POST['userid'];
                       $password = $_POST['password'];
                       $cpassword = $_POST['cpassword'];
                       
                       if($password == $cpassword){
                           if(strlen($password) > 6){
                                $password = md5($password);
                                mysqli_query($conn,"update `main admins` set `ADMIN PASSWORD`='$password' where `ADMIN ID`='$userid'");
                                mysqli_query($conn,"update users set `PASSWORD`='$password' where `USER ID`='$userid'");
                                $_SESSION['USER ID']=$userid;
                                if(strpos($userid,'-AC')){
                                    
                                    echo "<script>window.open('cms/accountant_dashboard.php','_self')</script>";
                                    
                                }else if(strpos($userid,'-DE')){
                                    echo "<script>window.open('cms/data_entry_dashboard.php','_self')</script>";
                                }else if(strpos($userid,'-LB')){
                                    echo "<script>window.open('cms/libarian_dashboard.php','_self')</script>";
                                }else if(strpos($userid,'-HD')){
                                    echo "<script>window.open('cms/head_dashboard.php','_self')</script>";
                                }else if(strpos($userid,'-TCH')){
                                    echo "<script>window.open('cms/teacher_dashboard.php','_self')</script>";
                                }else if(strpos($userid,'-PT')){
                                    echo "<script>window.open('cms/parent_dashboard.php','_self')</script>";
                                }else if(strpos($userid,'-STD')){
                                    echo "<script>window.open('cms/student_dashboard.php','_self')</script>";
                                }else{
                                     
                                    echo "<script>window.open('cms/admin_dashboard.php','_self')</script>";
                                    
                                }
                           }else{
                                echo "<script>swal('','Password must be greater than 6','error');</script>";
                           }
                       }else{
                           echo "<script>swal('','Passwords do not match','error');</script>";
                       }
                   }
                    
                    if(isset($_POST['userid']) && !empty($_POST['userid'])){
                        $userid = $_POST['userid'];
                        
                        $query = mysqli_query($conn,"select * from users where `USER ID`='$userid' and `SCHOOL` !=''");
                        if($fetch = mysqli_fetch_assoc($query)){
                            if($fetch['PASSWORD'] ==''){
                                $form = '<div class="form-group">
                            <label>Please input you user ID here</label>
                            <input type="text" class="form-control" placeholder="USER ID HERE" required name="userid" value="'.$userid.'" readonly/>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="PASSWORD" id="password" name="password"/>
                        </div>
                        <div class="form-group">
                            <label>Connfirm Password</label>
                            <input type="password" class="form-control" placeholder="CONFIRM PASSWORD" id="password" name="cpassword"/>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Add Account</button>
                        </div>';
                            }else{
                                echo "<script>
                                    swal('','User Already Exist','warning');
                                </script>";
                            }
                        }else{
                             echo "<script>
                                    swal('','Incorrect user ID','error');
                                </script>";
                           
                        }
                    }
                ?>
                <form action="add_account.php" method="post">
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
        //document.getElementById("home").className="active";
    </script>
    
</html>