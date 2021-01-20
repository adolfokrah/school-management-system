<?php
include '../includes/school_ini_user_id.php';

require_once 'tcpdf/tcpdf.php';

function fetchdata($initials,$user,$conn){
            $student_id = "";    
            $academic_year = "";
            $term = "";
            $school_logo = '';
            $school_name = '';
            $school_moto='';
            $schoo_location='';
            $shcool_numbers='';
    
    
    if(isset($_GET['student_id']) && !empty($_GET['student_id']) && isset($_GET['academic_year']) && !empty($_GET['academic_year'])&&isset($_GET['term']) && !empty($_GET['term'])){
            $student_id = $_GET['student_id'];    
            $academic_year = $_GET['academic_year'];
            $term = $_GET['term'];
            
        if(strpos($user,'-AD') || strpos($user,'-DE')){
            
        }else{
            
             $user  = str_replace('-PT','-STD',$user);
            
             $query3 = mysqli_query($conn,"select * from school_fees where `ACADEMIC YEAR`='$academic_year' and `TERM`='$term' and `STATUS`='ACTIVE' and `DEBIT`>'0' and `SCHOOL`='$initials' and `STUDENT ID`='$student_id'");
//             if($fetch = mysqli_fetch_assoc($query3)){
//                 echo 'Sorry! Please make payment of your fees debit before viewing report.';
//                 echo '<br/> <strong>Debit: GHS '.sprintf('%0.2f',$fetch['DEBIT']).'</strong>';
//                 die();
//             }
            
             $query2 = mysqli_query($conn,"select * from `terminal_reports_av` where `VIEWED`='yes' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term' and `STUDENT ID`='$user'");
            
            if(mysqli_num_rows($query2) < 1 || $user != $student_id){
                die("You don't have permission to check result");
            }
        }
    }else if(isset($_SESSION['voucher_code']) && !empty($_SESSION['voucher_code'])){
        $voucher_code = $_SESSION['voucher_code'];
        $num_rows = mysqli_query($conn,"select * from `results_vouchers` where `CODE`='$voucher_code'");
        if(mysqli_num_rows($num_rows) < 1){
        die("You don't have permission to check result. Please purchase a voucher code or check your result histories and view it again, only if you have already check it.");
            
        }
        
       
        
         mysqli_query($conn,"delete from  `results_vouchers`  where `CODE`='$voucher_code'");
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $id = $_GET['id'];
            $query_report = mysqli_query($conn,"select * from `terminal_reports_av` where `ID`='$id'");
            if($fetch_report = mysqli_fetch_assoc($query_report)){
                $student_id = $fetch_report['STUDENT ID'];    
                $academic_year = $fetch_report['ACADEMIC YEAR'];
                $term = $fetch_report['TERM'];
                
                 $query3 = mysqli_query($conn,"select * from school_fees where `ACADEMIC YEAR`='$academic_year' and `TERM`='$term' and `STATUS`='ACTIVE' and `DEBIT`>'0' and `SCHOOL`='$initials' and `STUDENT ID`='$student_id'");
             if($fetch = mysqli_fetch_assoc($query3)){
                 echo 'Sorry! Please make payment of your fees debit before viewing report.';
                 echo '<br/> <strong>Debit: GHS '.sprintf('%0.2f',$fetch['DEBIT']).'</strong>';
                 die();
             }
                
            }
        }
        
        $_SESSION['voucher_code']='';
        
    }else{
        die("You don't have permission to check result. Please purchase a voucher code or check your result histories and view it again, only if you have already check it.");
    }
            include '../includes/get_currencies.php';
            $query2 = mysqli_query($conn,"select * from `school_details` where `INITIALS` = '$initials'");
            $posA = 'true';
            if($fetch2 = mysqli_fetch_assoc($query2)){
                $school_logo = $fetch2['CREST'];
                $school_name = strtoupper(htmlentities($fetch2['SCHOOL NAME']));
                $school_moto = strtoupper(htmlentities($fetch2['SCHOOL MOTO']));
                $schoo_location= strtoupper(htmlentities($fetch2['COUNTRY'].' - '.$fetch2['CITY/TOWN']));
                $shcool_numbers  = strtoupper(htmlentities($fetch2['SCHOOL NUMBERS']));
                if($fetch2['POS']!=''){
                    $posA = 'false';
                }
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
            $grades = '';
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
                            <td style="border:0.5px solid #000; width:20%; font-size:13px;;">'.$fetch['SUBJECT'].'</td>
                            <td style="border:0.5px solid #000; width:15%; font-size:13px;;text-align:center;">'.$fetch['CLASS SCORE'].'</td>
                            <td style="border:0.5px solid #000; width:15%; font-size:13px;;text-align:center;">'.$fetch['EXAM SCORE'].'</td>
                            <td style="border:0.5px solid #000; width:15%; font-size:13px;;text-align:center;">'.$fetch['TOTAL SCORE'].'</td>
                            <td style="border:0.5px solid #000; width:10%; font-size:13px;;text-align:center;">'.$fetch['GRADE'].'</td>
                            <td style="border:0.5px solid #000; width:10%; font-size:13px;;text-align:center;">'.$fetch['POSITION'].'</td>
                            <td style="border:0.5px solid #000; width:15%; font-size:13px;;text-align:center;">'.$fetch['REMARKS'].'</td>
                        </tr>
                ';
                if($fetch['PROMOTION']=='true'){
                    //check promotion mark
                    $promotion = true;
                }
            }
            $number_row = mysqli_num_rows(mysqli_query($conn,"select * from terminal_reports_av where `TERM`='$term' and `CLASS`='$class' and `ACADEMIC YEAR`='$academic_year'"));
        
            
        
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
                if($posA == 'true'){
                    $position = $fetch_position['OVERALL POSITION'];
                }
                
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
                if($average_mark >= 70){
                    $remarks = 'Good work keep it up';
                }elseif($average_mark > 50 && $average_mark < 70){
                    $remarks = 'Good work more room for improvement';
                }elseif($average_mark > 40 && $average_mark <= 50){
                    $remarks = 'Can do better';
                }elseif($average_mark >30 && $average_mark <= 40){
                    $remarks = 'situp';
                }else{
                    $remarks = 'Poor work done. You need to situp';
                }
                
                $grades .='
                    <tr>
                            <td style="border:0.5px solid #000; width:100%; font-size:13px;;">
                                PROMOTION STATUS: <strong>'.$promotion_status.'</strong><br/><br/>
                                TEACHER\'S REMARKS: <strong>'.$remarks.'</strong>
                            </td>
                            
                    </tr>
                    <tr>
                        <td style="width:100%"></td>
                    </tr>
                    <tr>
                        <td style="width:25%"></td>
                        <td style="width:15%; border:0.5px solid #000; font-size:8px; text-align:center;"><strong>GRADING CODE</strong></td>
                        <td style="width:10%; border:0.5px solid #000; font-size:8px; text-align:center;"><strong>GRADE</strong></td>
                        <td style="width:20%; border:0.5px solid #000; font-size:8px; text-align:center;"><strong>TEACHERS REMARKS</strong></td>
                        <td style="width:25%"></td>
                        
                    </tr>
                    <tr>
                        <td style="width:25%"></td>
                        <td style="width:15%; border:0.5px solid #000; font-size:13px;; text-align:center;">'.$A.' - 100</td>
                        <td style="width:10%; border:0.5px solid #000; font-size:13px;; text-align:center;">A</td>
                        <td style="width:20%; border:0.5px solid #000; font-size:13px;; text-align:center;">Excellent</td>
                        <td style="width:25%"></td>
                        
                    </tr>
                    <tr>
                        <td style="width:25%"></td>
                        <td style="width:15%; border:0.5px solid #000; font-size:13px;; text-align:center;">'.$B.' - '.($A-1).'</td>
                        <td style="width:10%; border:0.5px solid #000; font-size:13px;; text-align:center;">B</td>
                        <td style="width:20%; border:0.5px solid #000; font-size:13px;; text-align:center;">Very Good</td>
                        <td style="width:25%"></td>
                        
                    </tr>
                    <tr>
                        <td style="width:25%"></td>
                        <td style="width:15%; border:0.5px solid #000; font-size:13px;; text-align:center;">'.$C.' - '.($B-1).'</td>
                        <td style="width:10%; border:0.5px solid #000; font-size:13px;; text-align:center;">C</td>
                        <td style="width:20%; border:0.5px solid #000; font-size:13px;; text-align:center;">Credit</td>
                        <td style="width:25%"></td>
                        
                    </tr>
                    <tr>
                        <td style="width:25%"></td>
                        <td style="width:15%; border:0.5px solid #000; font-size:13px;; text-align:center;">'.$D.' - '.($C-1).'</td>
                        <td style="width:10%; border:0.5px solid #000; font-size:13px;; text-align:center;">D</td>
                        <td style="width:20%; border:0.5px solid #000; font-size:13px;; text-align:center;">Good</td>
                        <td style="width:25%"></td>
                        
                    </tr>
                    <tr>
                        <td style="width:25%"></td>
                        <td style="width:15%; border:0.5px solid #000; font-size:13px;; text-align:center;">'.$E.' - '.($D-1).'</td>
                        <td style="width:10%; border:0.5px solid #000; font-size:13px;; text-align:center;">E</td>
                        <td style="width:20%; border:0.5px solid #000; font-size:13px;; text-align:center;">Pass</td>
                        <td style="width:25%"></td>
                        
                    </tr>
                    <tr>
                        <td style="width:25%"></td>
                        <td style="width:15%; border:0.5px solid #000; font-size:13px;; text-align:center;"> 0 - '.($E-1).'</td>
                        <td style="width:10%; border:0.5px solid #000; font-size:13px;; text-align:center;">F</td>
                        <td style="width:20%; border:0.5px solid #000; font-size:13px;; text-align:center;">Fail</td>
                        <td style="width:25%"></td>
                        
                    </tr>
             ';
            }
        
        
            $query_pick_stuent_info = mysqli_query($conn,"select * from admitted_students where `ADMISSION NO / ID`='$student_id' and `SCHOOL`='$initials'");
            if($fetch_info = mysqli_fetch_assoc($query_pick_stuent_info)){
                $student_name = $fetch_info['STUDENT LAST NAME'].' '.$fetch_info['STUDENT  FIRST NAME'];
                $student_photo = $fetch_info['PHOTO'];
            }
        
            $output = '
             
                <table cellpadding="5px" style="border:0.5px dashed #000; font-size:13px;;">
                    <tbody> 
                          <tr>
                             <td style="width:20%"><img src="../image_uploads_crests/'.$school_logo.'" width="250px;"/></td>
                             <td style="font-size:24px;; font-family:arial;width:60%; text-align:center"><strong>'.$school_name.'</strong><br/>'.$school_moto.'<br/>'.$schoo_location.'<br/>'.$shcool_numbers.'</td> 
                             <td style="width:20%"><img src="upload/'.$student_photo.'" width="100px;"/></td>
                          </tr> 
                          <tr><td  style="width:100%; text-align:center;"><strong>TERMINAL REPORT</strong></td></tr>
                          <tr>
                              <td style="border:0.5px solid #000; width:60%">STUDENT ID: <strong>'.$student_id.'</strong><br/><br/>
                                  STUDENT NAME: <strong>'.htmlentities(strtoupper($student_name)).'</strong><br/><br/>
                                  CLASS: <strong>'.htmlentities(strtoupper($class)).'</strong><br/><br/>
                                  ACADEMIC YEAR: <strong>'.$academic_year.'</strong> TERM: <strong>'.$term.'</strong>
                              
                                 </td>
                              <td style="border:0.5px solid #000; width:40%">NEXT TERM BEGINS: <strong>'.$term_begins.'</strong><br/><br/>
                              NO. ON ROLL: <strong>'.$number_row.'</strong><br/><br/>
                              POSITION IN CLASS: <strong>'.$position.'</strong><br/><br/>
                              STUDENT\'S AVERAGE MARK: <strong>'.$average_mark.'</strong> 
                              </td>
                          </tr>
                          <tr>
                            <td style="border:0.5px solid #000; width:20%; font-size:8px;"><strong>SUBJECT</strong></td>
                            <td style="border:0.5px solid #000; width:15%; font-size:8px;text-align:center;"><strong>CLASS SCORE <br/>'.$class_mark.'%</strong></td>
                            <td style="border:0.5px solid #000; width:15%; font-size:8px;text-align:center;"><strong>EXAM SCORE <br/>'.$exam_mark.'%</strong></td>
                            <td style="border:0.5px solid #000; width:15%; font-size:8px;text-align:center;"><strong>TOTAL SCORE <br/>100%</strong></td>
                            <td style="border:0.5px solid #000; width:10%; font-size:8px;text-align:center;"><strong>GRADE</strong></td>
                            <td style="border:0.5px solid #000; width:10%; font-size:8px;text-align:center;"><strong>POSITION IN SUB.</strong></td>
                            <td style="border:0.5px solid #000; width:15%; font-size:8px;text-align:center;"><strong>REMAKRS</strong></td>
                        </tr>
                         
                         
                         ';
        $output .=$grades.'<tr>
                            <td style="width:100%"></td>
                         </tr><tr>';
        
        $output .='<td style="font-size:13px;; width:100%">
                        © 2017 https://www.easyskul.com | Developed by Pectra Solutions
                    </td></tr> 
                   </tbody>
                   </table>
                        
                        ';
       
        
        return $output;
    
}
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		// get the current page break margin
		$bMargin = $this->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $this->AutoPageBreak;
		// disable auto-page-break
		$this->SetAutoPageBreak(false, 0);
		// set bacground image
		$img_file = K_PATH_IMAGES.'image_demo.jpg';
		$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$this->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$this->setPageMark();
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('PECTRA SOLUIONS');
$pdf->SetTitle('STUDENT TERMINAL REPORT');
$pdf->SetSubject('EASYSKUL');
$pdf->SetKeywords('TCPDF, PDF, PROFILE, test, guide');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(5, 5, 5);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

// remove default footer
$pdf->setPrintFooter(false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 12);

// add a page
$pdf->AddPage();

// Print a text
$html = fetchdata($initials,$user,$conn);
$pdf->writeHTML($html, true, false, true, false, '');







// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('STUDENT TERMINAL REPORT.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>