<?php
    
    //upload crest to database
   //error_reporting(0);
    include '../includes/school_ini_user_id.php';
    include '../includes/resize_image.php';
	$allowedExts = array("csv");
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

                $count = 0;                                         // add this line
                while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
                {
                    
                    //print_r($emapData);
                    //exit();
                    $count++;                                      // add this line

                    if($count>1){                                  // add this line
                         $class = $emapData[0];
                         if($class !=""){
                              $query = mysqli_query($conn,"select * from classes where `SCHOOL`='$initials' and `CLASS`='$class'");
                             if(mysqli_num_rows($query) < 1){
                                if(mysqli_query($conn,"INSERT INTO `classes` (`ID`, `SCHOOL`, `CLASS`) VALUES (NULL, '$initials', '$class');")){
                                    $data = '<span style="color:green">records uploaded</span>';
                                 }else{
                                    $data = '<span  style="color:red">records not uploaded, please make sure you are connected to the internet</span>';
                                 }
                             }
                         
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