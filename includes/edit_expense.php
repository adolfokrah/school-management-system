<?php
    include 'school_ini_user_id.php';

    //redirect user to registration stage if user is in registration stage
    if(isset($_REQUEST['item']) && isset($_REQUEST['unit_price']) && isset($_REQUEST['date']) && isset($_REQUEST['id']) && isset($_REQUEST['quantity']) && isset($_REQUEST['disc'])&& isset($_REQUEST['bal']) && isset($_REQUEST['debt'])){
        $item =$_REQUEST['item'];
        $unit_price =$_REQUEST['unit_price'];
        $date =$_REQUEST['date'];
        $bal =$_REQUEST['bal'];
        $debt =$_REQUEST['debt'];
        $disc =mysqli_real_escape_string($conn,$_REQUEST['disc']);
        
       $quantity = $_REQUEST['quantity'];
        $id = $_REQUEST['id'];
        
        
            mysqli_query($conn,"update expenses set `ITEM`='$item',`UNIT PRICE`='$unit_price',`DATE`='$date',`TOTAL AMOUNT`='".($unit_price * $quantity)."',`QUANTITY`='$quantity',`DISCRIPTION`='$disc',`BAL`='$bal',`DEBT`='$debt' where `ID`='$id'");
            echo 'success';
        
    
    }else{
        echo 'error';
    }
?>