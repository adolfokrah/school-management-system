<?php
    include 'mysql_connect.php';
    $ip = $_SERVER['REMOTE_ADDR'];
$query = mysqli_query($conn,"select * from users where `IP ADDRESS` = '$ip'");
    if($fetch = mysqli_fetch_assoc($query)){
        $userid = $fetch['USER ID'];
        $date = date('Y-m-d');
        mysqli_query($conn,"update visitors set `LOGIN IN`='YES' where `USER IP ADDRESS`='$ip' and `DATE`='$date'");
        
        $_SESSION['USER ID'] = $userid;
        
        echo "<script>window.open('cms/admin_dashboard.php','_self')</script>";
    }

?>