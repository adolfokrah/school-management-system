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
                                       
    $fields = array();

    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
        $query = mysqli_query($conn,"select * from academic_years where `SCHOOL`='$initials' and `ID`='$id'");
        
        if($fetch = mysqli_fetch_assoc($query)){
            $fields[0]=$fetch['SCHOOL'];
            $fields[1]=$fetch['ACADEMIC YEAR'];
            $fields[2]=$fetch['TERM'];
            $fields[3]=$fetch['STATUS'];
            $fields[4]=$fetch['ID'];
            
            
            echo $data = json_encode($fields);
        }
        
    }else{
        echo 'error';
    }
?>