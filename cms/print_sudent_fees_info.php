<?php
include '../includes/mysql_connect.php';
require_once 'tcpdf/tcpdf.php';

function fetchdata($conn){
    
    if(isset($_GET['student_id']) && !empty($_GET['student_id']) && isset($_GET['search']) && !empty($_GET['search'])){
        $student_id = $_GET['student_id'];
        $search = $_GET['search'];
        $fields = array();
        $query = mysqli_query($conn,"select * from `admitted_students` where `ADMISSION NO / ID` = '$student_id'");
        
        if($fetch = mysqli_fetch_assoc($query)){
            $fields[0]=$fetch['STUDENT  FIRST NAME'];
            $fields[1]=$fetch['STUDENT LAST NAME'];
            
            //STUDENT INFORMATION
            
            //pick school details
            $str_pos = strpos($student_id,'-');
            $initials = substr($student_id,0,$str_pos);
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
            
            $output = '
             
                <table cellpadding="5px;" style="border:0.5 dashed #000">
                    <tbody> 
                             <tr>
                             <td style="width:20%"><img src="../image_uploads_crests/'.$school_logo.'" width="250px;"/></td>
                             <td style="font-size:24px;; font-family:arial;width:80%"><strong>'.$school_name.'</strong><br/>'.$school_moto.'<br/>'.$schoo_location.'<br/>'.$shcool_numbers.'</td> 
                            </tr> 
                       </tbody>
                       <tbody>
                            <tr>
                                <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:100%;"><center><strong>STUDENT INFORMATION</strong></center></td>
                                
                            </tr>
                            <tr>
                            
                            <td style="font-size:13px;; width:100%; font-family:verdana; border:0.5px solid #000;"><strong>FIRST NAME: </strong>'.$fields[0].'<br/><br/><strong>LAST NAME: </strong>'.$fields[1].'<br/><br/><strong>STUDENT ID:</strong> '.$student_id.'
                            </td>
                        </tr>
                        <tr>
                            <td style="width:100%"></td>
                        </tr>
                        <tr>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center;"><center><strong>STUDENT SCHOOL FEES INFORMATION</strong></center></td>
                        </tr>
                        
                        
                     
                
            ';
            $query_pick_fees='';
            if($search == 'all'){
                $query_pick_fees = mysqli_query($conn,"select * from school_fees where `STUDENT ID`='$student_id' order by  `TERM` and `ACADEMIC YEAR` asc");
               
            }else{
                $query_pick_fees=mysqli_query($conn,"select * from school_fees where `STUDENT ID` = '".$student_id."' and `ACADEMIC YEAR` like '".$search."%' or `STUDENT ID` = '".$student_id."' and `TERM` like '".$search."%'  or `STUDENT ID` = '".$student_id."' and `ID` like '".$search."%' order by `TERM` and `ACADEMIC YEAR` asc");
            }
            
           
            $output .='
                    <tr>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%"><strong>#</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:20%"><strong>ACADEMIC YEAR</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%"><strong>TERM</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:15%"><strong>FEES</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:15%"><strong>PAYMENT</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:15%"><strong>DEBIT</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:15%"><strong>CREDIT</strong></td>
                            
                        </tr>
                        
                    ';
                $counter = 0;
                while($fetch_fees = mysqli_fetch_assoc($query_pick_fees)){
                    $counter ++;
                    $output .= '<tr>
                        <td style="border:0.5px solid #000; font-size:13px;; width:10%">'.$counter.'</td>
                        <td style="border:0.5px solid #000; font-size:13px;; width:20%">'.$fetch_fees['ACADEMIC YEAR'].'</td>
                        <td style="border:0.5px solid #000; font-size:13px;; width:10%">'.$fetch_fees['TERM'].'</td>
                        <td style="border:0.5px solid #000; font-size:13px;; width:15%">'.sprintf('%0.2f',$fetch_fees['AMOUNT']).'</td>
                        <td style="border:0.5px solid #000; font-size:13px;; width:15%">'.sprintf('%0.2f',$fetch_fees['PAYMENT']).'</td>
                        <td style="border:0.5px solid #000; font-size:13px;; width:15%">'.sprintf('%0.2f',$fetch_fees['DEBIT']).'</td>
                        <td style="border:0.5px solid #000; font-size:13px;; width:15%">'.sprintf('%0.2f',$fetch_fees['CREDIT']).'</td>
                    </tr>
                    <tr>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:100%; color:blue;"><strong>DAILY PAYMENTS</strong></td>
                    </tr>
                    <tr>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:10%"><strong>DATE</strong></td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:10%"><strong>TIME</strong></td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:20%"><strong>AMOUNT PAID</strong></td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:15%"><strong>CREDIT</strong></td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:15%"><strong>DEBIT</strong></td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:15%"><strong>PAID BY</strong></td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:15%"><strong>RECEIVED BY</strong></td>
                        
                    </tr>
                    
                    ';
                    
                    //SELECT STUDENT DAILY PAYMENTS
                    $query_select_daily_payments = mysqli_query($conn,"select * from `daily_fees_payments` where `STUDENT ID`='$student_id' and `ACADEMIC YEAR`='".$fetch_fees['ACADEMIC YEAR']."' and `TERM`='".$fetch_fees['TERM']."'");
                    $total_payments = 0;
                    $total_debits = 0;
                    $total_credits =0;
                    
                    while($fetch_payments = mysqli_fetch_assoc($query_select_daily_payments)){
                        $total_payments = $total_payments + $fetch_payments['AMOUNT PAID'];
                        $total_credits = $total_credits + $fetch_payments['CREDIT'];
                        $total_debits = $total_debits + $fetch_payments['DEBIT'];
                        $output .='
                        <tr>
                            <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:10%">'.$fetch_payments['DATE'].'</td>
                            <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:10%">'.$fetch_payments['TIME'].'</td>
                            <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:20%">'.sprintf('%0.2f',$fetch_payments['AMOUNT PAID']).'</td>
                            <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:15%">'.sprintf('%0.2f',$fetch_payments['CREDIT']).'</td>
                            <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:15%">'.sprintf('%0.2f',$fetch_payments['DEBIT']).'</td>
                            <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:15%">'.$fetch_payments['PAID BY'].'</td>
                            <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:15%">'.$fetch_payments['RECEIVED BY'].'</td>

                        </tr>
                        ';
                    }
                    $output .='
                        <tr>
                            <td style="border:0.5px solid #000; font-size:13px;; width:20%"><strong>TOTAL</strong></td>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:20%"><strong> '.$currency.' '.sprintf('%0.2f',$total_payments).'</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:15%"><strong> '.$currency.' '.sprintf('%0.2f',$total_credits).'</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:15%"><strong>'.$currency.' '.sprintf('%0.2f',$total_debits).'</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:30%"></td>

                        </tr>
                        <tr>
                            <td style="width:100%"></td>
                        </tr>
                        ';
                    
                    $output .='
                    <tr>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%"><strong>#</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:20%"><strong>ACADEMIC YEAR</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%"><strong>TERM</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:15%"><strong>FEES</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:15%"><strong>PAYMENT</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:15%"><strong>DEBIT</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:15%"><strong>CREDIT</strong></td>
                            
                        </tr>
                        
                    ';

                }
                $output .='</tbody></table>';
             $numysqli_num_rows = mysqli_num_rows($query_pick_fees);
            if($numysqli_num_rows < 1){
                $output = '<h1>Ooop..No Records Found.</h1>';
            }
            return $output;
            
        }
        
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
$pdf->SetTitle('STUDENT FEES INFO');
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
$html = fetchdata($conn);
$pdf->writeHTML($html, true, false, true, false, '');







// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('STUDENT_FEES_PFOFILE.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>