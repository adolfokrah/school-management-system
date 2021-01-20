<?php



    //connect and select database
    include 'mysql_connect.php';
    include 'message_boxes.php';
    
    session_start();
    if(isset($_REQUEST['password']) && isset($_REQUEST['username']) && isset($_REQUEST['ip']) ){
        
        //check if fields are empty
        if(empty($_REQUEST['password']) || empty($_REQUEST['username'])){
            error_box('User name and password required.');
        }else{
            //declare variables
            $username = $_REQUEST['username'];
            $password = md5($_REQUEST['password']);
            $ipaddress = '';
            if($_REQUEST['ip']=='true'){
                $ipaddress =  $_SERVER['REMOTE_ADDR'];
            }
            
            
            //check if user exist
            $query=mysqli_query($conn,"select * from `main admins` where `ADMIN ID`='$username' and `ADMIN PASSWORD`='$password' or `ADMIN EMAIL`='$username' and `ADMIN PASSWORD`='$password'");
            if(mysqli_num_rows($query) == null){
               error_box('Sorry, Incorrect combination of user name and password.');
                
            }else{
               
                //select user registration stage
                $query_slelect_stage = mysqli_query($conn,"select * from `main admins` where `ADMIN ID`='$username' or `ADMIN EMAIL`='$username'");
                if($fetch_stage = mysqli_fetch_assoc($query_slelect_stage)){
                    $userid = $fetch_stage['ADMIN ID'];
                    $email = $fetch_stage['ADMIN EMAIL'];
                    $_SESSION['email'] = $email;
                    
                    
                    $stage=$fetch_stage['REGISTRATION STAGE'];
                    
                    //send user to school_details
                    
                    if($stage == 'school_details'){
                        $_SESSION['stage']='register2.php';
                        echo 'school';
                        
                    }else if($stage == 'verification'){
                        $_SESSION['stage']='verify_registration.php';
                        echo 'verification';
                        
                    }else{
                        //get system date and time
            $date = date('Y-m-d');
            $time = new datetime('now',new DateTimeZone('Europe/London'));
            $current_time = $time->format('h:i:s a');
                        mysqli_query($conn,"update users set `LOGIN DATE`='$date', `LOGIN TIME`='$current_time', `IP ADDRESS` ='$ipaddress' where `USER ID`='$userid'");
                         $ip = $_SERVER['REMOTE_ADDR'];
                        $date = date('Y-m-d');
                        mysqli_query($conn,"update visitors set `LOGIN IN`='YES' where `USER IP ADDRESS`='$ip' and `DATE`='$date'");
                        echo 'success'; 
                    }
                }
          
            }
        }
        
    }else{
        error_box('Sorry for interuption.  please try agian later.');
    }
?>