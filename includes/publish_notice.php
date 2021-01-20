<?php
    include 'school_ini_user_id.php';
    
  
    if(isset($_REQUEST['notice'])){ 
        $notice = $_REQUEST['notice'];
       $date = date('Y-m-d');
        $time = date('h:i A');
        //check if class already exist
        mysqli_query($conn,"INSERT INTO `noticeboard` (`ID`, `SCHOOL`, `POSTED BY`, `INFO`,`DATE PUBLISHED`,`TIME`) VALUES (NULL, '$initials', '$user', '".mysqli_real_escape_string($conn,$notice)."','$date','$time')");
        echo 'success';
    }else{
        echo 'error';
    }
?>