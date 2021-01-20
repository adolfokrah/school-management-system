<!DOCTYPE html>
<html lang="en">
    	<head>
      <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="application-name" content="easyskul">
	<meta name="description" content="EASYSKUL, as the name goes easy. Its a cloud base school management  system built to eleminate the tedous work of managing a school throug technology.">
	<meta name="keywords" content="school, EASYSKUL, school software, school management system,register my school, easyskul registration, regsiter easyskul">
	<meta name="author" content="pectra solutions">
	<title>EASYSKUL - Register Your School Today</title>
            
<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet" type="text/css"/>
<link href="css/header_style.css" rel="stylesheet" type="text/css"/>
<link href="web_images/logo2.png" rel="icon"/>
<link href="css/web_styles.css" type="text/css" rel="stylesheet"/>
<link href="css/other.css" type="text/css" rel="stylesheet"/>
            
    <script src="js/jQuery-v2.1.3.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/singup_step1.js"></script>
    <script src="js/login.js"></script>
            <script src="//code.tidio.co/oc6tcjthxgtesxrtpwutqwmcbl4txaih.js"></script>

    </head>
    <body>
        <?php 
            session_start();
            //redire user to registration stage if user is in registration stage
            if(isset($_SESSION['email']) && isset($_SESSION['stage']) && !empty($_SESSION['email']) && !empty($_SESSION['stage'])){
                echo '<script>
                    
                    window.open(\''.$_SESSION['stage'].'\',\'_self\');
                </script>';
            }
            include 'includes/header.php';
            
        ?>
        
        
            <div id="header_image" style="background-image:url(web_images/step1.jpg);  border-color:#004c6c;  max-height:300px; min-height:100px">
                
                
                
            </div>
        
            <section>
          
                <div class="container" style="padding:50px;">
                  <div class="row">
                            
                <!--stepts header-->
                <div class="container">
	
            <ul class="nav nav-pills nav-justified thumbnail">
                <li  class="active"><a href="#">
                    <h4 class="list-group-item-heading">Step 1</h4>
                    <i class="fa fa-user" style="font-size:30px;"></i>
                    <p class="list-group-item-text">Administrator Details</p>
                </a></li>
                <li class="disabled"><a href="#">
                    <h4 class="list-group-item-heading">Step 2</h4>
                    <i class="fa fa-university" style="font-size:30px;"></i>
                    <p class="list-group-item-text">School Details</p>
                </a></li>
                <li class="disabled"><a href="#">
                    <h4 class="list-group-item-heading">Step 3</h4>
                    <i class="fa fa-credit-card" aria-hidden="true"></i>

                    <p class="list-group-item-text">Verificaton</p>
                </a></li>
            </ul>
        </div>
	       <!--end-->
                    <div class="col-md-6 col-md-offset-3 col-sm-10">
                    
                     <div class="form-area">  
                                <form role="form">
                                <br style="clear:both">
                                            <h3 style="margin-bottom: 25px; text-align: center;">Please fill in the form and press continue</h3>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="admin_name" name="admin_name" placeholder="Administrator Name" required>
                                            </div>
                                            <div class="form-group">
                                                <label><small><strong>Note: </strong>Please use a valid email address.</small></label>
                                                <input type="email" class="form-control" id="admin_email" name="admin_email" placeholder="Email" required>
                                            </div>
                                            <div class="form-group">
                                                <label><small><strong>Note: </strong>Mobile number should not include spaces</small></label>
                                                <input type="tel" class="form-control" id="admin_mobile" name="admin_mobile" placeholder="Mobile Number" required>
                                            </div>
                                            <div class="form-group">
                                                <label><small><strong>Note: </strong>Password must be more than six and must be in lowercase, uppercase and alphanumeric</small></label>
                                                <div class="input-group">
                                                    
                                                    
                                                    <input class="form-control" placeholder="password" name="admin_password" type="password" autofocus required id="admin_password"><span class="input-group-addon">
                                                        <i class="fa fa-eye" style="cursor:pointer" id="see_password"></i>
                                                    </span> 
											     </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control" id="admin_confirm_password" name="admin_confirm_password" placeholder="Confirm Password" required>
                                            </div>
                                            
                                <button type="button" id="submit" name="submit" class="btn btn-primary btn-block" style="height:50px; font-size:20px;">Sign up for Easyskul</button>
                                </form>
                            </div>

                    </div>   
                  </div><!-- /row -->
                </div>
            </section>
        
        
        
        <?php include 'includes/footer.php'?>
     
    </body>

    
    <script>
        
    </script>
</html>