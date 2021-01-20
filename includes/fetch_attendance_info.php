<?php
    include 'school_ini_user_id.php';
    
    

    if(isset($_REQUEST['date']) && isset($_REQUEST['class'])){
        $class = $_REQUEST['class'];
        $date = $_REQUEST['date'];
        $fields = array();
        $query  = mysqli_query($conn,"select * from attendance where `SCHOOL`='$initials' and `DATE`='$date' and `CLASS`='$class'");
        if($fetch = mysqli_fetch_assoc($query)){
            $fields[0]=$fetch['TEACHER'];
            $fields[1]=$fetch['DATE'];
            
            echo json_encode($fields);
        }
    }else{
        echo 'error';
    }
?>