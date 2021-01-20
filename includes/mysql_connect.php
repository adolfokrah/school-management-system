<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: X-PINGOTHER, Content-Type');
header('Access-Control-Max-Age: 86400');


//error_reporting(0);
//    $host = 'localhost';
//    $username = 'root';
//    $password = '';
//    $database_name  ='bittrader';


  // error_reporting(0);
   // declare data base variables
    $hostname = 'server222.web-hosting.com';
    $username = 'bittuoxf_bittuoxf';
    $password = 'QD2!?kPpMXX3';
    $database_name = 'bittuoxf_easyskul_db';

//    $hostname = 'localhost';
//    $username = 'root';
//    $password = '';
//    $database_name = 'easyskul_db';
    
    $conn =  mysqli_connect($hostname,$username,$password,$database_name);
    
    if($conn){
        //echo 'connected';
    }
//    //connect to mysql database
//    mysql_connect($hostname,$username,$password);
//    //select easyskul database
//    mysql_select_db($database_name);
?>