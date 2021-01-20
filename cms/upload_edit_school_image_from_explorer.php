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
                $query = mysqli_query($conn,"select * from `school_details` where `INITIALS`='$initials'");
                if($fetch_query = mysqli_fetch_assoc($query)){
                    //update records
                    
                    
                    $filename = $fetch_query['CREST'];
                    if($filename == "default_crest"){
                        $filename = 'IMG-'.md5($_FILES['file']['name'].''.$user);
                        $filename .='_'. date('Y-M-D');
                        $filename .='.'.$extension;
                       
                    }else{
                        // unlink('image_uploads_crests/'.$filename);
                         
                    }
                    //update row
                    mysqli_query($conn,"update school_details set `CREST`='$filename' where `INITIALS` ='$initials'");
                    move_uploaded_file($_FILES["file"]["tmp_name"],"../image_uploads_crests/".$filename);
                    
                    $img = resize_image("../image_uploads_crests/".$filename, 200, 200);
                    // again for jpg
                    imagejpeg($img,"../image_uploads_crests/".$filename);
                    
                    echo $filename;

                }
            }
             
            
		}else {
		  echo 'error';
	   }





	?>