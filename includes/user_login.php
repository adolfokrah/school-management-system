<?php
    include 'mysql_connect.php';
    
    if(isset($_REQUEST['username']) && isset($_REQUEST['password']) && isset($_REQUEST['ip']) ){
        
        $userid = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        $ipaddress = '';
        $num_rows = mysqli_num_rows(mysqli_query($conn,"select * from users where `USER ID`='$userid' and `PASSWORD`='".md5($password)."' and `POSITION` !=''"));
         if($_REQUEST['ip']=='true'){
                $ipaddress = $ipaddress = $_SERVER['REMOTE_ADDR'];
             
             
            }
        $date = date('Y-m-d');
             $time = new datetime('now',new DateTimeZone('Europe/London'));
            $current_time = $time->format('h:i:s a');
                mysqli_query($conn,"update users set `IP ADDRESS`='$ipaddress',`LOGIN TIME`='$current_time',`LOGIN DATE`='$date' where `USER ID`='$userid'");
                $ip = $_SERVER['REMOTE_ADDR'];
                $date = date('Y-m-d');
                mysqli_query($conn,"update visitors set `LOGIN IN`='YES' where `USER IP ADDRESS`='$ip' and `DATE`='$date'");
        if($num_rows > 0){
            session_start();
            $_SESSION['USER ID']=$userid;
            if(strpos($userid,'-AC')){
               echo 'accountant';
            }else if(strpos($userid,'-DE')){
               echo 'data_entry';
            }else if(strpos($userid,'-LB')){
                echo "libarian";
            }else if(strpos($userid,'-HD')){
                echo "school_head";
            }else if(strpos($userid,'-TCH')){
                echo "teacher";
            }else if(strpos($userid,'-STD')){
                //check if student has completed school
                $query = mysqli_query($conn,"select * from admitted_students where `ADMISSION NO / ID`='$userid' and `PRESENT CLASS` ='COMPLETED STUDENTS'");
                if(mysqli_num_rows($query) > 0){
                    echo 'Sorry Your session for using this system has ended';
                }else{
                    echo "student";
                }
            }else if(strpos($userid,'-PT')){
                //check if student has completed school
                $userid= str_replace('-PT','-STD',$userid);
                $query = mysqli_query($conn,"select * from admitted_students where `ADMISSION NO / ID`='$userid' and `PRESENT CLASS` ='COMPLETED STUDENTS'");
                if(mysqli_num_rows($query) > 0){
                    echo 'Sorry Your session for using this system has ended';
                }else{
                echo "parent";
                }
            }
        }else{
            echo 'Incorrect Combination of username and password';
        }
    }else{
        echo 'error';
    }
?>