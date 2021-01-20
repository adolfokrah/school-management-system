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
           $id = '';
            if(isset($_GET['id']) && !empty($_GET['id'])){
                $id = $_GET['id'];
            }
    
        $query = '';
         //fetch receipt information
         if($id == ''){
             $query = mysqli_query($conn,"select * from `daily_fees_payments` where `RECEIVED BY`='$user' and `SCHOOL`='$initials' and `GENERATED`='NO' limit 0,5");
         }else{
             $query = mysqli_query($conn,"select * from `daily_fees_payments` where `ID`='$id'");
         }
    $output = '';
        while($fetch = mysqli_fetch_assoc($query)){
            $received_from = strtoupper($fetch['STUDENT NAME']);
            $student_id = $fetch['STUDENT ID'];
            $date = $fetch['DATE'];
            $time = $fetch['TIME'];
            $amount_paid = sprintf('%0.2f',$fetch['AMOUNT PAID']);
            $credit = sprintf('%0.2f',$fetch['CREDIT']);
            $receipt_number = $fetch['RECEIPT NUMBER'];
            $academic_year = $fetch['ACADEMIC YEAR'];
            $term = $fetch['TERM'];
            $class = $fetch['CLASS'];
            $received_by = $fetch['RECEIVED BY'];
            $query3 = mysqli_query($conn,"select * from users where `USER ID`='$received_by'");
            if($fetch2 = mysqli_fetch_assoc($query3)){
                
                if($fetch2['USER NAME'] == ''){
                    $query3 = mysqli_query($conn,"select * from `main admins` where `ADMIN ID`='$received_by'");
                    if($fetch3 = mysqli_fetch_assoc($query3)){
                        $received_by = $fetch3['ADMIN NAME'];
                    }
                }else{
                    $received_by = $fetch2['USER NAME'];
                }
            }
            $paid_by = strtoupper($fetch['PAID BY']);
            $debit = sprintf('%0.2f',$fetch['DEBIT']);
            $being = '';
            $fee_id = $fetch['ID'];
            if($debit <= 0){
                $being = 'FULL PAYMENT OF SCHOOL FEES';
            }else{
                $being ='PART PAYMENT OF SCHOOL FEES';
            }
            if($fetch['BEIGN'] == 'ADMISSION'){
                $being = 'PAYMENT OF ADMISSION FEE';
            }
            $output .= '<table cellpadding="3px;" style="border-bottom:0.5 dashed #000; border-top:0.5 dashed #000">
                    <tbody> 
                    
                             <tr>
                             <td style="width:10%"></td>
                             <td style="width:10%;"><img src="../image_uploads_crests/'.$school_logo.'"  /></td>
                             <td style=" font-family:arial;width:60%; text-align:center;"><strong><div style="font-size:24px;">'.$school_name.'</div></strong>'.$shcool_numbers.'
                             
                             </td> 
                             <td style="width:10%"></td>
                             <td style="width:10%"></td>
                            </tr>
                            
                            <tr>
                                <td style="font-size:13px; font-family:arial;width:40%; text-align:center;"></td>
                                <td style="font-size:13px; font-family:arial;width:20%; text-align:center; border-top:1 solid #000;"><strong>OFFICIAL RECEIPT</strong></td>
                                <td style="font-size:24px;; font-family:arial; width:40%; text-align:center;"></td>
                            </tr>
                            <tr>
                               <td style="font-size:13px; font-family:arial;width:15%;">Received from: </td>
                               <td style="font-size:13px; font-family:arial;width:45%; ">'.htmlentities($received_from).'</td>
                               <td style="font-size:13px; font-family:arial;width:15%;">R/NO:</td>
                               <td style="font-size:13px; font-family:arial;width:25%; ">'.htmlentities($receipt_number).'</td>
                            </tr>
                            <tr>
                               <td style="font-size:13px; font-family:arial;width:15%;">Class: </td>
                               <td style="font-size:13px; font-family:arial;width:45%; "><strong>'.htmlentities($class).'</strong></td>
                               <td style="font-size:13px; font-family:arial;width:15%;">Date:</td>
                               <td style="font-size:13px; font-family:arial;width:25%; ">'.$date.' / '.$time.'</td>
                            </tr>
                            <tr>
                               <td style="font-size:13px; font-family:arial;width:15%;">Amount Paid: </td>
                               <td style="font-size:18px; font-family:arial;width:45%; "><strong>'.$currency.' '.$amount_paid.'</strong></td>
                               <td style="font-size:13px; font-family:arial;width:15%;">Debit:</td>
                               <td style="font-size:18px; font-family:arial;width:25%; "><strong>'.$currency.' '.$debit.'</strong></td>
                            </tr>
                            <tr>
                               <td style="font-size:13px; font-family:arial;width:15%;">Credit: </td>
                               <td style="font-size:18px; font-family:arial;width:45%; "><strong>'.$currency.' '.$credit.'</strong></td>
                               <td style="font-size:13px; font-family:arial;width:15%;">Student ID:</td>
                               <td style="font-size:13px; font-family:arial;width:25%; "><strong>'.$student_id.'</strong></td>
                            </tr>
                            <tr>
                               <td style="font-size:13px; font-family:arial;width:15%;">Paid by: </td>
                               <td style="font-size:13px; font-family:arial;width:45%; ">'.htmlentities($paid_by).'</td>
                               <td style="font-size:13px; font-family:arial;width:15%;">Academic Year:</td>
                               <td style="font-size:13px; font-family:arial;width:25%; ">'.$academic_year.'</td>
                            </tr>
                            <tr>
                               <td style="font-size:13px; font-family:arial;width:15%;">Being: </td>
                               <td style="font-size:13px; font-family:arial;width:45%; ">'.$being.'</td>
                               <td style="font-size:13px; font-family:arial;width:15%;">Term:</td>
                               <td style="font-size:13px; font-family:arial;width:25%; ">'.$term.'</td>
                            </tr>
                            
                          
                            <tr><td style="font-size:13px; font-family:arial;width:15%;">Received by: </td>
                                <td style="font-size:13px; font-family:arial;width:55%;"><strong>'.$received_by.'</strong></td>
                                <td style="font-size:13px; font-family:arial;width:20%; border-bottom:0.5px solid #000;"></td>
                                <td style="font-size:13px; font-family:arial;width:10%;"></td>
                            </tr>
                            <tr><td style="font-size:13px; font-family:arial;width:70%;"><strong>https://www.easyskul.com</strong></td>
                                <td style="font-size:13px; font-family:arial;width:20%;">SIGNATURE / STAMP</td>
                                <td style="font-size:13px; font-family:arial;width:10%; text-align:center;"></td>
                            </tr>
                       </tbody>
                </table><br/><br/>';
            
            mysqli_query($conn,"update `daily_fees_payments` set `GENERATED`='' where `ID`='$fee_id'");
            
        }
         
    $query2 = mysqli_query($conn,"select * from `daily_fees_payments` where `RECEIVED BY`='$user' and `SCHOOL`='$initials' and `GENERATED`='NO'");
    $remaining = mysqli_num_rows($query2);
    if($remaining > 0  && $id == ""){
        $msg = 'Load Some';
        if($remaining <=5){
            $msg= 'Load Them';
        }
        $output .='
        <br/><br/><br/>
        <table>
            <tbody>
                <tr>
                    <td style="width:100%; text-align:center"><strong>'.$remaining.' more remaining.</strong> Refresh Page To '.$msg.'</td>
                </tr>
            </tbody>
        </table>
        ';
    }else{
        //$output .='Ooops no reports to generate at the moment..';
    }
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
$pdf->SetTitle('FEES RECEIPT');
$pdf->SetSubject('EASYSKUL');
$pdf->SetKeywords('TCPDF, PDF, PROFILE, test, guide');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(2,2, 2);
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
$pdf->SetFont('Times', '', 12);

// add a page
$pdf->AddPage();

// Print a text
$html = fetchdata($initials,$user,$currency,$conn);
$pdf->writeHTML($html, true, false, true, false, '');







// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('OFFICIAL RECEIPT.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>