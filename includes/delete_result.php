<?php
    include 'school_ini_user_id.php';
    include 'sms.php';
    //redirect user to registration stage if user is in registration stage
    if(isset($_REQUEST['id']) && isset($_REQUEST['class']) && isset($_REQUEST['academic_year']) && isset($_REQUEST['term'])){
        $id = $_REQUEST['id'];
        $class = $_REQUEST['class'];
        $academic_year = $_REQUEST['academic_year'];
        $term = $_REQUEST['term'];
        //CHECK IF BILL if bill already exist if yes then update else insert
        
        mysqli_query($conn,"delete from terminal_reports_av where `STUDENT ID`='$id' and `CLASS`='$class' and `SCHOOL`='$initials' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term'");
        
        mysqli_query($conn,"delete from terminal_reports where `STUDENT ID`='$id' and `CLASS`='$class' and `SCHOOL`='$initials' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term'");
        
        echo 'success';
        }
?>