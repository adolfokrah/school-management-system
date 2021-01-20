<?php
include '../includes/school_ini_user_id.php';

require_once 'tcpdf/tcpdf.php';

function fetchdata($initials,$conn){
    
    if(isset($_GET['class']) && !empty($_GET['class']) && isset($_GET['academic_year']) && !empty($_GET['academic_year']) && isset($_GET['group']) && !empty($_GET['group']) && isset($_GET['term']) && !empty($_GET['term'])){
        $class = $_GET['class'];
        $academic_year = $_GET['academic_year'];
        $group = $_GET['group'];
        $term = $_GET['term'];
        
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
                             <td style="font-size:24px; font-family:arial;width:80%"><strong>'.$school_name.'</strong><br/>'.$school_moto.'<br/>'.$schoo_location.'<br/>'.$shcool_numbers.'</td> 
                          </tr> 
                          
                   </tbody><br/><br/>
                   <tbody>
                        <tr>
                            <td style="width:100%; border:0.5px solid #000; text-align:center; font-size:13px;;"><strong>TERMLY SCHOOL FEES RECORDS</strong></td>
                        </tr>
                        <tr>
                            <td style="width:100%; border:0.5px solid #000; font-size:13px;;">CLASS: <strong>'.$class.'</strong>
                            <br/><br/>
                            ACADEMIC YEAR: <strong>'.$academic_year.'</strong><br/><br/>
                            GROUP: <strong>'.$group.'</strong>
                            </td>
                        </tr>
                        <tr><td style="width:100%"></td></tr>
                        <tr>
                            <td style="width:5%; border:0.5px solid #000; font-size:13px;;"><strong>#</strong></td>
                            <td style="width:11%; border:0.5px solid #000; font-size:13px;;"><strong></strong></td>
                            <td style="width:19%; border:0.5px solid #000; font-size:13px;;"><strong>STUDENT ID</strong></td>
                            <td style="width:25%; border:0.5px solid #000; font-size:13px;;"><strong>STUDENT NAME</strong></td>
                            <td style="width:10%; border:0.5px solid #000; font-size:13px;;"><strong>FEES</strong></td>
                            <td style="width:10%; border:0.5px solid #000; font-size:13px;;"><strong>PAYMENT</strong></td>
                            <td style="width:10%; border:0.5px solid #000; font-size:13px;;"><strong>DEBIT</strong></td>
                            <td style="width:10%; border:0.5px solid #000; font-size:13px;;"><strong>CREDIT</strong></td>
                        </tr>
                        
                        ';
        
                $counter  = 0;
                $query_pick_fees = mysqli_query($conn,"select * from school_fees where `CLASS`='$class' and `ACADEMIC YEAR`='$academic_year' and `SCHOOL`='$initials' and `TERM`='$term' order by `STUDENT NAME` asc");
                $total_amount  =0;
                $total_payment = 0;
                $total_credits = 0;
                $total_debits = 0;
                while($fetch = mysqli_fetch_assoc($query_pick_fees)){
                                    
                        //check for full payments
                        if($group == 'FULL PAYMENT' && $fetch['DEBIT']==0){
                            
                            $total_amount  = $total_amount + $fetch['AMOUNT'];
                            $total_payment = $total_payment + $fetch['PAYMENT'];
                            $total_credits = $total_credits + $fetch['CREDIT'];
                            $total_debits = $total_debits + $fetch['DEBIT'];
                            $counter ++;
                            $output .= '<tr>
                            <td  style="width:5%; border:0.5px solid #000; font-size:13px;;">'.$counter.'</td>

                            <td style="width:11%; border:0.5px solid #000; font-size:13px;;"></td>
                            <td style="width:19%; border:0.5px solid #000; font-size:13px;;">'.$fetch['STUDENT ID'].'</td>
                            <td style="width:25%; border:0.5px solid #000; font-size:13px;;">'.htmlentities($fetch['STUDENT NAME']).'</td>
                            <td style="width:10%; border:0.5px solid #000; font-size:13px;;">'.sprintf('%0.2f',$fetch['AMOUNT']).'</td>
                            <td style="width:10%; border:0.5px solid #000; font-size:13px;;">'.sprintf('%0.2f',$fetch['PAYMENT']).'</td>
                            <td style="width:10%; border:0.5px solid #000; font-size:13px;;">'.sprintf('%0.2f',$fetch['DEBIT']).'</td>
                            <td style="width:10%; border:0.5px solid #000; font-size:13px;;">'.sprintf('%0.2f',$fetch['CREDIT']).'</td>
                            
                        </tr>';
                        }else if($group == 'DEBITORS' && ($fetch['DEBIT']) > 0){
                             $counter ++;
                            $total_amount  = $total_amount + $fetch['AMOUNT'];
                            $total_payment = $total_payment + $fetch['PAYMENT'];
                            $total_credits = $total_credits + $fetch['CREDIT'];
                            $total_debits = $total_debits + $fetch['DEBIT'];
                            $output .= '<tr>
                            <td  style="width:5%; border:0.5px solid #000; font-size:13px;;">'.$counter.'</td>

                            <td style="width:11%; border:0.5px solid #000; font-size:13px;;"></td>
                            <td style="width:19%; border:0.5px solid #000; font-size:13px;;">'.$fetch['STUDENT ID'].'</td>
                            <td style="width:25%; border:0.5px solid #000; font-size:13px;;">'.htmlentities($fetch['STUDENT NAME']).'</td>
                            <td style="width:10%; border:0.5px solid #000; font-size:13px;;">'.sprintf('%0.2f',$fetch['AMOUNT']).'</td>
                            <td style="width:10%; border:0.5px solid #000; font-size:13px;;">'.sprintf('%0.2f',$fetch['PAYMENT']).'</td>
                            <td style="width:10%; border:0.5px solid #000; font-size:13px;;">'.sprintf('%0.2f',$fetch['DEBIT']).'</td>
                            <td style="width:10%; border:0.5px solid #000; font-size:13px;;">'.sprintf('%0.2f',$fetch['CREDIT']).'</td>
                            
                        </tr>';
                        }else if($group == 'NO PAYMENT' && ($fetch['PAYMENT'] < 1)){
                             $counter ++;
                            $total_amount  = $total_amount + $fetch['AMOUNT'];
                            $total_payment = $total_payment + $fetch['PAYMENT'];
                            $total_credits = $total_credits + $fetch['CREDIT'];
                            $total_debits = $total_debits + $fetch['DEBIT'];
                            $output .= '<tr>
                            <td  style="width:5%; border:0.5px solid #000; font-size:13px;;">'.$counter.'</td>

                            <td style="width:11%; border:0.5px solid #000; font-size:13px;;"></td>
                            <td style="width:19%; border:0.5px solid #000; font-size:13px;;">'.$fetch['STUDENT ID'].'</td>
                            <td style="width:25%; border:0.5px solid #000; font-size:13px;;">'.htmlentities($fetch['STUDENT NAME']).'</td>
                            <td style="width:10%; border:0.5px solid #000; font-size:13px;;">'.sprintf('%0.2f',$fetch['AMOUNT']).'</td>
                            <td style="width:10%; border:0.5px solid #000; font-size:13px;;">'.sprintf('%0.2f',$fetch['PAYMENT']).'</td>
                            <td style="width:10%; border:0.5px solid #000; font-size:13px;;">'.sprintf('%0.2f',$fetch['DEBIT']).'</td>
                            <td style="width:10%; border:0.5px solid #000; font-size:13px;;">'.sprintf('%0.2f',$fetch['CREDIT']).'</td>
                            
                        </tr>';
                        }else if($group == 'CREDITORS' && $fetch['CREDIT'] > 0){
                             $counter ++;
                            $total_amount  = $total_amount + $fetch['AMOUNT'];
                            $total_payment = $total_payment + $fetch['PAYMENT'];
                            $total_credits = $total_credits + $fetch['CREDIT'];
                            $total_debits = $total_debits + $fetch['DEBIT'];
                            $output .= '<tr>
                            <td  style="width:5%; border:0.5px solid #000; font-size:13px;;">'.$counter.'</td>

                            <td style="width:11%; border:0.5px solid #000; font-size:13px;;"></td>
                            <td style="width:19%; border:0.5px solid #000; font-size:13px;;">'.$fetch['STUDENT ID'].'</td>
                            <td style="width:25%; border:0.5px solid #000; font-size:13px;;">'.htmlentities($fetch['STUDENT NAME']).'</td>
                            <td style="width:10%; border:0.5px solid #000; font-size:13px;;">'.sprintf('%0.2f',$fetch['AMOUNT']).'</td>
                            <td style="width:10%; border:0.5px solid #000; font-size:13px;;">'.sprintf('%0.2f',$fetch['PAYMENT']).'</td>
                            <td style="width:10%; border:0.5px solid #000; font-size:13px;;">'.sprintf('%0.2f',$fetch['DEBIT']).'</td>
                            <td style="width:10%; border:0.5px solid #000; font-size:13px;;">'.sprintf('%0.2f',$fetch['CREDIT']).'</td>
                            
                        </tr>';
                        }
                }
                            
                $output .='
                <tr>
                    <td style="width:60%; border:0.5px solid #000; font-size:13px;;"><strong>TOTAL</strong></td>
                    <td style="width:10%; border:0.5px solid #000; font-size:13px;;"><strong>'.$currency.' '.sprintf('%0.2f',$total_amount).'</strong></td>
                    <td style="width:10%; border:0.5px solid #000; font-size:13px;;"><strong>'.$currency.' '.sprintf('%0.2f',$total_payment).'</strong></td>
                    <td style="width:10%; border:0.5px solid #000; font-size:13px;;"><strong>'.$currency.'  '.sprintf('%0.2f',$total_debits).'</strong></td>
                    <td style="width:10%; border:0.5px solid #000; font-size:13px;;"><strong>'.$currency.' '.sprintf('%0.2f',$total_credits).'</strong></td>
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
$pdf->SetTitle('TERMLY FEES REPORT');
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
$pdf->Output('TERMLY FEES REPORT.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>