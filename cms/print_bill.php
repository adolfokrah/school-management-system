<?php
include '../includes/school_ini_user_id.php';
require_once 'tcpdf/tcpdf.php';

function fetchdata($initials,$conn){
include '../includes/get_currencies.php';
    
    if(isset($_GET['student_id']) && !empty($_GET['student_id'])){
        $student_id = $_GET['student_id'];
        $fields = array();
        
        
            $school_logo = '';
            $school_name = '';
            $school_moto='';
            $schoo_location='';
            $shcool_numbers='';
            $query2 = mysqli_query($conn,"select * from `school_details` where `INITIALS` = '$initials'");
            if($fetch2 = mysqli_fetch_assoc($query2)){
                $school_logo = $fetch2['CREST'];
                $school_name = strtoupper(htmlentities($fetch2['SCHOOL NAME']));
                $school_moto = strtoupper(htmlentities($fetch2['SCHOOL MOTO']));
                $schoo_location= strtoupper(htmlentities($fetch2['COUNTRY'].' - '.$fetch2['CITY/TOWN']));
                $shcool_numbers  = strtoupper(htmlentities($fetch2['SCHOOL NUMBERS']));
            }
            
            $academic_year = '';
            $term = '';
        
            $query_select_academic = mysqli_query($conn,"select * from `academic_years` where `SCHOOL`='$initials' and `STATUS`='ACTIVE'");
            if($fetch_year = mysqli_fetch_assoc($query_select_academic)){
                $academic_year = $fetch_year['ACADEMIC YEAR'];
                $term = $fetch_year['TERM'];
            }
            
            //SELECT STUDENT
            $student_name = '';
            $student_class = '';
            $query_pick_student = mysqli_query($conn,"select * from admitted_students where `ADMISSION NO / ID`='$student_id'");
            if($fetch = mysqli_fetch_assoc($query_pick_student)){
                $student_name = $fetch['STUDENT LAST NAME'].' '.$fetch['STUDENT  FIRST NAME'];
                $student_class = $fetch['PRESENT CLASS'];
            }
            $output = '<table cellpadding="5px;" style="border:0.5 dashed #000">
                    <tbody> 
                             <tr>
                             <td style="width:20%"><img src="../image_uploads_crests/'.$school_logo.'" width="250px;"/></td>
                             <td style="font-size:24px;; font-family:arial;width:80%"><strong>'.$school_name.'</strong><br/>'.$school_moto.'<br/>'.$schoo_location.'<br/>'.$shcool_numbers.'</td> 
                            </tr> 
                            <tr>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:100%"><strong>BILL SHEET</strong></td>
                            
                            </tr>
                            <tr>
                                <td style="width:100%"></td>
                            </tr>
                             <tr>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; width:100%"><strong>NAME</strong>: '.$student_name.'<br/><br/>
                            <strong>STUDENT ID</strong> '.$student_id.'<br/><br/>
                            <strong>CLASS</strong>: '.$student_class.'<br/><br/>
                                <strong>ACADEMIC YEAR</strong>:'.$academic_year.'<br/><br/>
                                <strong>TERM</strong>: '.$term.'
                                
                            </td>
                            
                            
                            </tr>
                            
                            <tr>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%"><strong>#</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:40%"><strong>ITEM</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:20%"><strong>QTY</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:30%"><strong>AMOUNT</strong></td>
                            
                        </tr>';
                        $counter = 0;
                        $total_amount = 0;
                        $query2 = mysqli_query($conn,"select * from bills where `STUDENT ID` ='$student_id' and `SCHOOL`= '$initials' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term'");
                        while($fetch_fee = mysqli_fetch_assoc($query2)){
                            $counter ++;
                            $total_amount = $total_amount + $fetch_fee['PRICE'];
                            $output .='
                                <tr>
                            
                                    <td style="border:0.5px solid #000; font-size:13px;; width:10%"><strong>'.$counter.'</strong></td>
                                    <td style="border:0.5px solid #000; font-size:13px;; width:40%">'.htmlentities($fetch_fee['ITEM']).'</td>
                                    <td style="border:0.5px solid #000; font-size:13px;; width:20%">'.htmlentities($fetch_fee['QUANTITY']).'</td>
                                    <td style="border:0.5px solid #000; font-size:13px;; width:30%">'.sprintf('%0.2f',$fetch_fee['PRICE']).'</td>

                                </tr>
                            ';
                            
                        }
                        $previous_arreas = 0;
                        $previous_credit = 0;
                        //PICK PREVIOUS TERM ARREAS
                        $query_pick_arreas = mysqli_query($conn,"select * from school_fees where `STUDENT ID`='$student_id' and `SCHOOL`='$initials' and `FROM`='Y'");
                        if($pick = mysqli_fetch_assoc($query_pick_arreas)){
                            $previous_arreas = $pick['DEBIT'];
                            $previous_credit = $pick['CREDIT'];
                            
                        }
                        $output .= '<tr>
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%"><strong>'.($counter+1).'</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:60%">PREVIOUS TERM ARREAS</td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:30%"> '.sprintf('%0.2f',$previous_arreas).'</td>
                            </tr>
                            <tr>
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%"><strong>'.($counter+1).'</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:60%">PREVIOUS TERM BALANCE</td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:30%"> -'.sprintf('%0.2f',$previous_credit).'</td>
                            </tr>
                            ';
                        
                        $payment = 0;
                        $credit =0;
                        $debit = 0;
                        $query_pick_fees = mysqli_query($conn,"select * from school_fees where `STUDENT ID`='$student_id' and `SCHOOL`='$initials' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term'");
                        if($fetch_sfee = mysqli_fetch_assoc($query_pick_fees)){
                           
                            $payment = $fetch_sfee['PAYMENT'];
                            $credit = $fetch_sfee['CREDIT'];
                            $debit = $fetch_sfee['DEBIT'];
                            
                        }else{
                            $credit = $previous_credit;
                            $debit = $previous_arreas;
                        }
                $output .='<tr>
                            <td style="border:0.5px solid #000; font-size:13px;; width:70%"><strong>TOTAL</strong></td>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; width:30%">'.$currency.' '.sprintf('%0.2f',$previous_arreas+$total_amount).'</td>
                            </tr>';
           
        $output .='</tbody><br/><br/>
            <tbody>
                            <tr>
                            <td style="border:0.5px solid #000; font-size:13px;; width:70%"><strong>PAYMENT</strong></td>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; width:30%">'.$currency.' '.sprintf('%0.2f',$payment).'</td>
                            </tr>
                            <tr>
                            <td style="border:0.5px solid #000; font-size:13px;; width:70%"><strong>ARREARS</strong></td>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; width:30%">'.$currency.' '.sprintf('%0.2f',$debit).'</td>
                            </tr>
                            <tr>
                            <td style="border:0.5px solid #000; font-size:13px;; width:70%"><strong>BALANCE</strong></td>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; width:30%">'.$currency.' '.sprintf('%0.2f',$credit).'</td>
                            </tr>

            </tbod>
        </table>
        ';
         return $output;
         
    }
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
$pdf->SetTitle('STUDENT BILL');
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
$html = fetchdata($initials,$conn);

$pdf->writeHTML($html, true, false, true, false, '');







// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('BILL SHEET.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>