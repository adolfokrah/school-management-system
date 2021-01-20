<!DOCTYPE html>
<html lang="en">
    	<head>
             <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="application-name" content="easyskul">
	<meta name="description" content="EASYSKUL, as the name goes easy. Its a cloud base school management  system built to eleminate the tedous work of managing a school throug technology.">
	<meta name="keywords" content="school, EASYSKUL, school software, school management system">
	<meta name="author" content="pectra solutions">
	<title>EASYSKUL - Sing Up</title>
            
<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet" type="text/css"/>
<link href="css/header_style.css" rel="stylesheet" type="text/css"/>
<link href="web_images/logo2.png" rel="icon"/>
<link href="css/web_styles.css" type="text/css" rel="stylesheet"/>
<link href="css/other.css" type="text/css" rel="stylesheet"/>

<link rel="stylesheet" href="css/boostrap-select.min.css" type="text/css"/> 
            
          
<script src="js/jQuery-v2.1.3.js"></script>
<script src="js/boostrap.min.js"></script>
<script  src="js/bootstrap-select.min.js"></script>
<script src="js/singup_step2.js"></script>  
<script src="cms/sweetalert2-master/dist/sweetalert2.all.min.js"></script>
            <script src="js/login.js"></script>
            <script src="//code.tidio.co/oc6tcjthxgtesxrtpwutqwmcbl4txaih.js"></script>

    </head>
    <body>
        <?php 
        session_start();
        
            //redire user to registration stage if user is in registration stage
            if(isset($_SESSION['email']) && isset($_SESSION['stage']) && !empty($_SESSION['email']) && !empty($_SESSION['stage'])){
                
            }else{
                 echo '<script>
                    
                    window.open(\'index.php\',\'_self\');
                </script>';
            }
        
        include 'includes/header.php';
        
            
        ?>
        
        
            <div id="header_image" style="background-image:url(web_images/step2.jpg);  border-color:#004c6c;  max-height:300px;min-height:100px; ">
                
                
                
            </div>
        
            <section>
          
                <div class="container" style="padding:50px;">
                  <div class="row">
                            
                <!--stepts header-->
                
        <div class="col-xs-12">
            <ul class="nav nav-pills nav-justified thumbnail">
                <li class="disabled"><a href="#">
                    <h4 class="list-group-item-heading">Step 1</h4>
                    <i class="fa fa-user" style="font-size:30px;"></i>
                    <p class="list-group-item-text">Administrator Details</p>
                </a></li>
                <li   class="active"><a href="#">
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
                                <form role="form" id="form" enctype="multipart/form-data">
                                <br style="clear:both">
                                            <h3 style="margin-bottom: 25px; text-align: center;">Please fill in the form and press continue</h3>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="school_name" name="school_name" placeholder="School Name" required>
                                            </div>
                                            <div class="form-group">
                                                <label><small>Use (/ or - ) to seperate numbers </small></label><br/>
                                                <textarea class="form-control" id="numbers" name="numbers" placeholder="Phone numbers" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <textarea class="form-control" id="address" name="address" placeholder="Address" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                
                                                    <labe>SMS ID will be the name on the sms you send from the system.<strong>  note:</strong>  it should not be more than 11 characters.</labe>
                                                    <input type="text" class="form-control"  name="sms_id" id="sms_id" placeholder="SMS ID" maxlength="11">
                                            </div>
                                    
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="moto" name="moto" placeholder="School Moto" required>
                                            </div>
                                            <div class="form-group">
                                                <label><small>Select Country: </small></label><br/>
                                               <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width:100%" id="country">
                                            <option value="Benin" >Benin</option>
                                            <option value="Burkina Faso">Burkina Faso</option>
                                                <option value="Cape Verde">Cape Verde</option>
                                                   <option value="Cote d'Ivoire (Ivory Coast)">Cote d'Ivoire (Ivory Coast)</option>
                                                   <option value="Gambia">Gambia</option>
                                                   <option value="Ghana">Ghana</option>
                                                   <option value="Guinea">Guinea</option>
                                                   <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                   <option value="Liberia">Liberia</option>
                                                   <option value="Mali">Mali</option>
                                                   <option value="Mauritania">Mauritania</option>
                                                   <option value="Niger">Niger</option>
                                                   <option value="Nigeria">Nigeria</option>
                                                  
                                                   <option value="Senegal">Senegal</option>
                                                   <option value="Sierra Leone">Sierra Leone</option>
                                                
                                                   <option value="Togo">Togo</option>
                                                   
                                          </select>

                                            </div>
                                           <div class="form-group">
                                                <input  type="text" class="form-control" id="city" name="city" placeholder="City / Town" required>
                                            </div>
                                    
                                            <div class="form-group">
                                                <label><small>Please make sure you pick the right logo. Image is automatically resized to fix print outs </small></label><br/>
                                                <div class="form-control" id="creast-holder">
                                                    
                                                </div><br/>
                                                <label class="btn btn-fb btn-block" for="file">Choose School Creast</label>
                                                <input type="file" class="form-control" style="display:none" id="file" name="file" accept="image/*">
                                            </div>

                                <button type="button" id="submit" name="submit" class="btn btn-tw btn-block" style="height:50px; font-size:20px;">Continue</button>
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