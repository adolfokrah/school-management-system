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
            if(isset($_GET['to_date']) && isset($_GET['from_date'])){
                $to = $_GET['to_date'];
                $from = $_GET['from_date'];
                
                
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
                                <td style="font-size:24px;; font-family:arial;width:100%; text-align:center; border:0.5 solid #000;"><strong>ACCOUNTING SUMMARY REPORT FROM :'.$from.' - '.$to.'</strong></td>
                                                            </tr>';    
        $overall_total = 0;
         foreach ($dates as $date){
             $output .='<tr><td style="font-size:24px;; font-family:arial;width:100%; text-align:center; border:2px solid #000;"><strong>'.$date.'</strong></td></tr>
             ';
             $total_fees =0;
             $total_expenses =0;
             $total_feeding_fee =0;
             $total_bus_fee =0;
             
             //pick total fees for the date
             $query_for_fees = mysqli_query($conn,"select * from daily_fees_payments where `DATE` ='$date' and `SCHOOL`='$initials'");
             while($fetch = mysqli_fetch_assoc($query_for_fees)){
                 $total_fees = $fetch['AMOUNT PAID'] + $total_fees;
             }
             //pick total expenses
             $query_for_expenses = mysqli_query($conn,"select * from expenses where `DATE`='$date' and `SCHOOL`='$initials'");
             while($fetch = mysqli_fetch_assoc($query_for_expenses)){
                 $total_expenses = $total_expenses + $fetch['TOTAL AMOUNT'];
             }
             //pick total feeding fees
             $query_for_feeding = mysqli_query($conn,"select * from daily_feeding_fee where `DATE`='$date' and `SCHOOL`='$initials'");
             while($fetch = mysqli_fetch_assoc($query_for_feeding)){
                 $total_feeding_fee = $total_feeding_fee + $fetch['AMOUNT'];
             }
             //pick total bus fees
             $query_for_bus = mysqli_query($conn,"select * from daily_bus_fee where `DATE`='$date' and `SCHOOL`='$initials'");
             while($fetch = mysqli_fetch_assoc($query_for_bus)){
                 $total_bus_fee = $total_bus_fee + $fetch['AMOUNT'];
             }
             
             $sub_total = $total_expenses + $total_feeding_fee + $total_fees+$total_bus_fee;
             $overall_total = $sub_total + $overall_total;
             $output .='
                <tr><td style="font-size:24px;; font-family:arial;width:70%;  border:0.5px solid #000;">FEES</td><td style="font-size:24px;; font-family:arial;width:30%; border:0.5px solid #000;">'.sprintf('%0.2f',$total_fees).'</td></tr>
                
                
                <tr><td style="font-size:24px;; font-family:arial;width:70%;  border:0.5px solid #000;">EXPENSES</td><td style="font-size:24px;; font-family:arial;width:30%; border:0.5px solid #000;">'.sprintf('%0.2f',$total_expenses).'</td></tr>
                
                <tr><td style="font-size:24px;; font-family:arial;width:70%; border:0.5px solid #000;">FEEDING FEE</td><td style="font-size:24px;; font-family:arial;width:30%; border:0.5px solid #000;">'.sprintf('%0.2f',$total_feeding_fee).'</td></tr>
                
                <tr><td style="font-size:24px;; font-family:arial;width:70%; border:0.5px solid #000;">BUS FEE</td><td style="font-size:24px;; font-family:arial;width:30%; border:0.5px solid #000;">'.sprintf('%0.2f',$total_bus_fee).'</td></tr>

<tr><td style="font-size:24px;; font-family:arial;width:70%; border:0.5px solid #000;"><strong>SUB TOTAL</strong></td><td style="font-size:24px;; font-family:arial;width:30%; border:0.5px solid #000;">'.$currency.' '.sprintf('%0.2f',$total_feeding_fee+$total_expenses+$total_fees).'</td></tr>
<tr><td style="width:100%"></td></tr>

             ';
             
         }
    $output .='
<tr><td style="font-size:24px;; font-family:arial;width:70%; border:0.5px solid #000;"><strong>TOTAL</strong></td><td style="font-size:24px;; font-family:arial;width:30%; border:0.5px solid #000;"><strong>'.$currency.' '.sprintf('%0.2f',$overall_total).'</strong></td></tr>';
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
$pdf->SetTitle('SUMMARY REPORT');
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
$pdf->Output('SUMMARY REPORT.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>