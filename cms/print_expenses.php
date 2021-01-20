<?php
include '../includes/school_ini_user_id.php';
require_once 'tcpdf/tcpdf.php';

function fetchdata($initials,$conn){
    include '../includes/get_currencies.php';
    if(isset($_GET['from']) && isset($_GET['to'])){
        $from = $_GET['from'];
        $to = $_GET['to'];
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
            
            $output = '<table cellpadding="5px;" style="border:0.5 dashed #000">
                    <tbody> 
                             <tr>
                             <td style="width:20%"><img src="../image_uploads_crests/'.$school_logo.'" width="150px;"/></td>
                             <td style="font-size:24px;; font-family:arial;width:80%"><strong>'.$school_name.'</strong><br/>'.$school_moto.'<br/>'.$schoo_location.'<br/>'.$shcool_numbers.'</td> 
                            </tr> 
                            <tr>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:100%"><strong>EXPENSES REPORT</strong></td>
                            
                            </tr>
                            <tr>
                                <td style="width:100%"></td>
                            </tr>
                             <tr>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; width:100%"><strong>DATE</strong>: '.$from.' - '.$to.'</td>
                            
                            </tr>
                            
                            <tr>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%"><strong>#</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%"><strong>EXPENS</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:20%"><strong>DESCRIPTION</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%"><strong>UNIT PRICE</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%"><strong>QUANTITY</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%"><strong>T-COST</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%"><strong>BAL</strong></td>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%"><strong>DEBIT</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%;"><strong>DATE</strong></td>
                        </tr>';
        
                        $query2 = mysqli_query($conn,"select * from expenses where `DATE` between '$from' and '$to' and `SCHOOL`= '$initials' order by  `ITEM` asc");

           $counter = 0;
          $total_amount=0;
          $debit=0;
          $balance=0;
            while($fetch = mysqli_fetch_assoc($query2)){
                $counter++;
                $total_amount = $total_amount + $fetch['TOTAL AMOUNT'];
                $debit = $debit + $fetch['DEBT'];
                $balance = $balance + $fetch['BAL'];
                $output .='<tr>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%"><strong>'.$counter.'</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%">'.htmlentities($fetch['ITEM']).'</td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:20%">'.htmlentities($fetch['DISCRIPTION']).'</td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%">'.htmlentities($fetch['UNIT PRICE']).'</td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%">'.htmlentities($fetch['QUANTITY']).'</td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%">'.sprintf('%0.2f',$fetch['TOTAL AMOUNT']).'</td>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%">'.sprintf('%0.2f',$fetch['BAL']).'</td>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%">'.sprintf('%0.2f',$fetch['DEBT']).'</td>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%; text-align:center"><strong>'.$fetch['DATE'].'</strong></td>
                        </tr>';
                
            }
                $output .='
                 <tr>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; width:60%"><strong>TOTAL</strong></td>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%"><strong>'.$currency.' '.sprintf('%0.2f',$total_amount).'</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%; "><strong>'.$currency.' '.sprintf('%0.2f',$balance).'</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%;"><strong>'.$currency.' '.sprintf('%0.2f',$debit).'</strong></td>
                        </tr>
                </tbody>
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
$pdf->SetTitle('EXPENSES');
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
$pdf->Output('EXPENSES.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>