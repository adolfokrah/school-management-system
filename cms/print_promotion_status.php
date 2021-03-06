<?php
include '../includes/school_ini_user_id.php';
require_once 'tcpdf/tcpdf.php';

function fetchdata($initials,$conn){
    
    if(isset($_GET['class']) && !empty($_GET['class']) && isset($_GET['academic_year']) && !empty($_GET['academic_year']) && isset($_GET['term']) && !empty($_GET['term'])){
        $class = $_GET['class'];
        $academic_year = $_GET['academic_year'];
        $term = $_GET['term'];
        
        
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
            
           
        
//            $query_select_academic = mysqli_query($conn,"select * from `academic_years` where `SCHOOL`='$initials' and `STATUS`='ACTIVE'");
//            if($fetch_year = mysqli_fetch_assoc($query_select_academic)){
//                $academic_year = $fetch_year['ACADEMIC YEAR'];
//                $term = $fetch_year['TERM'];
//            }
            
            $output = '<table cellpadding="5px;" style="border:0.5 dashed #000">
                    <tbody>
                             <tr>
                             <td style="width:20%"><img src="../image_uploads_crests/'.$school_logo.'" width="250px;"/></td>
                             <td style="font-size:24px;; font-family:arial;width:80%"><strong>'.$school_name.'</strong><br/>'.$school_moto.'<br/>'.$schoo_location.'<br/>'.$shcool_numbers.'</td> 
                            </tr> 
                      
                        <tr>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; text-align:center; width:100%"><strong>STUDENT PROMOTION STATUS</strong></td>
                            
                        </tr>
                        
                        <tr>
                            
                            <td style="border:0.5px solid #000; font-size:13px;; width:100%"><strong>CLASS: </strong>'.$class.'
                           <br/><br/><strong>ACADEMIC YEAR:</strong> '.$academic_year.'<br/><br/><strong>TERM: </strong>'.$term.'</td>
                            
                        </tr>
                        <tr>
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%"><strong>#</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:20%"><strong>STUDENT ID</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:40%"><strong>STUDENT NAME</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:15%"><strong>AVERAGE MARK</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:15%"><strong>STATUS</strong></td>
                        </tr>
                   
                ';
        
        //pick student PROMOTED STUDENTS 
        $counter = 0;
        $query2 = mysqli_query($conn,"select * from terminal_reports_av where `CLASS`='$class' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term' and `SCHOOL`='$initials'order by `AVERAGE MARK` desc");
        while($fetch = mysqli_fetch_assoc($query2)){
            $counter ++;
            
            $color = 'black';
            $status = '';
            if($fetch['PROMOTION STATUS']=='PROMOTED'){
                $color = 'black';
                $status = 'PROMOTED';
            }else if($fetch['PROMOTION STATUS']=='PROBATION'){
                $color = 'blue';
                $status = 'PROBATION';
            }else if($fetch['PROMOTION STATUS']=='REPEATED'){
                $color = 'red';
                $status  = 'REPEATED';
            }else{
                $color = 'black';
            }
            $output .='
            <tr>
                            <td style="border:0.5px solid #000; font-size:13px;; width:10%" color="'.$color.'"><strong>'.$counter.'</strong></td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:20%" color="'.$color.'">'.$fetch['STUDENT ID'].'</td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:40%" color="'.$color.'">'.$fetch['STUDENT NAME'].'</td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:15%" color="'.$color.'">'.$fetch['AVERAGE MARK'].'</td>
                            <td style="border:0.5px solid #000; font-size:13px;; width:15%" color="'.$color.'">'.$status.'</td>
                        </tr>
            ';
        }
        
//        $query3 = mysqli_query($conn,"select * from terminal_reports_av where `CLASS`='$class' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term' and `SCHOOL`='$initials' and `PROMOTION STATUS`='PROBATION' order by `AVERAGE MARK` desc");
//        while($fetch = mysqli_fetch_assoc($query3)){
//            $counter ++;
//            $output .='
//            <tr>
//                            <td style="border:0.5px solid #000; font-size:13px;; width:10%; color:blue"><strong>'.$counter.'</strong></td>
//                            <td style="border:0.5px solid #000; font-size:13px;; width:20%; color:blue">'.$fetch['STUDENT ID'].'</td>
//                            <td style="border:0.5px solid #000; font-size:13px;; width:40%; color:blue">'.$fetch['STUDENT NAME'].'</td>
//                            <td style="border:0.5px solid #000; font-size:13px;; width:15%; color:blue">'.$fetch['AVERAGE MARK'].'</td>
//                            <td style="border:0.5px solid #000; font-size:13px;; width:15%; color:blue">PROBATION</td>
//                        </tr>
//            ';
//        }
//        
//        $query4 = mysqli_query($conn,"select * from terminal_reports_av where `CLASS`='$class' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term' and `SCHOOL`='$initials' and `PROMOTION STATUS`='REPEATED' order by `AVERAGE MARK` desc");
//        while($fetch = mysqli_fetch_assoc($query4)){
//            $counter ++;
//            $output .='
//            <tr >
//                            <td style="border:0.5px solid #000;  font-size:13px;; width:10%; color:red"><strong>'.$counter.'</strong></td>
//                            <td style="border:0.5px solid #000; font-size:13px;; width:20%; color:red">'.$fetch['STUDENT ID'].'</td>
//                            <td style="border:0.5px solid #000; font-size:13px;; width:40%; color:red">'.$fetch['STUDENT NAME'].'</td>
//                            <td style="border:0.5px solid #000; font-size:13px;; width:15%; color:red">'.$fetch['AVERAGE MARK'].'</td>
//                            <td style="border:0.5px solid #000; font-size:13px;; width:15%; color:red;">REPEATED</td>
//                        </tr>
//            ';
//        }
        
        $output .=' </tbody>
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
$pdf->SetTitle('PROMOTION STATUS');
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
$pdf->Output('CLASS PROMOTION STATUS.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>