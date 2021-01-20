<?php
    include 'school_ini_user_id.php';
    include 'get_currencies.php';
    //redirect user to registration stage if user is in registration stage
    if( isset($_REQUEST['id']) && isset($_REQUEST['receipient'])){
        $id = $_REQUEST['id'];
        $taken = $_REQUEST['receipient'];
        //CHECK IF BILL if bill already exist if yes then update else insert
        $academic_year = '';
        $term = '';
        $query_pick = mysqli_query($conn,"select * from academic_years where `SCHOOL`='$initials' and `STATUS`='ACTIVE'");
        if($fetch_row = mysqli_fetch_assoc($query_pick)){
            $academic_year = $fetch_row['ACADEMIC YEAR'];
            $term = $fetch_row['TERM'];
        }else{
            //terminate if academic_year is not set
                echo 'year';
                
                die();
            }
        
        $pick_fees = mysqli_query($conn,"select * from school_fees where `ID`='$id'");
        
        if($fetch = mysqli_fetch_assoc($pick_fees)){
            $student_name = $fetch['STUDENT NAME'];
            $student_id = $fetch['STUDENT ID'];
            $credit = $fetch['CREDIT'];
            $class = $fetch['CLASS'];
            
            if($fetch['ACADEMIC YEAR'] != $academic_year && $fetch['TERM'] != $term){
                'fail';
            }else{
                mysqli_query($conn,"update school_fees set `CREDIT`='0' where ID = '$id'");
                $date = date('Y-m-d');
                $time = new datetime('now',new DateTimeZone('Europe/London'));
                $current_time = $time->format('h:i a');
                $operation = 'Fees Balance of amount '.$currency.' '.$credit.'  returned to '.$student_id.' ('.$student_name.') and taken by '.$taken;
                 mysqli_query($conn,"INSERT INTO `histories` (`ID`, `SCHOOL`, `USER ID`, `OPERATION`, `DATE`, `TIME`, `ACTION`) VALUES (NULL, '$initials', '$user', '".mysqli_real_escape_string($conn,$operation)."', '$date', '$current_time', '');");
                
                mysqli_query($conn,"INSERT INTO `returned_blances` (`ID`, `SCHOOL`, `STUDENT ID`, `STUDENT NAME`, `CLASS`, `ACADEMIC YEAR`, `TERM`, `DATE`, `TIME`, `AMOUNT`, `TAKEN BY`) VALUES (NULL, '$initials', '$student_id', '$student_name', '$class', '$academic_year', '$term', '$date', '$current_time', '$credit', '$taken');");
            }
        }
       
        echo 'success';
        }
        
        
    
    
?>