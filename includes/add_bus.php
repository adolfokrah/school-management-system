<?php
    include 'school_ini_user_id.php';
    include 'sms.php';
  
    if(isset($_REQUEST['bus_number'])&&isset($_REQUEST['bus_driver']) &&isset($_REQUEST['driver_number']) &&isset($_REQUEST['locations'])&&isset($_REQUEST['status'])){ 
        $bus_number = $_REQUEST['bus_number'];
        $bus_driver = $_REQUEST['bus_driver'];
        $driver_number = $_REQUEST['driver_number'];
        $locations = $_REQUEST['locations'];
        $status = $_REQUEST['status'];
        
        //check if buss already exist
        $year = date('Y');
     $userid =  generate_driver_id($initials, $year, 'BSD',$conn);
     $query = mysqli_query($conn,"select * from busses where `SCHOOL`='$initials' and `BUS NUMBER`='$bus_number'");
     if(mysqli_num_rows($query) == null){
          if(mysqli_query($conn,"INSERT INTO `busses` (`ID`, `SCHOOL`, `BUS NUMBER`, `BUS DRIVER`,`DRIVER ID`, `DRIVER TEL`, `LOCATIONS`, `STATUS`) VALUES (NULL, '$initials', '".mysqli_real_escape_string($conn,$bus_number)."',  '".mysqli_real_escape_string($conn,$bus_driver)."', '$userid', '".mysqli_real_escape_string($conn,$driver_number)."',  '".mysqli_real_escape_string($conn,$locations)."', '".mysqli_real_escape_string($conn,$status)."');")){
              
              $sql = "insert into `users`(`NO`, `USER ID`, `PASSWORD`, `SCHOOL`, `USER NAME`, `POSITION`, `CONTACT`, `GENDER`, `EMAIL`, `ADDRESS`, `USER IP`, `LOGIN DATE`, `LOGIN TIME`, `IP ADDRESS`) values (NULL, '".$userid."', '', '".$initials."', '".mysqli_real_escape_string($conn,$bus_driver)."', '".mysqli_real_escape_string($conn,'BUS DRIVER')."', '".mysqli_real_escape_string($conn,$driver_number)."', '".mysqli_real_escape_string($conn,'')."', '".mysqli_real_escape_string($conn,'driver@driver.com')."', '".mysqli_real_escape_string($conn,'')."', '', '', '', '')";
              mysqli_query($conn,$sql);
              
              //pick school name
$query_pick_school = mysqli_query($conn,"select * from school_details where `INITIALS`='$initials'");
$school_name  = '';
if($fetch_school_name = mysqli_fetch_assoc($query_pick_school)){
    $school_name = $fetch_school_name['SCHOOL NAME'];
}
/*$message = 'Message From '.$school_name.'
Dear '.$bus_driver.', your USER ID is '.$userid.'. Use this to access your portal on https://www.easyskul.com.Please visit our portal to add your account before you can login to our system.
';*/
                
if($driver_number !=''){
    if(str_replace(' ','',$driver_number)){
        if(strlen($driver_number) == 10){
            send_normal_sms($message,$driver_number,$initials,$conn);
        }

    }
}
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

 function generate_driver_id($school_initials, $year, $init,$conn){
        $select_teachers_number = mysqli_query($conn,"select * from `busses` where `SCHOOL`='$school_initials'");
     $number_rows = mysqli_num_rows($select_teachers_number);
     $number_rows++;
     $number_rows = str_pad($number_rows, 5, "0", STR_PAD_LEFT);
     
     $teacher_id = $school_initials."-".$init."_".$year."".$number_rows."D";
     return $teacher_id;
    }

?>