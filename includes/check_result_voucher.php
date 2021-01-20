<?php
    include 'school_ini_user_id.php';
    
  
    if(isset($_REQUEST['voucher_code']) && isset($_REQUEST['id'])){ 
        $voucher_code = ($_REQUEST['voucher_code']);
        $id = $_REQUEST['id'];
        
        $num_rows = mysqli_query($conn,"select * from `results_vouchers` where `CODE`='$voucher_code'");
        if($fetch = mysqli_fetch_assoc($num_rows)){
            if($fetch['USED'] == ''){
                
                mysqli_query($conn,"update `results_vouchers` set `USED`='true' where `CODE`='$voucher_code'");
                mysqli_query($conn,"update `terminal_reports_av` set `VIEWED`='yes' where `ID`='$id'");
                
                $_SESSION['voucher_code']=$voucher_code;
                echo 'success';
            }else{
                echo 'used';
            }
        }else{
            echo 'notfound';
        }
    }else{
        echo 'error';
    }

?>