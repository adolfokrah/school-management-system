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
                                       
  

    if(isset($_REQUEST['yr_id']) && isset($_REQUEST['status']) && isset($_REQUEST['academic_year']) && isset($_REQUEST['term_term'])){
        $id = $_REQUEST['yr_id'];
        $status = $_REQUEST['status'];
        $academic_year = $_REQUEST['academic_year'];
        $term_term = $_REQUEST['term_term'];
            
        $query = mysqli_query($conn,"update academic_years set `TERM`='$term_term', `ACADEMIC YEAR`='$academic_year' where `SCHOOL`='$initials' and `ID`='$id' ");
        echo 'success';
    }else{
        echo 'error';
    }
?>