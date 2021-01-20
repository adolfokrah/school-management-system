<?php 
    include 'mysql_connect.php';
    if(isset($_GET['initials'])){
        $initials = $_GET['initials']; 
        $query = mysqli_query($conn,"select * from  sms_credit where `SCHOOL`='$initials'");
        if($fetch = mysqli_fetch_assoc($query)){
            $sms_left = $fetch['SMS LEFT']-1;
            $sms_used = $fetch['SMS USED']+1;
            
            if($sms_left < 1){
                $sms_left = 0;
            }
            
            mysqli_query($conn,"update sms_credit set `SMS LEFT`='$sms_left',`SMS USED`='$sms_used' where `SCHOOL`='$initials'");
        }
    }
?>