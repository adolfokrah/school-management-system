<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Easyskul - </title>
    <link href="../web_images/logo2.png" rel="icon" />
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="../css/font-awesome.css">
    <link rel="stylesheet" href="../bootstrap-3.3.7-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css">

    <!--add the tables css-->
    <link rel="stylesheet" type="text/css" href="datatables/dataTables.bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../bootstrap-3.3.7-dist/css/boostrap-select.min.css" />
    <script src="../js/jQuery-v2.1.3.js"></script>
    <script src="../js/bootstrap-select.min.js"></script>
    <script src="sweetalert2-master/dist/sweetalert2.all.min.js"></script>
    <script src="../js/cms.js"></script>
</head>
<style>
    th{
        padding: 5px;
    }
    td{
        padding: 5px;
    }
    #box{
        height: auto;
       
        page-break-after:always;
    }
    
</style>
<body style="background-color:white;">
<?php
include '../includes/school_ini_user_id.php';

require_once 'tcpdf/tcpdf.php';

function fetchdata($initials,$user,$student_id,$academic_year,$term,$conn){
            
            $school_logo = '';
            $school_name = '';
            $school_moto='';
            $schoo_location='';
            $shcool_numbers='';
    
    
            include '../includes/get_currencies.php';
            $query2 = mysqli_query($conn,"select * from `school_details` where `INITIALS` = '$initials'");
            if($fetch2 = mysqli_fetch_assoc($query2)){
                $school_logo = $fetch2['CREST'];
                $school_name = strtoupper(htmlentities($fetch2['SCHOOL NAME']));
                $school_moto = strtoupper(htmlentities($fetch2['SCHOOL MOTO']));
                $schoo_location= strtoupper(htmlentities($fetch2['COUNTRY'].' - '.$fetch2['CITY/TOWN']));
                $shcool_numbers  = strtoupper(htmlentities($fetch2['SCHOOL NUMBERS']));
            }
        
        
            //pick student detial
            $student_name = '';
            
            $student_photo='';
            $class = '';
            $results = '';
            $term_begins = '';
            $term_ends = '';
            $average_mark = 0;
            $total_marks = 0;
            $num_subjects = 0;
            $position = '';
            $grades = '<div class="row"><tbody>';
            $promotion_status='';
        
        $pass_mark = '';
        $exam_mark = '';
        $class_mark = '';
        $A = '';
        $B = '';
        $C = '';
        $D = '';
        $E = '';
        $F = '';
        $promotion = false;
            $query2 = mysqli_query($conn,("select * from terminal_reports where `STUDENT ID`='$student_id' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term'and `SCHOOL`='$initials'"));
            while($fetch = mysqli_fetch_assoc($query2)){
                $class = $fetch['CLASS'];
                $term_begins = $fetch['TERM BEGINS'];
                $term_ends = $fetch['TERM END'];
                $total_marks = $total_marks + $fetch['TOTAL SCORE'];
                $num_subjects++;
                $grades .='
                <tr>
                            <td style="border:0.5px solid #000; width:20%; font-size:12px;">'.$fetch['SUBJECT'].'</td>
                            <td style="border:0.5px solid #000; width:15%; font-size:12px;text-align:center;">'.$fetch['CLASS SCORE'].'</td>
                            <td style="border:0.5px solid #000; width:15%; font-size:12px;text-align:center;">'.$fetch['EXAM SCORE'].'</td>
                            <td style="border:0.5px solid #000; width:15%; font-size:12px;text-align:center;">'.$fetch['TOTAL SCORE'].'</td>
                            <td style="border:0.5px solid #000; width:10%; font-size:12px;text-align:center;">'.$fetch['GRADE'].'</td>
                            <td style="border:0.5px solid #000; width:10%; font-size:12px;text-align:center;">'.$fetch['POSITION'].'</td>
                            <td style="border:0.5px solid #000; width:15%; font-size:12px;text-align:center;">'.$fetch['REMARKS'].'</td>
                        </tr>
                ';
                if($fetch['PROMOTION']=='true'){
                    //check promotion mark
                    $promotion = true;
                }
            }
            $number_row = mysqli_num_rows(mysqli_query($conn,"select * from terminal_reports_av where `SCHOOL`='$initials' and `CLASS`='$class'"));
        
        
            
        
            //check position in class
            $sql_pick_pos = mysqli_query($conn,"select MAX(`AVERAGE MARK`) from `terminal_reports_av` where `TERM`='$term' and `CLASS`='$class' and `ACADEMIC YEAR`='$academic_year' and `SCHOOL`='$initials'");

            $counter =0;
            $prev_score =0;
            
            if($fetch_mark = mysqli_fetch_assoc($sql_pick_pos)){
                $counter ++;
                $pos = '';
                
                $prev_score = $fetch_mark["MAX(`AVERAGE MARK`)"];
                   
                mysqli_query($conn,"update `terminal_reports_av` set `OVERALL POSITION`='1 / ".$number_row."' where `AVERAGE MARK` = '$prev_score' and `TERM`='$term' and `ACADEMIC YEAR`='$academic_year'  and `CLASS`='$class' and `SCHOOL`='$initials'");
                
            }
            
                $sql_2 = mysqli_query($conn,"select `AVERAGE MARK` from `terminal_reports_av` where  `TERM`='$term' and `CLASS`='$class' and `ACADEMIC YEAR`='$academic_year' and `AVERAGE MARK` < '$prev_score' and `SCHOOL`='$initials'");
                
                while($fetch_pos = mysqli_fetch_assoc($sql_2)){
                    
                $sql_4 = mysqli_num_rows(mysqli_query($conn,"select `AVERAGE MARK` from `terminal_reports_av` where  `TERM`='$term' and `CLASS`='$class' and `ACADEMIC YEAR`='$academic_year' and `AVERAGE MARK` > '".$fetch_pos['AVERAGE MARK']."' and `SCHOOL`='$initials'"));
                    
                   $prev_score = $fetch_pos['AVERAGE MARK'];
                   
                    $pos = '';
                    if($sql_4 == 0){
                        $pos = ($sql_4 + 1)." / ".$number_row;
                    }else if($sql_4 == 1){
                        $pos = ($sql_4 + 1)." / ".$number_row; 
                    }else if($sql_4 == 2){
                        $pos = ($sql_4 + 1)." / ".$number_row;
                    }else{
                         $pos = ($sql_4 + 1)." / ".$number_row;
                    }
                    
                    mysqli_query($conn,"update `terminal_reports_av` set `OVERALL POSITION`='".$pos."' where `AVERAGE MARK` = '$prev_score' and `TERM`='$term' and `ACADEMIC YEAR`='$academic_year'  and `CLASS`='$class' and `SCHOOL`='$initials'");
                    
                }
        
            $query1 = mysqli_query($conn,("select * from terminal_reports_av where `STUDENT ID`='$student_id' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term'and `SCHOOL`='$initials'"));
        
            if($fetch_position = mysqli_fetch_assoc($query1)){
                $position = $fetch_position['OVERALL POSITION'];
                $average_mark = $fetch_position['AVERAGE MARK'];
                $promotion_status = $fetch_position['PROMOTION STATUS'];
                //GET ATTEDANCE REPORT
                $all_attendance = 0;
                $present = 0;
                $attendance = mysqli_query($conn,"select * from attendance where `STUDENT ID`='$student_id' and `SCHOOL`='$initials' and `CLASS`='$class' and `TERM`='$term' and `ACADEMIC YEAR`='$academic_year'");
                while($fetch_attendance = mysqli_fetch_assoc($attendance)){
                    $all_attendance ++;
                    if($fetch_attendance['STATUS']=='PRESENT'){
                        $present ++;
                    }
                }
                    $class_mark =0;
                    $exam_mark =0;
                    $query_grading = mysqli_query($conn,"select * from grading_system where `SCHOOL`='$initials'");
                    if($fetch_grading = mysqli_fetch_assoc($query_grading)){

                        $pass_mark = $fetch_grading['PASS MARK'];
                        $exam_mark = $fetch_grading['EXAM MARK'];
                        $class_mark = $fetch_grading['CLASS MARK'];
                        $probation = $fetch_grading['PROBATION MARK'];
                        $A = $fetch_grading['A'];
                        $B = $fetch_grading['B'];
                        $C = $fetch_grading['C'];
                        $D = $fetch_grading['D'];
                        $E = $fetch_grading['E'];
                        $F = $fetch_grading['F'];
                    }
                
                
                $remarks = '';
                if($average_mark > 50 && $average_mark <70){
                    $remarks = 'Not a bad performance, should be more serious with weak subjects.';
                }else if($average_mark > 70){
                    $remarks = 'Well done keep it up.';
                }else{
                    $remarks = 'Should be more serious with weak subjects.';
                }
                $grades .=' </tbody></table>
                    <div class"row" style="border:0.5px solid #000; padding:5px;">
                           ATTENDANCE: <strong>'.$present.' OUT OF '.$all_attendance.'</strong><br/><br/>
                                PROMOTION STATUS: <strong>'.$promotion_status.'</strong><br/><br/>
                                TEACHER\'S REMARKS: <strong>'.$remarks.'</strong>
                            
                            
                    </div>
                    <br/>
                    <div class="row">
                    <div class="col-xs-4 col-xs-offset-3" >
                   <table>
                    <thead>
                        <th style="width:25%"></th>
                        <th style="width:15%; border:0.5px solid #000; font-size:12px; text-align:center;"><strong>GRADING CODE</strong></th>
                        <th style="width:10%; border:0.5px solid #000; font-size:12px; text-align:center;"><strong>GRADE</strong></th>
                        <th style="width:20%; border:0.5px solid #000; font-size:12px; text-align:center;"><strong>REMARKS</strong></th>
                        <th style="width:25%"></th>
                        
                    </thead>
                    <tbody>
                    <tr>
                        <td style="width:25%"></td>
                        <td style="width:15%; border:0.5px solid #000; font-size:12px; text-align:center;">'.$A.' - 100</td>
                        <td style="width:10%; border:0.5px solid #000; font-size:12px; text-align:center;">A</td>
                        <td style="width:20%; border:0.5px solid #000; font-size:12px; text-align:center;">Excellent</td>
                        <td style="width:25%"></td>
                        
                    </tr>
                    <tr>
                        <td style="width:25%"></td>
                        <td style="width:15%; border:0.5px solid #000; font-size:12px; text-align:center;">'.$B.' - '.($A-1).'</td>
                        <td style="width:10%; border:0.5px solid #000; font-size:12px; text-align:center;">B</td>
                        <td style="width:20%; border:0.5px solid #000; font-size:12px; text-align:center;">Very Good</td>
                        <td style="width:25%"></td>
                        
                    </tr>
                    <tr>
                        <td style="width:25%"></td>
                        <td style="width:15%; border:0.5px solid #000; font-size:12px; text-align:center;">'.$C.' - '.($B-1).'</td>
                        <td style="width:10%; border:0.5px solid #000; font-size:12px; text-align:center;">C</td>
                        <td style="width:20%; border:0.5px solid #000; font-size:12px; text-align:center;">Credit</td>
                        <td style="width:25%"></td>
                        
                    </tr>
                    <tr>
                        <td style="width:25%"></td>
                        <td style="width:15%; border:0.5px solid #000; font-size:12px; text-align:center;">'.$D.' - '.($C-1).'</td>
                        <td style="width:10%; border:0.5px solid #000; font-size:12px; text-align:center;">D</td>
                        <td style="width:20%; border:0.5px solid #000; font-size:12px; text-align:center;">Good</td>
                        <td style="width:25%"></td>
                        
                    </tr>
                    <tr>
                        <td style="width:25%"></td>
                        <td style="width:15%; border:0.5px solid #000; font-size:12px; text-align:center;">'.$E.' - '.($D-1).'</td>
                        <td style="width:10%; border:0.5px solid #000; font-size:12px; text-align:center;">E</td>
                        <td style="width:20%; border:0.5px solid #000; font-size:12px; text-align:center;">Pass</td>
                        <td style="width:25%"></td>
                        
                    </tr>
                    <tr>
                        <td style="width:25%"></td>
                        <td style="width:15%; border:0.5px solid #000; font-size:12px; text-align:center;"> 0 - '.($E-1).'</td>
                        <td style="width:10%; border:0.5px solid #000; font-size:12px; text-align:center;">F</td>
                        <td style="width:20%; border:0.5px solid #000; font-size:12px; text-align:center;">Fail</td>
                        <td style="width:25%"></td>
                        
                    </tr>
                    </tbody>
                    </table>
                    </div>
                    </div>
             ';
            }
        
        
            $query_pick_stuent_info = mysqli_query($conn,"select * from admitted_students where `ADMISSION NO / ID`='$student_id' and `SCHOOL`='$initials'");
            if($fetch_info = mysqli_fetch_assoc($query_pick_stuent_info)){
                $student_name = $fetch_info['STUDENT LAST NAME'].' '.$fetch_info['STUDENT  FIRST NAME'];
                $student_photo = $fetch_info['PHOTO'];
            }
        
            $output = '
             
                <div >
                    <div > 
                          <div style="border:2px dashed #000; font-size:12px; border-radius:20px; padding:10px;" class="row">
                             <div class="col-xs-3"><img src="../image_uploads_crests/'.$school_logo.'" class="img img-responsive"/></div>
                             <div style="font-size:14px;  text-align:center" class="col-xs-6"><strong>'.$school_name.'</strong><br/>'.$school_moto.'<br/>'.$schoo_location.'<br/>'.$shcool_numbers.'</div> 
                             <div class="col-xs-3"><img src="upload/'.$student_photo.'" width="100px;"/></div>
                             
                          </div> 
                          <div class="row"><div  class="col-xs-12" style="text-align:center;"><strong>TERMINAL REPORT</strong></div></div>
                          
                          <div class="row" style=" border:thin solid #000; ">
                              <div class="col-xs-6" style="border-right:2px solid #000;  padding:10px;">STUDENT ID: <strong>'.$student_id.'</strong><br/><br/>
                                  STUDENT NAME: <strong>'.htmlentities(strtoupper($student_name)).'</strong><br/><br/>
                                  CLASS: <strong>'.htmlentities(strtoupper($class)).'</strong><br/><br/>
                                  ACADEMIC YEAR: <strong>'.$academic_year.'</strong> TERM: <strong>'.$term.'</strong>
                              
                                 </div>
                                 
                              <div class="col-xs-6" style="padding:10px">NEXT TERM BEGINS: <strong>'.$term_begins.'</strong><br/><br/>
                              NO. ON ROLL: <strong>'.$number_row.'</strong><br/><br/>
                              POSITION IN CLASS: <strong>'.$position.'</strong><br/><br/>
                              STUDENT\'S AVERAGE MARK: <strong>'.$average_mark.'</strong> 
                              </div>
                              </div>
                        
                            <div class="row" id="box">
                                
                                     <table >
                                  <thead>
                                    <th style="border:0.5px solid #000; width:20%; font-size:12px;"><strong>SUBJECT</strong></th>
                                    <th style="border:0.5px solid #000; width:15%; font-size:12px;text-align:center;"><strong>CLASS SCORE <br/>'.$class_mark.'%</strong></th>
                                    <th style="border:0.5px solid #000; width:15%; font-size:12px;text-align:center;"><strong>EXAM SCORE <br/>'.$exam_mark.'%</strong></th>
                                    <th style="border:0.5px solid #000; width:15%; font-size:12px;text-align:center;"><strong>TOTAL SCORE <br/>100%</strong></th>
                                    <th style="border:0.5px solid #000; width:10%; font-size:12px;text-align:center;"><strong>GRADE</strong></th>
                                    <th style="border:0.5px solid #000; width:10%; font-size:12px;text-align:center;"><strong>POSITION IN SUB.</strong></th>
                                    <th style="border:0.5px solid #000; width:15%; font-size:12px;text-align:center;"><strong>REMAKRS</strong></th>
                                   
                                </thead>
                            </div>
                         
                         
                         ';
        $output .=$grades.'</div><br/><hr/>';
        
        
       
        
        return $output;
    
}

?>

<div style="width:900px; margin:auto;">
<?php if(isset($_GET['class']) && !empty($_GET['class']) && isset($_GET['academic_year']) && !empty($_GET['academic_year'])&&isset($_GET['term']) && !empty($_GET['term'])){
    $class = $_GET['class'];    
    $academic_year = $_GET['academic_year'];
    $term = $_GET['term'];
    $query= mysqli_query ($conn,"select * from `terminal_reports_av` where `SCHOOL`='$initials' and `CLASS`='$class' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term' order by `STUDENT NAME` asc");
    while($fetch = mysqli_fetch_assoc($query)){
        $student_id = $fetch['STUDENT ID'];
       echo  fetchdata($initials,$user,$student_id,$academic_year,$term,$conn);
    }
}
?>
</div>
    
<!-- jQuery CDN -->

    <!-- Bootstrap Js CDN -->
    <script src="../js/boostrap.min.js"></script>

    <!--add the table js-->
    <script src="datatables/jquery.dataTables.min.js" id="script1"></script>
    <script src="datatables/dataTables.bootstrap.min.js" id="script2"></script>
    <script src="../js/table.js" id="script3"></script>
    <script src="bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script src="bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>
    <script>window.print()</script>
   
</body>
</html>