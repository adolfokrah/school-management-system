<?php
    
    //upload crest to database
    include 'resize_image.php';
    include 'mysql_connect.php';
     $email = "";
    include 'message_boxes.php';
     session_start();
      if($_SESSION['email']&&!empty($_SESSION['email'])){
        $email = $_SESSION['email'];
      }
  
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
                $filename = 'IMG-'.md5($_FILES['file']['name'].''.$email);
                $filename .='_'. date('Y-M-D');
                $filename .='.'.$extension;


                move_uploaded_file($_FILES["file"]["tmp_name"],"../image_uploads_crests/".$filename);
            
                //delete previous image
                $query = mysqli_query($conn,"select * from school_details where `ADMIN EMAIL`='$email' and `CREST` !=''");
                if($fetch = mysqli_fetch_assoc($query)){
                    $previous_image = $fetch['CREST'];
                    if(file_exists('../image_uploads_crests/'.$previous_image)){
                        //unlink('../image_uploads_crests/'.$previous_image);
                    }
                      
                }
                mysqli_query($conn,"update school_details set `CREST`='$filename' where `ADMIN EMAIL`='$email'");
                $img = resize_image("../image_uploads_crests/".$filename, 200, 200);
                    // again for jpg
                imagejpeg($img,"../image_uploads_crests/".$filename);
                echo $filename;
            }
             
            
		}else {
		  echo 'error';
	   }
	?>