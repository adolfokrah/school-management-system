<?php
    include 'school_ini_user_id.php';
    include 'get_currencies.php';
    include 'sms.php';

    //redirect user to registration stage if user is in registration stage
    if(isset($_REQUEST['number']) && isset($_REQUEST['operation'])&& isset($_REQUEST['invoice_number'])){
         $number = mysqli_real_escape_string($conn,$_REQUEST['number']);
        $opertion  = $_REQUEST['operation'];
        $in_number = $_REQUEST['invoice_number'];
        //CHECK IF BILL if bill already exist if yes then update else insert
        if(mysqli_query($conn,"update `payment_invoices` set `MOBILE MONEY NUMBER`='$number',`STATUS`='SUBMITTED'  where `INVOICE NUMBER`='$in_number'")){
          
            $message = '';
            
            if($opertion == "SMS CREDIT"){
$message = 'Dear sir/Madam, we have receive your invoice, you account will be topup as soon as payment is confirm. You will receive a confirmation sms.';
            }else{
$message = 'Dear sir/Madam, we have receive your invoice, voucher code will be sent to you via sms and email as soon as payment is confirm';
            }
         include 'ZenophSMSGH/examples/non_personalised2.php';
            echo 'success';
        }else{
            echo 'error';
        }
        }else{
        echo 'no';
    } 
?>