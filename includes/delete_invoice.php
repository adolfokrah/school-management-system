<?php
    include 'school_ini_user_id.php';

    //redirect user to registration stage if user is in registration stage
    if( isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
            mysqli_query($conn,"update  `payment_invoices` set `SCHOOL`=''  where ID ='$id'");
            echo 'success';
        }
?>