<?php
include '../includes/school_ini_user_id.php';
include '../includes/get_currencies.php';
require_once 'tcpdf/tcpdf.php';

function fetchdata($initials,$user,$currency,$conn){
    
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
           $to = '';
           $from = '';
          $dates = array();
            if(isset($_GET['from']) && isset($_GET['to'])){
                $to = $_GET['to'];
                $from = $_GET['from'];
                
                
                 $begin = new DateTime($from);
                 $end = new DateTime($to);
                $end = $end->modify('+1 day');


                $interval= new DateInterval('P1D');
                $daterange = new DatePeriod($begin,$interval,$end);
                $counter=0;
                foreach($daterange as $date){
                    $dates[$counter] = $date->format("Y-m-d");
                    $counter ++;
                }

            }
       
        $output ='
            <table cellpadding="5px;" style="border:0.5 dashed #000">
                    <tbody> 
                    
                             <tr>
                             <td style="width:20%"><img src="../image_uploads_crests/'.$school_logo.'" /></td>
                             <td style="font-size:24px;; font-family:arial;width:80%;"><strong>'.$school_name.'</strong><br/>'.$school_moto.'<br/>'.$schoo_location.'<br/>'.$shcool_numbers.'</td> 
                             
                            </tr>
                            
                            <tr>
                                <td style="font-size:24px;; font-family:arial;width:100%; text-align:center; border:0.5 solid #000;"><strong>FEES BALANCES GIVEN  :'.$from.' - '.$to.'</strong></td>
                                                            </tr>';    
        $overall_total = 0;
         foreach ($dates as $date){
             $output .='<tr><td style="font-size:24px;; font-family:arial;width:100%; text-align:center; border:2px solid #000;"><strong>'.$date.'</strong></td></tr>
             <tr>
                <td style="width:10%; border:0.5px solid #000; font-size:13px;;"><strong>#</strong></td>
                  <td style="width:15%; border:0.5px solid #000; font-size:13px;;"><strong>STUDENT ID</strong></td>
                  <td style="width:20%; border:0.5px solid #000; font-size:13px;;"><strong>STUDENT NAME</strong></td>
                  <td style="width:10%; border:0.5px solid #000; font-size:13px;;"><strong>CLASS</strong></td>
                  <td style="width:10%; border:0.5px solid #000; font-size:13px;;"><strong>DATE</strong></td>
                    <td style="width:10%; border:0.5px solid #000; font-size:13px;;"><strong>TIME</strong></td>
                    <td style="width:10%; border:0.5px solid #000; font-size:13px;;"><strong>AMOUNT</strong></td>
                  <td style="width:15%; border:0.5px solid #000; font-size:13px;;"><strong>TAKEN BY</strong></td>
             </tr>
             ';
             $total_amount =0;
             $counter = 0;
             //pick total fees for the date
             $query_for_fees = mysqli_query($conn,"select * from returned_blances where `DATE` ='$date' and `SCHOOL`='$initials'");
             while($fetch = mysqli_fetch_assoc($query_for_fees)){
                 $total_amount = $fetch['AMOUNT'] + $total_amount;
                 $counter ++;
                 $output .='
                    <tr>
                        <td  style="width:10%; border:0.5px solid #000">'.$counter.'</td>

                        <td style="width:15%; border:0.5px solid #000; font-size:13px;;">'.htmlentities($fetch['STUDENT ID']).'</td>
                        <td style="width:20%; border:0.5px solid #000; font-size:13px;;">'.htmlentities($fetch['STUDENT NAME']).'</td>
                        <td style="width:10%; border:0.5px solid #000; font-size:13px;;">'.htmlentities($fetch['CLASS']).'</td>
                        <td style="width:10%; border:0.5px solid #000; font-size:13px;;">'.htmlentities($fetch['DATE']).'</td>
                        <td style="width:10%; border:0.5px solid #000; font-size:13px;;">'.$fetch['TIME'].'</td>
                        <td style="width:10%; border:0.5px solid #000; font-size:13px;;">'.$currency.' '.sprintf('%0.2f',$fetch['AMOUNT']).'</td>

                        <td style="width:15%; border:0.5px solid #000; font-size:13px;;">'.htmlentities($fetch['TAKEN BY']).'</td>
                    </tr>
                 ';
             }
            
              $output .='
            <tr>
                <td style="width:75%; border:0.5px solid #000;font-size:13px;; "><strong>TOTAL</strong></td>
                <td style="width:10%; border:0.5px solid #000;font-size:13px;;"><strong>'.$currency.' '.sprintf('%0.2f',$total_amount).'</strong></td>
                <td style="width:15%; border:0.5px solid #000;font-size:13px;;"></td>
            </tr>
            <tr>
            <td style="width:100%"></td>
            </tr>
        ';
         }
   
       
        $output .='</tbody></table>';
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
$pdf->SetTitle('FEE BALANCE SHEET');
$pdf->SetSubject('EASYSKUL');
$pdf->SetKeywords('TCPDF, PDF, PROFILE, test, guide');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(5,5, 5);
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
$html = fetchdata($initials,$user,$currency,$conn);
$pdf->writeHTML($html, true, false, true, false, '');







// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('FEES BALANCES REPORT.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>