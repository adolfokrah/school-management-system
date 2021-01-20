<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: X-PINGOTHER, Content-Type');
header('Access-Control-Max-Age: 86400');

    include 'school_ini_user_id.php';
    
  
    if(isset($_REQUEST['vcode'])){ 
       $vcode = md5($_REQUEST['vcode']);
       $date = date('Y-m-d');
       $time = new datetime('now',new DateTimeZone('Europe/London'));
       $current_time = $time->format('h:i a');
      //check if vocher number exist
            $year = date('Y');
            $pick = mysqli_query($conn,"select * from `renewal_vouchers` where `VOUCHER CODE`='$vcode'");
            if($fetch = mysqli_fetch_assoc($pick)){
                
                
                $effectiveDate = strtotime("+4 months", strtotime(date('Y-m-d'))); 
                $new_date = date('Y-m-d',$effectiveDate);
                
               // $effectiveDate = strtotime("+2 weeks", strtotime($new_date)); 
                $expiry_date = date('Y-m-d',$effectiveDate);
                
                if($fetch['EXPIRY DATE'] < $date){
                    echo 'expired';
                }else if($fetch['USED']=='true'){
                    echo 'used';
                }else{
                    mysqli_query($conn,"update `renewal_vouchers` set `USED`='true' where `VOUCHER CODE`='$vcode'");
                    mysqli_query($conn,"update `school_details` set `RENEWAL DATE`='".$date."' where `INITIALS`='$initials'");
                    mysqli_query($conn,"update `school_entered_vouchers` set `DATE RENEWED`='$date',`EXPIRY DATE`='".$expiry_date."' where `SCHOOL`='$initials'");
                    $rnumber = receipt_number($year,$conn);
                    mysqli_query($conn,"INSERT INTO `account_renewals` (`ID`, `SCHOOL`, `ADMIN ID`, `RENEWAL DATE`, `OPERATION`, `UNIT PRICE`, `QUANTITY`, `AMOUNT`, `DATE`, `TIME`,`RECEIPT NUMBER`) VALUES (NULL, '$initials', '$user', '$date', 'ACCOUNT REACTIVATION', '200', '0', '200.00', '$date', '$current_time','$rnumber');");
                    
                    
                   
                    $query_pick_admin_number = mysqli_query($conn,"select * from `users` where `USER ID`='$user'");
                    if($fetch_num = mysqli_fetch_assoc($query_pick_admin_number)){
                        $number = $fetch_num['CONTACT'];
                        $email = $fetch_num['EMAIL'];
$message = 'Dear sir/Madam You have successfully reactivated your schools\' account, your session will expire on '.$expiry_date;
                                
@ include 'ZenophSMSGH/examples/non_personalised2.php';

 include 'mailing.php';
@ mail_admin($conn,$email,$message,'ACCOUNT REACTIVATED');
                    }
                    
                    $query = mysqli_query($conn,"select * from `account_renewals` where `ADMIN ID`='$user' and `SCHOOL`='$initials' order by `ID` desc");
                    if($fetch = mysqli_fetch_assoc($query)){
                        echo $id= $fetch['ID'];
                        $_SESSION['payment']='payment';
                    }
                }
            }else{
                    echo 'notfound';
            }
    }else{
        echo 'error';
    }


function receipt_number($year,$conn){



        $select_student_number = mysqli_query($conn,"select * from `account_renewals`");
        $number_rows = mysqli_num_rows($select_student_number);
        $number_rows ++;
        $number_rows = str_pad($number_rows,9,"0",STR_PAD_LEFT);

        $student_id = "ES-"."RT"."_".$year."".$number_rows."T";
        
        return $student_id;

    }
?>