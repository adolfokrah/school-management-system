<?php
    include 'school_ini_user_id.php';
    include 'get_currencies.php';
    //redirect user to registration stage if user is in registration stage
    if( isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
        
            $pick_fees = mysqli_query($conn,"select * from returned_blances where `ID`='$id'");
        
        if($fetch = mysqli_fetch_assoc($pick_fees)){
            $student_name = $fetch['STUDENT NAME'];
            $student_id = $fetch['STUDENT ID'];
            $amount = $fetch['AMOUNT'];
            $date = $fetch['DATE'];
            $times = $fetch['TIME'];
            $class = $fetch['CLASS'];
            
            $date = date('Y-m-d');
            $time = new datetime('now',new DateTimeZone('Europe/London'));
            $current_time = $time->format('h:i a');
            $operation = 'Fees blanace of amount '.$currency.' '.$amount.' given to '.$student_id.' '.$student_name.' on '.$date.' '.$times.' was deleted ';
            mysqli_query($conn,"INSERT INTO `histories` (`ID`, `SCHOOL`, `USER ID`, `OPERATION`, `DATE`, `TIME`, `ACTION`) VALUES (NULL, '$initials', '$user', '".mysqli_real_escape_string($conn,$operation)."', '$date', '$current_time', '');");
            
        }
            mysqli_query($conn,"delete from `returned_blances`  where ID ='$id'");
            echo 'success';
        }
?>