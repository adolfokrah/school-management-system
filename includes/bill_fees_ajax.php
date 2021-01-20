<?php
    include 'school_ini_user_id.php';
    include 'get_currencies.php';
    

    if(isset($_REQUEST['class']) && isset($_REQUEST['ids']) && isset($_REQUEST['amount'])){
        $class = $_REQUEST['class'];
        $ids = $_REQUEST['ids'];
        $amount = $_REQUEST['amount'];
        $data = '';
        
        
        //check if academic_year is set
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
                    
        
        foreach($ids as $id){
            if($id !=""){
            $credit = 0;
            $debit = 0;
            $operation  ='';
            //select student by row id
            $query_select = mysqli_query($conn,"select * from `admitted_students` where `SCHOOL`='$initials' and `NO`='$id'");
            if($fetch = mysqli_fetch_assoc($query_select)){
                $student_id = $fetch['ADMISSION NO / ID'];
                $student_name = $fetch['STUDENT LAST NAME'].' '.$fetch['STUDENT  FIRST NAME'];
                //check of any of the student has already made payment
                $query_check = mysqli_query($conn,"select * from school_fees where `PAYMENT` > 0 and `SCHOOL`='$initials' and `CLASS`='$class' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term' and `STUDENT ID`='$student_id' and `STATUS`='ACTIVE'");
                if(mysqli_num_rows($query_check) > 0){
                    
                }else{
        
                
                //check if student has already been billed
                $query_pick_student = mysqli_query($conn,"select * from `school_fees` where `SCHOOL`='$initials' and `STUDENT ID`='$student_id' and `STATUS`='ACTIVE' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term'");
                if($fetch_student = mysqli_fetch_assoc($query_pick_student)){
                   
                        
                        //check if student is owing or not for previous term
                        $query_pick_previous = mysqli_query($conn,"select * from school_fees where `FROM`='Y' and `SCHOOL`='$initials' and `STUDENT ID`='$student_id'");
                        if($fetch_previous = mysqli_fetch_assoc($query_pick_previous)){
                            $credit = $fetch_previous['CREDIT'];
                            $debit = $fetch_previous['DEBIT'];
                            
                            //check if student is owing
                            if($debit > 0){
                                $initial_amount = $amount + $debit;
                                $debit = $amount + $debit;
                            }
                            //check if balance needs to be given
                            if($credit > 0){
                                $debit = $amount - $credit;
                                $initial_amount = $amount;
                                
                                if($debit < 0){
                                    $initial_amount = $amount;
                                    $debit = 0;
                                    $credit = $credit - $amount;
                                }else{
                                    $credit = 0;
                                }
                            }
                                
                                
                        }else{
                            
                            $debit = $amount + $fetch_student['DEBIT'];
                            $initial_amount = $amount;
                        }
                        
                        //update bill
                        mysqli_query($conn,"update school_fees set `AMOUNT`='$initial_amount',`DEBIT`='$debit',`CREDIT`='$credit' where `SCHOOL`='$initials' and `STUDENT ID`='$student_id' and `STATUS`='ACTIVE'");
                        $data = 'success';
                        $operation = 'Updated student with ID <strong>'.$student_id.'\'s School fees bill to'.$currency.' '.$initial_amount;
                    
                }else{
                    //set all recent terms to 
                    mysqli_query($conn,"update school_fees set `FROM`='' where `STUDENT ID`='$student_id' and `SCHOOL`='$initials'");
                    //check and update previous term to yes
                    $query_pick_previous = mysqli_query($conn,"select * from `school_fees` where `SCHOOL`='$initials' and `STATUS`='ACTIVE' and `STUDENT ID`='$student_id' and `ACADEMIC YEAR` != '$academic_year' or `SCHOOL`='$initials' and `STATUS`='ACTIVE' and `STUDENT ID`='$student_id' and `TERM` !='$term' ");
                   
                    if($fetch_previous = mysqli_fetch_assoc($query_pick_previous)){
                            $credit = $fetch_previous['CREDIT'];
                            $debit = $fetch_previous['DEBIT'];
                            $fees_id = $fetch_previous['ID'];
                            
                            //check if student is owing
                            if($debit > 0){
                                $initial_amount = $amount + $debit;
                                $debit = $amount + $debit;
                            }
                            //check if balance needs to be given
                            if($credit > 0){
                                $debit = $amount - $credit;
                                $initial_amount = $amount;
                                
                                if($debit < 0){
                                    $initial_amount = $amount;
                                    $debit = 0;
                                    $credit = $credit - $amount;
                                }else{
                                    $credit = 0;
                                }
                            }
                                
                        
                            //Set previous term to old
                            
                            mysqli_query($conn,"update school_fees set `FROM`='Y',`STATUS`='' where `ID`='$fees_id'");
                        
                            mysqli_query($conn,"INSERT INTO `school_fees` (`ID`, `SCHOOL`,`CLASS`,`AMOUNT`, `STUDENT NAME`, `STUDENT ID`, `ACADEMIC YEAR`, `TERM`, `PAYMENT`, `DEBIT`, `CREDIT`, `STATUS`,`FROM`) VALUES (NULL, '$initials', '$class','$initial_amount', '$student_name', '$student_id', '$academic_year', '$term', '0', '$debit', '$credit', 'ACTIVE','');");
                            $data = 'success';
                            $operation = 'Billed student with ID <strong>'.$student_id.'\'s with school fees of an amount of '.$currency.' '.$initial_amount;    
                        }else{
                            //insert new bill
                            mysqli_query($conn,"INSERT INTO `school_fees` (`ID`, `SCHOOL`,`CLASS`, `AMOUNT`, `STUDENT NAME`, `STUDENT ID`, `ACADEMIC YEAR`, `TERM`, `PAYMENT`, `DEBIT`, `CREDIT`, `STATUS`,`FROM`) VALUES (NULL, '$initials','$class', '$amount', '$student_name', '$student_id', '$academic_year', '$term', '0', '$amount', '0', 'ACTIVE','');");
                            $data = 'success';
                            $operation = 'Billed student with ID <strong>'.$student_id.'\'s</strong> with school fees of an amount of '.$currency.' '.$amount;    
                            
                        }
                    
                    
                }
            }
            }
        }
            //insert history
            $date = date('Y-m-d');
            $time = new datetime('now',new DateTimeZone('Europe/London'));
            $current_time = $time->format('h:i:s a');

            mysqli_query($conn,"INSERT INTO `histories` (`ID`, `SCHOOL`, `USER ID`, `OPERATION`, `DATE`, `TIME`, `ACTION`) VALUES (NULL, '$initials', '$user', '".mysqli_real_escape_string($conn,$operation)."', '$date', '$current_time', '');");
            //echo mysqli_connect_error();
        }
        if($data == 'success'){
            echo 'success';
        }
        //
    }else{
        echo 'error';
    }
?>