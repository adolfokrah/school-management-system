<?php
    //connect and select database
    include 'mysql_connect.php';
    include 'message_boxes.php';
    include 'mailing.php';
    include 'sms.php';
    $email = '';
    session_start();
    if(isset($_SESSION['email']) && !empty($_SESSION['email'])){
        $email = $_SESSION['email'];
    }    
    if(isset($_REQUEST['school_name']) && isset($_REQUEST['numbers']) && isset($_REQUEST['address']) && isset($_REQUEST['moto']) && isset($_REQUEST['country']) && isset($_REQUEST['city'])&& isset($_REQUEST['sms_id'])){
        
        //check if fields are empty
        if(empty($_REQUEST['school_name']) || empty($_REQUEST['numbers']) || empty($_REQUEST['address']) || empty($_REQUEST['moto']) || empty($_REQUEST['country']) || empty($_REQUEST['city'])){
            error_box('Please make sure you fill all fields correctly');
        }else{
            
            
            //declare variables
            $school_name = $_REQUEST['school_name'];
            $numbers = $_REQUEST['numbers'];
            $address= $_REQUEST['address'];
            $moto = $_REQUEST['moto'];
            $country = $_REQUEST['country'];
            $city = $_REQUEST['city'];
            $sms_id = $_REQUEST['sms_id'];
            //get system date and time
            $year = date('Y');
            $initials = generate_school_id($school_name,$conn);
            $email;
            $number = 0;
            $number++;
            $number = str_pad($number,5,"0",STR_PAD_LEFT);
            $admin_id = $initials.'-'.'AD_'.$year.''.$number.'D';
            mysqli_query($conn,"update `main admins` set `ADMIN ID`='$admin_id',`REGISTRATION STAGE`='verification' where `ADMIN EMAIL`='$email'");
            
            mysqli_query($conn,"update `school_details` set `SCHOOL NAME`='".mysqli_real_escape_string($conn,$school_name)."',`SCHOOL NUMBERS`='".mysqli_real_escape_string($conn,$numbers)."',`SCHOOL ADDRESS`='".mysqli_real_escape_string($conn,$address)."',`SCHOOL MOTO`='".mysqli_real_escape_string($conn,$moto)."',`COUNTRY`='".mysqli_real_escape_string($conn,$country)."',`CITY/TOWN`='".mysqli_real_escape_string($conn,$city)."',`INITIALS`='".$initials."',`SCHOOL ID`='".$sms_id."' where `ADMIN EMAIL`='$email'");
            
            
            $pick_admin_password = mysqli_query($conn,"select * from `main admins` where `ADMIN EMAIL`='$email'");
            if($fetch = mysqli_fetch_assoc($pick_admin_password)){
                $password = $fetch['ADMIN PASSWORD'];
                
                
                mysqli_query($conn,"INSERT INTO `users` (`NO`, `USER ID`, `PASSWORD`, `USER IP`, `LOGIN DATE`, `LOGIN TIME`, `IP ADDRESS`,`SCHOOL`,`USER NAME`,`POSITION`,`CONTACT`) VALUES (NULL, '$admin_id', '$password', '', '', '', '','$initials','','MAIN ADMIN','');");
                
                mysqli_query($conn,"INSERT INTO `sms_credit` (`ID`, `SCHOOL`, `SMS LEFT`, `SMS USED`) VALUES (NULL, '$initials', '201', '0');");
                
            }
           
            //send admin credentials through email and sms
            $message = '<br/><br/> Your USER ID is <strong>'.$admin_id.'</strong>.<br/>Use this in combination with your password to access your admin page on the platform.';
            $subject = 'Message From EASYSKUL';
            //send email
           // mail_admin($conn,$email,$message,$subject);
                
            //send sms
            $message = ' Your USER ID is '.$admin_id.'. Use this in combination with your password to access your admin page on the platform.';
              send_admin_sms($message,$email,$conn);  
                
            
            $_SESSION['stage']='verify_registration.php';
            echo 'success';
        }
        
    }else{
        error_box('Sorry for interuption. A problem occured whiles registring you. please try agian later');
    }

    function generate_school_id($school_name,$conn){
        $school_name = strtoupper($school_name);
        $initials = "";
        $school_name .=" ";
        $find_length = strlen($school_name);
        $oschool_name = $school_name;
        for($i=0; $i<3; $i++){
            $string_position = strpos($school_name,' ');
            $name = substr($school_name,0,$string_position);
            $string_position = $string_position +1;
            $school_name = substr($school_name,$string_position);
            $initials .= substr($name,0,1);
            
        }
         $compare = mysqli_query($conn,"select * from school_details where `INITIALS`='$initials'");
         if(mysqli_num_rows($compare) < 1){
               
         }else{
                $compare2 = mysqli_query($conn,"select * from school_details where `INITIALS`='$initials'");
                $number_rows = mysqli_num_rows($compare2)+1;
               
             
               $initials = $initials.''. $number_rows;
               // $initials .= $number_rows;
               
         }
         return $initials;
    }
    
?>