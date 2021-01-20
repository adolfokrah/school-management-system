<?php
    include 'school_ini_user_id.php';

    //redirect user to registration stage if user is in registration stage
    mysqli_query($conn,"delete from `attendance` where `SCHOOL`='$initials' ");
    mysqli_query($conn,"delete from `daily_feeding_fee` where `SCHOOL`='$initials' ");
    mysqli_query($conn,"delete from `daily_fees_payments` where `SCHOOL`='$initials' ");
    mysqli_query($conn,"delete from `expenses` where `SCHOOL`='$initials' ");
    mysqli_query($conn,"delete from `feeding_fee` where `SCHOOL`='$initials' ");
    mysqli_query($conn,"delete from `marksheet` where `SCHOOL`='$initials' ");
    mysqli_query($conn,"delete from `school_fees` where `SCHOOL`='$initials' ");
    mysqli_query($conn,"delete from `terminal_reports` where `SCHOOL`='$initials' ");
    mysqli_query($conn,"delete from `terminal_reports_av` where `SCHOOL`='$initials' ");
    mysqli_query($conn,"delete from `bills` where `SCHOOL`='$initials' ");
    mysqli_query($conn,"delete from `library_books` where `SCHOOL`='$initials' ");
    mysqli_query($conn,"delete from `library_books_status` where `SCHOOL`='$initials' ");
    mysqli_query($conn,"delete from `noticeboard` where `SCHOOL`='$initials' ");
    mysqli_query($conn,"delete from `shelves` where `SCHOOL`='$initials' ");
    mysqli_query($conn,"delete from `subjects` where `SCHOOL`='$initials' ");
    mysqli_query($conn,"delete from `teachers` where `SCHOOL`='$initials' ");
    mysqli_query($conn,"delete from `users` where `SCHOOL`='$initials' and `USER ID`!='$user'");
    mysqli_query($conn,"delete from `academic_years` where `SCHOOL`='$initials'");
    
    mysqli_query($conn,"delete from `classes` where `SCHOOL`='$initials'");
    mysqli_query($conn,"delete from `events` where `SCHOOL`='$initials'");
    mysqli_query($conn,"delete from `grading_system` where `SCHOOL`='$initials'");
    mysqli_query($conn,"delete from `returned_blances` where `SCHOOL`='$initials'");
//pick time_table
    $query_pick = mysqli_query($conn,"select * from `time_table` where `SCHOOL`='$initials' ");
    if($fetch_table  = mysqli_fetch_assoc($query_pick)){
        $file = $fetch_table['FILE'];
        if(file_exists('../cms/time_tables/'.$file)){
            unlink('../cms/time_tables/'.$fetch_table['FILE']);
        }
        mysqli_query($conn,"delete from `time_tables` where `SCHOOL`='$initials' ");
    }

    $query_pick1 = mysqli_query($conn,"select * from `admitted_students` where `SCHOOL`='$initials' ");
        if($fetch_table  = mysqli_fetch_assoc($query_pick1)){
            $file = $fetch_table['PHOTO'];
            if(file_exists('../cms/upload/'.$file) && $file !="avatar3.jpg"){
                unlink('../cms/upload/'.$fetch_table['PHOTO']);
            }
            mysqli_query($conn,"delete from `admitted_students` where `SCHOOL`='$initials'");
        }
    
    echo 'success';
?>