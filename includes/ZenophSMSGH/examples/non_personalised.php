<?php

/*
 * This is an example PHP script to send non-personalised message
 * using the PHP SMS library through http://smsonlinegh.com/
 */


    include_once (__DIR__.'/../lib/ZenophSMSGH.php');
    
    try{
        // Initialise the object for sending the message and set parameters.
        $zs = new ZenophSMSGH();
        $zs->setUser('info@easyskul.com');
        $zs->setPassword('GHANA123');
        
        // set message parameters
        $zs->setSenderId($school_id);
        $zs->setMessage($message);
        $zs->setMessageType(ZenophSMSGH_MESSAGETYPE::TEXT); // default is TEXT if you do not set it yourself.
        
        
        // phone numbers can also be in international number format. 
        // the leading '+' is also optional.
        $zs->addDestination($number);
        //$zs->addDestination('+233264432039');  
        
        // after adding phone numbers, the message can be submitted.
        $response = $zs->sendMessage();
        
        // the value returned depends on whether the server returned a token
        // or the submit status of the destinations. You may need to read the
        // documentation for information on handling the value returned from sendMessage();
        if ($response->isTokenResponse() == false)  {
            // we have the destinations and their submit status.
            $destinations = $response->getResponseValue();
            
            // iterate and show destination and status.
            foreach ($destinations as $destination) {
                $phonenumber   = $destination['number'];        // the destination phone number         
                $statusCode    = $destination['statusCode'];    // whether message was submitted to destination or not
                $destinationId = $destination['destinationId']; // assigned to the destination
            }
        }
        
        else {  // a token was rather returned.
            /*
             * a token will always be returned if the message was personalised, 
             * scheduled or when the number of destinations is greater than 400.
             */ 
            $messagetoken = $response->getResponseValue();
        }
        
        
        //deduct sms
        include 'mysql_connect.php';
    
        $user='';
        $shool ='';
        //redirect user to registration stage if user is in registration stage
        if(isset($_SESSION['email']) && !empty($_SESSION['email'])){
            $user =$_SESSION['email'];
            $query = mysqli_query($conn,"select * from `main admins` where `ADMIN EMAIL`='$user'");
            if($fetch = mysqli_fetch_assoc($query)){
                $user = $fetch['ADMIN ID'];
            }
        }else if(isset($_SESSION['USER ID']) && !empty($_SESSION['USER ID'])){
            $user = $_SESSION['USER ID'];
        }

        //pick school details
        $str_pos = strpos($user,'-');
        $initials = substr($user,0,$str_pos);
        
        
        $query = mysqli_query($conn,"select * from  sms_credit where `SCHOOL`='$initials'");
        if($fetch = mysqli_fetch_assoc($query)){
            $sms_left = $fetch['SMS LEFT']-1;
            $sms_used = $fetch['SMS USED']+1;
            
            if($sms_left < 1){
                $sms_left = 0;
            }
            
            mysqli_query($conn,"update sms_credit set `SMS LEFT`='$sms_left',`SMS USED`='$sms_used' where `SCHOOL`='$initials'");
        }
    } 
    
    // when sending requests to the server, ZenophSMSGH_Exception may be
    // thrown if error occurs or the server rejects the request.
    catch (ZenophSMSGH_Exception $ex){
        $errmessage   = $ex->getMessage();
        $responsecode = $ex->getResponseCode();
        
        // the response code indicates the specific cause of the error
        // you will need to compare with the elements in ZenophSMSGH_RESPONSECODE class.
        // for example,
        $response = $zs->sendMessage();
        switch ($response){
            case ZenophSMSGH_RESPONSECODE::ERR_AUTH:
                // authentication failed.
                break;
            
            case ZenophSMSGH_RESPONSECODE::ERR_INSUFF_CREDIT:
                // balance is insufficient to send message to all destinations.
                break;
            
            // you can check for the other causes.
        }
    }
    
    // Exceptions caught here are mostly not the cause of 
    // sending request to the SMS server.
    catch (Exception $ex) {
        $errmessage = $ex->getMessage();
        
        // if the error needs to be echoed.
       // echo $errmessage;
    }
?>