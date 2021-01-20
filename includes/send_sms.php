<?php
    include 'school_ini_user_id.php';
    include 'sms.php';
  
//pick school name
$query_pick_school = mysqli_query($conn,"select * from school_details where `INITIALS`='$initials'");
$school_name  = '';

if($fetch_school_name = mysqli_fetch_assoc($query_pick_school)){
    $school_name = $fetch_school_name['SCHOOL NAME'];
   
}
    if(isset($_REQUEST['message'])&&isset($_REQUEST['numbers'])){ 
        $message1 = $_REQUEST['message'];
        $numbers = $_REQUEST['numbers'];
        
        
        
         foreach($numbers as $number){
$sub = '';
$sub .=$message1;
            
            if($number !=''){
                if(str_replace(' ','',$number)){
                    
                    if(preg_match('/[0-9]/',$number)){
                         if(strlen($number) >= 10){
                        //echo $number;
                             
                             $query = mysqli_query($conn,"select * from  sms_credit where `SCHOOL`='$initials' and `SMS LEFT`>0");
                            if(mysqli_num_rows($query)!=null){
                                //$number = str_replace(' ','',$_REQUEST['guardiantel']);
                                $message = $sub;
                                send_normal_sms($message,$number,$initials,$conn);

                            }else{
                                echo 'fail';
                            }
                        
                        }   
                    }
                }
            }
             
         }
          echo 'success';
    }else{
        echo 'error';
    }



?>