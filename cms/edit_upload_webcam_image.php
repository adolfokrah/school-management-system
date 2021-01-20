<?php

include '../includes/school_ini_user_id.php';

// new filename


$url = '';


    $id = '';
    if(isset($_SESSION['student_row_id'])){
        $id = $_SESSION['student_row_id'];
    }
//check if user is has an un finish registration

    $query = mysqli_query($conn,"select * from `admitted_students` where `NO`='$id'");
    if($fetch_query = mysqli_fetch_assoc($query)){
        //update records
        $filename = $fetch_query['PHOTO'];
        if($filename =="avatar3.jpg"){
            
           $filename = $fetch_query['ADMISSION NO / ID'].'.jpeg';
        }else{
             unlink('upload/'.$filename);
        }
        
        mysqli_query($conn,"update `admitted_students` set `PHOTO`='$filename' where `NO` ='$id'");
        
        if( move_uploaded_file($_FILES['webcam']['tmp_name'],'upload/'.$filename) ){
            $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/upload/' . $filename;
        }
        
    }


// Return image url
echo $url;



?>