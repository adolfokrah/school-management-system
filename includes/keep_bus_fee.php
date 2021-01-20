<?php
    include 'school_ini_user_id.php';
    include 'sms.php';
    include 'get_currencies.php';

    if(isset($_REQUEST['student_ids']) && isset($_REQUEST['amounts']) && isset($_REQUEST['pday']) && isset($_REQUEST['date']) && isset($_REQUEST['amount_per_day']) && isset($_REQUEST['location'])&& isset($_REQUEST['bus'])&& isset($_REQUEST['cat'])){  
        $student_ids = $_REQUEST['student_ids'];
        $amounts = $_REQUEST['amounts'];
        $pday = $_REQUEST['pday'];
        $location = $_REQUEST['location'];
        $bus = $_REQUEST['bus'];
        $cat = $_REQUEST['cat'];
       
        $date = $_REQUEST['date'];
        $amount_per_day =$_REQUEST['amount_per_day'];
        
        $amount_tobe_paid = $amount_per_day * $pday;
        
        $ids = array();
       
        //check if academic_year is set
        $academic_year = '';
        $term = '';
        $query_pick = mysqli_query($conn,"select * from academic_years where `SCHOOL`='$initials' and `STATUS`='ACTIVE'");
        if($fetch_row = mysqli_fetch_assoc($query_pick)){
            $academic_year = $fetch_row['ACADEMIC YEAR'];
            $term = $fetch_row['TERM'];
        }else{
            //terminate if academic_year is not set
               
            }
        
        //check if student is billed
       
        $counter = 0;
        foreach($student_ids as $student_id){
             $check = 0;
            //check if payment is duplicated
            foreach($student_ids as $id_check){
                if($student_id == $id_check){
                    $check ++;
                    
                }
            }
            
            if($check > 1){
                
            }else{
                
                
                //check if student is a member
                $query_check = mysqli_query($conn,"select * from admitted_students where `SCHOOL`='$initials' and `ADMISSION NO / ID`='$student_id'");
                if($fetch_student_details = mysqli_fetch_assoc($query_check)){
                    
                    $student_name = $fetch_student_details['STUDENT LAST NAME'].' '.$fetch_student_details['STUDENT  FIRST NAME'];
                    $student_class = $fetch_student_details['PRESENT CLASS'];
                    //ok now check if student already has a record in db
                    $query_check_feeding_records = mysqli_query($conn,"select * from `bus_fee` where `SCHOOL`='$initials' and `STUDENT ID`='$student_id'");
                    
                       
                    
                    if($fetch_feeding = mysqli_fetch_assoc($query_check_feeding_records)){
                        $days_left = $fetch_feeding['DAYS LEFT'];
                        $amount = $fetch_feeding['AMOUNT'];
                        $balance = $fetch_feeding['BALANCE'];
                        $arreas = $fetch_feeding['ARREAS'];
                        $bcat=$fetch_feeding['CATEGORY'];
                        
                        if($days_left > 0){
                            $cat = $bcat;
                        }else{
                           $cat = $_REQUEST['cat'];
                        }
                        
                        
                         if($days_left > 0 && $amounts > 0){
                             $days_left = ($pday + $days_left)-1;
                         }else if($days_left > 0 && $amounts < 1){
                             $days_left = $days_left - 1;
                         }else if($days_left < 1 && $amounts > 1){
                             $days_left = $pday - 1;
                         }else if($days_left < 1 && $amounts < 1){
                             $days_left = $pday - 1;
                         }
//                        if($days_left < 1 && $amounts < 1){
//                            $days_left = $pday;
//                        }else if($amounts < 1 && $days_left > 0){
//                            $pday =$pday - 1;
//                            if($pday < 0){
//                                $pday = 0;
//                            }
//                        }else if($amounts > 1 && $days_left > 0){
//                            $days_left = ($days_left + $pday)-1;
//                        }
                        
                        //calculate arreas and blance
                        
                        if($amounts > $amount_tobe_paid){
                            if($arreas > 0){
                               $new_amount = $amounts - $arreas;
                                
                                if($new_amount > $amount_tobe_paid){
                                    $balance = $new_amount - $amount_tobe_paid;
                                    $arreas = 0;
                                }else if($new_amount < $amount_tobe_paid){
                                    $arreas = $amount_tobe_paid - $new_amount;
                                    $balance = 0;
                                }else{
                                    $arreas = 0;
                                }
                                
                            }else{
                                $balance = ($amounts - $amount_tobe_paid)+$balance;
                            }
                        }else if($amounts < $amount_tobe_paid){
                            if($balance > 0){
                                $new_amount = $amounts + $balance;
                                
                                if($new_amount > $amount_tobe_paid){
                                    $balance = $new_amount - $amount_tobe_paid;
                                    $arreas = 0;
                                }else if($new_amount < $amount_tobe_paid){
                                    $arreas = $amount_tobe_paid - $new_amount;
                                    $balance = 0;
                                }else{
                                    $balance = 0;
                                }
                                
                            }else{
                                $arreas = ($amount_tobe_paid - $amounts) + $arreas;
                            }
                        }
                        
                        
                        $amount = $amount + $amounts;
                        mysqli_query($conn,"update `bus_fee` set `DAYS LEFT` = '$days_left',`BALANCE`='$balance',`ARREAS`='$arreas',`AMOUNT`='$amount',`CATEGORY`='$cat' where `SCHOOL`='$initials' and `STUDENT ID`='$student_id'");
                        
                        
                        mysqli_query($conn,"INSERT INTO `daily_bus_fee` (`ID`, `SCHOOL`, `AMOUNT PER DAY`, `AMOUNT`, `DATE`, `DAYS`, `STUDENT ID`, `STUDENT NAME`, `CLASS`, `LOCATION`, `BUS`, `CATEGORY`, `ACADEMIC YEAR`, `TERM`) VALUES (NULL, '$initials','$amount_per_day', '".$amounts."', '$date', '".$pday."', '$student_id', '$student_name','$student_class','$location','$bus','$cat','$academic_year', '$term');");
                        
                        
                        //insert history
                        $operation = 'bus fee payment of '.$date.' of amount  '.$currency.' '.$amounts.' Made for Student with ID '.$student_id.' ('.$student_name.') for '.$pday.' day(s)  amount per day charged ='.$currency.'  '.sprintf('%0.2f',$amount_per_day);
                        $date = date('Y-m-d');
                        $time = new datetime('now',new DateTimeZone('Europe/London'));
                        $current_time = $time->format('h:i:s a');

                        mysqli_query($conn,"INSERT INTO `histories` (`ID`, `SCHOOL`, `USER ID`, `OPERATION`, `DATE`, `TIME`, `ACTION`) VALUES (NULL, '$initials', '$user', '".mysqli_real_escape_string($conn,$operation)."', '$date', '$current_time', '');");
                        echo mysqli_connect_error();
                        
                    }else{
                        
                        //calculate arreas and blance
                        $balance = 0;
                        $arreas = 0;
                        if($amounts > $amount_tobe_paid){
                            $balance = $amounts - $amount_tobe_paid;
                        }else if($amounts < $amount_tobe_paid){
                            $arreas = $amount_tobe_paid - $amounts;
                        }
                        
                        mysqli_query($conn,"INSERT INTO `bus_fee` (`ID`, `SCHOOL`, `AMOUNT`,`ARREAS`,`BALANCE`, `DATE`, `DAYS LEFT`, `STUDENT ID`, `STUDENT NAME`, `ACADEMIC YEAR`, `TERM`,`CATEGORY`) VALUES (NULL, '$initials', '".$amounts."','$arreas','$balance', '$date', '".($pday-1)."', '$student_id', '$student_name', '$academic_year', '$term','$cat');");
                        
                        
                        mysqli_query($conn,"INSERT INTO `daily_bus_fee` (`ID`, `SCHOOL`, `AMOUNT PER DAY`, `AMOUNT`, `DATE`, `DAYS`, `STUDENT ID`, `STUDENT NAME`, `CLASS`, `LOCATION`, `BUS`, `CATEGORY`, `ACADEMIC YEAR`, `TERM`) VALUES (NULL, '$initials','$amount_per_day', '".$amounts."', '$date', '".$pday."', '$student_id', '$student_name','$student_class','$location','$bus','$cat','$academic_year', '$term');");
                        
                        
                        //insert history
                        $operation = 'bus fee payment of '.$date.' of amount  '.$currency.' '.$amounts.' Made for Student with ID '.$student_id.' ('.$student_name.') for'.$pday.' day(s) amount per day charged ='.$currency.'  '.sprintf('%0.2f',$amount_per_day);
                        $date = date('Y-m-d');
                        $time = new datetime('now',new DateTimeZone('Europe/London'));
                        $current_time = $time->format('h:i:s a');

                        mysqli_query($conn,"INSERT INTO `histories` (`ID`, `SCHOOL`, `USER ID`, `OPERATION`, `DATE`, `TIME`, `ACTION`) VALUES (NULL, '$initials', '$user', '".mysqli_real_escape_string($conn,$operation)."', '$date', '$current_time', '');");
                        echo mysqli_connect_error();
                    }
                }else{
                    
                }
                
            }
             $counter++;
        }
        echo 'success';
        
    }else{
        echo 'error';
    }

//Generate receipt number

 function generate_student_id($school_initial,$year){



        $select_student_number = mysqli_query($conn,"select * from `daily_fees_payments` where `SCHOOL`='$school_initial'");
        $number_rows = mysqli_num_rows($select_student_number);
        $number_rows ++;
        $number_rows = str_pad($number_rows,5,"0",STR_PAD_LEFT);

        $student_id = $school_initial."-"."RC"."_".$year."".$number_rows."T";
        
        return $student_id;

    }
?>