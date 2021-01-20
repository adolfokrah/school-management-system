<?php
    include 'school_ini_user_id.php';

    //redirect user to registration stage if user is in registration stage
    if( isset($_REQUEST['ids'])){
        $ids = $_REQUEST['ids'];
        
        foreach($ids as $id){
            $query = mysqli_query($conn,"select * from shelves where ID ='$id'");
            if($fetch = mysqli_fetch_assoc($query)){
                mysqli_query($conn,"update shelves set `SHELF NUMBER`='' where ID ='$id'");
                mysqli_query($conn,"update library_books set `SHELF NUMBER`=''  where `SHELF NUMBER` ='".$fetch['SHELF NUMBER']."'");
            }
        }
        echo 'success';
        }
        
        
    
    
?>