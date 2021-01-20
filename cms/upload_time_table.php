<?php
    
    //upload crest to database
    
    include '../includes/school_ini_user_id.php';
    
	$allowedExts = array("pdf");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);

   

	if ((($_FILES["file"]["type"] == "application/pdf")
	
	&& in_array($extension, $allowedExts) && isset($_REQUEST['Class']))) {
        $class = $_REQUEST['Class'];
		if ($_FILES["file"]["error"] > 0) {
			 error_box("Return Code: " . $_FILES["file"]["error"]);
		} else {
            
            $academic_year = '';
            $term = '';
        
            $query_select_academic = mysqli_query($conn,"select * from `academic_years` where `SCHOOL`='$initials' and `STATUS`='ACTIVE'");
            if($fetch_year = mysqli_fetch_assoc($query_select_academic)){
                $academic_year = $fetch_year['ACADEMIC YEAR'];
                $term = $fetch_year['TERM'];
            }else{
                echo 'year';
                die();
            }
            
            //check if time table already exist
            $quer_select = mysqli_query($conn,"select * from time_table where `SCHOOL`='$initials' and `TERM`='$term'and `ACADEMIC YEAR`='$academic_year' ");
            if($fetch = mysqli_fetch_assoc($quer_select)){
                $file = $fetch['FILE'];
                unlink ('time_tables/'.$file);
                move_uploaded_file($_FILES["file"]["tmp_name"],"time_tables/".$file);
                echo 'success';
            }else{
                $filename = generate_filename($conn,$initials,$year);
                $filename = md5($filename).'.'.$extension;
                move_uploaded_file($_FILES["file"]["tmp_name"],"time_tables/".$filename);
                mysqli_query($conn,"INSERT INTO `time_table` (`ID`, `ACADEMIC YEAR`, `TERM`, `SCHOOL`, `CLASS`, `FILE`) VALUES (NULL, '$academic_year', '$term', '$initials', '$class', '$filename'); ");
                echo 'success';
            }
            
        }
            
		}else {
		  echo 'error';
	   }

function generate_filename($conn,$school_initial,$year){
   
    
    
            $quer_select = mysqli_query($conn,"select * from time_table where `SCHOOL`='$initials'");
    $number_rows = mysqli_num_rows($select_student_number);
    $number_rows ++;
    $number_rows = str_pad($number_rows,5,"0",STR_PAD_LEFT);
    
    $student_id = $school_initial."-"."STD"."_".$year."".$number_rows."D";
    return $student_id;
    
}
	?>