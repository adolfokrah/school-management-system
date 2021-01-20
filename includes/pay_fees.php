<?php
    include 'school_ini_user_id.php';
    include 'sms.php';
    include 'get_currencies.php';

    if(isset($_REQUEST['student_id']) && isset($_REQUEST['amount']) && isset($_REQUEST['paidby']) && isset($_REQUEST['date'])){  
        $student_id = $_REQUEST['student_id'];
        $amount = $_REQUEST['amount'];
        $padby = $_REQUEST['paidby'];
        $date = $_REQUEST['date'];
        
        //check if academic_year is set
        $academic_year = '';
        $term = '';
        $query_pick = mysqli_query($conn,"select * from academic_years where `SCHOOL`='$initials' and `STATUS`='ACTIVE'");
        if($fetch_row = mysqli_fetch_assoc($query_pick)){
            $academic_year = $fetch_row['ACADEMIC YEAR'];
            $term = $fetch_row['TERM'];
        }else{
                //terminate if academic_year is not set
                echo '0';
                die();
            }
        
                
            
            $query_pick_fees = mysqli_query($conn,"select * from school_fees where `SCHOOL`='$initials' and `STUDENT ID`='$student_id' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term' and `STATUS`='ACTIVE'");
           
            if(mysqli_num_rows($query_pick_fees) > 0){
                 if($fetch_fees = mysqli_fetch_assoc($query_pick_fees)){
                    //check if student is owing
                    $credit = $fetch_fees['CREDIT'];
                    $debit = $fetch_fees['DEBIT'];
                    $payment = $fetch_fees['PAYMENT'];
                    $id = $fetch_fees['ID'];
                     
                     
                    if($debit < 1){
                        
                        echo '1';
                        die();
                    }else{
                        
                        //update student records
                        $payment = $payment + $amount;
                        
                        if($amount > $debit){
                            $credit = $amount-$debit;
                            $debit = 0;
                        }else{
                            $debit = $debit - $amount;
                            $credit = 0;
                        }
                        
                        //pick student details
                        $query_pick_student_details = mysqli_query($conn,"select * from `admitted_students` where `SCHOOL`='$initials' and `ADMISSION NO / ID`='$student_id'");
                        if($fetch_details = mysqli_fetch_assoc($query_pick_student_details)){
                            
                             $query_update = mysqli_query($conn,"update school_fees set `PAYMENT`='$payment',`CREDIT`='$credit',`DEBIT`='$debit' where `ID`='$id'");
                           
                            if($query_update == 1){
                                
                            //insert daily payment records
                            $year = date('Y');
                            $receipt_number = generate_student_id($conn,$initials,$year);
                            
                            $ndate = date('Y-m-d');
                            $time = new datetime('now',new DateTimeZone('Europe/London'));
                            $current_time = $time->format('h:i a');
                            
                            if($date != ""){
                                $ndate = $date;
                                $current_time = "";
                            }
                            
                            $student_name = $fetch_details['STUDENT LAST NAME'].' '.$fetch_details['STUDENT  FIRST NAME'];
                            $guardian_number = $fetch_details['GUARDIAN TEL'];
                            $guardian_name = $fetch_details['GUARDIAN NAME'];
                            $class = $fetch_details['PRESENT CLASS'];
                            
                            if(mysqli_query($conn,"INSERT INTO `daily_fees_payments` (`ID`, `SCHOOL`, `ACADEMIC YEAR`, `TERM`, `STUDENT ID`, `STUDENT NAME`,`CLASS`, `DATE`, `TIME`, `AMOUNT PAID`, `CREDIT`, `DEBIT`, `PAID BY`, `RECEIVED BY`, `RECEIPT NUMBER`, `GENERATED`,`BEIGN`) VALUES (NULL, '$initials', '$academic_year', '$term', '$student_id', '$student_name', '$class','$ndate', '$current_time', '".$amount."', '$credit', '$debit', '".$padby."', '$user', '$receipt_number', 'NO','SCHOOL FEES')")){
                                
                            }else{
                                echo mysqli_error($conn);
                                die();
                            }
                            
                            //insert history
                            $operation = 'Fees payment of amount  '.$currency.' '.$amount.' made for '.$student_id.'('.$student_name.') paid by '.$padby;
                            $date = date('Y-m-d');
                            $time = new datetime('now',new DateTimeZone('Europe/London'));
                            $current_time = $time->format('h:i:s a');
                            
                            mysqli_query($conn,"INSERT INTO `histories` (`ID`, `SCHOOL`, `USER ID`, `OPERATION`, `DATE`, `TIME`, `ACTION`) VALUES (NULL, '$initials', '$user', '".mysqli_real_escape_string($conn,$operation)."', '$date', '$current_time', '');");
                            echo mysqli_connect_error();
                            
                            //pick school name
                            $query_pick_school = mysqli_query($conn,"select * from school_details where `INITIALS`='$initials'");
                            $school_name  = '';
                            if($fetch_school_name = mysqli_fetch_assoc($query_pick_school)){
                                $school_name = $fetch_school_name['SCHOOL NAME'];
                                
                            }
                            
$message = 'Dear '.$guardian_name.', payment of school fees for '.$student_name.' - student ID: '.$student_id.' has been done successfully by '.$padby.' on '.$ndate.'
AMOUNT PAID: '.sprintf('%0.2f',$amount).'
CREDIT: '.sprintf('%0.2f',$credit).'
DEBIT: '.sprintf('%0.2f',$debit).'

You can visit your portal at https://easyskul.com with your ID: '.str_replace('-STD','-PT',$student_id).' and password or add your account to the system if you have not yet added it and check your ward\'s fees payment transcript for this term.
Thank you.
';
                if($guardian_number !=''){
                    if(strlen($guardian_number) >= 10){
                       // echo $guardian_number;
                        send_normal_sms($message,$guardian_number,$initials,$conn);

                    }
                }
                            echo '2';
                            }else{
                                echo 'error';
                            }
                            
                            
                        }
                    }
                        
                 }
            }else{
                echo '3';
            }
                           
    }else{
        echo 'error';
    }

//Generate receipt number

 function generate_student_id($conn,$school_initial,$year){



        $select_student_number = mysqli_query($conn,"select * from `daily_fees_payments` where `SCHOOL`='$school_initial'");
        $number_rows = mysqli_num_rows($select_student_number);
        $number_rows ++;
        $number_rows = str_pad($number_rows,5,"0",STR_PAD_LEFT);

        $student_id = $school_initial."-"."RC"."_".$year."".$number_rows."T";
        
        return $student_id;

    }
?>