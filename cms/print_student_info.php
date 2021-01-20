<?php
include '../includes/mysql_connect.php';
require_once 'tcpdf/tcpdf.php';

function fetchdata($conn){
    
    if(isset($_GET['student_id']) && !empty($_GET['student_id'])){
        $student_id = $_GET['student_id'];
        $fields = array();
        $query = mysqli_query($conn,"select * from `admitted_students` where `ADMISSION NO / ID` = '$student_id'");
        if($fetch = mysqli_fetch_assoc($query)){
            $fields[0]=htmlentities($fetch['STUDENT  FIRST NAME']);
            $fields[1]=htmlentities($fetch['STUDENT LAST NAME']);
            $fields[2]=htmlentities($fetch['STD DATE OF BIRTH']);
            $fields[3]='';
            $fields[4]=htmlentities($fetch['HOME TOWN']);
            $fields[5]=htmlentities($fetch['NATIONALITY']);
            $fields[6]=htmlentities($fetch['STD RELIGIOUS DENOMINATION']);
            $fields[7]=htmlentities($fetch['FORMER SCHOOL']);
            $fields[8]=htmlentities($fetch['PRESENT CLASS']);
            $fields[9]=htmlentities($fetch['GENDER']);
            $fields[10]=htmlentities($fetch['PRESENT CLASS']);
            $fields[11]=htmlentities($fetch['GUARDIAN NAME']);
            $fields[12]=htmlentities($fetch['GUARDIAN ADDRESS']);
            $fields[13]=htmlentities($fetch['GUARDIAN OCCUPATION']);
            $fields[14]=htmlentities($fetch['GUARDIAN TEL']);
            $fields[15]=htmlentities($fetch['GUARDIAN RD']);
            $fields[16]=htmlentities($fetch['GUARDIAN RELATIONSHIP STATUS']);
            $fields[17]=htmlentities($fetch['STUDENT DISABILITIES']);
            $fields[18]=htmlentities($fetch['ADMISSION FEE']);
            $fields[19]=htmlentities($fetch['PAIDDATE']);
            $fields[20]=htmlentities($fetch['YEAR OF ADMISSION']);
            $fields[21]=htmlentities($fetch['NO']);
            $fields[22]=htmlentities($fetch['PHOTO']);
            //STUDENT INFORMATION
            
            //pick school details
            $str_pos = strpos($student_id,'-');
            $initials = substr($student_id,0,$str_pos);
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
            
            $output = '
              <style>
                
              </style>
                <table cellpadding="10px;" style="border:0.5 dashed #000">
                    <thead> 
                             <tr>
                             <th style="width:20%"><img src="../image_uploads_crests/'.$school_logo.'" width="250px;"/></th>
                             <th style="font-size:24px;; font-family:arial;width:80%"><strong>'.$school_name.'</strong><br/>'.$school_moto.'<br/>'.$schoo_location.'<br/>'.$shcool_numbers.'</th> 
                            </tr> 
                       </thead>
                </table>
                <br/><br/>
                <table cellpadding="5px">
                    <thead>
                        <tr>
                            
                            <th style="border:0.5px solid #000; font-size:13px;; text-align:center;"><center><strong>STUDENT INFORMATION</strong></center></th>
                            
                        </tr>
                    </thead>
                </table>
                
                <table cellpadding="5px">
                    <thead>
                        <tr>
                            <th style="width:20%; border:0.5px solid #000;"><img src="upload/'.$fields[22].'"/></th>
                            <th style="font-size:13px;; width:40%; font-family:verdana; border:0.5px solid #000;"><strong>FIRST NAME: </strong>'.$fields[0].'<br/><br/><strong>LAST NAME: </strong>'.$fields[1].'<br/><br/><strong>DATE OF BIRTH:</strong> '.$fields[2].'<br/><br/><strong>NATIONALITY</strong>: '.$fields[5].'
                            <br/><br/><strong>HOME TOWN</strong>: '.$fields[4].'<br/><br/><strong>STUDENT DISABILITIES</strong>: '.$fields[17].'
                            </th>
                            <th style="font-size:13px;; width:40%; font-family:verdana; border:0.5px solid #000;"><strong>RELIGIOUS DENOMINATION: </strong>'.$fields[6].'<br/><br/><strong>FORMER SCHOOL: </strong>'.$fields[7].'<br/><br/><strong>CLASS ADMITTED:</strong> '.$fields[8].'<br/><br/><strong>GENDER</strong>: '.$fields[9].'<br/><br/><strong>STUDENT ID</strong>: '.$student_id.'
                            
                            </th>
                        </tr>
                    </thead>
                </table>
                
                <table cellpadding="5px">
                    <thead>
                        <tr>
                            
                            <th style="border:0.5px solid #000; font-size:13px;; text-align:center;"><center><strong>GUARDIAN INFORMATION</strong></center></th>
                            
                        </tr>
                    </thead>
                </table>
                <table cellpadding="5px">
                    <thead>
                        <tr>
                            
                            <th style="border:0.5px solid #000; font-size:13px;; width:50%"><strong>GUARDIAN NAME: </strong>'.$fields[11].'<br/><br/><strong>GUARDIAN ADDRESS: </strong>'.$fields[12].'<br/><br/><strong>GUARDIAN OCCUPATION:</strong> '.$fields[13].'
                            </th>
                            <th style="border:0.5px solid #000; font-size:13px;; width:50%;"><strong>GUARDIAN TEL: </strong>'.$fields[14].'<br/><br/><strong>RELATIONSHIP TO STUDENT: </strong>'.$fields[16].'<br/><br/>
                            <strong>RELIGIOUS DENOMINATION: </strong>'.$fields[15].'
                            </th>
                        </tr>
                    </thead>
                </table>
                <table cellpadding="5px">
                    <thead>
                        <tr>
                            
                            <th style="border:0.5px solid #000; font-size:13px;; text-align:center;"><center><strong>OFFICE USE</strong></center></th>
                            
                        </tr>
                    </thead>
                </table>
                <table cellpadding="5px">
                    <thead>
                        <tr>
                            
                            <th style="border:0.5px solid #000; font-size:13px;; width:100%"><strong>ADMISSION FEE: </strong>'.sprintf('%0.2f',$fields[18]).'<br/><br/><strong>PAIDDATE: </strong>'.$fields[19].'<br/><br/><strong>YEAR OF ADMISSION:</strong> '.$fields[20].'
                            </th>
                            
                        </tr>
                    </thead>
                </table>
                <table cellpadding="20px">
                    <thead>
                        <tr>
                            
                            <th style=" font-size:13px;;  width:70%"></th>
                            <th style=" font-size:13px;; border-bottom:0.5px dashed #000; width:30%"></th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            
                            <th style=" font-size:13px;;  width:70%"></th>
                            <th style=" font-size:13px;;  text-align:center; width:30%">SIGNATURE</th>
                        </tr>
                    </thead>
                </table>
            ';
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
$pdf->SetTitle('STUDENT PROFILE');
$pdf->SetSubject('EASYSKUL');
$pdf->SetKeywords('TCPDF, PDF, PROFILE, test, guide');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(15, 15, 15);
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
$pdf->Output('STUDENT_PFOFILE.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>