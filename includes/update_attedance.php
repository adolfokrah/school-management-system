<?php
    include 'school_ini_user_id.php';
    include 'sms.php';
    

    if(isset($_REQUEST['id']) && isset($_REQUEST['class']) && isset($_REQUEST['teacher']) && isset($_REQUEST['date']) && isset($_REQUEST['pdate'])) {
        $ids = $_REQUEST['id'];
        $class = $_REQUEST['class'];
        $teacher=$_REQUEST['teacher'];
        $date = $_REQUEST['date'];
        $pdate = $_REQUEST['pdate'];
        if($ids =='none'){
            $ids = array("0");
        }
        
        $academic_year = '';
        $term = '';

        $query_select_academic = mysqli_query($conn,"select * from `academic_years` where `SCHOOL`='$initials' and `STATUS`='ACTIVE'");
        if($fetch_year = mysqli_fetch_assoc($query_select_academic)){
            $academic_year = $fetch_year['ACADEMIC YEAR'];
            $term = $fetch_year['TERM'];
        }
        
        
        
        //check if attendance is already taken for the day
            $school_name='';
            $query2 = mysqli_query($conn,"select * from `school_details` where `INITIALS` = '$initials'");
            if($fetch2 = mysqli_fetch_assoc($query2)){
                $school_name = strtoupper(htmlentities($fetch2['SCHOOL NAME']));
            }
        
        $query_picked = mysqli_query($conn,"select * from attendance where `SCHOOL`='$initials' and `DATE`='$date' and `CLASS`='$class'");
        $number_rows = mysqli_num_rows($query_picked);
        
        if($date == $pdate){
            $number_rows = 0;
        }
        if($number_rows < 1){
        //select all students from the clas
        $query_pick = mysqli_query($conn,"select * from `admitted_students` where `SCHOOL`='$initials' and `PRESENT CLASS`='$class' order by `STUDENT LAST NAME` asc");
        while($fetch = mysqli_fetch_assoc($query_pick)){
            //pick student row id and compare to the ids array
            $status = "ABSCENT";
            $guardian_number = $fetch['GUARDIAN TEL'];
            $guardian_name = $fetch['GUARDIAN NAME'];
            $student_name = $fetch['STUDENT LAST NAME'].' '.$fetch['STUDENT  FIRST NAME'];
           //if id is found then mark as present else mark as abscent
            $student_row_id = $fetch['ADMISSION NO / ID'];
            foreach($ids as $id){
                if($student_row_id == $id){
                    //mark as present if found
                    $status = "PRESENT";
                    break;
                }
            }
            
            mysqli_query($conn,"update `attendance` set `STATUS`='$status', `TEACHER`='$teacher',`DATE`='$date' where `STUDENT ID`='".$fetch['ADMISSION NO / ID']."' and `SCHOOL`='$initials' and `DATE`='$pdate'");
           
            
        }
            echo 'success';
        }else{
            echo 'found';
        }
        
    }else{
        echo 'error';
    }
?>