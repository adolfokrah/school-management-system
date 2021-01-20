<?php
    function mail_admin($conn,$email,$message,$subject){
        
        //pick username 
            
        $pick_username = mysqli_query($conn,"select * from `main admins` where `ADMIN EMAIL`='$email'");
        if($fetch = mysqli_fetch_assoc($pick_username)){
            $username = $fetch['ADMIN NAME'];
            $to = $email;
            $subject = $subject;
            $txt = "Hi ".$username.",".$message;

            // To send HTML mail, the Content-type header must be set
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            // Additional headers

            $headers .= "From: EASYSKUL <info@easyskul.com>" . "\r\n" .
            "CC: ".$username."";

            mail($to,$subject,$txt,$headers);
        }
    }


    //send email with attachment
//    function mail_attachment($from,$sender_name,$subject,$message,$receipients,$filepath,$file_name){
//         
//    use PHPMailer\PHPMailer\PHPMailer;
//    use PHPMailer\PHPMailer\Exception;
//    
//        require('PHPMailer-master/src/PHPMailer.php');
//        require('PHPMailer-master/src/Exception.php');
//        require_once('PHPMailer-master/src/OAuth.php');
//    
//        try{
//             $email = new PHPMailer();
//        $email->From      = $from;
//        $email->FromName  = $sender_name;
//        $email->Subject   = $subject;
//        $email->Body      = $message;
//        foreach($receipients as $receipient){
//            $email->AddAddress( $receiptient );
//        }
//
//        $file_to_attach = $filepath;
//
//        $email->AddAttachment( $file_to_attach , $file_name );
//
//        $email->Send();
//        echo 'Message sent';
//        }catch (Exception $e) {
//        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
//        }   
//       
//    }
?>