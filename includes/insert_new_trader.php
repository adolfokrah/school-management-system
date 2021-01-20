<?php 
    
   header('Access-Control-Allow-Origin: *');
   header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
    
  if(isset($_POST)){
      echo 'hello';
  }

?>