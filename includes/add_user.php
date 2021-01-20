<?php

include 'school_ini_user_id.php';
include 'sms.php';

    if(isset($_REQUEST['user_name']) && isset($_REQUEST['gender']) && isset($_REQUEST['contact']) && isset($_REQUEST['email']) && isset($_REQUEST['address']) && isset($_REQUEST['roles'])){
        
        $user_name = mysqli_real_escape_string($conn,$_REQUEST['user_name']);
        $gender = mysqli_real_escape_string($conn,$_REQUEST['gender']);
        $contact = mysqli_real_escape_string($conn,$_REQUEST['contact']);
        $email = mysqli_real_escape_string($conn,$_REQUEST['email']);
        $address = mysqli_real_escape_string($conn,$_REQUEST['address']);
        $roles = mysqli_real_escape_string($conn,$_REQUEST['roles']);
        $year = date('Y');

    
            
        $sql = "select * from `users` where `email`='$email'";
        $query = mysqli_query($conn,$sql);
        
        if(mysqli_num_rows($query) < 1){
            
            switch($roles){
                case 'accountant':
                    $user_id = generate_teacher_id($initials, $year, 'AC',$conn);
                    
                    $sql = "insert into `users`(`NO`, `USER ID`, `PASSWORD`, `SCHOOL`, `USER NAME`, `POSITION`, `CONTACT`, `GENDER`, `EMAIL`, `ADDRESS`, `USER IP`, `LOGIN DATE`, `LOGIN TIME`, `IP ADDRESS`) values (NULL, '".$user_id."', '', '".$initials."', '".mysqli_real_escape_string($conn,$user_name)."', '".mysqli_real_escape_string($conn,$roles)."', '".mysqli_real_escape_string($conn,$contact)."', '".mysqli_real_escape_string($conn,$gender)."', '".mysqli_real_escape_string($conn,$email)."', '".mysqli_real_escape_string($conn,$address)."', '', '', '', '')";
                    
                    $query = mysqli_query($conn,$sql);
                    message($user_id,$contact,$user_name,$initials,$conn);
                    echo 'success';
                    break;
                    
                case 'data entry':
                    $user_id = generate_teacher_id($initials, $year, 'DE',$conn);
                    
                     $sql = "insert into `users`(`NO`, `USER ID`, `PASSWORD`, `SCHOOL`, `USER NAME`, `POSITION`, `CONTACT`, `GENDER`, `EMAIL`, `ADDRESS`, `USER IP`, `LOGIN DATE`, `LOGIN TIME`, `IP ADDRESS`) values (NULL, '".$user_id."', '', '".$initials."', '".mysqli_real_escape_string($conn,$user_name)."', '".mysqli_real_escape_string($conn,$roles)."', '".mysqli_real_escape_string($conn,$contact)."', '".mysqli_real_escape_string($conn,$gender)."', '".mysqli_real_escape_string($conn,$email)."', '".mysqli_real_escape_string($conn,$address)."', '', '', '', '')";
                    
                    $query = mysqli_query($conn,$sql);
                    message($user_id,$contact,$user_name,$initials,$conn);
                    echo 'success';
                    
                    break;
                    
                case 'librarian':
                    $user_id = generate_teacher_id($initials, $year, 'LB',$conn);
                    
                    $sql = "insert into `users`(`NO`, `USER ID`, `PASSWORD`, `SCHOOL`, `USER NAME`, `POSITION`, `CONTACT`, `GENDER`, `EMAIL`, `ADDRESS`, `USER IP`, `LOGIN DATE`, `LOGIN TIME`, `IP ADDRESS`) values (NULL, '".$user_id."', '', '".$initials."', '".mysqli_real_escape_string($conn,$user_name)."', '".mysqli_real_escape_string($conn,$roles)."', '".mysqli_real_escape_string($conn,$contact)."', '".mysqli_real_escape_string($conn,$gender)."', '".mysqli_real_escape_string($conn,$email)."', '".mysqli_real_escape_string($conn,$address)."', '', '', '', '')";
                    
                    $query = mysqli_query($conn,$sql);
                    message($user_id,$contact,$user_name,$initials,$conn);
                    echo 'success';
                    
                    break;
                    
                case 'headmaster/headmistress':
                    $role_opt = role_select($roles,$gender);
                    
                    $user_id = generate_teacher_id($initials, $year, 'HD',$conn);
                    
                    $sql = "insert into `users`(`NO`, `USER ID`, `PASSWORD`, `SCHOOL`, `USER NAME`, `POSITION`, `CONTACT`, `GENDER`, `EMAIL`, `ADDRESS`, `USER IP`, `LOGIN DATE`, `LOGIN TIME`, `IP ADDRESS`) values (NULL, '".$user_id."', '', '".$initials."', '".mysqli_real_escape_string($conn,$user_name)."', '".$role_opt."', '".mysqli_real_escape_string($conn,$contact)."', '".mysqli_real_escape_string($conn,$gender)."', '".mysqli_real_escape_string($conn,$email)."', '".mysqli_real_escape_string($conn,$address)."', '', '', '', '')";
                    
                    $query = mysqli_query($conn,$sql);
                    message($user_id,$contact,$user_name,$initials,$conn);
                    echo 'success';
                    
                    break;
                    
                case 'administrator':
                    
                    $user_id = generate_teacher_id($initials, $year, 'AD',$conn);
                    
                    $sql = "insert into `users`(`NO`, `USER ID`, `PASSWORD`, `SCHOOL`, `USER NAME`, `POSITION`, `CONTACT`, `GENDER`, `EMAIL`, `ADDRESS`, `USER IP`, `LOGIN DATE`, `LOGIN TIME`, `IP ADDRESS`) values (NULL, '".$user_id."', '', '".$initials."', '".mysqli_real_escape_string($conn,$user_name)."', '".mysqli_real_escape_string($conn,$roles)."', '".mysqli_real_escape_string($conn,$contact)."', '".mysqli_real_escape_string($conn,$gender)."', '".mysqli_real_escape_string($conn,$email)."', '".mysqli_real_escape_string($conn,$address)."', '', '', '', '')";
                    
                    $query = mysqli_query($conn,$sql);
                    message($user_id,$contact,$user_name,$initials,$conn);
                    echo 'success';
                    
                    break;
                    
                default:
                    
                    echo 'role not found';
                    
            }
            
            $operation = 'New user registered in the system, User name '.$user_name.' POSITION '.$roles;
            $date = date('Y-m-d');
            $time = new datetime('now',new DateTimeZone('Europe/London'));
            $current_time = $time->format('h:i:s a');

            mysqli_query($conn,"INSERT INTO `histories` (`ID`, `SCHOOL`, `USER ID`, `OPERATION`, `DATE`, `TIME`, `ACTION`) VALUES (NULL, '$initials', '$user', '".mysqli_real_escape_string($conn,$operation)."', '$date', '$current_time', '');");
            echo mysqli_connect_error();
            
        }else{
            echo 'found';
        }
    }
    
        
    
function role_select($value,$option){
    $value_length = strlen($value);
    if($option == 'male'){
        $new_value = substr($value, 0,($value_length/2)-1);
            }else if($option == 'female'){
            $new_value = substr($value, $value_length/2,($value_length/2)+1);
        }
    return $new_value;

}

 function generate_teacher_id($school_initials, $year, $init,$conn){
        $select_teachers_number = mysqli_query($conn,"select * from `users` where `SCHOOL`='$school_initials'");
     $number_rows = mysqli_num_rows($select_teachers_number);
     $number_rows++;
     $number_rows = str_pad($number_rows, 5, "0", STR_PAD_LEFT);
     
     $teacher_id = $school_initials."-".$init."_".$year."".$number_rows."D";
     return $teacher_id;
    }
    

function message($user_id,$contact,$user_name,$school_name,$conn){
$initials = $school_name;
//pick school name
$query_pick_school = mysqli_query($conn,"select * from school_details where `INITIALS`='$school_name'");
$school_name  = '';
if($fetch_school_name = mysqli_fetch_assoc($query_pick_school)){
    $school_name = $fetch_school_name['SCHOOL NAME'];
}
$message = '
Dear '.$user_name.', your USER ID is '.$user_id.'. Use this to access your portal on https://www.easyskul.com.Please visit our portal to add your account before you can login to our system.
';
                
if($contact !=''){
    if(str_replace(' ','',$contact)){
        if(strlen($contact) == 10){
            send_normal_sms($message,$contact,$initials,$conn);
        }

    }
}
}
?>
