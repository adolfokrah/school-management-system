<?php
include '../includes/school_ini_user_id.php';

require_once 'tcpdf/tcpdf.php';
include '../includes/get_currencies.php';
function fetchdata($initials,$conn,$currency){
            $student_id = "";    
            $academic_year = "";
            $term = "";
            $school_logo = '';
            $school_name = '';
            $school_moto='';
            $schoo_location='';
            $shcool_numbers='';
            $student_name='';
            $class = '';
    
    if(isset($_GET['student_id']) && !empty($_GET['student_id']) && isset($_GET['academic_year']) && !empty($_GET['academic_year'])&&isset($_GET['term']) && !empty($_GET['term'])){
            $student_id = $_GET['student_id'];    
            $academic_year = $_GET['academic_year'];
            $term = $_GET['term'];
            $query_pick_student_name = mysqli_query($conn,"select * from admitted_students where `ADMISSION NO / ID`='$student_id'");
            if($fetch3 = mysqli_fetch_assoc($query_pick_student_name)){
                $student_name = $fetch3['STUDENT LAST NAME'].' '.$fetch3['STUDENT  FIRST NAME'];
                $class = $fetch3['PRESENT CLASS'];
            }
       
    }
    
            include '../includes/get_currencies.php';
            $query2 = mysqli_query($conn,"select * from `school_details` where `INITIALS` = '$initials'");
            if($fetch2 = mysqli_fetch_assoc($query2)){
                $school_logo = $fetch2['CREST'];
                $school_name = strtoupper(htmlentities($fetch2['SCHOOL NAME']));
                $school_moto = strtoupper(htmlentities($fetch2['SCHOOL MOTO']));
                $schoo_location= strtoupper(htmlentities($fetch2['COUNTRY'].' - '.$fetch2['CITY/TOWN']));
                $shcool_numbers  = strtoupper(htmlentities($fetch2['SCHOOL NUMBERS']));
            }
    
            $output = '
             
                <table cellpadding="5px" style="border:0.5px dashed #000; font-size:10px;">
                    <tbody> 
                          <tr>
                             <td style="width:20%"><img src="../image_uploads_crests/'.$school_logo.'" width="250px;"/></td>
                             <td style="font-size:14px; font-family:arial;width:80%;"><strong>'.$school_name.'</strong><br/>'.$school_moto.'<br/>'.$schoo_location.'<br/>'.$shcool_numbers.'</td> 
                            
                          </tr> 
                            <tr>
                                <td style="border:0.5px solid #000; font-size:10px; text-align:center; width:100%"><strong>FEES PAYMENT TRANSCRIPT</strong></td>
                            </tr>
                            <tr>
                                <td style="border:0.5px solid #000; font-size:10px;width:100%">Academic Year: <strong>'.$academic_year.'</strong><br/><br/>
                                    Term: <strong>'.$term.'</strong><br/><br/>
                                    Class: <strong>'.$class.'</strong><br/><br/>
                                    Student Name: <strong>'.$student_name.'</strong><br/><br/>
                                    Student ID: <strong>'.$student_id.'</strong>
                                </td>
                            </tr>
                            <tr>
                                <td style="border:0.5px solid #000; font-size:10px;width:20%"><strong>DATE</strong></td>
                                <td style="border:0.5px solid #000; font-size:10px;width:20%"><strong>TIME</strong></td>
                                <td style="border:0.5px solid #000; font-size:10px;width:20%"><strong>AMONT PAID</strong></td>
                                <td style="border:0.5px solid #000; font-size:10px;width:20%"><strong>BLANCE</strong></td>
                                <td style="border:0.5px solid #000; font-size:10px;width:20%"><strong>DEBIT</strong></td>
                            </tr>
                            ';
    
                            $query_pick_fees_records = mysqli_query($conn,"select * from daily_fees_payments where `SCHOOL`='$initials' and `STUDENT ID`='$student_id' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term'");
                            $total_amount = 0;
                            $total_credit = 0;
                            $total_debit = 0;
                            while($fetch = mysqli_fetch_assoc($query_pick_fees_records)){
                            $total_amount = $total_amount + $fetch['AMOUNT PAID'];
                            $total_credit = $total_credit + $fetch['CREDIT'];
                            $total_debit = $total_debit + $fetch['DEBIT'];
                                $output .='<tr>
                                <td style="font-size:10px; width:20%">'.$fetch['DATE'].'</td>
                                <td style="font-size:10px; width:20%">'.$fetch['TIME'].'</td>
                                <td style="text-align:right; font-size:10px;width:20%">'.sprintf('%0.2f',$fetch['AMOUNT PAID']).'</td>
                                <td style="text-align:right; font-size:10px;width:20%">'
                                    .sprintf('%0.2f',$fetch['CREDIT']).'</td>
                                <td style="text-align:right; font-size:10px;width:20%">'.sprintf('%0.2f',$fetch['DEBIT']).'</td>
                                </tr>';
                            }
    $output .='<tr>
                        <td style="border-bottom:0.5px solid #000;  border-top:0.5px solid #000; font-size:10px;width:40%"><strong>TOTAL</strong></td>
                        
                        <td style="border-bottom:0.5px solid #000; border-top:0.5px solid #000; text-align:right; font-size:10px;width:20%"><strong>'.$currency.' '.sprintf('%0.2f',$total_amount).'</strong></td>
                        <td style="border-bottom:0.5px solid #000; border-top:0.5px solid #000; text-align:right; font-size:10px;width:20%"></td>
                        <td style="border-bottom:0.5px solid #000; border-top:0.5px solid #000; text-align:right; font-size:10px;width:20%"></td>
                          </tr>
                          
                          <tr><td></td></tr>';
    $query_pick_fees_records1 = mysqli_query($conn,"select * from school_fees where `SCHOOL`='$initials' and `STUDENT ID`='$student_id' and `STATUS`='ACTIVE'");
                                                
                if($fetch = mysqli_fetch_assoc($query_pick_fees_records1)){
                    $output .= '<tr><td style="font-size:10px; width:10%">Fees:</td>
                         <td style="font-size:10px; width:20%; text-align:right;"><strong>'.$currency.' ' .sprintf('%0.2f',$fetch['AMOUNT']).'</strong></td></tr>
                         
                         <tr><td style="font-size:10px; width:10%">Credit:</td>
                         <td style="font-size:10px; width:20%; text-align:right;"><strong>'.$currency.' '.sprintf('%0.2f',$fetch['CREDIT']).'</strong></td></tr>
                         
                         <tr><td style="font-size:10px; width:10%">Debit:</td>
                         <td style="font-size:10px; width:20%; text-align:right;"><strong>'.$currency.' ' .sprintf('%0.2f',$fetch['DEBIT']).'</strong></td></tr>
                         
                        ';
                }
    $output .='
                          
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
$pdf->SetTitle('STUDENT FEES TRANSCRIPT');
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
$pdf->SetFont('Courier', '', 12);

// add a page
$pdf->AddPage();

// Print a text
$html = fetchdata($initials,$conn,$currency);
$pdf->writeHTML($html, true, false, true, false, '');







// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('STUDENT FEES TRANSCRIPT.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>