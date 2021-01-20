<?php
    include 'mysql_connect.php';

    if(isset($_REQUEST['numbers'])&&isset($_REQUEST['names']) &&isset($_REQUEST['message'])){ 
        $message1 = $_REQUEST['message'];
        $numbers = $_REQUEST['numbers'];
        $names = $_REQUEST['names'];
        
        
        $counter = 0;
         foreach($numbers as $number){
$message = 'Dear '.$names[$counter].' , ' .$message1;
            
            if($number !=''){
                if(str_replace(' ','',$number)){
                    
                    if(preg_match('/[0-9]/',$number)){
                         if(strlen($number) >= 10){
                        //echo $number;
                           $number = $number;
                             
                           include 'ZenophSMSGH/examples/non_personalised2.php';
                        }   
                    }
                }
            }
             $counter ++;
         }
          echo 'success';
    }else{
        echo 'error';
    }



?>