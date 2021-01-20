<?php
include '../includes/school_ini_user_id.php';
require_once 'tcpdf/tcpdf.php';

function fetchdata($initials,$conn){
    
    if(isset($_GET['class']) && !empty($_GET['class'])&&isset($_GET['group']) && !empty($_GET['group'])){
        $class = $_GET['class'];
        $action = $_GET['group'];
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
                             <td style="width:20%"><img src="../image_uploads_crests/'.$school_logo.'" width="250px;"/></td>
                             <td style="font-size:24px;; font-family:arial;width:80%"><strong>'.$school_name.'</strong><br/>'.$school_moto.'<br/>'.$schoo_location.'<br/>'.$shcool_numbers.'</td> 
                            </tr> 
                      
                
               
                   
                        <tr>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:100%"><strong>FEEDING FEE PAYMENT SHEET  - '.$action.'</strong></td>
                            
                        </tr>
                        
                    
               
                
                   
                        <tr>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; width:100%"><strong>CLASS: </strong>'.$class.'
                            <br/><br/><strong>DATE</strong>: <br/><br/><strong>ACADEMIC YEAR:</strong> '.$academic_year.'<br/><br/><strong>TERM: </strong>'.$term.'</td>
                            
                        </tr>
                    
                
                
                   
                        <tr>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%"><strong>#</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:30%"><strong>STUDENT ID</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:40%"><strong>STUDENT NAME</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:20%"><strong>';
        if($action == "debitors"){
             $output .='ARREAS';
        }else{
            $output .='BALANCE';
        }
        $output .= '</strong></td>
                            
                           
                        </tr>
                    
               
                ';
        
        $counter = 0;
        $query = mysqli_query($conn,"select * from `admitted_students` where `PRESENT CLASS` = '$class' and `SCHOOL`='$initials' order by `STUDENT LAST NAME` asc");
        if(mysqli_num_rows($query)==0){
            $output = 'Ooops. No list to display';
        }
        $total = 0;
        while($fetch = mysqli_fetch_assoc($query)){
            $fields[0]=htmlentities($fetch['STUDENT  FIRST NAME']);
            $fields[1]=htmlentities($fetch['STUDENT LAST NAME']);
            $fields[2]=htmlentities($fetch['ADMISSION NO / ID']);
            $counter ++;
            
            //check if student has extra days
            $days_left = 0;
            $query_pick_days_left = "";
            
            if($action == "debitors"){
                     $query_pick_days_left = mysqli_query($conn,"select * from feeding_fee where ARREAS > 0 and `SCHOOL`='$initials' and `STUDENT ID`='".$fields[2]."'");
                }else{
                    $query_pick_days_left = mysqli_query($conn,"select * from feeding_fee where  `SCHOOL`='$initials' and `BALANCE`>0 and `STUDENT ID`='".$fields[2]."'");
                    echo mysqli_error($conn);
                }
            
            if($fetch_days = mysqli_fetch_assoc($query_pick_days_left)){
                $days_left = $fetch_days['DAYS LEFT'];
                
                if($action == "debitors"){
                     $fields[3] = sprintf('%0.2f',$fetch_days['ARREAS']);
                }else{
                    $fields[3] = sprintf('%0.2f',$fetch_days['BALANCE']);
                }
                $total = $total + $fields[3];
               
                $output .='
                        <tr>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%">'.$counter.'</td>
                            <td style="border:0.5px solid #000; font-size:13px;;  width:30%">'.$fields[2].'</td>
                            <td style="border:0.5px solid #000; font-size:13px;;  width:40%">'.$fields[1].' '.$fields[0].'</td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:20%">'.sprintf('%0.2f',$fields[3]).'</td>
                        </tr>
                     ';
                
            }
            
            
            
            
        }
        $output .='<tr><td style="border:0.5px solid #000; font-size:13px;; width:80%">'.$counter.'</td>
        <td style="border:0.5px solid #000; font-size:13px;; width:20%">'.sprintf('%0.2f',$total).'</td></tr>';
        $output .='</tbody>
                </table>';
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
$pdf->SetTitle('FEEDING FEE PAYMENT LIST');
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
$pdf->Output('FEEDING FEE PAYMENT SHEET.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>