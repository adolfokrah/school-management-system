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

    if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
        $year_id = $_REQUEST['id'];
        
        $sql ="update academic_years set `STATUS`='' where `SCHOOL`='$initials'";
        $query = mysqli_query($conn,$sql);
        
        $sql = "update academic_years set `STATUS`='ACTIVE' where `SCHOOL`='$initials' and `ID`='$year_id'";
        $query = mysqli_query($conn,$sql);
        
        echo 'success';
    }else{
        echo 'error';
    }

?>