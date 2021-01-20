<?php
    include 'school_ini_user_id.php';
    include 'sms.php';
  
    if(isset($_REQUEST['bus_number']) && !empty($_REQUEST['bus_number'])){ 
        $id =$_REQUEST['bus_number'];
        if( mysqli_query($conn,"update busses set `STATUS`='DELETED' where `SCHOOL`='$initials' and `BUS NUMBER`='$id'")){
            echo 'success';
        }else{
            echo 'error';
        }
        
    }else{
        
         if(mysqli_query($conn,"delete from users where `SCHOOL`='$initials' and `POSITION`='BUS DRIVER'")){
            if(mysqli_query($conn,"update busses set `STATUS`='DELETED' where `SCHOOL`='$initials'")){
             echo 'success';
            }else{
                echo 'error';
            }
         }
    }


?>