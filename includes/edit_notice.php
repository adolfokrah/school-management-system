<?php
    include 'school_ini_user_id.php';
    
  
    if(isset($_REQUEST['notice']) && isset($_REQUEST['id'])){ 
        $notice = $_REQUEST['notice'];
        $id = $_REQUEST['id'];
        //check if class already exist
        mysqli_query($conn,"update noticeboard set `INFO`='".mysqli_real_escape_string($conn,$notice)."' where `ID`='$id'");
        echo 'success';
    }else{
        echo 'error';
    }
?>