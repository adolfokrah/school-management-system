<?php
    include 'school_ini_user_id.php';
    $fields = array();
    //redirect user to registration stage if user is in registration stage
    if(isset($_REQUEST['id'])){
        $id =$_REQUEST['id'];
        
        $query_get_fields = mysqli_query($conn,"select * from expenses where `ID`='$id'");
        if($fetch = mysqli_fetch_assoc($query_get_fields)){
            $fields[0]=$fetch['ITEM'];
            $fields[1]=$fetch['UNIT PRICE'];
            $fields[2]=$fetch['QUANTITY'];
            $fields[3]=$fetch['DATE'];
            $fields[4]=$fetch['ID'];
            $fields[5]=$fetch['DISCRIPTION'];
            $fields[6]=$fetch['BAL'];
            $fields[7]=$fetch['DEBT'];
            
            echo json_encode($fields);
        }
    
    }else{
        echo 'error';
    }
?>