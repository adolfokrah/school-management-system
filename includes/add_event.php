<?php
    include 'school_ini_user_id.php';

    //redirect user to registration stage if user is in registration stage
    if( isset($_REQUEST['event_name']) && isset($_REQUEST['start_date']) && isset($_REQUEST['end_date'])&& isset($_REQUEST['event_color']) ){
        $event_name = $_REQUEST['event_name'];
        $start_date = $_REQUEST['start_date'];
        $end_date = new DateTime($_REQUEST['end_date']);
        $event_color = $_REQUEST['event_color'];
        
        $day = $end_date->format('d');
        $month = $end_date->format('m');
        $year = $end_date->format('Y');
        
        $new_date = $year.'-'.($month).'-'.($day+1);
        //insert event
        mysqli_query($conn,"INSERT INTO `events` (`ID`, `SCHOOL`, `POSTED BY`, `DATE`, `END DATE`, `EVENT`, `COLOR`) VALUES (NULL, '$initials', '$user', '$start_date', '".$new_date."', '".mysqli_real_escape_string($conn,$event_name)."', '$event_color'); ");
        
        echo 'success';
        }
        
        
    
    
?>