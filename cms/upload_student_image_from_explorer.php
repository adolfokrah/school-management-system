<?php
    
    //upload crest to database
    
    include '../includes/school_ini_user_id.php';
    include '../includes/resize_image.php';
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);

   

	if ((($_FILES["file"]["type"] == "image/gif")
	|| ($_FILES["file"]["type"] == "image/jpeg")
	|| ($_FILES["file"]["type"] == "image/jpg")
	|| ($_FILES["file"]["type"] == "image/pjpeg")
	|| ($_FILES["file"]["type"] == "image/x-png")
	|| ($_FILES["file"]["type"] == "image/png"))
	
	&& in_array($extension, $allowedExts)) {
        
		if ($_FILES["file"]["error"] > 0) {
			 error_box("Return Code: " . $_FILES["file"]["error"]);
		} else {
                //check if user is has an un finish registration
                $year = date('Y');
                $query = mysqli_query($conn,"select * from `admitted_students` where `ENTRY BY`='$user' and `SCHOOL`='$initials' and `NEW`!=''");
                if($fetch_query = mysqli_fetch_assoc($query)){
                    //update records
                    $student_id =  $fetch_query['ADMISSION NO / ID'];
                    $filename = $fetch_query['PHOTO'];
                    unlink('upload/'.$filename);
                    $filename = $student_id.'.'.$extension;
                    
                    //update row
                    mysqli_query($conn,"update admitted_students set `PHOTO`='$filename' where `ADMISSION NO / ID` ='$student_id'");
                    move_uploaded_file($_FILES["file"]["tmp_name"],"upload/".$filename);
                    
                    

                }else{
                    //insert new student
                    $year = date('Y');
                    $student_id = generate_student_id($conn,$initials,$year);
                    $filename = $student_id.'.'.$extension;

                    $query_insert = mysqli_query($conn,"INSERT INTO `admitted_students` (`NO`, `SCHOOL`, `ENTRY BY`, `ADMISSION NO / ID`, `STUDENT LAST NAME`, `STUDENT  FIRST NAME`, `STD DATE OF BIRTH`, `HOME TOWN`, `NATIONALITY`, `STD RELIGIOUS DENOMINATION`, `FORMER SCHOOL`, `DATE OF ADMISSION`, `PRESENT CLASS`, `PHOTO`, `GENDER`, `GUARDIAN NAME`, `GUARDIAN ADDRESS`, `GUARDIAN OCCUPATION`, `GUARDIAN TEL`, `GUARDIAN RD`, `GUARDIAN RELATIONSHIP STATUS`, `STUDENT DISABILITIES`,  `ADMISSION FEE`, `PAIDDATE`, `ACADEMIC YEAR`, `YEAR OF ADMISSION`,`NEW`) VALUES (NULL, '$initials', '$user', '$student_id', '', '', '', '', '', '', '',  '', '', '$filename', '', '', '', '', '', '', '', '', '', '', '', '$year','YES');");
                    
                    move_uploaded_file($_FILES["file"]["tmp_name"],"upload/".$filename);

                    $img = resize_image("upload/".$filename, 200, 200);
                    // again for jpg
                    imagejpeg($img,"upload/".$filename);
                }
                echo $filename;
            }
             
            
		}else {
		  echo 'error';
	   }

function generate_student_id($conn,$school_initial,$year){
   
    
    
    $select_student_number = mysqli_query($conn,"select * from `admitted_students` where `SCHOOL`='$school_initial' and `YEAR OF ADMISSION`='$year'");
    $number_rows = mysqli_num_rows($select_student_number);
    $number_rows ++;
    $number_rows = str_pad($number_rows,5,"0",STR_PAD_LEFT);
    
    $student_id = $school_initial."-"."STD"."_".$year."".$number_rows."D";
    
    
    return $student_id;
    
}
	?>