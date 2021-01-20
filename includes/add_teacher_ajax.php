<?php

include 'school_ini_user_id.php';
include 'sms.php';
    if(isset($_REQUEST['first_name']) && isset($_REQUEST['last_name']) && isset($_REQUEST['teacher_class']) && isset($_REQUEST['contact'])){
        
        $first_name = mysqli_real_escape_string($conn,$_REQUEST['first_name']);
        $last_name = mysqli_real_escape_string($conn,$_REQUEST['last_name']);
        $teacher_class = mysqli_real_escape_string($conn,$_REQUEST['teacher_class']);
//        $gender = mysqli_real_escape_string($conn,$_REQUEST['gender']);
//        $date_of_birth = mysqli_real_escape_string($conn,$_REQUEST['date_of_birth']);
//        $age = mysqli_real_escape_string($conn,$_REQUEST['age']);
        $contact = mysqli_real_escape_string($conn,$_REQUEST['contact']);
 //       $email = mysqli_real_escape_string($conn,$_REQUEST['email']);
//        $address = mysqli_real_escape_string($conn,$_REQUEST['address']);
//        $city = mysqli_real_escape_string($conn,$_REQUEST['city']);
//        $country = mysqli_real_escape_string($conn,$_REQUEST['country']);
//        $regDate = mysqli_real_escape_string($conn,$_REQUEST['regDate']);
//        $jobType = mysqli_real_escape_string($conn,$_REQUEST['jobType']);
        $year = date('Y');
        
    
        //check if tecaher already exist
        $sql = "SELECT * FROM `teachers` WHERE  `SCHOOL`='$initials' and `TEACHER CLASS`='$teacher_class' and `TEACHER CLASS` != 'NONE' ";
        $query = mysqli_query($conn,$sql);
        
        if(mysqli_num_rows($query) > 0){
            
            echo 'found';
        
        }else{
              $teacher_id = generate_teacher_id($initials, $year,$conn);
              $sql1 = "INSERT INTO `teachers` (`id`, `SCHOOL`,`TEACHER ID`,`FIRST NAME`, `LAST NAME`,`CONTACT`, `TEACHER CLASS`,`EMAIL`) VALUES (NULL, '$initials', '".$teacher_id."', '".mysqli_real_escape_string($conn,$first_name)."', '".mysqli_real_escape_string($conn,$last_name)."',  '".mysqli_real_escape_string($conn,$contact)."','".mysqli_real_escape_string($conn,$teacher_class)."','MAIL')";
            
            $query1 = mysqli_query($conn,$sql1);
            
            //insert teacher as user
            
            $teacher_name = $last_name.''.$first_name;
            
             //insert parent as user
                mysqli_query($conn,"INSERT INTO `users` (`NO`, `USER ID`, `PASSWORD`, `USER IP`, `LOGIN DATE`, `LOGIN TIME`, `IP ADDRESS`,`SCHOOL`,`USER NAME`,`POSITION`,`CONTACT`,`GENDER`,`EMAIL`) VALUES (NULL, '$teacher_id', '', '', '', '', '','$initials','$teacher_name','TEACHER','$contact','','MAIL')");
            
            if($query1){
                
               //pick school name
                $query_pick_school = mysqli_query($conn,"select * from school_details where `INITIALS`='$initials'");
                $school_name  = '';
                if($fetch_school_name = mysqli_fetch_assoc($query_pick_school)){
                    $school_name = $fetch_school_name['SCHOOL NAME'];
                }
                echo 'success';
$message = '
Dear '.$first_name.' '.$last_name.', your Teacher ID is '.$teacher_id.'. Use this to access your teacher portal on https://www.easyskul.com. Please visit our portal to add your account before you can login to our system.
';
                
if($contact !=''){
            if(str_replace(' ','',$contact)){
                if(strlen($contact) >= 10){
                    send_normal_sms($message,$contact,$initials,$conn);
                }

            }
        }

        }else{
            echo 'error';
        }

    }
        
    }else{
        echo 'error';
    }



 function generate_teacher_id($school_initials, $year,$conn){
        $select_teachers_number = mysqli_query($conn,"select * from `teachers` where `SCHOOL`='$school_initials'");
     $number_rows = mysqli_num_rows($select_teachers_number);
     $number_rows++;
     $number_rows = str_pad($number_rows, 5, "0", STR_PAD_LEFT);
     
     $teacher_id = $school_initials."-"."TCH"."_".$year."".$number_rows."D";
     
     
     return $teacher_id;
    }
    
?>