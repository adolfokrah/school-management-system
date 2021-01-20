<?php
 
    include 'school_ini_user_id.php';
    include 'sms.php';
    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
        $value = '';
        $query = mysqli_query($conn,"update `users` set `PASSWORD RECOVERY`='$value' where `NO`='$id' and `SCHOOL`='$initials'");
        
        $pick_admin = mysqli_query($conn,"select * from users where `NO`='$id'");
                            
        if($fetch = mysqli_fetch_assoc($pick_admin)){
            
            
            //pick school name
            $query_pick_school = mysqli_query($conn,"select * from school_details where `INITIALS`='$initials'");
            $school_name  = '';
            if($fetch_school_name = mysqli_fetch_assoc($query_pick_school)){
                $school_name = $fetch_school_name['SCHOOL NAME'];
            }
            
$message = '
Your forgotten password is cleared Please visit https://www.easyskul.com/add_account.php to add new password to your account.';
            
            $number = $fetch['CONTACT'];
            $position = $fetch['POSITION'];
            $userid = $fetch['USER ID'];
            if($position =="STUDENT"|| $position == "GUARDIAN"){
                $userid = str_replace('-PT','-STD',$userid);
                $query_pick = mysqli_query($conn,"select * from admitted_students where `ADMISSION NO / ID`='$userid'");
                if($fetch_user = mysqli_fetch_assoc($query_pick)){
                    $number = $fetch_user['GUARDIAN TEL'];
                    if($position == "STUDENT"){
$message = 'Message From '.$school_name.'
Your ward with student ID: '.$userid.' forgotten password is cleared Please visit https://www.easyskul.com/add_account.php to add new password to his/her account.';                        
                    }
                }
                
            }
            
            send_normal_sms($message,$number,$initials,$conn);
            
        }
        echo 'success';
   
    }
?>
