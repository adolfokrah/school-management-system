<?php

    include 'mysql_connect.php';
    

    if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
        $id = $_REQUEST['id'];
        
        $sql ="delete from `main admins` where `ADMIN EMAIL`='$id'";
        $query = mysqli_query($conn,$sql);
        
        $sql ="delete from `school_details` where `ADMIN EMAIL`='$id'";
        $query = mysqli_query($conn,$sql);
        echo 'success';
    }else{
        echo 'error';
    }

?>