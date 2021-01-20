<?php
    include 'school_ini_user_id.php';
    
    

    if(isset($_REQUEST['exam_subjects']) && isset($_REQUEST['exam_scores']) && isset($_REQUEST['class_subjects']) && isset($_REQUEST['class_score']) && isset($_REQUEST['id']) && isset($_REQUEST['class']) ){
        
        $student_id = $_REQUEST['id'];
        $class = $_REQUEST['class'];
        //get exam score and subjects as ans array from js
        $exam_subjects = $_REQUEST['exam_subjects'];
        $exam_scores = $_REQUEST['exam_scores'];
        
        //get class subjects and score as an array form js
        $class_subjects = $_REQUEST['class_subjects'];
        $class_scores = $_REQUEST['class_score'];
        
        $academic_year = '';
        $term = '';

        $query_select_academic = mysqli_query($conn,"select * from `academic_years` where `SCHOOL`='$initials' and `STATUS`='ACTIVE'");
        if($fetch_year = mysqli_fetch_assoc($query_select_academic)){
            $academic_year = $fetch_year['ACADEMIC YEAR'];
            $term = $fetch_year['TERM'];
        }
        $i = 0;
       //loop to insert subject score to db if subjects for the term and academic_year does not exist
        foreach($exam_subjects as $exam_subject){
           
            
            $query_select = mysqli_query($conn,"select * from marksheet where `SUBJECT`='$exam_subject' and `STUDENT ID`='$student_id' and `CLASS`='$class' and `SCHOOL`='$initials' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term' and `MARKSHEET`='EXAM SCORE'");
            if(mysqli_num_rows($query_select) < 1){
                //insert exam_subjects and score
                mysqli_query($conn,"INSERT INTO `marksheet` (`ID`, `SCHOOL`, `CLASS`, `STUDENT ID`, `ACADEMIC YEAR`, `TERM`, `SUBJECT`, `MARKS`, `MARKSHEET`) VALUES (NULL, '$initials', '$class', '$student_id', '$academic_year', '$term', '$exam_subject', '".$exam_scores[$i]."', 'EXAM SCORE');");
            }else{
                //update exam subjects and score
                mysqli_query($conn,"update `marksheet` set `MARKS`='".$exam_scores[$i]."' where `SCHOOL`='$initials' and `CLASS`='$class' and `ACADEMIC YEAR`='$academic_year' and `TERM`= '$term' and `SUBJECT`='$exam_subject' and `MARKSHEET`='EXAM SCORE' and `STUDENT ID`='$student_id'");
            }
            $i++;
        }
        $i=0;
        foreach($class_subjects as $class_subject){
           
            $query_select = mysqli_query($conn,"select * from marksheet where `SUBJECT`='$class_subject' and `STUDENT ID`='$student_id' and `CLASS`='$class' and `SCHOOL`='$initials' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term' and `MARKSHEET`='CLASS SCORE'");
            if(mysqli_num_rows($query_select) < 1){
                //insert exam_subjects and score
                mysqli_query($conn,"INSERT INTO `marksheet` (`ID`, `SCHOOL`, `CLASS`, `STUDENT ID`, `ACADEMIC YEAR`, `TERM`, `SUBJECT`, `MARKS`, `MARKSHEET`) VALUES (NULL, '$initials', '$class', '$student_id', '$academic_year', '$term', '$class_subject', '".$class_scores[$i]."', 'CLASS SCORE');");
            }else{
                //update exam subjects and score
                mysqli_query($conn,"update `marksheet` set `MARKS`='".$class_scores[$i]."' where `SCHOOL`='$initials' and `CLASS`='$class' and `ACADEMIC YEAR`='$academic_year' and `TERM`= '$term' and `SUBJECT`='$class_subject' and `MARKSHEET`='CLASS SCORE' and `STUDENT ID`='$student_id'");
            }
           
            $i++;
        }
        
        echo 'success';
       //else update that row
    }else{
        echo 'error';
    }
?>