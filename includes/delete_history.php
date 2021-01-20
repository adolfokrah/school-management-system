<?php
    include 'school_ini_user_id.php';
    include 'get_currencies.php';
    //redirect user to registration stage if user is in registration stage
    if( isset($_REQUEST['ids'])){
        $ids = $_REQUEST['ids'];
        //CHECK IF BILL if bill already exist if yes then update else insert
        
        
        
        
        
        $counter =0;
        foreach($ids as $id){
           mysqli_query($conn,"delete from histories  where `ID`='$id'");
            
            echo mysqli_connect_error();
            $counter ++;
            }
        echo 'success';
        }
        
        
    
    
?>