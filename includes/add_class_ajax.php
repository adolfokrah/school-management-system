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

    if(isset($_REQUEST['classname'])){ 
        $classname = $_REQUEST['classname'];
        
        //check if class already exist
        $query = mysqli_query($conn,"select * from classes where `CLASS`='".mysqli_real_escape_string($conn,$classname)."' and `SCHOOL`='$initials'");
        if(mysqli_num_rows($query) < 1){
            if(mysqli_query($conn,"INSERT INTO `classes` (`ID`, `SCHOOL`, `CLASS`) VALUES (NULL, '$initials', '".mysqli_real_escape_string($conn,$classname)."')")){
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