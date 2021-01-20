<?php
    $message = '';
    $query_check = mysqli_query($conn,"select * from academic_years where `STATUS`='ACTIVE' and `SCHOOL`='$initials'");
    if(mysqli_num_rows($query_check) == null){
        echo "<script>window.open('manage_academic_year.php','_self');</script>";
       die(); 
       
    }else{
        $query_check2 = mysqli_query($conn,"select * from classes where `SCHOOL`='$initials'");
        if(mysqli_num_rows($query_check2)==null){
            echo "<script>window.open('manage_class.php','_self');</script>";
            die();
        }
    }
?>