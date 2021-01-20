<?php
include '../includes/school_ini_user_id.php';

require_once 'tcpdf/tcpdf.php';

function fetchdata($initials,$conn){

    if(isset($_GET['from']) && !empty($_GET['from']) && isset($_GET['to']) && !empty($_GET['to'])){
        $from = $_GET['from'];
        $to = $_GET['to'];
       
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
                          
                   </tbody><br/><br/>
                   <tbody>
                        <tr>
                            <td style="width:100%; border:0.5px solid #000; text-align:center; font-size:13px;;"><strong>DAILY  FEES RECORDS</strong></td>
                        </tr>
                        <tr>
                            <td style="width:100%; border:0.5px solid #000; font-size:13px;;">From: <strong>'.$from.'</strong>
                            <br/><br/>
                            To: <strong>'.$to.'</strong><br/><br/>
                            
                            </td>
                        </tr>
                        <tr><td style="width:100%"></td></tr>
                        <tr>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:5%"><strong>#</strong></td>
                        
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:10%"><strong>STUDENT ID</strong></td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:20%"><strong>STUDENT NAME</strong></td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:5%"><strong>DATE</strong></td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:5%"><strong>TIME</strong></td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:10%"><strong>AMOUNT PAID</strong></td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:10%"><strong>CREDIT</strong></td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:10%"><strong>DEBIT</strong></td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:15%"><strong>PAID BY</strong></td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:10%"><strong>RECEIVED BY</strong></td>
                        
                    </tr>
                        
                        ';
        
                $counter  = 0;
                $query_pick_fees = mysqli_query($conn,"select * from `daily_fees_payments` where `DATE` between '$from' and '$to' and `SCHOOL`='$initials' order by  `TERM` and `STUDENT NAME` asc");
                $total_payments = 0;
                $total_debits = 0;
                $total_credits =0;
                while($fetch_payments = mysqli_fetch_assoc($query_pick_fees)){
                  $counter ++;
                    $total_payments = $total_payments + $fetch_payments['AMOUNT PAID'];
                        $total_credits = $total_credits + $fetch_payments['CREDIT'];
                        $total_debits = $total_debits + $fetch_payments['DEBIT'];
                        $output .='
                        <tr>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:5%">'.$counter.'</td>
                        
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:10%">'.htmlentities($fetch_payments['STUDENT ID']).'</td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:20%">'.htmlentities($fetch_payments['STUDENT NAME']).'</td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:5%">'.$fetch_payments['DATE'].'</td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:5%">'.$fetch_payments['TIME'].'</td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:10%">'.sprintf('%0.2f',$fetch_payments['AMOUNT PAID']).'</td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:10%">'.sprintf('%0.2f',$fetch_payments['CREDIT']).'</td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:10%">'.sprintf('%0.2f',$fetch_payments['DEBIT']).'</td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:15%">'.$fetch_payments['PAID BY'].'</td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:10%">'.$fetch_payments['RECEIVED BY'].'</td>
                        
                    </tr>';
                }
        $output .='<tr>
                        <td style="border:0.5px solid #000; font-size:13px;; width:45%"><strong>TOTAL</strong></td>
                        
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:10%"><strong>'.$currency.' '.sprintf('%0.2f',$total_payments).'</strong></td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:10%"><strong>'.$currency.' '.sprintf('%0.2f',$total_credits).'</strong></td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:10%"><strong>'.$currency.' '.sprintf('%0.2f',$total_debits).'</strong></td>
                        <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:25%"></td>
                        
                    </tr>'
                        ;
        $output .='</tbody></table>';
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
$pdf->SetTitle('DAILY FEES REPORT');
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

$pdf->AddPage('L', 'A4');
$pdf->Cell(0, 0, '', 1, 1, 'C');
// Print a text
$html = fetchdata($initials,$conn);
$pdf->writeHTML($html, true, false, true, false, '');







// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('DAILY FEES RECORDS.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>