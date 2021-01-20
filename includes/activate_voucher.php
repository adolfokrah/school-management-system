<?php
    include 'mysql_connect.php';
    include 'school_ini_user_id.php';

    if(isset($_REQUEST['id']) && isset($_REQUEST['accept'])){
        $id = $_REQUEST['id'];
        $accept = $_REQUEST['accept'];
        $d=strtotime("+4 Months");
	    $expiry_date = date("Y-m-d", $d);
        $user ='';
         $number = '';
        $sql = "select * from `payment_invoices` where `ID`='$id'";
        $query = mysqli_query($conn,$sql);
        
        if(mysqli_num_rows($query) < 1){
            echo 'not found';
        }else{
            $sql = mysqli_query($conn,"select * from `payment_invoices` where `ID`='$id'");
            if($fetch = mysqli_fetch_assoc($sql)){
                $number = $fetch['MOBILE MONEY NUMBER'];
                $user = $fetch['USER ID'];
            } 
            
            mysqli_query($conn,"update `payment_invoices` set `STATUS`='".mysqli_real_escape_string($conn,$accept)."' where `ID`='$id'");
            mysqli_query($conn,"delete from `renewal_vouchers` where `USED`='' and `USER`='$user'");
            $new_voucher_code = (generate_voucher_new('ES',$conn));
            
            $query = mysqli_query($conn,"insert into `renewal_vouchers`(`NO`, `VOUCHER CODE`, `EXPIRY DATE`, `USED`,`USER`) values('', '".mysqli_real_escape_string($conn,md5($new_voucher_code))."', '".$expiry_date."', '','$user')");
            
            
            $message = 'Dear sir/Madam, your voucher code is '.$new_voucher_code.' use this to activate or reactivate your account';
            include 'ZenophSMSGH/examples/non_personalised2.php';
            
            $email = '';
            $subject = '';
            $query_pick_mail  = mysqli_query($conn,"select * from users where `USER ID`='$user'");
            if($fetch=mysqli_fetch_assoc($query_pick_mail)){
                $email = $fetch['EMAIL'];
                $subject = "VOUCHER CODE";
                 
                
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
        
    

function generate_voucher($init){
   	$number_rows = rand(0, 99999);
     	$number_rows = str_pad($number_rows, 5, rand(0,99999), STR_PAD_LEFT);
    	
    	$voucher_rand = $init.$number_rows;
    
     return $voucher_rand;
}

function generate_voucher_new($init,$conn){
   	$number_rows = rand(0, 999999);
     	$number_rows = str_pad($number_rows, 5, rand(0,999999), STR_PAD_LEFT);
    	
    	$voucher_rand = $init.$number_rows;
    
    
          $query = mysqli_query($conn,"select * from `renewal_vouchers` where `VOUCHER CODE`='".md5($voucher_rand)."' and `USED`='true'");
            
          if(mysqli_num_rows($query) > 0){

              generate_voucher_new($init,$conn);
          }else{
              
              
              $voucher_code = md5(generate_voucher('ES'));
             
          }
    
     return $voucher_rand;
}

?>
