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

    if(isset($_REQUEST['classname']) && isset($_REQUEST['subject']) && isset($_REQUEST['teacher'])){
        $classname = $_REQUEST['classname'];
        $subject = $_REQUEST['subject'];
        //check if subject already exist
        $query = mysqli_query($conn,"select * from subjects where `CLASS`='".mysqli_real_escape_string($conn,$classname)."' and `SCHOOL`='$initials' and `SUBJECT NAME`='$subject'");
        if(mysqli_num_rows($query) < 1){
            if(mysqli_query($conn,"INSERT INTO `subjects` (`ID`, `SCHOOL`,`SUBJECT NAME`,`TEACHER`,`CLASS`) VALUES (NULL, '$initials','".mysqli_real_escape_string($conn,$subject)."','".$_REQUEST['teacher']."','".mysqli_real_escape_string($conn,$classname)."')")){
                echo 'success';
            }else{
                echo 'error';
            }
        }else{
            echo 'found';
        }
        
    }else{
        echo 'error';
    }
?>