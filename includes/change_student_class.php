<?php
    include 'school_ini_user_id.php';
    
    
    if(isset($_REQUEST['id']) && isset($_REQUEST['class'])){
        $ids = $_REQUEST['id'];
        $class = $_REQUEST['class'];
        foreach($ids as $id){
            $academic_year = '';
           if($class == "COMPLETED STUDDENTS"){
                 $query_pick = mysqli_query($conn,"select * from academic_years where `SCHOOL`='$initials' and `STATUS`='ACTIVE'");
                if($fetch_row = mysqli_fetch_assoc($query_pick)){
                    $academic_year = $fetch_row['ACADEMIC YEAR'];
                }   
            }
            mysqli_query($conn,"update admitted_students set `PRESENT CLASS`='$class',`YEAR OF COMPLESTION`='$academic_year' where NO='$id'");
             
        }
        echo 'success';
      }else{
        echo 'error';
    }
?>