<?php

include '../includes/school_ini_user_id.php';

// new filename


$url = '';



//check if user  has an un finish registration

    $query = mysqli_query($conn,"select * from `admitted_students` where `ENTRY BY`='$user' and `SCHOOL`='$initials' and `NEW`!=''");
    if($fetch_query = mysqli_fetch_assoc($query)){
        //update records
        $filename = $fetch_query['PHOTO'];
        unlink('upload/'.$filename);
        
        if( move_uploaded_file($_FILES['webcam']['tmp_name'],'upload/'.$filename) ){
            $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/upload/' . $filename;
        }
        
        
        
    }else{
        //insert new student
        $year = date('Y');
        $student_id = generate_student_id($conn,$initials,$year);
        $filename = $student_id.'.jpeg';
        
        $query_insert = mysqli_query($conn,"INSERT INTO `admitted_students` (`NO`, `SCHOOL`, `ENTRY BY`, `ADMISSION NO / ID`, `STUDENT LAST NAME`, `STUDENT  FIRST NAME`, `STD DATE OF BIRTH`, `HOME TOWN`, `NATIONALITY`, `STD RELIGIOUS DENOMINATION`, `FORMER SCHOOL`, `DATE OF ADMISSION`, `PRESENT CLASS`, `PHOTO`, `GENDER`, `GUARDIAN NAME`, `GUARDIAN ADDRESS`, `GUARDIAN OCCUPATION`, `GUARDIAN TEL`, `GUARDIAN RD`, `GUARDIAN RELATIONSHIP STATUS`, `STUDENT DISABILITIES`, `ADMISSION FEE`, `PAIDDATE`, `ACADEMIC YEAR`, `YEAR OF ADMISSION`,`NEW`) VALUES (NULL, '$initials', '$user', '$student_id', '', '', '', '', '', '', '', '', '', '$filename', '', '', '', '', '', '', '', '', '', '', '', '$year','YES');");
        
        if( move_uploaded_file($_FILES['webcam']['tmp_name'],'upload/'.$filename) ){
            $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/upload/' . $filename;
        }
        
        
    }


// Return image url
echo $url;

function generate_student_id($conn,$school_initial,$year){
   
    
    
    $select_student_number = mysqli_query($conn,"select * from `admitted_students` where `SCHOOL`='$school_initial' and `YEAR OF ADMISSION`='$year'");
    $number_rows = mysqli_num_rows($select_student_number);
    $number_rows ++;
    $number_rows = str_pad($number_rows,5,"0",STR_PAD_LEFT);
    
    $student_id = $school_initial."-"."STD"."_".$year."".$number_rows."D";
    
    
    return $student_id;
    
}

