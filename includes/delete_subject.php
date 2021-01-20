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
    
    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
        
           $query = mysqli_query($conn,"select * from `subjects` where `ID` = '$id'");
            if($fetch = mysqli_fetch_assoc($query)){
                $class = $fetch['CLASS'];
                $subject = $fetch['SUBJECT NAME'];
                mysqli_query($conn,"delete from subjects where `ID` = '$id'");
                mysqli_query($conn,"delete from marksheet where `SCHOOL` = '$initials' and `SUBJECT`='$subject' and `CLASS`='$class'");
            }
            echo 'success';
        
        
    }else if(isset($_REQUEST['all']) && isset($_REQUEST['class'])){
        $class = $_REQUEST['class'];
        if(mysqli_query($conn,"delete from subjects where `SCHOOL` = '$initials' and `CLASS`='$class'")){
            mysqli_query($conn,"delete from marksheet where `SCHOOL` = '$initials' and `CLASS`='$class'");
            echo 'success';
        }else{
            echo 'error';
        }
    }else{
        echo 'error';
    }
?>