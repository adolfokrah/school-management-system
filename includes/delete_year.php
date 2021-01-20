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
    
    if(isset($_REQUEST['id']) && isset($_REQUEST['sch'])){
        $id = $_REQUEST['id'];
        $sch = $_REQUEST['sch'];
        $academic_year = '';
        $query = mysqli_query($conn,"select * from academic_years where `ID` = '$id' and `SCHOOL`='$sch'");
        if($fetch = mysqli_fetch_assoc($query)){
            $academic_year = $fetch['ACADEMIC YEAR'];
        }
        
        if(mysqli_query($conn,"delete from academic_years where `ID` = '$id' and `SCHOOL`='$sch'")){
            mysqli_query($conn,"delete from `attendance` where `SCHOOL`='$initials' and `ACADEMIC YEAR`='$academic_year'");
            mysqli_query($conn,"delete from `daily_feeding_fee` where `SCHOOL`='$initials' and `ACADEMIC YEAR`='$academic_year'");
            mysqli_query($conn,"delete from `daily_fees_payments` where `SCHOOL`='$initials' and `ACADEMIC YEAR`='$academic_year'");
            mysqli_query($conn,"delete from `expenses` where `SCHOOL`='$initials' and `ACADEMIC YEAR`='$academic_year'");
            mysqli_query($conn,"delete from `feeding_fee` where `SCHOOL`='$initials' and `ACADEMIC YEAR`='$academic_year'");
            mysqli_query($conn,"delete from `marksheet` where `SCHOOL`='$initials' and `ACADEMIC YEAR`='$academic_year'");
            mysqli_query($conn,"delete from `school_fees` where `SCHOOL`='$initials' and `ACADEMIC YEAR`='$academic_year'");
            mysqli_query($conn,"delete from `terminal_reports` where `SCHOOL`='$initials' and `ACADEMIC YEAR`='$academic_year'");
            mysqli_query($conn,"delete from `terminal_reports_av` where `SCHOOL`='$initials' and `ACADEMIC YEAR`='$academic_year'");
            
            //pick time_table
            $query_pick = mysqli_query($conn,"select * from `time_table` where `SCHOOL`='$initials' and `ACADEMIC YEAR`='$academic_year'");
            if($fetch_table  = mysqli_fetch_assoc($query_pick)){
                $file = $fetch_table['FILE'];
                if(file_exists('../cms/time_tables/'.$file)){
                    unlink('../cms/time_tables/'.$fetch_table['FILE']);
                }
                mysqli_query($conn,"delete from `time_tables` where `SCHOOL`='$initials' and `ACADEMIC YEAR`='$academic_year'");
            }
            echo 'success';
        }else{
            echo 'error';
        }
        
    }else if(isset($_REQUEST['all'])){
        
        if(mysqli_query($conn,"delete from admitted_students where `SCHOOL` = '$initials'")){
            echo 'success';
        }else{
            echo 'error';
        }
    }else{
        echo 'error';
    }
?>