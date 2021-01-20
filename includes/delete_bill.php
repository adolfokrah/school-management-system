<?php
    include 'school_ini_user_id.php';
    include 'get_currencies.php';
    //redirect user to registration stage if user is in registration stage
    if( isset($_REQUEST['ids'])){
        $ids = $_REQUEST['ids'];
        //CHECK IF BILL if bill already exist if yes then update else insert
        
        
        $academic_year = '';
        $term = '';
        $data = '';
        $query_pick = mysqli_query($conn,"select * from academic_years where `SCHOOL`='$initials' and `STATUS`='ACTIVE'");
        if($fetch_row = mysqli_fetch_assoc($query_pick)){
            $academic_year = $fetch_row['ACADEMIC YEAR'];
            $term = $fetch_row['TERM'];
        }else{
            //terminate if academic_year is not set
                echo 'year';
                
                die();
            }
        
        
        
        $counter =0;
        foreach($ids as $id){
            $query_check = mysqli_query($conn,"select * from bills where `ID`='$id'");
            if($fetch_bill = mysqli_fetch_assoc($query_check)){
                $academic_year = $fetch_bill['ACADEMIC YEAR'];
                $term = $fetch_bill['TERM'];
                $bill_amount = $fetch_bill['PRICE'];
                $bill_id = $fetch_bill['ID'];
                $student_id = $fetch_bill['STUDENT ID'];
                    $query_fees = mysqli_query($conn,"select * from school_fees where `SCHOOL`='$initials' and `STUDENT ID`='$student_id' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term' and `STATUS`='ACTIVE'");
                
                if($fetch = mysqli_fetch_assoc($query_fees)){
                    $debit = $fetch['DEBIT'];
                    $fees_id=$fetch['ID'];
                    $credit = $fetch['CREDIT'];
                    $payment = $fetch['PAYMENT'];
                    
                         if($bill_amount - $debit > 0){
                            $credit = $credit + ($bill_amount - $debit);
                             
                        }
                    
                        $debit = $debit - $bill_amount;
                        if($debit < 0){
                            $debit = 0;
                        }
                        
                    
                       
                        mysqli_query($conn,"delete from bills  where `ID`='$id'");
                        mysqli_query($conn,"update school_fees set `DEBIT`='$debit',`CREDIT`='$credit' where ID='$fees_id'");
                        
                        $operation = 'Student of ID '.$student_id.' bill of amount '.$currency.' '.$bill_amount.' deleted';
                        
                        $date = date('Y-m-d');
                        $time = new datetime('now',new DateTimeZone('Europe/London'));
                        $current_time = $time->format('h:i:s a');

                        mysqli_query($conn,"INSERT INTO `histories` (`ID`, `SCHOOL`, `USER ID`, `OPERATION`, `DATE`, `TIME`, `ACTION`) VALUES (NULL, '$initials', '$user', '".mysqli_real_escape_string($conn,$operation)."', '$date', '$current_time', '');");
                        echo mysqli_connect_error();
                        
                        $data = 'success';
                   
                }
                 
                }
            
            echo mysqli_connect_error();
            $counter ++;
            }
        echo $data;
        }
        
        
    
    
?>