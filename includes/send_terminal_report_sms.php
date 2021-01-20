<?php
    include 'school_ini_user_id.php';
    include 'sms.php';
    //redirect user to registration stage if user is in registration stage
    if(isset($_REQUEST['class'])){
        $class = $_REQUEST['class'];
        $counter = 0;
        $academic_year = '';
        $term = '';

        $query_select_academic = mysqli_query($conn,"select * from `academic_years` where `SCHOOL`='$initials' and `STATUS`='ACTIVE'");
        if($fetch_year = mysqli_fetch_assoc($query_select_academic)){
            $academic_year = $fetch_year['ACADEMIC YEAR'];
            $term = $fetch_year['TERM'];
        }

        $query = mysqli_query($conn,"select * from `terminal_reports_av` where  `SCHOOL`='$initials' and `CLASS`='$class' and `SMS SENT`=''");
        while($fetch = mysqli_fetch_assoc($query)){
            $student_name = $fetch['STUDENT NAME'];
            $student_id = $fetch['STUDENT ID'];
            
            //PICK STUDENT GUARDIAN DETAILS
            $query1 = mysqli_query($conn,"select * from admitted_students where `ADMISSION NO / ID`='$student_id'");
            if($fetch_student = mysqli_fetch_assoc($query1)){
                $guardian_name=$fetch_student['GUARDIAN NAME'];
                $guardian_number = $fetch_student['GUARDIAN TEL'];
                
                
                 //pick school name
                    $query_pick_school = mysqli_query($conn,"select * from school_details where `INITIALS`='$initials'");
                    $school_name  = '';
                    if($fetch_school_name = mysqli_fetch_assoc($query_pick_school)){
                        $school_name = $fetch_school_name['SCHOOL NAME'];
                    }                         
                    
                    $guardian_id = str_replace('-STD','-PT',$student_id);
$message = '
Dear '.$guardian_name.', your ward, '.$student_name.' ID: '.$student_id.' end of '.$term.' '.$academic_year.' of '.$class.' result is out please either you or your ward should visit https://easyskul.com to check and print full result and student\'s bill.Your Parent ID:'.$guardian_id.' Thank You. ';
                    if($guardian_number !=''){
                        if(str_replace(' ','',$guardian_number)){
                            if(strlen($guardian_number) >= 10){
                                send_normal_sms($message,$guardian_number,$initials,$conn);
                                mysqli_query($conn,"update `terminal_reports_av` set `SMS SENT`='YES' where `STUDENT ID`='$student_id'");
                                $counter ++;
                            }

                        }
                    }
            }
        }
      
        echo $counter;
            }
       
        
        
    
    
?>