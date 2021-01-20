<?php
    include 'school_ini_user_id.php';
    
    include 'sms.php';
 $data = '';
//pick school name
$query_select = mysqli_query($conn,"select * from school_details where `INITIALS`='$initials'");
if($fetch_school = mysqli_fetch_assoc($query_select)){
    $school_name = $fetch_school['SCHOOL NAME'];
}

    $query = mysqli_query($conn,"select * from `admitted_students` where  `SCHOOL`='$initials' and `SMS`=''");
    while($fetch = mysqli_fetch_assoc($query)){
    $id = $fetch['NO'];
    $student_id = $fetch['ADMISSION NO / ID'];
    $parent_id = str_replace('-STD','-PT',$student_id);
$message = '
Dear '.$fetch['GUARDIAN NAME'].', your ward, '.$fetch['STUDENT  FIRST NAME'].' '.$fetch['STUDENT LAST NAME'].'\'s student ID is: '. $student_id.' and your parent ID is: '.$parent_id.'. Use your parent ID to check on your ward\'s academic performance in the school and other relevant information through https://easyskul.com.
                ';
                $number = str_replace(' ','',$fetch['GUARDIAN TEL']);
        
                if(preg_match('/[0-9]/',$number)){
                     if(strlen($number) >= 10){
                    //echo $number;
                        send_normal_sms($message,$number,$initials,$conn);
                        mysqli_query($conn,"update `admitted_students` set `SMS`='SENT' where `NO`='$id'");
                        $data = 'success';
                    }   
                }
        
                
       
    }
 echo $data;
?>