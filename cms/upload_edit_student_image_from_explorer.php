<?php
    
    //upload crest to database
    
    include '../includes/school_ini_user_id.php';
    include '../includes/resize_image.php';
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);

   
$id = '';
    if(isset($_SESSION['student_row_id'])){
        $id = $_SESSION['student_row_id'];
    }


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
                $query = mysqli_query($conn,"select * from `admitted_students` where `NO`='$id'");
                if($fetch_query = mysqli_fetch_assoc($query)){
                    //update records
                    $student_id =  $fetch_query['ADMISSION NO / ID'];
                    
                    $filename = $fetch_query['PHOTO'];
                    if($filename =="avatar3.jpg"){

                       
                    }else{
                        // unlink('upload/'.$filename);
                         
                    }
                    
                    $student_id .='.'.$extension;
                    $filename = $student_id;
                    //update row
                    mysqli_query($conn,"update admitted_students set `PHOTO`='$filename' where `NO` ='$id'");
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





	?>