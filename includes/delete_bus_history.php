<?php
   

    $user='';
    $shool ='';
 include 'school_ini_user_id.php';
include 'get_currencies.php';
    //redirect user to registration stage if user is in registration stage
    if(isset($_REQUEST['id']) &&isset($_REQUEST['student_id'])&&isset($_REQUEST['arreas'])&&isset($_REQUEST['balance'])&&isset($_REQUEST['days_left']) ){
        $id =$_REQUEST['id'];
        $student_id =$_REQUEST['student_id'];
        $arreas =$_REQUEST['arreas'];
        $balance =$_REQUEST['balance'];
        $days_left =$_REQUEST['days_left'];
        
        $query = mysqli_query($conn,"select * from `daily_bus_fee` where `ID`='$id' ");
        if($fetch = mysqli_fetch_assoc($query)){
        $student_name  = $fetch['STUDENT NAME'];
        $amount = $fetch['AMOUNT'];
        $days = $fetch['DAYS'];
        $student_id = $fetch['STUDENT ID'];
        $amount_per_day = $fetch['AMOUNT PER DAY'];
            
            
        mysqli_query($conn,"delete from `daily_bus_fee` where `ID`='$id'");
        mysqli_query($conn,"update bus_fee set `ARREAS`='$arreas',`BALANCE`='$balance',`DAYS LEFT`='$days_left' where `STUDENT ID`='$student_id'");
            
        //insert history
        $operation = 'BUS fee payment of amount  '.$currency.' '.$amount.' Made by Student with ID '.$student_id.' ('.$student_name.') for '.$days.' day(s)  amount per day charged ='.$currency.'  '.sprintf('%0.2f',$amount_per_day).' deleted and student records set to<br/>
        <strong>arreas</strong> = '.$arreas.' <strong>Balance</strong>'.$balance.', <strong>days left</strong> '.$days_left;
        $date = date('Y-m-d');
        $time = new datetime('now',new DateTimeZone('Europe/London'));
        $current_time = $time->format('h:i:s a');

        mysqli_query($conn,"INSERT INTO `histories` (`ID`, `SCHOOL`, `USER ID`, `OPERATION`, `DATE`, `TIME`, `ACTION`) VALUES (NULL, '$initials', '$user', '".mysqli_real_escape_string($conn,$operation)."', '$date', '$current_time', '');");
        echo mysqli_connect_error();
         echo 'success';
        }
        
    
    }else{
        echo 'error';
    }
?>