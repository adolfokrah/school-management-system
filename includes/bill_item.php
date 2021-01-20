<?php
    include 'school_ini_user_id.php';
    include 'get_currencies.php';
    //redirect user to registration stage if user is in registration stage
    if(isset($_REQUEST['item']) && isset($_REQUEST['unit_price'])  && isset($_REQUEST['quantity'])&& isset($_REQUEST['class']) && isset($_REQUEST['ids'])){
        $item =strtoupper($_REQUEST['item']);
        $unit_price =$_REQUEST['unit_price'];
       $quantity = $_REQUEST['quantity'];
        $class = $_REQUEST['class'];
        $ids = $_REQUEST['ids'];
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
        
        
        
        $counter =0;
        foreach($ids as $id){
            if($id != ""){
                $credit = 0;
                $debit = 0;
                $operation = '';
            $query_check = mysqli_query($conn,"select * from bills where `SCHOOL`='$initials' and `CLASS`='$class' and `STUDENT ID`='$id' and `ITEM`='$item' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term'");
            if($fetch_bill = mysqli_fetch_assoc($query_check)){
                $price = $fetch_bill['PRICE'];
                $bill_id = $fetch_bill['ID'];
                
               mysqli_query($conn,"update bills set `PRICE`='$unit_price',`QUANTITY`='$quantity' where `ID`='$bill_id'");
              
              
              //insert action to histories
                $operation = 'Student with ID '.$id.' bill of item '.$item.' updated from '.$currency.' '.$price.' to '.$currency.' '.$unit_price;
                $date = date('Y-m-d');
                $time = new datetime('now',new DateTimeZone('Europe/London'));
                $current_time = $time->format('h:i:s a');

                mysqli_query($conn,"INSERT INTO `histories` (`ID`, `SCHOOL`, `USER ID`, `OPERATION`, `DATE`, `TIME`, `ACTION`) VALUES (NULL, '$initials', '$user', '".mysqli_real_escape_string($conn,$operation)."', '$date', '$current_time', '');");
                
                
                
                //pick current school fees
                $query_pick_student = mysqli_query($conn,"select * from `school_fees` where `SCHOOL`='$initials' and `STUDENT ID`='$id' and `STATUS`='ACTIVE' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term'");
                if($fetch_previous = mysqli_fetch_assoc($query_pick_student)){
                    $credit = $fetch_previous['CREDIT'];
                    $debit = $fetch_previous['DEBIT'];
                    $payment = $fetch_previous['PAYMENT'];
                    $initial_amount = $fetch_previous['AMOUNT'];
                    if($unit_price < $price){
                        
                        $diff = $price - $unit_price;
                        $initial_amount = $initial_amount - ($diff);
                        if($initial_amount < 1){
                            $initial_amount = 0;
                        }
                        
                        //check if payment is greater than or equal to previous debit
                        if($payment >= $debit){
                            $credit  = $credit + $diff;
                        }
                        
                        //deduct price from fees if new amount of bill is lesser than old amount
                        $debit = $debit - $diff;
                        if($debit < 1){
                            $debit = 0;
                        }
                       
                    }else if($unit_price > $price){
                        $diff = $unit_price-$price;
                        $initial_amount = $initial_amount + ($diff);
                        if($credit > 0){
                            //check if credit can pay for the new amount
                            if($credit >= $diff){
                                $credit = $credit - $diff;
                                $diff = 0;
                                $debit = $debit;
                            }else{
                                //$credit = 0;
                                $diff = $diff - $credit;
                                $debit = $debit + $diff;
                            }
                        }else{
                            $debit = $debit + $diff;
                        }
                        
                    }
                    
                    
                     //update bill
                    mysqli_query($conn,"update school_fees set `AMOUNT`='$initial_amount',`DEBIT`='$debit',`CREDIT`='$credit' where `SCHOOL`='$initials' and `STUDENT ID`='$id' and `STATUS`='ACTIVE'");
                    
                }
                
                
                
            }else{
                
                $student_name = '';
                $query_select = mysqli_query($conn,"select * from `admitted_students` where `SCHOOL`='$initials' and `ADMISSION NO / ID`='$id'");
                if($fetch = mysqli_fetch_assoc($query_select)){
                    $student_name = $fetch['STUDENT LAST NAME'].' '.$fetch['STUDENT  FIRST NAME'];
                }
                
                 mysqli_query($conn,"INSERT INTO `bills` (`ID`, `SCHOOL`, `STUDENT ID`,`STUDENT NAME`,`CLASS`,`ITEM`, `PRICE`, `QUANTITY`,`ACADEMIC YEAR`,`TERM`) VALUES (NULL, '$initials', '$id','$student_name','$class', '$item', '$unit_price', '$quantity','$academic_year','$term')");
                
                //insert action to histories
                $operation = 'Student with ID '.$id.' billed with new  item - '.$item.' quantity- '.$quantity.' price- '.$currency.' '.$unit_price;
                $date = date('Y-m-d');
                $time = new datetime('now',new DateTimeZone('Europe/London'));
                $current_time = $time->format('h:i:s a');

                mysqli_query($conn,"INSERT INTO `histories` (`ID`, `SCHOOL`, `USER ID`, `OPERATION`, `DATE`, `TIME`, `ACTION`) VALUES (NULL, '$initials', '$user', '".mysqli_real_escape_string($conn,$operation)."', '$date', '$current_time', '');");
                
                //insert new fees to system if student has not beign billed for this or previous term
                
                //check if student has already been billed for this term
                $query_pick_student = mysqli_query($conn,"select * from `school_fees` where `SCHOOL`='$initials' and `STUDENT ID`='$id' and `STATUS`='ACTIVE' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term'");
                if($fetch_student = mysqli_fetch_assoc($query_pick_student)){
                    
                    //check if student is to be giving balance or owing
                    $query_pick_previous = mysqli_query($conn,"select * from school_fees where `FROM`='Y' and `SCHOOL`='$initials' and `STUDENT ID`='$id'");
                    if($fetch_previous_fees = mysqli_fetch_assoc($query_pick_previous)){
                        $total_amount=0;
                        $query2 = mysqli_query($conn,"select * from bills where `STUDENT ID` ='$id' and `SCHOOL`= '$initials' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term'");
                        while($fetch_fee = mysqli_fetch_assoc($query2)){
                           
                            $total_amount = $total_amount + $fetch_fee['PRICE'];
                        }
                        // if found then take it debit and credit and add to current term accounting
                         $credit = $fetch_previous_fees['CREDIT'];
                         $debit = $fetch_previous_fees['DEBIT'];
                        
                         //check if student is owing
                        if($debit > 0){
                            $initial_amount = $total_amount + $debit;
                            $debit = $total_amount + $debit;
                        }
                        
                        //check if balance needs to be given
                        if($credit > 0){
                            $debit = $total_amount - $credit;
                            $initial_amount = $total_amount;

                            if($debit < 0){
                                $initial_amount = $total_amount;
                                $debit = 0;
                                $credit = $credit - $total_amount;
                            }else{
                                $credit = 0;
                            }
                        } 
                    }else{
                        
                        
                        
                        $initial_amount = $fetch_student['AMOUNT']+$unit_price;
                        //calculate new credit
                        $credit = $fetch_student['PAYMENT'] - $initial_amount;
                        
                        if($credit >= 0){
                            $debit = 0;
                        }else{
                            
                            $debit = $fetch_student['DEBIT'] + $unit_price - $fetch_student['PAYMENT'];
                            if($debit < 1){
                                $debit = 0;
                            }
                            $credit = 0;
                        }
                        
                        
                    }
                    
                    
                     //update bill
                    mysqli_query($conn,"update school_fees set `AMOUNT`='$initial_amount',`DEBIT`='$debit',`CREDIT`='$credit' where `SCHOOL`='$initials' and `STUDENT ID`='$id' and `STATUS`='ACTIVE'");
                        
                    
                }else{
                    //set all previous terms to past if found
                    mysqli_query($conn,"update school_fees set `FROM`='' where `STUDENT ID`='$id' and `SCHOOL`='$initials'");
                    //check and update recent term to yes
                    $query_pick_previous = mysqli_query($conn,"select * from `school_fees` where `SCHOOL`='$initials' and `STATUS`='ACTIVE' and `STUDENT ID`='$id' and `ACADEMIC YEAR` != '$academic_year' or `SCHOOL`='$initials' and `STATUS`='ACTIVE' and `STUDENT ID`='$id' and `TERM` !='$term' ");
                    
                    //insert new bill for this term but find if student is owing or to be balanced
                    if($fetch_previous = mysqli_fetch_assoc($query_pick_previous)){
                        $initial_amount = $unit_price;
                             $credit = $fetch_previous['CREDIT'];
                            $debit = $fetch_previous['DEBIT'];
                            $fees_id = $fetch_previous['ID'];
                            
                            //check if student is owing
                            if($debit > 0){
                                $initial_amount = $unit_price + $debit;
                                $debit = $unit_price + $debit;
                            }
                            //check if balance needs to be given
                            if($credit > 0){
                                $debit = $unit_price - $credit;
                                $initial_amount = $unit_price;
                                
                                if($debit < 0){
                                    $initial_amount = $unit_price;
                                    $debit = 0;
                                    $credit = $credit - $unit_price;
                                }else{
                                    $credit = 0;
                                }
                            }
                        echo $initial_amount;
                        //Set previous term to old
                            
                            mysqli_query($conn,"update school_fees set `FROM`='Y',`STATUS`='' where `ID`='$fees_id'");
                        
                            mysqli_query($conn,"INSERT INTO `school_fees` (`ID`, `SCHOOL`,`CLASS`,`AMOUNT`, `STUDENT NAME`, `STUDENT ID`, `ACADEMIC YEAR`, `TERM`, `PAYMENT`, `DEBIT`, `CREDIT`, `STATUS`,`FROM`) VALUES (NULL, '$initials', '$class','$initial_amount', '$student_name', '$id', '$academic_year', '$term', '0', '$debit', '$credit', 'ACTIVE','');");
                    }else{
                        //insert new bill to the system
                            mysqli_query($conn,"INSERT INTO `school_fees` (`ID`, `SCHOOL`,`CLASS`, `AMOUNT`, `STUDENT NAME`, `STUDENT ID`, `ACADEMIC YEAR`, `TERM`, `PAYMENT`, `DEBIT`, `CREDIT`, `STATUS`,`FROM`) VALUES (NULL, '$initials','$class', '$unit_price', '$student_name', '$id', '$academic_year', '$term', '0', '$unit_price', '0', 'ACTIVE','');");
                    }
                }
                
                
            }
            
            
            echo mysqli_connect_error();
                
           
            $counter ++;
            }
        }
        echo 'success';
        
    
    }else{
        echo 'error';
    }
?>