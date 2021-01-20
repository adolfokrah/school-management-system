<!DOCTYPE html>
<html lang="en">
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

    	<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="application-name" content="Astage">
	<meta name="description" content="EASYSKUL, as the name goes easy. Its a cloud base school management  system built to eleminate the tedous work of managing a school throug technology.">
	<meta name="keywords" content="school, EASYSKUL, school software, school management system">
	<meta name="author" content="pectra solutions">
	<title>EASYSKUL - Contact our customer care for any info and assistance</title>
            
<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet" type="text/css"/>
<link href="css/header_style.css" rel="stylesheet" type="text/css"/>
<link href="web_images/logo2.png" rel="icon"/>
<link href="css/web_styles.css" type="text/css" rel="stylesheet"/>
<script src="sweetalert2-master/dist/sweetalert2.all.min.js"></script>
<script src="js/jQuery-v2.1.3.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/login.js"></script>
            <script src="//code.tidio.co/oc6tcjthxgtesxrtpwutqwmcbl4txaih.js"></script>

    </head>
    <body>
        <?php include 'includes/header.php'?>
        
        
             <div id="header" style="background-image:none; background-color:#092e3d; border:none; padding-bottom:50px;">
                
                <div class="content">
                    <center>    <img src="web_images/logo.png" width="300px;"/><br/><br/>
                    <strong><span style="font-size:30px;">Contact us Now</span></strong>
                    </center>
                </div>
                
            </div>
        
            <section>
                <div class="box" style="padding-bottom:20px;">
                    <div class="container">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-area">  
                                <form role="form" action="contact.php" method="POST">
                                <br style="clear:both">
                                            <h3 style="margin-bottom: 25px; text-align: center;">Please fill in the form and press submit</h3>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="name" name="fname" placeholder="Name" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="email" class="form-control" id="email" name="femail" placeholder="Email" required >
                                            </div>
                                            <div class="form-group">
                                                <input type="tel" class="form-control"  placeholder="Mobile Number" name="ftel"  required >
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control"  placeholder="Subject" name="fsubject" required >
                                            </div>
                                            <div class="form-group">
                                            <textarea class="form-control" type="textarea" id="message" placeholder="Message" maxlength="140" rows="7" name="fmsg"></textarea>
                                            </div>

                                <button type="submit" id="submit" name="submit" class="btn btn-primary pull-right">Submit Form</button>
                                </form>
                                
                                <?php
                                    if(isset($_POST['fname'])&&isset($_POST['femail']) && isset($_POST['ftel']) && isset($_POST['fsubject']) &&isset($_POST['fmsg'])){
                                        
                                        $email = $_POST['femail'];
                                        $number = $_POST['ftel'];
                                        
                                        $to = 'info@easyskul.com';
                                        $subject = $_POST['fsubject'];
                                        $txt = htmlentities($_POST['fmsg']);

                                        // To send HTML mail, the Content-type header must be set
                                        $headers  = 'MIME-Version: 1.0' . "\r\n";
                                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                                        // Additional headers

                                        $headers .= "From: $email <".$_POST['fname'].">" . "\r\n" .
                                        "CC: info@easyskul.com";

                                       @  mail($to,$subject,$txt,$headers);
                                        
$message = "Dear Sir/Madam, We have receive your mail we will soon be with you.";
                                       include 'includes/ZenophSMSGH/examples/non_personalised2.php';
                                       echo "<script>swal('','Message sent','success')</script>";
                                    }else{
                                      // echo "<script>swal('','Message not sent','error')</script>";
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12" style="padding:40px;">
                            <address>
                            <h3><strong>Easyskul.com</strong></h3><br>
                            <h4>Accra - Ghana</h4>
                            <h4><abbr title="Phone">P:</abbr> (+233) 245-301631 | (+233) 57 768 1063 | (+233) 026 443 2039</h4>
                            </address>
                            <address>
                            <strong>Easyskul</strong><br>
                            <a href="#"><span>info@easyskul.com</span></a>
                            </address>
                            
                            <h3>Get in touch with us</h3><hr/>
                            <p><img src="web_images/fb.jpg" width="40px;"/> easyskul</p>
                            <p><img src="web_images/tw.jpg" width="40px;"/> @easyskul</p>
                            <p><img src="web_images/in.jpg" width="40px;"/> easyskul</p>
                        </div>
                    </div>
                </div>
                <div class="box">
                    
                    <center><h1><i class="fa fa-map-marker" aria-hidden="true"></i> Locate us</h1></center><hr/>
                      <iframe src="https://maps.google.com/maps?q='kasoa'&hl=en&z=14&amp;output=embed" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
                    
                </div>
            </section>
        
        
        
        <?php include 'includes/footer.php'?>
         <?PHP
	function sendMessage(){
//		$content = array(
//			"en" => 'This is a test Push from easyskul.'
//			);
//        $headings = array(
//            "en"=>'From Epinal School'
//        );
//		$web_buttons = array(
//            "id"=> "read-more-button", "text" => "Read more",'icon'=>"",'url'=>"https://github.com"
//        );
//		$fields = array(
//			'app_id' => "65f21f3d-0ddc-4379-997d-3356aea135cd",
//			'included_segments' => array('All'),
//      'data' => array("foo" => "bar"),
//			'contents' => $content,
//            'headings' => $headings,
//            'chrome_web_image' => "http://hdwpro.com/wp-content/uploads/2017/02/Colorful-Nice-Wallpaper.jpg",
//            'chrome_web_icon' => "http://hdwpro.com/wp-content/uploads/2017/02/Colorful-Nice-Wallpaper.jpg",
//            'url'=>"https://youtube.com"
//            
//		);
//		
//		$fields = json_encode($fields);
//    print("\nJSON sent:\n");
//    print($fields);
//		
//		$ch = curl_init();
//		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
//		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
//												   'Authorization: Basic ZGUxMjE5NTItZmRhNy00MGUwLWE4ZTItMjg4MWU4YTRjYzJi'));
//		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//		curl_setopt($ch, CURLOPT_HEADER, FALSE);
//		curl_setopt($ch, CURLOPT_POST, TRUE);
//		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
//		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//
//		$response = curl_exec($ch);
//		curl_close($ch);
//		
//		return $response;
//	}
//	
//	$response = sendMessage();
//	$return["allresponses"] = $response;
//	$return = json_encode( $return);
//	
////  print("\n\nJSON received:\n");
////	print($return);
////  print("\n");
?>
    </body>

    <script>
        document.getElementById("contact").className="active";
    </script>
</html>