<?php
 
    include 'school_ini_user_id.php';
    if(isset($_REQUEST['id']) && isset($_REQUEST['show'])){
        $id = $_REQUEST['id'];
        $query = mysqli_query($conn,"select * from `users` where `NO`='$id' and `SCHOOL`='$initials'");
        $fields = array();
        if($fetch = mysqli_fetch_assoc($query)){    

            $fields[0]=$fetch['USER NAME'];
            $fields[1]=$fetch['GENDER'];
            $fields[2]=$fetch['CONTACT'];
            $fields[3]=$fetch['EMAIL'];
            $fields[4]=$fetch['ADDRESS'];
            $fields[5]=$fetch['POSITION'];
            $fields[6]=$fetch['NO'];
            
            if($fields[5]=="MAIN ADMIN"){
                echo 'no';
            }else{
                echo json_encode($fields);
            }
        }
        
    }else if(isset($_REQUEST['e_user_name']) && !empty($_REQUEST['e_user_name']) && isset($_REQUEST['e_gender']) && !empty($_REQUEST['e_gender']) && isset($_REQUEST['e_contact']) && !empty($_REQUEST['e_contact']) && isset($_REQUEST['e_email']) && !empty($_REQUEST['e_email']) && isset($_REQUEST['e_address']) && !empty($_REQUEST['e_address']) && isset($_REQUEST['edit_role']) && !empty($_REQUEST['edit_role']) && isset($_REQUEST['e_id']) && !empty($_REQUEST['e_id'])){
           
        $user_name = mysqli_real_escape_string($conn,$_REQUEST['e_user_name']);
        $gender = mysqli_real_escape_string($conn,$_REQUEST['e_gender']);
        $contact = mysqli_real_escape_string($conn,$_REQUEST['e_contact']);
        $email = mysqli_real_escape_string($conn,$_REQUEST['e_email']);
        $address = mysqli_real_escape_string($conn,$_REQUEST['e_address']);
        $roles = mysqli_real_escape_string($conn,$_REQUEST['edit_role']);;
        $id = mysqli_real_escape_string($conn,$_REQUEST['e_id']);
        $year = date('Y');
        
        //check if user already exist
        $query = mysqli_query($conn,"select * from `users` where `NO`!='$id' and `EMAIL`='".$email."' and `SCHOOL`='$initials'");
        if(mysqli_num_rows($query) < 1){
            
            switch($roles){
                case 'accountant':
                    
                     $user_id = generate_teacher_id($initials, $year, 'AC',$conn);
                    
                     if(mysqli_query($conn,"update `users` set `USER NAME`='".mysqli_real_escape_string($conn,$user_name)."', `USER ID`='".mysqli_real_escape_string($conn,$user_id)."',`POSITION`='".mysqli_real_escape_string($conn,$roles)."', `CONTACT`='".mysqli_real_escape_string($conn,$contact)."',`GENDER`='".mysqli_real_escape_string($conn,$gender)."', `EMAIL`='".mysqli_real_escape_string($conn,$email)."',`ADDRESS`='".mysqli_real_escape_string($conn,$address)."' where `NO`='$id' and `SCHOOL`= '$initials'")){
                                echo 'success';
                            }else{
                                echo 'error';
                            }                    
                    break;
                    
                case 'data entry':
                    
                     $user_id = generate_teacher_id($initials, $year, 'DE',$conn);
                    
                    if(mysqli_query($conn,"update `users` set `USER NAME`='".mysqli_real_escape_string($conn,$user_name)."', `USER ID`='".mysqli_real_escape_string($conn,$user_id)."',`POSITION`='".mysqli_real_escape_string($conn,$roles)."', `CONTACT`='".mysqli_real_escape_string($conn,$contact)."',`GENDER`='".mysqli_real_escape_string($conn,$gender)."', `EMAIL`='".mysqli_real_escape_string($conn,$email)."',`ADDRESS`='".mysqli_real_escape_string($conn,$address)."' where `NO`='$id' and `SCHOOL`='$initials'")){
                                echo 'success';
                            }else{
                                echo ' error';
                            } 
                    
                    break;
                    
                case 'librarian':
                    
                     $user_id = generate_teacher_id($initials, $year, 'LB',$conn);
                    
                    if(mysqli_query($conn,"update `users` set `USER NAME`='".mysqli_real_escape_string($conn,$user_name)."', `USER ID`='".mysqli_real_escape_string($conn,$user_id)."',`POSITION`='".mysqli_real_escape_string($conn,$roles)."', `CONTACT`='".mysqli_real_escape_string($conn,$contact)."',`GENDER`='".mysqli_real_escape_string($conn,$gender)."', `EMAIL`='".mysqli_real_escape_string($conn,$email)."',`ADDRESS`='".mysqli_real_escape_string($conn,$address)."' where `NO`='$id' and `school`='$initials'")){
                                echo 'success';
                            }else{
                                echo 'error';
                            } 
                    
                    break;
                    
                case 'headmaster/headmistress':
                    
                    $role_opt = role_select($roles,$gender);
                    
                     $user_id = generate_teacher_id($initials, $year, 'HD',$conn);
                    
                    if(mysqli_query($conn,"update `users` set `USER NAME`='".mysqli_real_escape_string($conn,$user_name)."', `USER ID`='".mysqli_real_escape_string($conn,$user_id)."',`POSITION`='".mysqli_real_escape_string($conn,$role_opt)."', `CONTACT`='".mysqli_real_escape_string($conn,$contact)."',`GENDER`='".mysqli_real_escape_string($conn,$gender)."', `EMAIL`='".mysqli_real_escape_string($conn,$email)."',`ADDRESS`='".mysqli_real_escape_string($conn,$address)."' where `NO`='$id' and `SCHOOL`='$initials'")){
                                echo 'success';
                            }else{
                                echo 'error';
                            } 
                    
                    break;
                    
                case 'administrator':
                    
                     $user_id = generate_teacher_id($initials, $year, 'AD',$conn);
                    
                     if(mysqli_query($conn,"update `users` set `USER NAME`='".mysqli_real_escape_string($conn,$user_name)."', `USER ID`='".mysqli_real_escape_string($conn,$user_id)."',``POSITION`='".mysqli_real_escape_string($conn,$roles)."', `CONTACT`='".mysqli_real_escape_string($conn,$contact)."',`GENDER`='".mysqli_real_escape_string($conn,$gender)."', `EMAIL`='".mysqli_real_escape_string($conn,$email)."',`ADDRESS`='".mysqli_real_escape_string($conn,$address)."' where `NO`='$id' and `SCHOOL`='$initials'")){
                                echo 'success';
                            }else{
                                echo 'error';
                            } 
                    break;
                    
                default:
                    echo 'role not found';
            }
            
        }else{
            echo 'found';
        }
    }else{
        echo 'error'.$id;
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
?>
