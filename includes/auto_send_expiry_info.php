<?php 
    include 'mysql_connect.php';

    //pick schools whos expiry is almost ending
    $query = mysqli_query($conn,"select * from `school_entered_vouchers`");
    $counter =0;
    $schools='';
    while($fetch = mysqli_fetch_assoc($query)){
        $datetime1 = new DateTime(date('Y-m-d'));

        $datetime2 = new DateTime($fetch['EXPIRY DATE']);
        
        
            
            $difference = $datetime1->diff($datetime2);
                    
             $days = $difference->d;
             $month =$difference ->m;
            
            $school = $fetch['SCHOOL'];
            
            $number = '';
            $message = '';
            $email = '';
            $subject = 'ACCOUNT USAGE STATUS';
            
            $pick_admin = mysqli_query($conn,"SELECT * FROM `school_details` where `INITIALS`='$school'");
            while($pick = mysqli_fetch_assoc($pick_admin)){
                //pick admin
                $query_admin =  mysqli_query($conn,"SELECT * FROM `main admins` where `ADMIN EMAIL`='".$pick['ADMIN EMAIL']."'");
                if($fetch_admin = mysqli_fetch_assoc($query_admin)){
                    $number = $fetch_admin['ADMIN NUMBER'];
                    $email = $fetch_admin['ADMIN EMAIL'];
                    
                    if($month < 1){
$message ='Dear sir/Madam, You have '.$days.' days left  to activate your account';
                        
                        if($datetime2 <= $datetime1){
$message ='Dear sir/Madam, your session for using our system has expire please click the link provided to purchase a new  voucher code https://www.easyskul.com/cms/sms_payment_invoice.php?voucher=true';
                        }
                       include 'ZenophSMSGH/examples/non_personalised2.php';
                        $counter ++;
                        $to = $email;
                        $subject = 'ACCOUNT EXPIRY STATUS';
                        $txt = $message;

                        // To send HTML mail, the Content-type header must be set
                        $headers  = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                        // Additional headers

                        $headers .= "From: EASYSKUL <info@easyskul.com>" . "\r\n" .
                        "CC: ".$email."";

                       @  mail($to,$subject,$txt,$headers);
                        
                       $schools .= $school.'<br/>';
                    }
                    
            
                }
            }

        
        }     
echo '<h3>'.$counter. ' results found.</h3>';
echo $schools;
?>