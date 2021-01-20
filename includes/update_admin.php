<?php
    include 'school_ini_user_id.php';

    if(isset($_REQUEST['admin_id']) && isset($_REQUEST['admin_name']) && isset($_REQUEST['phone_number']) &&  isset($_REQUEST['email'])){
        
        $id = $_REQUEST['admin_id'];
        $admin_name = $_REQUEST['admin_name'];
        $admin_numbers = $_REQUEST['phone_number'];
        $admin_email = $_REQUEST['email'];
    
        mysqli_query($conn,"update users set `USER NAME`='".mysqli_real_escape_string($conn,$admin_name)."',`EMAIL`='".mysqli_real_escape_string($conn,$admin_email)."',`CONTACT`='".mysqli_real_escape_string($conn,$admin_numbers)."' where `USER ID`='$id'");
       
if(strpos($id,'-AD')){
        if(mysqli_query($conn,"update `main admins` set `ADMIN NAME`='".mysqli_real_escape_string($conn,$admin_name)."', `ADMIN EMAIL`='".mysqli_real_escape_string($conn,$admin_email)."' ,`ADMIN NUMBER`='".mysqli_real_escape_string($conn,$admin_numbers)."' where `ADMIN ID`='$id'")){
                
                mysqli_query($conn,"update `school_details` set `ADMIN EMAIL`='".mysqli_real_escape_string($conn,$admin_email)."' where `INITIALS`='$initials'");
            
               
            }else{
                echo ' this error';
            }
}
             
   echo 'success';          
      
    }else{
        echo 'error';
    }
?>