<!DOCTYPE html>
<html lang="en">
    	<head>
             <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="application-name" content="Astage">
	<meta name="description" content="easyskul School Management System software is a cloud based software that computerizes the life cycle of a student from admission, academic records, facilitates collaboration, allows fees collection, conduct exams and print report cards, generate timetables and more.">
	<meta name="keywords" content="school, EASYSKUL, school software, school management system, easyskul.com, easyskul, easy, skul">
	<meta name="author" content="pectra solutions">
	<title>EASYSKUL - Sing Up</title>
            
<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet" type="text/css"/>
<link href="css/header_style.css" rel="stylesheet" type="text/css"/>
<link href="web_images/logo2.png" rel="icon"/>
<link href="css/web_styles.css" type="text/css" rel="stylesheet"/>
<link href="css/other.css" type="text/css" rel="stylesheet"/>
        <script src="js/jQuery-v2.1.3.js"></script>
        <script src="js/boostrap.min.js"></script>
        <script src="js/singup_step3.js"></script>
        <script src="sweetalert2-master/dist/sweetalert2.all.min.js"></script>
        <script src="js/login.js"></script>
            <script src="//code.tidio.co/oc6tcjthxgtesxrtpwutqwmcbl4txaih.js"></script>

    </head>
    
    <body>
        <?php 
            session_start();
            //redire user to registration stage if user is in registration stage
            if(isset($_SESSION['email']) && !empty($_SESSION['email'])){
                
                if(isset($_SESSION['login']) && !empty($_SESSION['login'])){
                    echo '<script>
                        window.open(\'cms/admin_dashboard.php\',\'_self\');
                    </script>';
                }
                
            }else{
                echo '<script>
                    
                    window.open(\'index.php\',\'_self\');
                </script>';
            }
        include 'includes/header.php';
        ?>
        
        
            <div id="header_image" style="background-image:url(web_images/step3.jpg);  border-color:#004c6c;  max-height:300px; min-height:100px">
                
                
                
            </div>
           
            <section>
          
                <div class="container" style="padding:50px;">
                  <div class="row">
                            
                <!--stepts header-->
                
	
        <div class="col-xs-12" >
            <ul class="nav nav-pills nav-justified thumbnail">
                <li class="disabled"><a href="#">
                    <h4 class="list-group-item-heading">Step 1</h4>
                    <i class="fa fa-user" style="font-size:30px;"></i>
                    <p class="list-group-item-text">Administrator Details</p>
                </a></li>
                <li class="disabled"> <a href="#">
                    <h4 class="list-group-item-heading">Step 2</h4>
                    <i class="fa fa-university" style="font-size:30px;"></i>
                    <p class="list-group-item-text">School Details</p>
                </a></li>
                <li    class="active"><a href="#">
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
                                            <h3 style="margin-bottom: 25px; text-align: center;">Please Input Voucher Code Given 
                                    Below</h3>
                                            <div class="form-group">
                                                <label><small><strong>Note:</strong> Please make sure your voucher code is not expired</small></label>
                                                <input type="text" class="form-control" id="vcode" name="vcode" placeholder="Voucher Code here" required>
                                            </div>
                                            
<div class="form-group">
                                    
                                <button type="button" id="submit" name="submit" class="btn btn-tw btn-block" style="height:50px; font-size:20px;">Verify 
</button></div>
                                    <div class="form-group">
                       <a href="cms/sms_payment_invoice.php?voucher=true" target="_blank" style="text-decoration:none"><button type="button" class="btn btn-warning btn-block">Get Voucher</button></a> 
                    </div>
                                   
                                </form>
                            </div>

                    </div>   
                  </div><!-- /row -->
                </div>
            </section>
        
        
        
        <?php include 'includes/footer.php';
           
        ?>
     
    </body>

    
    <script>
        
    </script>
</html>