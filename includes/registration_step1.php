<?php
    //connect and select database
    include 'mysql_connect.php';
    include 'message_boxes.php';
    
    
    if(isset($_REQUEST['admin_name']) && isset($_REQUEST['admin_email']) && isset($_REQUEST['admin_password']) && isset($_REQUEST['admin_mobilenumber']) && isset($_REQUEST['admin_confirm_password'])){
        
        //check if fields are empty
        if(empty($_REQUEST['admin_name']) || empty($_REQUEST['admin_email']) || empty($_REQUEST['admin_password']) || empty($_REQUEST['admin_mobilenumber']) || empty($_REQUEST['admin_confirm_password'])){
            error_box('Please make sure you fill all fields correctly');
        }else{
             if (!filter_var($_REQUEST['admin_email'], FILTER_VALIDATE_EMAIL)) {
            error_box('Email is not valid.');
            }else{
                
            
            
            //declare variables
            $administrator_name = $_REQUEST['admin_name'];
            $administrator_email = $_REQUEST['admin_email'];
            $administrator_mobilenumber= $_REQUEST['admin_mobilenumber'];
            $administrator_password = $_REQUEST['admin_password'];
            $administrator_confirm_password = $_REQUEST['admin_confirm_password'];
            //get system date and time
            $date = date('Y-m-d');
            
            //get registration stage
            $registration_stage = 'school_details';

            //compare passwords
            if($administrator_password == $administrator_confirm_password){
                if(strlen($administrator_password) > 6){
                    //check if password contains these characters
                    if (preg_match("/^[a-zA-Z0-9]*$/", $administrator_password)){
                        //insert first registration step in database / registrater main administrator
                        $administrator_password = md5($administrator_password);
                        
                        //check if admin already exist
                        $query = mysqli_query($conn,"select * from `main admins` where `ADMIN EMAIL`='".mysqli_real_escape_string($conn,$administrator_email)."'");
                        if(mysqli_num_rows($query)==null){
                            mysqli_query($conn,"INSERT INTO `main admins` (`NO`, `ADMIN ID`, `ADMIN NAME`, `ADMIN EMAIL`, `ADMIN PASSWORD`, `REGISTRATION STAGE`, `ADMIN PHOTO`, `REGISTRATION DATE`,`ADMIN NUMBER`) VALUES (NULL, 'pending...', '".mysqli_real_escape_string($conn,$administrator_name)."', '".mysqli_real_escape_string($conn,$administrator_email)."', '".mysqli_real_escape_string($conn,$administrator_password)."', 'school_details', '', '$date','".mysqli_real_escape_string($conn,$administrator_mobilenumber)."')");
                            
                            mysqli_query($conn,"INSERT INTO `school_details` (`NO`, `ADMIN EMAIL`, `SCHOOL NAME`, `SCHOOL NUMBERS`, `SCHOOL ADDRESS`, `SCHOOL MOTO`, `COUNTRY`, `CITY/TOWN`, `CREST`) VALUES (NULL, '".mysqli_real_escape_string($conn,$administrator_email)."', '', '', '', '', '', '', 'default_crest.jpg')");
                            
                            session_start();
                            $_SESSION['email']= $administrator_email;
                            $_SESSION['stage']='register2.php';
                            echo 'success';
                        }else{
                            error_box('Sorry, Administrator Already Exist');
                        }
                        
                    }else{
                        //if not print error message
                        error_box('Your password is not strong enough, it must include both small and capital letters and numbers. Also avoid using spaces in passwords');
                    }
                }else{
                    error_box('Sorry password should be more than six characters');
                }
            }else{
                error_box('Sorry passwords do not match');
            }
        }
        }
    }else{
        error_box('Sorry for interuption. A problem occured whiles registring you. please try agian later');
    }
?>