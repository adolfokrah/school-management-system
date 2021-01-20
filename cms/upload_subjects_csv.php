<?php
    
    //upload crest to database
   //error_reporting(0);
    include '../includes/school_ini_user_id.php';
    include '../includes/resize_image.php';
	$allowedExts = array("csv");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);
    $data = '';
    
   
   $class = '';
    if(isset($_REQUEST['class'])){
        $class = $_REQUEST['class'];
    }
  
	if (in_array($extension, $allowedExts)) {
        
		if ($_FILES["file"]["error"] > 0) {
			 error_box("Return Code: " . $_FILES["file"]["error"]);
		} else {
          $teachers = array();
          $subjects= array();
           if($_FILES["file"]["name"]!=""){
               $filename = $_FILES["file"]["tmp_name"];
               $file = fopen($filename, "r");
                //$sql_data = "SELECT * FROM prod_list_1 ";

                $count = 0;                                         // add this line
                while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
                {
                    
                    //print_r($emapData);
                    //exit();
                    $count++;                                      // add this line

                    if($count>1){                                  // add this line
                         $subject = $emapData[0];
                         $teacher_id = $emapData[1];
                         if($subject !="" || $teacher !=""){
                             $query2 = mysqli_query($conn,"select * from teachers where `TEACHER ID`='$teacher_id' and `SCHOOL`='$initials'");
                                 if(mysqli_num_rows($query2) > 0){
                                    $query = mysqli_query($conn,"select * from subjects where `SCHOOL`='$initials' and `SUBJECT NAME`='$subject' and `CLASS`='$class'");
                                 if(mysqli_num_rows($query) < 1){

                                         if(mysqli_query($conn,"INSERT INTO `subjects` (`ID`, `SCHOOL`, `SUBJECT NAME`, `TEACHER`, `CLASS`) VALUES (NULL, '$initials', '$subject', '$teacher_id', '$class'); ")){
                                            $data = '<span style="color:green">records uploaded</span>';
                                             array_push($teachers,$teacher_id);
                                             array_push($subjects,$subject);
                                             $data = 'success';
                                         }else{
                                            $data = '<span  style="color:red">records not uploaded, please make sure you are connected to the internet</span>';
                                         }
                                        
                                        
                                 }else{
                                     mysqli_query($conn,"update subjects set `TEACHER`='$teacher_id' where `SUBJECT NAME`='$subject' and `SCHOOL`='$initials' and `CLASS`='$class'");
                                     $data = 'success';
                                 } 
                            }else{
                                     $counter=0;
                                     foreach($teachers as $id){
                                         $counter++;
                                         mysqli_query($conn,"delete from subjects where `TEACHER`='$id' and `SUBJECT NAME`='".$subject[$counter]."' and `CLASS`='$class'");
                                     }
                                     echo  '<span style="color:red"> Teacher ID not found at excel document row :'.$count.' </span>';
                                     die();
                                 }
                         }else{
                            // echo 'null';
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

	?>