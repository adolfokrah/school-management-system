<?php
    include 'school_ini_user_id.php';
    
    

    if(isset($_REQUEST['exam_subjects']) && isset($_REQUEST['exam_scores']) && isset($_REQUEST['class_subjects']) && isset($_REQUEST['class_score']) && isset($_REQUEST['ids']) && isset($_REQUEST['class']) ){
        $message = '';
        $student_ids = $_REQUEST['ids'];
         $i = 0;
        foreach($student_ids as $student_id){
            $class = $_REQUEST['class'];
        //get exam score and subjects as ans array from js
        $exam_subject = $_REQUEST['exam_subjects'];
        $exam_scores = $_REQUEST['exam_scores'];
        
        //get class subjects and score as an array form js
        $class_subject = $_REQUEST['class_subjects'];
        $class_scores = $_REQUEST['class_score'];
        
        $academic_year = '';
        $term = '';

        $query_select_academic = mysqli_query($conn,"select * from `academic_years` where `SCHOOL`='$initials' and `STATUS`='ACTIVE'");
        if($fetch_year = mysqli_fetch_assoc($query_select_academic)){
            $academic_year = $fetch_year['ACADEMIC YEAR'];
            $term = $fetch_year['TERM'];
        }
       
       //loop to insert subject score to db if subjects for the term and academic_year does not exist
       
           
            
            $query_select = mysqli_query($conn,"select * from marksheet where `SUBJECT`='$exam_subject' and `STUDENT ID`='$student_id' and `CLASS`='$class' and `SCHOOL`='$initials' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term' and `MARKSHEET`='EXAM SCORE'");
            if(mysqli_num_rows($query_select) < 1){
                //insert exam_subjects and score
                mysqli_query($conn,"INSERT INTO `marksheet` (`ID`, `SCHOOL`, `CLASS`, `STUDENT ID`, `ACADEMIC YEAR`, `TERM`, `SUBJECT`, `MARKS`, `MARKSHEET`) VALUES (NULL, '$initials', '$class', '$student_id', '$academic_year', '$term', '$exam_subject', '".$exam_scores[$i]."', 'EXAM SCORE');");
            }else{
                //update exam subjects and score
                mysqli_query($conn,"update `marksheet` set `MARKS`='".$exam_scores[$i]."' where `SCHOOL`='$initials' and `CLASS`='$class' and `ACADEMIC YEAR`='$academic_year' and `TERM`= '$term' and `SUBJECT`='$exam_subject' and `MARKSHEET`='EXAM SCORE' and `STUDENT ID`='$student_id'");
            }
        
        
           
            $query_select = mysqli_query($conn,"select * from marksheet where `SUBJECT`='$class_subject' and `STUDENT ID`='$student_id' and `CLASS`='$class' and `SCHOOL`='$initials' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term' and `MARKSHEET`='CLASS SCORE'");
            if(mysqli_num_rows($query_select) < 1){
                //insert exam_subjects and score
                mysqli_query($conn,"INSERT INTO `marksheet` (`ID`, `SCHOOL`, `CLASS`, `STUDENT ID`, `ACADEMIC YEAR`, `TERM`, `SUBJECT`, `MARKS`, `MARKSHEET`) VALUES (NULL, '$initials', '$class', '$student_id', '$academic_year', '$term', '$class_subject', '".$class_scores[$i]."', 'CLASS SCORE');");
            }else{
                //update exam subjects and score
                mysqli_query($conn,"update `marksheet` set `MARKS`='".$class_scores[$i]."' where `SCHOOL`='$initials' and `CLASS`='$class' and `ACADEMIC YEAR`='$academic_year' and `TERM`= '$term' and `SUBJECT`='$class_subject' and `MARKSHEET`='CLASS SCORE' and `STUDENT ID`='$student_id'");
            }
          
        
        $message =  'success';
       //else update that row
        $i++;
        }
        echo $message;
    }else{
        echo 'error';
    }
?>