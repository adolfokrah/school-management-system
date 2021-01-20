<?php
    include 'school_ini_user_id.php';
    include 'sms.php';
    //redirect user to registration stage if user is in registration stage
    if(isset($_REQUEST['ids']) && isset($_REQUEST['term_end']) && isset($_REQUEST['term_begin']) && isset($_REQUEST['promotion'])){
        $ids = $_REQUEST['ids'];
        $end_term = $_REQUEST['term_end'];
        $term_begins = $_REQUEST['term_begin'];
        $promotion = $_REQUEST['promotion'];
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
            $student_name = '';
            $class = '';
            $guardian_name = '';
            $guardian_number ='';
            $average_mark = 0;
            
          
            
            $query_pick_stuent_info = mysqli_query($conn,"select * from admitted_students where `ADMISSION NO / ID`='$id' and `SCHOOL`='$initials'");
            if($fetch_info = mysqli_fetch_assoc($query_pick_stuent_info)){
                $student_name = $fetch_info['STUDENT LAST NAME'].' '.$fetch_info['STUDENT  FIRST NAME'];
                $class = $fetch_info['PRESENT CLASS'];
                $guardian_name = $fetch_info['GUARDIAN NAME'];
                $guardian_number = $fetch_info['GUARDIAN TEL'];
                $guardian_id = str_replace('STD','PT',$id);
            }

                //grades
                
                //select student marksheet 
                $query_pick_marksheet = mysqli_query($conn,"select * from marksheet where `STUDENT ID`='$id' and `TERM`='$term' and `ACADEMIC YEAR`='$academic_year' and `SCHOOL`='$initials' and `CLASS`='$class' order by ID");
                while($fetch = mysqli_fetch_assoc($query_pick_marksheet)){
                    $subject = $fetch['SUBJECT'];
                    $marks = $fetch['MARKS'];
                    $marksheet = $fetch['MARKSHEET'];
                    $examMark = 0;
                    $classMark = 0;
                    
                    if($marksheet == 'EXAM SCORE'){
                        $examMark = $marks;
                        $query_pick_class_score = mysqli_query($conn,"select * from marksheet where `STUDENT ID`='$id' and `TERM`='$term' and `ACADEMIC YEAR`='$academic_year' and `SCHOOL`='$initials' and `SUBJECT`='$subject' and `CLASS`='$class' and `MARKSHEET`='CLASS SCORE' order by ID");
                        if($fetch_class = mysqli_fetch_assoc($query_pick_class_score)){
                            $classMark = $fetch_class['MARKS'];
                        }
                    }else{
                        $classMark = $marks;
                        $query_pick_class_score = mysqli_query($conn,"select * from marksheet where `STUDENT ID`='$id' and `TERM`='$term' and `ACADEMIC YEAR`='$academic_year' and `SCHOOL`='$initials' and `SUBJECT`='$subject' and `CLASS`='$class' and `MARKSHEET`='EXAM SCORE' order by ID");
                        if($fetch_class = mysqli_fetch_assoc($query_pick_class_score)){
                            $examMark = $fetch_class['MARKS'];
                        }
                    }
                    //CALCULATE FOR BOTH EXAM AND CLASS SCORE
                    
                    $query_pick_grading = mysqli_query($conn,"select * from grading_system where `SCHOOL`='$initials'");
                    if($fetch_grading = mysqli_fetch_assoc($query_pick_grading)){
                        
                            $pass_mark = $fetch_grading['PASS MARK'];
                            $exam_mark = $fetch_grading['EXAM MARK'];
                            $class_mark = $fetch_grading['CLASS MARK'];
                            $A = $fetch_grading['A'];
                            $B = $fetch_grading['B'];
                            $C = $fetch_grading['C'];
                            $D = $fetch_grading['D'];
                            $E = $fetch_grading['E'];
                            $F = $fetch_grading['F'];
                            
                        
                        $examMark = sprintf('%0.2f',$exam_mark/100 * $examMark);
                        $classMark = sprintf('%0.2f',$class_mark/100 * $classMark);
                        $total_marks = $examMark + $classMark;
                        $grade = '';
                        $remarks = '';
                        $position_in_subject = '';
                        if($total_marks < $E){
                            $grade = 'F';
                            $remarks = 'Fail';
                        }else if($total_marks > $F && $total_marks < $D){
                            $grade='E';
                            $remarks = 'Pass';
                        }else if($total_marks > $E && $total_marks <$C){
                            $grade = 'D';
                            $remarks = 'Good';
                        }else if($total_marks > $D && $total_marks < $B){
                            $grade = 'C';
                            $remarks = 'Credit';
                        }else if($total_marks > $C && $total_marks < $A){
                            $grade = 'B';
                            $remarks = 'Very Good';
                        }else if($total_marks > $B ){
                            $grade = 'A';
                            $remarks = 'Excellent';
                        }
                        
                        //check marks is inserted
                        mysqli_query($conn,"delete from terminal_reports where `STUDENT ID`='$id' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term' and `CLASS`='$class' and `SCHOOL`='$initials' and `SUBJECT`='$subject'");
                        
                        mysqli_query($conn,"INSERT INTO `terminal_reports` (`ID`, `SCHOOL`, `CLASS`, `STUDENT ID`, `STUDENT NAME`, `ACADEMIC YEAR`, `TERM`, `SUBJECT`, `CLASS SCORE`, `EXAM SCORE`, `TOTAL SCORE`, `POSITION`, `GRADE`, `REMARKS`,`TERM END`,`TERM BEGINS`,`PROMOTION`) VALUES (NULL, '$initials', '$class', '$id', '$student_name', '$academic_year', '$term', '$subject', '$classMark', '$examMark', '$total_marks', '', '$grade', '$remarks','$end_term','$term_begins','$promotion');");
                        
                        
                 $sql_pick_pos = mysqli_query($conn,"select MAX(`TOTAL SCORE`) from `terminal_reports` where `SUBJECT`='$subject' and `TERM`='$term' and `CLASS`='$class' and `ACADEMIC YEAR`='$academic_year' and `SCHOOL`='$initials'");
                        $counter =0;
                        $prev_score =0;
                        
                        if($fetch_score = mysqli_fetch_assoc($sql_pick_pos)){
                            $counter ++;
                            $pos = '';
                            
                            $prev_score = $fetch_score["MAX(`TOTAL SCORE`)"];
                            
                            mysqli_query($conn,"update `terminal_reports` set `POSITION`='1st' where `TOTAL SCORE` = '$prev_score' and `TERM`='$term' and `ACADEMIC YEAR`='$academic_year' and `SCHOOL`='$initials' and `CLASS`='$class' and `SUBJECT`='$subject'");
                            
                            $sql = mysqli_query($conn,"select `TOTAL SCORE` from `terminal_reports` where `SUBJECT`='$subject' and `TERM`='$term' and `CLASS`='$class' and `ACADEMIC YEAR`='$academic_year' and `TOTAL SCORE` < '$prev_score' and `SCHOOL`='$initials'");
                           
                            while($fetch2 = mysqli_fetch_assoc($sql)){
                                $sql_3 = mysqli_query($conn,"select `TOTAL SCORE` from `terminal_reports` where `SUBJECT`='$subject' and `TERM`='$term' and `CLASS`='$class' and `ACADEMIC YEAR`='$academic_year' and `TOTAL SCORE` > '".$fetch2['TOTAL SCORE']."' and `SCHOOL`='$initials'");
                                $counter = mysqli_num_rows($sql_3);
                                
                                $prev_score = $fetch2['TOTAL SCORE'];
                                $pos = '';
                                if($counter == 0){
                                    $pos = ($counter + 1)." st";
                                }else if($counter == 1){
                                    $pos = ($counter + 1)." nd";
                                }else if($counter == 2){
                                    $pos = ($counter + 1)." rd ";
                                }else{
                                     $pos = ($counter + 1)." th ";
                                }
                               
                                mysqli_query($conn,"update `terminal_reports` set `POSITION`='".$pos."' where `TOTAL SCORE` = '$prev_score' and `TERM`='$term' and `ACADEMIC YEAR`='$academic_year'  and `CLASS`='$class' and `SCHOOL`='$initials'");
                            }
                            
                        }
                            
                            //echo mysqli_connect_error();
                        
                    }
                    
                }    
            
            
               

            $average_mark = 0;
            $query = mysqli_query($conn,"select * from `terminal_reports` where `STUDENT ID`='$id' and `TERM`='$term' and `ACADEMIC YEAR`='$academic_year' and `SCHOOL`='$initials'");
            while($fetch_total_score = mysqli_fetch_assoc($query)){
                $average_mark = $average_mark + $fetch_total_score['TOTAL SCORE'];
            }
            
            $count = mysqli_num_rows(mysqli_query($conn,"select * from subjects where `CLASS`='$class' and `SCHOOL`='$initials'"));
            
            
            
          
        $counter ++;
        $average_mark = sprintf('%0.2f',$average_mark / $count);
        mysqli_query($conn,"delete from terminal_reports_av  where `STUDENT ID`='$id' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term' and `CLASS`='$class' and `SCHOOL`='$initials' ");  
            $pass_mark = 0;
            $probation_mark = 0;
            
            $query_grading = mysqli_query($conn,"select * from grading_system where `SCHOOL`='$initials'");
            if($fetch_grading = mysqli_fetch_assoc($query_grading)){

                $pass_mark = $fetch_grading['PASS MARK'];
               
                $probation_mark = $fetch_grading['PROBATION MARK'];
                
            }
            
            $promotion_status ='';
           
            if($promotion == "true"){

                    if($average_mark < $probation_mark){
                        $promotion_status = 'REPEATED';
                    }else if($average_mark >= $probation_mark && $average_mark <$pass_mark){
                            $promotion_status = 'PROBATION';
                    }
                    else{
                        $promotion_status = 'PROMOTED';
                    }

            }
        mysqli_query($conn,"INSERT INTO `terminal_reports_av` (`ID`, `SCHOOL`, `CLASS`, `STUDENT ID`,`STUDENT NAME`, `ACADEMIC YEAR`, `TERM`, `OVERALL POSITION`, `AVERAGE MARK`,`PROMOTION STATUS`,`VIEWED`,`SMS SENT`) VALUES (NULL, '$initials', '$class', '$id','$student_name', '$academic_year', '$term', '', '$average_mark','$promotion_status','','');");
            echo mysqli_connect_error($conn);
            }
        echo 'success';
        }
        
        
    
    
?>