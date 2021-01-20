<?php
    include 'school_ini_user_id.php';

    //redirect user to registration stage if user is in registration stage
    if(isset($_REQUEST['ids'])){
        $ids = $_REQUEST['ids'];
        
        foreach($ids as $id){
            mysqli_query($conn,"delete from expenses where `ID`='$id'");
        }
        echo 'success';
    
    }else{
        echo 'error';
    }
?>