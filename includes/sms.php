<?php 
    
    function send_admin_sms($message,$email,$conn){
        
        $pick_username = mysqli_query($conn,"select * from `main admins` where `ADMIN EMAIL`='$email'");
        if($fetch = mysqli_fetch_assoc($pick_username)){
            $username = $fetch['ADMIN NAME'];
            $number = $fetch['ADMIN NUMBER'];
            
            $message = "Hi ".$username.",".$message;

            include 'ZenophSMSGH/examples/non_personalised2.php';
        }
    }
    
    function send_normal_sms($message,$number,$initials,$conn){
         
         $query = mysqli_query($conn,"select * from  sms_credit where `SCHOOL`='$initials' and `SMS LEFT`>0");
        if(mysqli_num_rows($query)!=null){
            //$number = str_replace(' ','',$_REQUEST['guardiantel']);
            $query_pick = mysqli_query($conn,"select * from school_details where  INITIALS = '$initials' and SMS!=''");
            if($fetch = mysqli_fetch_assoc($query_pick)){
                $school_id = $fetch['SCHOOL ID'];
                include 'ZenophSMSGH/examples/non_personalised.php';    
            }
            

        }
        
    }
?>