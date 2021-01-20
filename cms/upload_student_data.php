<?php
    
    //upload crest to database
    //error_reporting(0);
    
    include '../includes/resize_image.php';
	$allowedExts = array("csv");
	if(isset($_FILES['file'])){
        
    
    $temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);
    $data = '';
    
  
	if (in_array($extension, $allowedExts)) {
        
		if ($_FILES["file"]["error"] > 0) {
			 error_box("Return Code: " . $_FILES["file"]["error"]);
		} else {
          
           if($_FILES["file"]["name"]!=""){
               $filename = $_FILES["file"]["tmp_name"];
               $file = fopen($filename, "r");
                //$sql_data = "SELECT * FROM prod_list_1 ";
               $students_ids = array();
                $count = 0;                                         // add this line
                while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
                {
                    
                    //print_r($emapData);
                    //exit();
                    $count++;                                      // add this line

                    if($count>1){                                  // add this line
                         $student_first_name = $emapData[0];
                         $student_last_name = $emapData[1];
                         $date_of_birth = $emapData[2];
                         $home_town = "";
                         $nationality = "";
                         $rd = $emapData[3];
                         $fs = "";
                         $class = $emapData[5];
                         $gender = $emapData[4];
                        
                         $guardian_name = $emapData[6];
                         $guardian_address = $emapData[7];
                         $guardian_occupation = $emapData[8];
                         $guardian_tel = $emapData[9];
                         $guardian_rd = "";
                         $guardian_rs = "";
                         $disabilites = "";
                        
                         $admmision_fee = 0;
                         $paid_date = "0000-00-00";
                         $academic_year = '';
                        
                            $term = '';
                            $query_pick = mysqli_query($conn,"select * from academic_years where `SCHOOL`='$initials' and `STATUS`='ACTIVE'");
                            if($fetch_row = mysqli_fetch_assoc($query_pick)){
                                $academic_year = $fetch_row['ACADEMIC YEAR'];
                               
                            }
                        
                        $admmision_date = "0000-00-00";
                        $class_admitted = "";
                        $year_of_completion = "";
                         $year = date('Y');
                        $student_id = generate_student_id($conn,$initials,$year);
                        
                        $query_check = mysqli_query($conn,"select * from classes where `CLASS`='$class' and `SCHOOL`='$initials'");
                        if(mysqli_num_rows($query_check) > 0){
                                  $guardian_tel = str_replace('a','0',$guardian_tel);
                                 if(mysqli_query($conn,"INSERT INTO `admitted_students` (`NO`, `SCHOOL`, `ENTRY BY`, `ADMISSION NO / ID`, `STUDENT LAST NAME`, `STUDENT  FIRST NAME`, `STD DATE OF BIRTH`, `HOME TOWN`, `NATIONALITY`, `STD RELIGIOUS DENOMINATION`, `FORMER SCHOOL`, `DATE OF ADMISSION`, `PRESENT CLASS`, `PHOTO`, `GENDER`, `GUARDIAN NAME`, `GUARDIAN ADDRESS`, `GUARDIAN OCCUPATION`, `GUARDIAN TEL`, `GUARDIAN RD`, `GUARDIAN RELATIONSHIP STATUS`, `STUDENT DISABILITIES`,  `ADMISSION FEE`, `PAIDDATE`, `ACADEMIC YEAR`, `YEAR OF ADMISSION`,`CLASS ADMITTED`,`YEAR OF COMPLESTION`,`SMS`,`NEW`) VALUES (NULL, '$initials', '$user', '$student_id', '$student_first_name', '$student_last_name', '$date_of_birth', '$home_town', '$nationality', '$rd', '$fs',  '$admmision_date', '$class', 'avatar3.jpg', '$gender', '$guardian_name', '$guardian_address', '$guardian_occupation', '$guardian_tel', '$guardian_rd', '$guardian_rs', '$disabilites', '$admmision_fee', '$paid_date', '$academic_year', '$year','$class_admitted','$year_of_completion','','');")){
                                  
                                     
                                  //insert student as user
                                $student_name = $student_last_name.' '.$student_first_name;
                                mysqli_query($conn,"INSERT INTO `users` (`NO`, `USER ID`, `PASSWORD`, `USER IP`, `LOGIN DATE`, `LOGIN TIME`, `IP ADDRESS`,`SCHOOL`,`USER NAME`,`POSITION`) VALUES (NULL, '$student_id', '', '', '', '', '','$initials','$student_name','STUDENT');");
                                //insert parent as user
                                $parent_id = $student_id;
                                $parent_id = str_replace('-STD','-PT',$parent_id);
                                mysqli_query($conn,"INSERT INTO `users` (`NO`, `USER ID`, `PASSWORD`, `USER IP`, `LOGIN DATE`, `LOGIN TIME`, `IP ADDRESS`,`SCHOOL`,`USER NAME`,`POSITION`,`CONTACT`) VALUES (NULL, '$parent_id', '', '', '', '', '','$initials','".mysqli_real_escape_string($conn,$guardian_name)."','GUARDIAN','".$guardian_tel."');");
                                     
                                 array_push($students_ids,$student_id);
                                 $data = '<span style="color:green">records uploaded</span>';
                             }else{
                                     
                                echo mysqli_error($conn);
                                $data = '<span  style="color:red">records not uploaded, please make sure you are connected to the internet</span>';
                             }
                        }else{
                            foreach($students_ids as $id){
                                mysqli_query($conn,"delete from `admitted_students` where `SCHOOL`='$initials' and `ADMISSION NO / ID`='$id'");
                                $parent_id = $id;
                                $parent_id = str_replace('-STD','-PT',$parent_id);
                                mysqli_query($conn,"delete from `users` where `SCHOOL`='$initials' and `USER ID`='$id'");
                                mysqli_query($conn,"delete from `users` where `SCHOOL`='$initials' and `USER ID`='$parent_id'");
                                
                            }
                            echo mysqli_error($conn);
                            echo '<span style="color:red">Could not find class at excel document row :'.$emapData[5].'</span>';
                            die();
                        }
                        
                     
                    }                                              // add this line
                }
               
           
           }else{
              $data = '<span style="color:red"> Please select a .csv file </span>';
           }
		}
    }else {
		  $data = '<span style="color:red">Please select a .csv file or convert your excel file to a .csv file</span>';
	   }
    
echo $data;
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