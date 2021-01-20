<?php
    include 'school_ini_user_id.php';
    
  
    if(isset($_REQUEST['category']) && isset($_REQUEST['book_name']) && isset($_REQUEST['Publisher']) && isset($_REQUEST['shelf']) && isset($_REQUEST['booknumber'])){ 
        $categories = $_REQUEST['category'];
        $book_name = $_REQUEST['book_name'];
        $Publisher = $_REQUEST['Publisher'];
        $shelf = $_REQUEST['shelf'];
        $booknumber = $_REQUEST['booknumber'];
        //check if class already exist
        
        
        mysqli_query($conn,"update library_books set `CATEGORY`='".mysqli_real_escape_string($conn,$categories)."',`BOOK NAME`='".mysqli_real_escape_string($conn,$book_name)."' ,`PUBLISHER`='".mysqli_real_escape_string($conn,$Publisher)."' where `BOOK NUMBER`='$booknumber' and `SCHOOL`='$initials'");
        
        echo 'success';
    }else{
        echo 'error';
    }
?>