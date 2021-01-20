<?php
    include 'school_ini_user_id.php';
    include 'get_currencies.php';
    include 'sms.php';

    if(isset($_REQUEST['firstname']) && isset($_REQUEST['lastname']) && isset($_REQUEST['date_of_birth']) && isset($_REQUEST['hometown']) && isset($_REQUEST['nationality']) && isset($_REQUEST['rgd']) && isset($_REQUEST['guardianname']) && isset($_REQUEST['guardianaddress']) && isset($_REQUEST['guardianoccupation']) && isset($_REQUEST['guardianrgd']) && isset($_REQUEST['relationship_to_std']) && isset($_REQUEST['disability']) && isset($_REQUEST['paid_date']) && isset($_REQUEST['admission_date']) && isset($_REQUEST['former_school']) && isset($_REQUEST['former_school']) && isset($_REQUEST['fee']) && isset($_REQUEST['guardiantel']) &&  isset($_REQUEST['class']) && isset($_REQUEST['gender'])){
        
        
        //check if student already exist
        $query = mysqli_query($conn,"select * from `admitted_students` where `SCHOOL`='$initials' and `ENTRY BY`='$user' and `NEW`!=''");
        if($fetch = mysqli_fetch_assoc($query)){
            $id = $fetch['NO'];
            $date = date('Y-m-d');
            $student_id = $fetch['ADMISSION NO / ID'];
            $year = date('Y');
            //PICK  ACTIVE ACADEMIC YEAR
            $academic_year = '';
            $term = '';
            $query_pick = mysqli_query($conn,"select * from academic_years where `SCHOOL`='$initials' and `STATUS`='ACTIVE'");
            if($fetch_row = mysqli_fetch_assoc($query_pick)){
                $academic_year = $fetch_row['ACADEMIC YEAR'];
                $term= $fetch_row['TERM'];
            }else{
                echo 'year';
                die();
            }
            
            
            //UPDATE THE ROW
            if(mysqli_query($conn,"update `admitted_students` set `STUDENT LAST NAME`='".mysqli_real_escape_string($conn,$_REQUEST['lastname'])."', `STUDENT  FIRST NAME`='".mysqli_real_escape_string($conn,$_REQUEST['firstname'])."',`STD DATE OF BIRTH`='".$_REQUEST['date_of_birth']."',`HOME TOWN`='".mysqli_real_escape_string($conn,$_REQUEST['hometown'])."',`NATIONALITY`='".mysqli_real_escape_string($conn,$_REQUEST['nationality'])."',`STD RELIGIOUS DENOMINATION`='".mysqli_real_escape_string($conn,$_REQUEST['rgd'])."',`FORMER SCHOOL`='".mysqli_real_escape_string($conn,$_REQUEST['former_school'])."',`PRESENT CLASS`='".mysqli_real_escape_string($conn,$_REQUEST['class'])."',`GENDER`='".mysqli_real_escape_string($conn,$_REQUEST['gender'])."',`GUARDIAN NAME`='".mysqli_real_escape_string($conn,$_REQUEST['guardianname'])."',`GUARDIAN ADDRESS`='".mysqli_real_escape_string($conn,$_REQUEST['guardianaddress'])."', `GUARDIAN TEL`='".mysqli_real_escape_string($conn,$_REQUEST['guardiantel'])."',`GUARDIAN RD`='".mysqli_real_escape_string($conn,$_REQUEST['guardianrgd'])."',`GUARDIAN RELATIONSHIP STATUS`='".mysqli_real_escape_string($conn,$_REQUEST['relationship_to_std'])."',`STUDENT DISABILITIES`='".mysqli_real_escape_string($conn,$_REQUEST['disability'])."',`DATE OF ADMISSION`='".$date."',`ADMISSION FEE`='".$_REQUEST['fee']."',`ACADEMIC YEAR`='$academic_year',`GUARDIAN OCCUPATION`='".mysqli_real_escape_string($conn,$_REQUEST['guardianoccupation'])."',`PAIDDATE`='".date('Y-m-d')."',`CLASS ADMITTED`='".$_REQUEST['class']."',`SMS`='SENT',`NEW`='' where `NO`='$id'")){
                
                
                
                
                $parent_id = str_replace('STD','PT',$student_id);
                $school_name = '';
                //pick school name
                $query_select = mysqli_query($conn,"select * from school_details where `INITIALS`='$initials'");
                if($fetch_school = mysqli_fetch_assoc($query_select)){
                    $school_name = $fetch_school['SCHOOL NAME'];
                }
                $student_name = mysqli_real_escape_string($conn,$_REQUEST['lastname']).'  '.mysqli_real_escape_string($conn,$_REQUEST['firstname']);
                //insert student as user
                mysqli_query($conn,"INSERT INTO `users` (`NO`, `USER ID`, `PASSWORD`, `USER IP`, `LOGIN DATE`, `LOGIN TIME`, `IP ADDRESS`,`SCHOOL`,`USER NAME`,`POSITION`) VALUES (NULL, '$student_id', '', '', '', '', '','$initials','$student_name','STUDENT');");
                //insert parent as user
                mysqli_query($conn,"INSERT INTO `users` (`NO`, `USER ID`, `PASSWORD`, `USER IP`, `LOGIN DATE`, `LOGIN TIME`, `IP ADDRESS`,`SCHOOL`,`USER NAME`,`POSITION`,`CONTACT`) VALUES (NULL, '$parent_id', '', '', '', '', '','$initials','".mysqli_real_escape_string($conn,$_REQUEST['guardianname'])."','GUARDIAN','".$_REQUEST['guardiantel']."');");
                
                $message = '
Dear '.$_REQUEST['guardianname'].', your ward, '.$_REQUEST['firstname'].' '.$_REQUEST['lastname'].'\'s student ID is: '. $student_id.' and your parent ID is: '.$parent_id.'. Use your parent ID to check on your ward\'s academic performance in the school and other relevant information through https://easyskul.com.
                ';
                $number = str_replace(' ','',$_REQUEST['guardiantel']);
                send_normal_sms($message,$number,$initials,$conn);
               
                
                $time = new datetime('now',new DateTimeZone('Europe/London'));
                $current_time = $time->format('h:i:s a');
                
                if($_REQUEST['fee'] >0){
                    
                
               $receipt_number = receipt_number($initials,$year,$conn);
               mysqli_query($conn,"INSERT INTO `daily_fees_payments` (`ID`, `SCHOOL`, `ACADEMIC YEAR`, `TERM`, `STUDENT ID`, `STUDENT NAME`,`CLASS`, `DATE`, `TIME`, `AMOUNT PAID`, `CREDIT`, `DEBIT`, `PAID BY`, `RECEIVED BY`, `RECEIPT NUMBER`, `GENERATED`,`BEIGN`) VALUES (NULL, '$initials', '$academic_year', '$term', '$student_id','".mysqli_real_escape_string($conn,$_REQUEST['lastname'])."'         '".mysqli_real_escape_string($conn,$_REQUEST['firstname'])."', '".mysqli_real_escape_string($conn,$_REQUEST['class'])."','$date', '$current_time', '".mysqli_real_escape_string($conn,$_REQUEST['fee'])."', '0', '0', '".mysqli_real_escape_string($conn,$_REQUEST['guardianname'])."', '$user', '$receipt_number', 'NO','ADMISSION')");
                
               $get_receipt = mysqli_query($conn,"select * from `daily_fees_payments` where `SCHOOL`='$initials' and `RECEIVED BY`='$user' and `GENERATED`='NO' order by `ID` desc");
                
                //insert history
                    $operation = 'Admisson fee payment of amount  '.$currency.' '.$_REQUEST['fee'].' made for '.$student_id.'('.$_REQUEST['firstname'].' '.$_REQUEST['lastname'].') paid by '.$_REQUEST['guardianname'];
                    $date = date('Y-m-d');
                    $time = new datetime('now',new DateTimeZone('Europe/London'));
                    $current_time = $time->format('h:i:s a');

                    mysqli_query($conn,"INSERT INTO `histories` (`ID`, `SCHOOL`, `USER ID`, `OPERATION`, `DATE`, `TIME`, `ACTION`) VALUES (NULL, '$initials', '$user', '".mysqli_real_escape_string($conn,$operation)."', '$date', '$current_time', '');");
                    echo mysqli_connect_error();
}
                if($fetch_get_row = mysqli_fetch_assoc($get_receipt)){
                    echo $fetch_get_row['ID'];
                }
            }else{
                echo mysqli_connect_error();
                
            }
        }else{
            //insert new student
            $academic_year = '';
            $term = '';
            $query_pick = mysqli_query($conn,"select * from academic_years where `SCHOOL`='$initials' and `STATUS`='ACTIVE'");
            if($fetch_row = mysqli_fetch_assoc($query_pick)){
                $academic_year = $fetch_row['ACADEMIC YEAR'];
                $term = $fetch_row['TERM'];
            }else{
                    echo 'year';
                    die();
                }
            
            $date = date('Y-m-d');
            $year = date('Y');
            $student_id = generate_student_id($initials,$year,$conn);
            $filename = 'avatar3.jpg';
            if(mysqli_query($conn,"INSERT INTO `admitted_students` (`NO`, `SCHOOL`, `ENTRY BY`, `ADMISSION NO / ID`, `STUDENT LAST NAME`, `STUDENT  FIRST NAME`, `STD DATE OF BIRTH`,  `HOME TOWN`, `NATIONALITY`, `STD RELIGIOUS DENOMINATION`, `FORMER SCHOOL`, `DATE OF ADMISSION`, `PRESENT CLASS`, `PHOTO`, `GENDER`, `GUARDIAN NAME`, `GUARDIAN ADDRESS`, `GUARDIAN OCCUPATION`, `GUARDIAN TEL`, `GUARDIAN RD`, `GUARDIAN RELATIONSHIP STATUS`, `STUDENT DISABILITIES`, `ADMISSION FEE`, `PAIDDATE`, `ACADEMIC YEAR`, `YEAR OF ADMISSION`,`CLASS ADMITTED`,`SMS`) VALUES (NULL, '$initials', '$user', '$student_id', '".mysqli_real_escape_string($conn,$_REQUEST['lastname'])."', '".mysqli_real_escape_string($conn,$_REQUEST['firstname'])."', '".$_REQUEST['date_of_birth']."',  '".mysqli_real_escape_string($conn,$_REQUEST['hometown'])."', '".mysqli_real_escape_string($conn,$_REQUEST['nationality'])."', '".mysqli_real_escape_string($conn,$_REQUEST['rgd'])."', '".mysqli_real_escape_string($conn,$_REQUEST['former_school'])."', '".$date."', '".mysqli_real_escape_string($conn,$_REQUEST['class'])."', '$filename', '".mysqli_real_escape_string($conn,$_REQUEST['gender'])."', '".mysqli_real_escape_string($conn,$_REQUEST['guardianname'])."', '".mysqli_real_escape_string($conn,$_REQUEST['guardianaddress'])."', '".mysqli_real_escape_string($conn,$_REQUEST['guardianoccupation'])."', '".mysqli_real_escape_string($conn,$_REQUEST['guardiantel'])."', '".mysqli_real_escape_string($conn,$_REQUEST['guardianrgd'])."', '".mysqli_real_escape_string($conn,$_REQUEST['relationship_to_std'])."', '".mysqli_real_escape_string($conn,$_REQUEST['disability'])."', '".$_REQUEST['fee']."', '$date', '$academic_year',  '$year','".$_REQUEST['class']."','SENT');")){
                
                $parent_id = str_replace('STD','PT',$student_id);
                $school_name = '';
                //pick school name
                $query_select = mysqli_query($conn,"select * from school_details where `INITIALS`='$initials'");
                if($fetch_school = mysqli_fetch_assoc($query_select)){
                    $school_name = $fetch_school['SCHOOL NAME'];
                }
                
                //insert student as user
                mysqli_query($conn,"INSERT INTO `users` (`NO`, `USER ID`, `PASSWORD`, `USER IP`, `LOGIN DATE`, `LOGIN TIME`, `IP ADDRESS`,`SCHOOL`,`USER NAME`,`POSITION`) VALUES (NULL, '$student_id', '', '', '', '', '','$initials','".mysqli_real_escape_string($conn,$_REQUEST['lastname']).' '.mysqli_real_escape_string($conn,$_REQUEST['firstname'])."','STUDENT');");
                //insert parent as user
                mysqli_query($conn,"INSERT INTO `users` (`NO`, `USER ID`, `PASSWORD`, `USER IP`, `LOGIN DATE`, `LOGIN TIME`, `IP ADDRESS`,`SCHOOL`,`USER NAME`,`POSITION`,`CONTACT`) VALUES (NULL, '$parent_id', '', '', '', '', '','$initials','".mysqli_real_escape_string($conn,$_REQUEST['guardianname'])."','GUARDIAN','".$_REQUEST['guardiantel']."');");
                
                
                $message = '
Dear '.$_REQUEST['guardianname'].', your ward, '.$_REQUEST['firstname'].' '.$_REQUEST['lastname'].'\'s student ID is: '. $student_id.' and your parent ID is: '.$parent_id.'. Use your parent ID to check on your ward\'s academic performance in the school and other relevant information through https://easyskul.com. Please both you and your ward should  visit our portal to add your accounts before you can login to our system.
                ';
                $number = $_REQUEST['guardiantel'];
                if(strlen($number) >=10){
                    send_normal_sms($message,$number,$initials,$conn);
                }
                
                $time = new datetime('now',new DateTimeZone('Europe/London'));
                $current_time = $time->format('h:i:s a');
                if($_REQUEST['fee'] >0){
               $receipt_number = receipt_number($initials,$year,$conn);
               mysqli_query($conn,"INSERT INTO `daily_fees_payments` (`ID`, `SCHOOL`, `ACADEMIC YEAR`, `TERM`, `STUDENT ID`, `STUDENT NAME`,`CLASS`, `DATE`, `TIME`, `AMOUNT PAID`, `CREDIT`, `DEBIT`, `PAID BY`, `RECEIVED BY`, `RECEIPT NUMBER`, `GENERATED`,`BEIGN`) VALUES (NULL, '$initials', '$academic_year', '$term', '$student_id','".mysqli_real_escape_string($conn,$_REQUEST['lastname'])."'     '".mysqli_real_escape_string($conn,$_REQUEST['firstname'])."', '".mysqli_real_escape_string($conn,$_REQUEST['class'])."','$date', '$current_time', '".mysqli_real_escape_string($conn,$_REQUEST['fee'])."', '0', '0', '".mysqli_real_escape_string($conn,$_REQUEST['guardianname'])."', '$user', '$receipt_number', 'NO','ADMISSION')");
                
               $get_receipt = mysqli_query($conn,"select * from `daily_fees_payments` where `SCHOOL`='$initials' and `RECEIVED BY`='$user' and `GENERATED`='NO' order by `ID` desc");
                
                
                //insert history
                    $operation = 'Admission fee  payment of amount  '.$currency.' '.$_REQUEST['fee'].' made for '.$student_id.'('.$_REQUEST['firstname'].' '.$_REQUEST['lastname'].') paid by '.$_REQUEST['guardianname'];
                    $date = date('Y-m-d');
                    $time = new datetime('now',new DateTimeZone('Europe/London'));
                    $current_time = $time->format('h:i:s a');

                    mysqli_query($conn,"INSERT INTO `histories` (`ID`, `SCHOOL`, `USER ID`, `OPERATION`, `DATE`, `TIME`, `ACTION`) VALUES (NULL, '$initials', '$user', '".mysqli_real_escape_string($conn,$operation)."', '$date', '$current_time', '');");
                    echo mysqli_connect_error();
                }
                if($fetch_get_row = mysqli_fetch_assoc($get_receipt)){
                    echo $fetch_get_row['ID'];
                }
             
            }else{
                echo mysqli_error($conn);;
            }
        }
        
    }else{
        echo 'error';
    }

    function generate_student_id($school_initial,$year,$conn){



        $select_student_number = mysqli_query($conn,"select * from `admitted_students` where `SCHOOL`='$school_initial' and `YEAR OF ADMISSION`='$year'");
        $number_rows = mysqli_num_rows($select_student_number);
        $number_rows ++;
        $number_rows = str_pad($number_rows,5,"0",STR_PAD_LEFT);

        $student_id = $school_initial."-"."STD"."_".$year."".$number_rows."D";
        
       
        return $student_id;

    }

function receipt_number($school_initial,$year,$conn){



        $select_student_number = mysqli_query($conn,"select * from `daily_fees_payments` where `SCHOOL`='$school_initial'");
        $number_rows = mysqli_num_rows($select_student_number);
        $number_rows ++;
        $number_rows = str_pad($number_rows,5,"0",STR_PAD_LEFT);

        $student_id = $school_initial."-"."RC"."_".$year."".$number_rows."T";
        
       
        return $student_id;

    }
?>