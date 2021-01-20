<?php
        
    
    include 'school_ini_user_id.php';
    $off = '';
    $query_pick = mysqli_query($conn,"select * from school_details where  INITIALS = '$initials' and SMS=''");
    if(mysqli_num_rows($query_pick)!=null){
        $off = 'off';    
    }
    
    mysqli_query($conn,"update school_details set `SMS`='$off' where INITIALS = '$initials'");
?>