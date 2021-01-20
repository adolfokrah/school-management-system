<!DOCTYPE html>
<html lang="en">
 
    	<head>
     <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="application-name" content="Easyskul">
	<meta name="description" content="Easyskul, as the name goes easy. Its a cloud base school management  system built to eleminate the tedous work of managing a school throug technology.">
	<meta name="keywords" content="school, EASYSKUL, school software, school management system">
	<meta name="author" content="pectra solutions">
	<title>EASYSKUL :: Integrated School Management System</title>
            
    
    <meta property="og:title" content="EASYSKUL :: Integrated School Management System" />
    <meta property="og:url" content="https://easyskul.com" /> 
    <meta property="og:description" content="Easyskul, as the name goes easy. Its a cloud base school management  system built to eleminate the tedous work of managing a school throug technology.">
    <meta property="og:image" content="https://easyskul.com/web_images/logo2.png"/>
    <meta property="og:type" content="easyskul" />
    <meta property="og:locale" content="en_GB" />
    <meta property="og:locale:alternate" content="fr_FR" />
    <meta property="og:locale:alternate" content="es_ES" />
    
<link href="bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet" type="text/css"/>
<link href="css/header_style.css" rel="stylesheet" type="text/css"/>
<link href="web_images/logo2.png" rel="icon"/>
<link href="css/web_styles.css" type="text/css" rel="stylesheet"/>
<script src="sweetalert2-master/dist/sweetalert2.all.min.js"></script>
<script src="js/jQuery-v2.1.3.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/login.js"></script>
<script src="js/singup_step1.js"></script>
<script src="//code.tidio.co/oc6tcjthxgtesxrtpwutqwmcbl4txaih.js"></script>
            <link rel="manifest" href="/manifest.json" />
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  var OneSignal = window.OneSignal || [];
    
  OneSignal.on('subscriptionChange', function (isSubscribed) {
    console.log("The user's subscription state is now:",isSubscribed);
      OneSignal.push(function() {
        OneSignal.getUserId(function(userId) {
          console.log("OneSignal User ID:", userId);
        });
      });
    });
  });
    
  OneSignal.push(function() {
    OneSignal.init({
      appId: "65f21f3d-0ddc-4379-997d-3356aea135cd",
      autoRegister: true, /* Set to true to automatically prompt visitors */
      notifyButton: {
          enable: true /* Set to false to hide */
      }
    });
  });
   
  
</script>
    </head>
    
    <body>

        <?php 
            session_start();
            
            //redirect user to registration stage if user is in registration stage
            if(isset($_SESSION['login']) && !empty($_SESSION['login']) && isset($_SESSION['stage']) && !empty($_SESSION['stage'])){
                $stage = $_SESSION['stage']; 
                echo '<script>
                    
                    window.open(\''.$stage.'\',\'_self\');
                </script>';
            }
            else if(isset($_SESSION['login']) && !empty($_SESSION['login']) || isset($_SESSION['USER ID']) && !empty($_SESSION['USER ID'])){
               @ $userid = $_SESSION['USER ID'];
                @ $email = $_SESSION['EMAIL'];
                
                     echo '<script>
                    
                        window.open(\'cms/admin_dashboard.php\',\'_self\');
                    </script>';
            }
       
       include 'includes/header.php';
            
            
        ?>
        
        
            <div id="header">
                
                <div class="content">
                    <div class="col-sm-12 col-md-7">
                        <h1 style="text-shadow: 1px 1px 4px #000000;  text-transform:uppercase"><strong>Hey! Welcome to easyskul</strong></h1>
                    <p style=" line-height:1.3em; font-size:24px;">A great platform to manage your school.<br/>
                        Join the biggest platform that  makes the <br/>management of your school
                        easier,faster <br/>and reliable today.</p>
                   <a href="about.php"><button type="button" id="about_us" name="submit" class="btn btn-success btn-md">About Easyskul <i class="fa fa-arrow-circle-right"></i></button></a> 
                   
                    </div>
                    <div class="hidden-sm col-md-5">
                         <div class="form-area" style="margin-top:-30px;">  
                                <form role="form">
                                <br style="clear:both">
                                            <div class="form-group">
                                                <h4 style="text-shadow: 1px 1px 2px #000000; text-align:center; text-transform:uppercase">Please fill in the form and click Sign up</h4>

                                                <input type="text" class="form-control" id="admin_name" name="admin_name" placeholder="Administrator Name" required>
                                            </div>
                                            <div class="form-group">
                                               
                                                <input type="email" class="form-control" id="admin_email" name="admin_email" placeholder="Email" required> Note: Mobile number should not include spaces
                                            </div>
                                            <div class="form-group"  style="margin-top:-15px;">
                                               
                                                <input type="tel" class="form-control" id="admin_mobile" name="admin_mobile" placeholder="Mobile Number" required>
                                            </div>
                                            <div class="form-group">
                                                
                                                <div class="input-group">
                                                    
                                                    
                                                    <input class="form-control" placeholder="password" name="admin_password" type="Password" autofocus required id="admin_password"><span class="input-group-addon">
                                                        <i class="fa fa-eye" style="cursor:pointer" id="see_password"></i>
                                                    </span> 
											     </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control" id="admin_confirm_password" name="admin_confirm_password" placeholder="Confirm Password" required>
                                            </div>
                                            
                               <div class="form-group">
                                     <button type="button" id="submit" name="submit" class="btn btn-success btn-block">Sign up for Easyskul</button> 
                                   
                                    <h5 style="text-align:center">By clicking “Sign up for Easyskul”, you agree to our
                                    <strong>terms of service</strong> and <a href="other.php"><strong>privacy policy</strong></a>. Well 
                                    occasionally send your account related emails
                                    and sms</h5>
                                </div>
                                    
                                </form>
                        </div>
                    </div>
                </div>
                
            </div>
        
        <div class="row">
            <div class="content" style="text-align:center; padding:20px;" id="row_header">
                <h3>How do i get my school to join the platform?<br/>
                    It's quite easy. The steps below will guide you.
                </h3><hr/>
            </div>
        </div>
      
        <div class="box">
            <div class="content">
                <div class="col-md-6 col-sm-12">
                    <div class="row"  style="padding-bottom:10px;">
                        <div class="col-sm-12 col-sm-3">
                            <center>
                            <img src="web_images/one.jpg" styles="margin-right:10px;"/></center>
                        </div>
                        <div class="col-sm-12 col-sm-9" id="content">
                            <h4><strong>ADMINISTRATOR DETAILS</strong></h4>
                            <p style="text-align: justify;">
                                The registration process comprises of three steps, the first step allows you to fill in administrator details.The administrator will be the only user who can have access to all user modules in the system, change system settings and school details. This step requires <strong>Admin Name, Email, Phone Number and other relevant informations</strong> from the registrar.
                            </p>

                        </div>
                    </div>
                    <div class="row"  style="padding-bottom:10px;">
                        <div class="col-sm-12 col-sm-3">
                            <center>
                            <img src="web_images/tow.jpg" styles="margin-right:10px;"/></center>
                        </div>
                        <div class="col-sm-12 col-sm-9" id="content">
                            <h4><strong>SCHOOL DETAILS</strong></h4>
                            <p style="text-align: justify;">
This step allows the registrar/Admin to fill in school details such as <strong>School Name, Address, Moto, crest etc.</strong> to the system since the system needs these details to complete the registration. After the system will generate school unique initials and ID for the users of the school's portal including the admin. The Admin will receive his <strong>Admin ID</strong> through <strong>SMS and Email</strong>. The admin will use the ID sent in combination with his / her password to login to the system.
</p>

                        </div>
                    </div>
                    <div class="row"  style="padding-bottom:10px;">
                        <div class="col-sm-12 col-sm-3">
                            <center>
                            <img src="web_images/three.jpg" styles="margin-right:10px;"/></center>
                        </div>
                        <div class="col-sm-12 col-sm-9" id="content">
                            <h4><strong>VERIFICATION</strong></h4>
                            <p style="text-align: justify;">
                            After the registrar completes filling <strong>Admin and school details</strong>. The Account created needs to be verified. This step allows the user to verify it by inputting the voucher code purchased in to the field provided.<a href="faq.php#voucher">How to get a voucher.</a> <strong>Note: </strong> expired and used voucher code will be ignored by the system.
                            After click verify to complete registration.
</p>

                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12" style="padding-top:10px;">
                <h4><strong>NEW SCHOOLS</strong></h4>

                    <div class="banner_slideshow">
                           <div id="transition-timer-carousel" class="carousel slide transition-timer-carousel" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#transition-timer-carousel" data-slide-to="0" class="active"></li>
				<li data-target="#transition-timer-carousel" data-slide-to="1"></li>
				
			</ol>

			<!-- Wrapper for slides -->
			<div class="carousel-inner">
				<div class="item active">
                    <img src="web_images/epinal.jpg" />
                    <div class="carousel-caption">
                        <h1 class="carousel-caption-header">Epinal Schools</h1>
                        <p class="carousel-caption-text hidden-sm hidden-xs">
                           Kasoa - Central Region
                        </p>
                    </div>
                </div>
                
                <div class="item">
                    <img src="web_images/Grade4KasoaCover.jpg" />
                    <div class="carousel-caption">
                        <h1 class="carousel-caption-header">Little Rock School</h1>
                        <p class="carousel-caption-text hidden-sm hidden-xs">
                             Kasoa - Central Region
                        </p>
                    </div>
                </div>
                
                
            </div>

			<!-- Controls -->
			<a class="left carousel-control" href="#transition-timer-carousel" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left"></span>
			</a>
			<a class="right carousel-control" href="#transition-timer-carousel" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right"></span>
			</a>
            
            <!-- Timer "progress bar" -->
            <hr class="transition-timer-carousel-progress-bar animate" />
		</div>
                        </div>
               
                </div>
            </div>
        </div>
        
        <div class="box" style="background-color:#dedede; margin-top:50px; padding:20px;">
            <div class="content" >
                <center><h3>SOME FEATURES OF THE SYSTEM</h3></center>
                <div class="box">
                <div class="col-sm-6 col-xs-12 col-md-3" style="margin-top:30px;">
                    <center>
                        <i class="fa fa-book" aria-hidden="true" style="font-size:24px;"></i>
                        <h4 style="text-align: center;"><strong>Out of the Box Flexibility for all Grading Type from School Management System</strong></h4>
                            <p style="text-align: justify;">Our experts have studied in details all types of Grading Systems followed in any part of the world, and designed the module to enable configuration of any Grading system followed by your institution. The only SIS which can accomodate any complexity in Grades and results processing. EasySkul's unique and proprietary formular allows you to  replicate your standards for students grades calculations.
</p>
                    </center>
                </div>
                <div class="col-sm-6 col-xs-12 col-md-3" style="margin-top:30px;">
                    <center>
                        <i class="fa  fa-cubes" aria-hidden="true" style="font-size:24px;"></i>
                        <h4 style="text-align: center;"><strong>Secured Portal for Students, Parents, Teachers, Accountants, Administrator and more</strong></h4>
                            <p style="text-align: justify;">Part of the unified communications startegy, EasySkul provides 24x7 access to pre identified information to different types of users-Students, Parents, Teachers, Accountants, Administrators,Data entry person,Libarian and Headmaster/Headmistress. The system has already assigned access level avoiding you the trouble to do so for every user. The same login protal intelligently identifies the type of user based on their access credentials- reducing complexity to manage and administer your SIS.
</p>
                    </center>
                </div>
                <div class="col-sm-6 col-xs-12 col-md-3" style="margin-top:30px;">
                    <center>
                        <i class="fa fa-bank (alias)" aria-hidden="true" style="font-size:24px;"></i>
                        <h4><strong>Complete Visibility into Income and Expenses</strong></h4>
                            <p style="text-align: justify;">A detailed accounting system automatically generates visual interpretation of your School's Income and Expenses. Accessible only via your Accountants secured credentials, get real time information about your institution Financial performance. Take informed decision.
</p>
                    </center>
                </div>
                <div class="col-sm-6 col-xs-12 col-md-3" style="margin-top:30px;">
                    <center>
                        <i class="fa fa-paw" aria-hidden="true" style="font-size:24px;"></i>
                        <h4><strong>Data Visualisation of your Institution's Performance</strong></h4>
                            <p style="text-align: justify;">Thoughtfully designed Analytical Dashboards provide you with easy interpretation of complex data of your institution. EasySkul captures and generates loads of data from your School's everyday operations. Visualising these data in visual graphs and charts provide you with never before insights.
</p>
                    </center>
                </div>
            </div>
                <div class="box">
                <div class="col-sm-6 col-xs-12 col-md-3" style="margin-top:30px;">
                    <center>
                        <i class="fa fa-users" aria-hidden="true" style="font-size:24px;"></i>
                        <h4><strong>MULTI USER</strong></h4>
                            <p style="text-align: justify;">24 X 7 X 365 access to your Administrators, Teachers, Students, Parents & Accountant. Application provides access to all your stakeholders who get to see what they are expected. We simplified the complexity of user privileges so that you don’t need to worry about it.
</p>
                    </center>
                </div>
                <div class="col-sm-6 col-xs-12 col-md-3" style="margin-top:30px;">
                    <center>
                        <i class="fa fa-archive" aria-hidden="true" style="font-size:24px;"></i>
                        <h4><strong>EXAMINATION</strong></h4>
                            <p style="text-align: justify;">Create and publish a list of all examinations for the current academic year which will be visible to Teachers, Students and their parents using their respective logins.
</p>
                    </center>
                </div>
                <div class="col-sm-6 col-xs-12 col-md-3" style="margin-top:30px;">
                    <center>
                        <i class="fa fa-navicon (alias)" aria-hidden="true" style="font-size:24px;"></i>
                        <h4><strong>MULTI CURRICULUM</strong></h4>
                            <p style="text-align: justify;">The system is so flexible to allow your school to configure multiple Boards or Curriculum. All classes, students, examination, grading and related are aligned as per the Boards selected so that you can easily manage multiple curriculum within the same system. 
</p>
                    </center>
                </div>
                <div class="col-sm-6 col-xs-12 col-md-3" style="margin-top:30px;">
                    <center>
                        <i class="fa fa-tasks" aria-hidden="true" style="font-size:24px;"></i>
                        <h4><strong>TIME TABLE/SCHEDULE</strong></h4>
                            <p style="text-align: justify;">Easily create flexible TimeTable for conducting classes in a planned manner. Teachers, students, parents can all view their respective timetables in their login
</p>
                    </center>
                </div>
                    
                    </div>
            </div>
            <center><h3>And More Features.</h3></center>
        </div>
        
        <div class="row">
            <div class="content" style="padding:10px; color:black;">
                <center><h3><strong>Why choose us?</strong></h3>
                    <h4>This software has been built in a flexible way which allows us to customize it to fit perfectly how each school operates. </h4>
                </center>
            </div>
        </div>
        <div class="row">
            <div class="content">
                <div class="col-sm-12 col-md-6">
                    <dv class="row">
                        <div class="content">
                            <div class="col-sm-12 col-md-1">
                               <center> <img src="web_images/web_29.jpg"/></center>
                            </div>
                            <div class="col-sm-12 col-md-11">
                               <h4><strong>Accessible Every Where</strong></h4>
                            <p>Since this system is remotely hosted, the system can be accessed every where at any time and with any device which can access the internet.
</p>
                            </div>
                        </div>
                    </dv>
                </div>
                
                <div class="col-sm-12 col-md-6">
                    <dv class="row">
                        <div class="content">
                            <div class="col-sm-12 col-md-1">
                                <center><img src="web_images/web_32.jpg"/></center>
                            </div>
                            <div class="col-sm-12 col-md-11">
                               <h4><strong>Strong Database</strong></h4>
                            <p>We use a database , which is a very strong and high level database as a back end and since this system is remotely hosted, all database are safe from damage and cannot be lost also database can be accessed everywhere.
</p>
                            </div>
                        </div>
                    </dv>
                </div>
            </div>
        </div>
        
        <?php include 'includes/footer.php'?>
                

    </body>

    <script>
        document.getElementById("home").className="active";
          $(document).ready(function() {    
    //Events that reset and restart the timer animation when the slides change
    $("#transition-timer-carousel").on("slide.bs.carousel", function(event) {
        //The animate class gets removed so that it jumps straight back to 0%
        $(".transition-timer-carousel-progress-bar", this)
            .removeClass("animate").css("width", "0%");
    }).on("slid.bs.carousel", function(event) {
        //The slide transition finished, so re-add the animate class so that
        //the timer bar takes time to fill up
        $(".transition-timer-carousel-progress-bar", this)
            .addClass("animate").css("width", "100%");
    });
    
    //Kick off the initial slide animation when the document is ready
    $(".transition-timer-carousel-progress-bar", "#transition-timer-carousel")
        .css("width", "100%");
});
        
        $(document).ready(function(){

var images = Array("web_images/library.jpg",
               "web_images/epinal2.jpg");
var currimg = 0;


function loadimg(){

   $('#header').animate({ opacity: 1 }, 2000,function(){

        //finished animating, minifade out and fade new back in           
        $('#header').animate({ opacity: 0.7 }, 3000,function(){

            currimg++;

            if(currimg > images.length-1){

                currimg=0;

            }

            var newimage = images[currimg];

            //swap out bg src                
            $('#header').css("background-image", "url("+newimage+")"); 

            //animate fully back in
           
            $('#header').animate({ opacity: 1 }, 2000,function(){
                
                //set timer for next
                setTimeout(loadimg,5000);

            });

        });

    });

  }
  loadimg();

});
    </script>
</html>