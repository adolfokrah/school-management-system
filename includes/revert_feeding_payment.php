<?php
    

    $user='';
    $shool ='';

    include 'school_ini_user_id.php';
    include 'get_currencies.php';
    //redirect user to registration stage if user is in registration stage
    if(isset($_REQUEST['id']) && !empty($_REQUEST['id']) && isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
        $id =$_REQUEST['id'];
        $action = $_REQUEST['action'];
        $operation='';
        //pick row details
        
        $query = mysqli_query($conn,"select * from daily_feeding_fee where `ID`='$id'");
        
        if($fetch = mysqli_fetch_assoc($query)){
            $days = $fetch['DAYS'];
            $student_id = $fetch['STUDENT ID'];
            $amount = $fetch['AMOUNT'];
            $student_name = $fetch['STUDENT NAME'];
            $amount_per_day = $fetch['AMOUNT PER DAY'];
            
            $query2 = mysqli_query($conn,"select * from feeding_fee where `STUDENT ID`='$student_id'");
            if($fetch_fee = mysqli_fetch_assoc($query2)){
                $days_left = $fetch_fee['DAYS LEFT'];
                $o_balance = $fetch_fee['BALANCE'];
                $o_arreas = $fetch_fee['ARREAS'];
                $o_amount = $fetch_fee['AMOUNT'];
                $amount_tobe_paid = $days * $amount_per_day;
               //calculate arreas and blance
                $balance = 0;
                $arreas = 0;
                if($amount > $amount_tobe_paid){
                    $balance = $amount - $amount_tobe_paid;
                    
                }else if($amount < $amount_tobe_paid){
                    $arreas = $amount_tobe_paid - $amount;
                    
                }
                
                
                if($action == 'deduct'){
                    $days_left = $days_left - $days;
                    if($days_left < 1){
                        $days_left = 0;
                    }
                    $o_balance = $o_balance - $balance;
                    $o_arreas  = $o_arreas - $arreas;
                    if($o_arreas <=0){
                        $o_arreas = 0;
                    }
                    if($o_balance <=0){
                        $o_balance = 0;
                    }
                    
                    $operation = 'Feeding fee payment of amount  '.$currency.' '.$amount.' Made by Student with ID '.$student_id.' ('.$student_name.') for'.$days.' day(s) deleted and deducted from his/her Feeding fee records';
                }else{
                    $days_left = ($days_left + $days)-1;
                    
                    
                    
                    $operation = 'Feeding fee payment of amount  '.$currency.' '.$amount.' Made by Student with ID '.$student_id.' ('.$student_name.') for'.$days.' day(s) deleted and added from his/her Feeding fee records';
                }
                
               $o_amount = $o_amount - $amount;
                
               mysqli_query($conn,"update feeding_fee set `DAYS LEFT`='$days_left',`BALANCE`='$o_balance',`ARREAS`='$o_arreas',`AMOUNT`='$o_amount' where `STUDENT ID`='$student_id'");
               mysqli_query($conn,"delete from `daily_feeding_fee` where `ID`='$id'");
                
                //insert history
                
                $date = date('Y-m-d');
                $time = new datetime('now',new DateTimeZone('Europe/London'));
                $current_time = $time->format('h:i:s a');

                mysqli_query($conn,"INSERT INTO `histories` (`ID`, `SCHOOL`, `USER ID`, `OPERATION`, `DATE`, `TIME`, `ACTION`) VALUES (NULL, '$initials', '$user', '".mysqli_real_escape_string($conn,$operation)."', '$date', '$current_time', '');");
                echo mysqli_connect_error();
                
               echo 'success';
            }
        }     
    
    }else{
        echo 'error';
    }
?>