<?php
    include 'school_ini_user_id.php';
    include 'get_currencies.php';
    $id = '';
    if(isset($_SESSION['student_row_id'])){
        $id = $_SESSION['student_row_id'];
    }

    if(isset($_REQUEST['firstname']) && isset($_REQUEST['lastname']) && isset($_REQUEST['date_of_birth']) && isset($_REQUEST['hometown']) && isset($_REQUEST['nationality']) && isset($_REQUEST['rgd']) && isset($_REQUEST['guardianname']) && isset($_REQUEST['guardianaddress']) && isset($_REQUEST['guardianoccupation']) && isset($_REQUEST['guardianrgd']) && isset($_REQUEST['relationship_to_std']) && isset($_REQUEST['disability']) && isset($_REQUEST['paid_date']) && isset($_REQUEST['admission_date']) && isset($_REQUEST['former_school']) && isset($_REQUEST['former_school']) && isset($_REQUEST['fee']) && isset($_REQUEST['guardiantel']) && isset($_REQUEST['class']) && isset($_REQUEST['gender'])){
          
        //UPDATE THE ROW
            if(mysqli_query($conn,"update `admitted_students` set `STUDENT LAST NAME`='".mysqli_real_escape_string($conn,$_REQUEST['lastname'])."', `STUDENT  FIRST NAME`='".mysqli_real_escape_string($conn,$_REQUEST['firstname'])."',`STD DATE OF BIRTH`='".$_REQUEST['date_of_birth']."',`HOME TOWN`='".mysqli_real_escape_string($conn,$_REQUEST['hometown'])."',`NATIONALITY`='".mysqli_real_escape_string($conn,$_REQUEST['nationality'])."',`STD RELIGIOUS DENOMINATION`='".mysqli_real_escape_string($conn,$_REQUEST['rgd'])."',`FORMER SCHOOL`='".mysqli_real_escape_string($conn,$_REQUEST['former_school'])."',`PRESENT CLASS`='".mysqli_real_escape_string($conn,$_REQUEST['class'])."',`GENDER`='".mysqli_real_escape_string($conn,$_REQUEST['gender'])."',`GUARDIAN NAME`='".mysqli_real_escape_string($conn,$_REQUEST['guardianname'])."',`GUARDIAN ADDRESS`='".mysqli_real_escape_string($conn,$_REQUEST['guardianaddress'])."', `GUARDIAN TEL`='".mysqli_real_escape_string($conn,$_REQUEST['guardiantel'])."',`GUARDIAN RD`='".mysqli_real_escape_string($conn,$_REQUEST['guardianrgd'])."',`GUARDIAN RELATIONSHIP STATUS`='".mysqli_real_escape_string($conn,$_REQUEST['relationship_to_std'])."',`STUDENT DISABILITIES`='".mysqli_real_escape_string($conn,$_REQUEST['disability'])."',`ADMISSION FEE`='".$_REQUEST['fee']."', `GUARDIAN OCCUPATION`='".mysqli_real_escape_string($conn,$_REQUEST['guardianoccupation'])."' where `NO`='$id'")){
                
                $student_name = mysqli_real_escape_string($conn,$_REQUEST['lastname']).' '.mysqli_real_escape_string($conn,$_REQUEST['firstname']);
                
                echo 'success';
            }
                
    }else{
        echo 'error';
    }
?>