<?php
    include 'school_ini_user_id.php';

  
    if(isset($_REQUEST['bus_number'])&&isset($_REQUEST['bus_driver']) &&isset($_REQUEST['driver_number']) &&isset($_REQUEST['locations'])&&isset($_REQUEST['status'])&&isset($_REQUEST['id'])){ 
        $bus_number = $_REQUEST['bus_number'];
        $bus_driver = $_REQUEST['bus_driver'];
        $driver_number = $_REQUEST['driver_number'];
        $locations = $_REQUEST['locations'];
        $status = $_REQUEST['status'];
        $id = $_REQUEST['id'];
        
        //check if buss already exist
        $year = date('Y');
     
     $query = mysqli_query($conn,"select * from busses where `SCHOOL`='$initials' and `BUS NUMBER`='$bus_number' and `ID` != '$id'");
     if(mysqli_num_rows($query) == null){
         
         if(mysqli_query($conn,"update busses set `BUS NUMBER`='$bus_number',`BUS DRIVER`='$bus_driver',`DRIVER TEL`='$driver_number',`LOCATIONS`='$locations',`STATUS`='$status' where `ID`='$id' and `SCHOOL`='$initials'")){
             echo 'success';
         }else{
              echo '<div class="alert alert-danger alert-dismissable"> <button type="button"class="close"data-dismiss="alert"aria-hidden="true">&times;</button>An error occured.</div>';
         }
     }else{
          echo '<div class="alert alert-danger alert-dismissable"> <button type="button"class="close"data-dismiss="alert"aria-hidden="true">&times;</button>Bus with Number : '.$bus_number.' already exist.</div>';
     }
       
    }else{
         echo '<div class="alert alert-danger alert-dismissable"> <button type="button"class="close"data-dismiss="alert"aria-hidden="true">&times;</button>An error occured.</div>';
    }


?>