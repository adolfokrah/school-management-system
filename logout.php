<?php
    include 'includes/mysql_connect.php';
    session_start();
    
    $user='';
    
    //redirect user to registration stage if user is in registration stage
    if(isset($_SESSION['email']) && !empty($_SESSION['email'])){
        $user =$_SESSION['email'];
    }else if(isset($_SESSION['USER ID']) && !empty($_SESSION['USER ID'])){
        $user = $_SESSION['USER ID'];
        mysqli_query($conn,"update users set `IP ADDRESS`='' where `USER ID`='$user'");
    }
    
    session_unset();
    session_destroy();
    
    echo "<script>window.open('login.php','_self');</script>";

?>