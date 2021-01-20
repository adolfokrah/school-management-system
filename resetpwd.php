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
                    include 'includes/mysql_connect.php';
                    if(isset($_GET['user']) && isset($_GET['v_code']) && !empty($_GET['user']) && !empty($_GET['v_code'])){
                       if( mysqli_query($conn,"update users set `PASSWORD`='',`PASSWORD RECOVERY`='' where `USER ID`='".$_GET['user']."' and `SCHOOL` !=''")){
                            echo '<div class="alert alert-success" style="color:white">Your password has been resetted please Add your account to continue</div>';
                       }
                       
                    }else{
                        echo '<script>
                    
                    window.open(\'index.php\',\'_self\');
                </script>';    
                    }
                ?>
               
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