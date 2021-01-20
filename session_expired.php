<!DOCTYPE html>
<html lang="en">
  
    	<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="application-name" content="Astage">
	<meta name="description" content="EASYSKUL, as the name goes easy. Its a cloud base school management  system built to eleminate the tedous work of managing a school throug technology.">
	<meta name="keywords" content="school, EASYSKUL, school software, school management system">
	<meta name="author" content="pectra solutions">
	<title>EASYSKUL</title>
            
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
            
            //redirect user to registration stage if user is in registration stage
            if(isset($_SESSION['email']) && !empty($_SESSION['email']) && isset($_SESSION['stage']) && !empty($_SESSION['stage'])){
                $stage = $_SESSION['stage']; 
                echo '<script>
                    
                    window.open(\''.$stage.'\',\'_self\');
                </script>';
            }
            else if(isset($_SESSION['email']) && !empty($_SESSION['email']) || isset($_SESSION['USER ID']) && !empty($_SESSION['USER ID'])){
               
            }
       
            
            
        ?>
        
        <div class="content">
            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <center><img src="web_images/expired_banner.png" class="img img-responsive" style="padding-top:60px;"/></center>
                </div>
             
            </div>
            
                <div class="col-sm-4 col-sm-offset-4">
                    <div class="form-group" style="text-align:center">
                        <label>Your voucher session has expire please input new voucher code to active your account.</label>
                        <input type="text" placeholder="Vocher Code here" class="form-control" id="vcode"/>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary btn-block" id="activate_btn">Activate</button>
                    </div>
                    <div class="form-group">
                       <a href="cms/sms_payment_invoice.php?voucher=true" target="_blank" style="text-decoration:none"><button type="button" class="btn btn-warning btn-block">Get Voucher</button></a> 
                    </div>
                </div>
        </div>
           
        <?php //include 'includes/footer.php'?>
        
    </body>

    <script>
        //send ajax request
        $('document').ready(function(){
            $('#activate_btn').on('click',function(){
                var vcode = $('#vcode').val();
                if(vcode ==""){
                    swal('','Voucher code needed','warning');
                }else{
                    $(this).html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> please wait...');
                    $(this).attr('disabled','true');
                     $.post("includes/renew_voucher.php",{vcode:vcode},
                          function(data){
                                console.log(data);
                                $('#activate_btn').html('Activate');
                                $('#activate_btn').removeAttr('disabled','true');
                                if(data=="expired"){
                                    swal('Fail','voucher code expired','error');
                                }else if(data=="used"){
                                    swal('Fail','voucher has already been used','error');
                                }else if(data=="notfound"){
                                    swal('Fail','incorrect voucher code','error');
                                }else{
                                    window.open('cms/print_payment_receipt.php?id='+data,'_blank');
                                    window.open('cms/admin_dashboard.php','_self');
                                }
                          })
                    }
        })
        })
    </script>
    
</html>