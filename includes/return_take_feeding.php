<?php
   

    $user='';
    $shool ='';
 include 'school_ini_user_id.php';
include 'get_currencies.php';
    //redirect user to registration stage if user is in registration stage
    if(isset($_REQUEST['ids'] )&& isset($_REQUEST['action'])){
        $ids =$_REQUEST['ids'];
        $action =$_REQUEST['action'];
        
        foreach($ids as $id){
            $query = mysqli_query($conn,"select * from `feeding_fee` where `ID`='$id' ");
            if($fetch = mysqli_fetch_assoc($query)){
            $student_name  = $fetch['STUDENT NAME'];
            $balance = $fetch['BALANCE'];
            $arreas = $fetch['ARREAS'];
            $student_id = $fetch['STUDENT ID'];
            

            $operation = '';
            if($action == "debitors"){
                 mysqli_query($conn,"update feeding_fee set `ARREAS`='0' where `STUDENT ID`='$student_id'");
                $operation = 'FEEDING FEE ARREAS OF <strong>'.$currency.' '.$arreas.' </strong>taken from <strong>'.$student_name.'</strong> ID :'.$student_id;
            }else{
                 mysqli_query($conn,"update feeding_fee set `BALANCE`='0' where `STUDENT ID`='$student_id'");
                 $operation = 'FEEDING FEE BALANCE OF <strong>'.$currency.' '.$balance.' </strong> given to <strong>'.$student_name.'/strong> ID :'.$student_id;
            }
           

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