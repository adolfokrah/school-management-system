<?php
    include 'includes/mysql_connect.php';
    session_start();
    session_unset();
    session_destroy();
    
    echo "<script>window.open('cpanel2.php','_self');</script>";

?>