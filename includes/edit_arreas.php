<?php
    include 'school_ini_user_id.php';
    include 'get_currencies.php';
    
    if(isset($_REQUEST['id']) && isset($_REQUEST['payment'])  && isset($_REQUEST['arreas'])&& isset($_REQUEST['credit'])){
        $old_arreas = sprintf('%0.2f',$_REQUEST['payment']);
        $new_arreas = sprintf('%0.2f',$_REQUEST['arreas']);
        $credit = sprintf('%0.2f',$_REQUEST['credit']);
        $student_id = $_REQUEST['id'];
        
        
       
           if(mysqli_query($conn,"update school_fees set `DEBIT`='$new_arreas',`PAYMENT`='$old_arreas',`CREDIT`='$credit' where `STUDENT ID`='$student_id' and `STATUS`='ACTIVE'")){
               
               //insert history
                $operation = 'Student with ID '.$student_id.' arreas updated to '.$currency.' '.$new_arreas.', payment  to '.$currency.' '.$old_arreas.' and credit  to '.$currency.' '.$credit;
                $date = date('Y-m-d');
                $time = new datetime('now',new DateTimeZone('Europe/London'));
                $current_time = $time->format('h:i:s a');

                mysqli_query($conn,"INSERT INTO `histories` (`ID`, `SCHOOL`, `USER ID`, `OPERATION`, `DATE`, `TIME`, `ACTION`) VALUES (NULL, '$initials', '$user', '".mysqli_real_escape_string($conn,$operation)."', '$date', '$current_time', '');");
            echo ' <div class="alert alert-success alert-dismissable"> 
               
              Fees updated.
            </div>';
        }else{
              echo ' <div class="alert alert-danger alert-dismissable"> 
              
              Ooops.. An error occured please try again later.
            </div>'; 
           }
       
        
        
        
    }
?>