<?php
    session_start();
    include 'mysql_connect.php';
    
    $user='';
    $shool ='';
    //redirect user to registration stage if user is in registration stage
    if(isset($_SESSION['email']) && !empty($_SESSION['email'])){
        $user =$_SESSION['email'];
        $query = mysqli_query($conn,"select * from `main admins` where `ADMIN EMAIL`='$user'");
        if($fetch = mysqli_fetch_assoc($query)){
            $user = $fetch['ADMIN ID'];
        }
    }else if(isset($_SESSION['USER ID']) && !empty($_SESSION['USER ID'])){
        $user = $_SESSION['USER ID'];
    }

    //pick school details
    $str_pos = strpos($user,'-');
    $initials = substr($user,0,$str_pos);
    if(isset($_REQUEST['Class'])){
        $class = $_REQUEST['Class'];
        
        $query = mysqli_query($conn,"select * from `admitted_students` where `SCHOOL`='$initials' and `PRESENT CLASS`='$class'");
        while($fetch = mysqli_fetch_assoc($query)){
            mysqli_query($conn,"delete from `users` where `SCHOOL` = '$initials' and `USER ID`='".$fetch['ADMISSION NO / ID']."' or `SCHOOL`='$initials' and `USER ID`='".str_replace('-STD','-PT',$fetch['ADMISSION NO / ID'])."'");
        }
        if(mysqli_query($conn,"update `admitted_students` set `PRESENT CLASS`='' where `SCHOOL` = '$initials' and `PRESENT CLASS`='$class'")){
            
            echo 'success';
        }else{
            echo 'error';
        }
    }else{
        echo 'error';
    }
?>