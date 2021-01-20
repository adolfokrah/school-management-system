<?php
    include 'mysql_connect.php';
    include 'school_ini_user_id.php';

    if(isset($_REQUEST['id']) && isset($_REQUEST['accept'])){
        $id = $_REQUEST['id'];
        $accept = $_REQUEST['accept'];
        
        
        $sql = "select * from `payment_invoices` where `ID`='$id'";
        $query = mysqli_query($conn,$sql);
        
        if(mysqli_num_rows($query) < 1){
            echo 'not found';
        }else{
            mysqli_query($conn,"update `payment_invoices` set `STATUS`='".mysqli_real_escape_string($conn,$accept)."' where `ID`='$id'");
            
            
            $school='';
            $quantity = '';
            $number  = '';
            $user ='';
            $query1 = mysqli_query($conn,"select * from `payment_invoices` where `ID`='$id'");
                if(mysqli_num_rows($query1) > 0){
                    if($fetch1 = mysqli_fetch_assoc($query1)){
                        $user = $fetch1['USER ID'];
                        $quantity = $fetch1['QUANTITY'];
                        $school = $fetch1['SCHOOL'];
                        $number = $fetch1['MOBILE MONEY NUMBER'];
                    }
                    
                }else{
                    
                    echo 'this not found';
                    
                }
                
            
            $query = mysqli_query($conn,"select * from `sms_credit` where `SCHOOL`='$school'");
            if(mysqli_num_rows($query) > 0){
            if($fetch = mysqli_fetch_assoc($query)){
               $sms_id = $fetch['ID'];
               $sms_left = $fetch['SMS LEFT'];
            }
         }else{
                echo 'this rather not found';
            }
            
            $sms_total = $quantity + $sms_left;
            
            $query = mysqli_query($conn,"update `sms_credit` set `SMS LEFT`='".mysqli_real_escape_string($conn,$sms_total)."' where `SCHOOL`='".mysqli_real_escape_string($conn,$school)."' and `ID`='$sms_id'");
            
            $message = 'Dear sir/Madam, your account has successfully been topup with '.$quantity.' SMS credit. SMS left '.$sms_total;
            include 'ZenophSMSGH/examples/non_personalised2.php';
            $email = '';
            $subject = '';
            $query_pick_mail  = mysqli_query($conn,"select * from users where `USER ID`='$user'");
            if($fetch=mysqli_fetch_assoc($query_pick_mail)){
                $email = $fetch['EMAIL'];
                $subject = "SMS TOPUP";
               
                
            }
            
            $query_pick_mail2  = mysqli_query($conn,"select * from `main admins` where `ADMIN ID`='$user'");
            if($fetch=mysqli_fetch_assoc($query_pick_mail2)){
                $email = $fetch['ADMIN EMAIL'];
                $subject = "VOUCHER CODE";
               
            }
            
            $to = $email;
            $subject = $subject;
            $txt = $message;

            // To send HTML mail, the Content-type header must be set
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            // Additional headers

            $headers .= "From: EASYSKUL <info@easyskul.com>" . "\r\n" .
            "CC: ".$email."";

            mail($to,$subject,$txt,$headers);
            echo 'success';
        }
            
        }
        
    

?>
