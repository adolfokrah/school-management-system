<?php
    include 'school_ini_user_id.php';
    include 'sms.php';
  
    if(isset($_REQUEST['check'])){ 
       $sql_2 = mysqli_query($conn,"select * from `school_details` where `INITIALS`='$initials' and `POS`='' ");
       if(mysqli_num_rows($sql_2)!=null){
           mysqli_query($conn,"update `school_details` set `POS`='OFF' where `INITIALS`='$initials'");
           
       }else{
           mysqli_query($conn,"update `school_details` set `POS`='' where `INITIALS`='$initials'");
           echo 'success';
          
       }
       
    }
?>