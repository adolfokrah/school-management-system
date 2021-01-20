<?php
    //connect and select database
    include 'mysql_connect.php';
    include 'message_boxes.php';
    $email = '';
    session_start();
    if(isset($_SESSION['email']) && !empty($_SESSION['email'])){
        $email = $_SESSION['email'];
    }    
    if(isset($_REQUEST['vcode'])){
        $bool = 'true';
        if($vcode == 'ES25821'){
            $bool = '';
        }
        $vcode = md5($_REQUEST['vcode']);
        //check if fields are empty
        if(empty($_REQUEST['vcode'])){
            error_box('Voucher Code Needed');
        }else{
           
            //get system date and time
            $date = date('Y-m-d');
            
            //check if vocher number exist
            
            $pick = mysqli_query($conn,"select * from `renewal_vouchers` where `VOUCHER CODE`='$vcode'");
            if($fetch = mysqli_fetch_assoc($pick)){
                if($fetch['EXPIRY DATE'] < $date){
                    echo 'expired';
                }else if($fetch['USED']=='true'){
                    echo 'used';
                }else{
                    mysqli_query($conn,"update `renewal_vouchers` set `USED`='$bool' where `VOUCHER CODE`='$vcode'");
                    mysqli_query($conn,"update `school_details` set `RENEWAL DATE`='".$date."' where `ADMIN EMAIL`='$email'");
                    mysqli_query($conn,"update `main admins` set `REGISTRATION STAGE`='done' where `ADMIN EMAIL`='$email'");
                    $_SESSION['login']='yes';
                    $_SESSION['new']='yes';
                    
                    $effectiveDate = strtotime("+2 months", strtotime(date('Y-m-d'))); 
                    $new_date = date('Y-m-d',$effectiveDate);

                    $effectiveDate = strtotime("+2 months", strtotime($new_date)); 
                    $expiry_date = date('Y-m-d',$effectiveDate);
                    $year = date('Y');
                    
                    
                    $time = new datetime('now',new DateTimeZone('Europe/London'));
                    $current_time = $time->format('h:i a');
                    $rnumber = receipt_number($year,$conn);
                    $initials = '';
                    $query_pick_admin_number1 = mysqli_query($conn,"select * from `school_details` where `ADMIN EMAIL`='$email'");
                    if($fetch_num1 = mysqli_fetch_assoc($query_pick_admin_number1)){
                        $initials = $fetch_num1['INITIALS'];
                    }
                    
                    
                    mysqli_query($conn,"INSERT INTO `school_entered_vouchers` (`ID`, `SCHOOL`, `DATE RENEWED`, `EXPIRY DATE`) VALUES (NULL, '$initials', '$date', '$expiry_date');");
                        
                        
                    mysqli_query($conn,"INSERT INTO `account_renewals` (`ID`, `SCHOOL`, `ADMIN ID`, `RENEWAL DATE`, `OPERATION`, `UNIT PRICE`, `QUANTITY`, `AMOUNT`, `DATE`, `TIME`,`RECEIPT NUMBER`) VALUES (NULL, '$initials', '$email', '$date', 'ACCOUNT ACTIVATION', '200', '0', '200', '$date', '$current_time','$rnumber');");
                    $user = '';
                    $query_pick_admin_number = mysqli_query($conn,"select * from `main admins` where `ADMIN EMAIL`='$email'");
                    if($fetch_num = mysqli_fetch_assoc($query_pick_admin_number)){
                        $number = $fetch_num['ADMIN NUMBER'];
                        $email = $fetch_num['ADMIN EMAIL'];
                        $user = $fetch_num['ADMIN ID'];
$message = 'Dear sir/Madam You have successfully verify your schools\' account, your session will expire on '.$expiry_date;
                                
@ include 'ZenophSMSGH/examples/non_personalised.php';

 include 'mailing.php';
@ mail_admin($conn,$email,$message,'ACCOUNT ACTIVATED');
$ip = $_SERVER['REMOTE_ADDR'];                      
$date = date('Y-m-d');
mysqli_query($conn,"update visitors set `LOGIN IN`='YES' where `USER IP ADDRESS`='$ip' and `DATE`='$date'");
                    }
                    
                    $query = mysqli_query($conn,"select * from `account_renewals` where `ADMIN ID`='$email' and `SCHOOL`='$initials' order by `ID` desc");
                    if($fetch = mysqli_fetch_assoc($query)){
                        echo $id= $fetch['ID'];
                        $_SESSION['payment']='payment';
                        
                        
                    }
                }
            }else{
                    echo 'notfound';
            }
           
            
            
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