<?php

    
    $user='';
    $shool ='';

    include 'school_ini_user_id.php';
    include 'get_currencies.php';
    //redirect user to registration stage if user is in registration stage
    if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
        $id =$_REQUEST['id'];
        $query = mysqli_query($conn,"select * from `daily_fees_payments` where `ID`='$id'");
        if($fetch = mysqli_fetch_assoc($query)){
            $amount = $fetch['AMOUNT PAID'];
            $credit = $fetch['CREDIT'];
            $academic_year = $fetch['ACADEMIC YEAR'];
            $term = $fetch['TERM'];
            $student_id = $fetch['STUDENT ID'];
            $school_initials = $fetch['SCHOOL'];
            
            mysqli_query($conn,"delete from  `daily_fees_payments` WHERE `ID`='$id'");
            
            //update fees
            $query1 = mysqli_query($conn,"select * from school_fees where `TERM`='$term' and `ACADEMIC YEAR`='$academic_year' and `STATUS`='ACTIVE' and `STUDENT ID`='$student_id' and `SCHOOL`='$school_initials'");
            if($fetch_fees = mysqli_fetch_assoc($query1)){
                
                $update_payment = $fetch_fees['PAYMENT']-$amount;
                $update_credit = $fetch_fees['CREDIT']- $credit;
                
                $update_debit = $fetch_fees['DEBIT'] + ($amount - $credit);
                
                if($update_payment < 1){
                    $update_payment = 0;
                }
                
                if($update_credit < 1){
                    $update_credit = 0;
                }
                
                $row_id = $fetch_fees['ID'];
                
                mysqli_query($conn,"update school_fees set `PAYMENT`='$update_payment',`CREDIT`='$update_credit',`DEBIT`='$update_debit' where `ID`='$row_id'");
                
                //insert history
                $operation = 'Fees payment of amount  '.$currency.' '.$amount.' Deleted';
                $date = date('Y-m-d');
                $time = new datetime('now',new DateTimeZone('Europe/London'));
                $current_time = $time->format('h:i:s a');

                mysqli_query($conn,"INSERT INTO `histories` (`ID`, `SCHOOL`, `USER ID`, `OPERATION`, `DATE`, `TIME`, `ACTION`) VALUES (NULL, '$initials', '$user', '".mysqli_real_escape_string($conn,$operation)."', '$date', '$current_time', '');");
                //echo mysqli_connect_error();
                
                echo 'success';
            }
            
        }
    
    }else{
        echo 'error';
    }
?>