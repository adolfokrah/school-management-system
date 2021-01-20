<?php
    include 'school_ini_user_id.php';
    
  
    if(isset($_REQUEST['categories']) && isset($_REQUEST['id'])){ 
        $categories = $_REQUEST['categories'];
        $id = $_REQUEST['id'];
        //check if class already exist
        mysqli_query($conn,"update shelves set `BOOKS CATEGORIES`='".mysqli_real_escape_string($conn,$categories)."' where `ID`='$id'");
        echo 'success';
    }else{
        echo 'error';
    }
?>