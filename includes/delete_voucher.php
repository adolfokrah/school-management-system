<?php

    include 'school_ini_user_id.php';
    
    
    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
        if(mysqli_query($conn,"delete from `payment_invoices` where `ID` = '$id' and `OPERATION`='VOUCHER'")){
            echo 'success';
        }else{
            echo 'error';
        }
        
    }
?>