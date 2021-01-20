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

    
    if(isset($_REQUEST['sch_id']) && isset($_REQUEST['school_name']) && isset($_REQUEST['school_number']) &&  isset($_REQUEST['sch_address']) && isset($_REQUEST['principal_name'])&& isset($_REQUEST['sms_id'])){
        
        $id = $_REQUEST['sch_id'];
        $sch_name = $_REQUEST['school_name'];
        $sch_numbers = $_REQUEST['school_number'];
        $sch_address = $_REQUEST['sch_address'];
        $sch_principal = $_REQUEST['principal_name'];
        $sms_id = $_REQUEST['sms_id'];
        
       
            if(mysqli_query($conn,"update `school_details` set `SCHOOL NAME`='".mysqli_real_escape_string($conn,$sch_name)."',`SCHOOL NUMBERS`='".mysqli_real_escape_string($conn,$sch_numbers)."', `SCHOOL ADDRESS`='".mysqli_real_escape_string($conn,$sch_address)."', `SCHOOL ID`='".mysqli_real_escape_string($conn,$sms_id)."' where `NO`='$id'")){
                
                mysqli_query($conn,"update `main admins` set `ADMIN NAME`='".mysqli_real_escape_string($conn,$sch_principal)."' where `ADMIN ID`='$user' ");
                
                echo 'success';
            }else{
                echo ' this error';
            }
      
    }else{
        echo 'error';
    }
?>