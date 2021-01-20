<?php
    include 'school_ini_user_id.php';
    include 'get_currencies.php';
    //redirect user to registration stage if user is in registration stage
    if(isset($_REQUEST['item']) && isset($_REQUEST['unit_price']) && isset($_REQUEST['date']) && isset($_REQUEST['action']) && isset($_REQUEST['quantity'])&& isset($_REQUEST['disc'])&& isset($_REQUEST['bal']) && isset($_REQUEST['debt'])){
        $item =$_REQUEST['item'];
        $unit_price =$_REQUEST['unit_price'];
        $date =$_REQUEST['date'];
        $action =$_REQUEST['action'];
       $quantity = $_REQUEST['quantity'];
       $bal = $_REQUEST['bal'];
       $debt = $_REQUEST['debt'];
       $disc = mysqli_real_escape_string($conn,$_REQUEST['disc']);
        $operation='';
        
        if($action != ""){
            mysqli_query($conn,"update expenses set `STATUS`='' where `SCHOOL`='$initials' and `USER ID`='$user'");
            $operation = 'Expenses made saved';
            echo 'success';
        }else{
            mysqli_query($conn,"INSERT INTO `expenses` (`ID`, `SCHOOL`, `ITEM`, `UNIT PRICE`, `QUANTITY`, `TOTAL AMOUNT`, `DATE`,`DISCRIPTION` ,`USER ID`, `STATUS`,`BAL`,`DEBT`) VALUES (NULL, '$initials', '$item', '$unit_price', '$quantity', '".($unit_price * $quantity)."', '$date','$disc', '$user', 'NEW','$bal','$debt')");
            $operation = 'Expense of item '.$item.' unit price of '.$currency.' '.$unit_price.' of '.$date.' Discription : <strong>"'.$disc.'"<strong> inserted';
            //insert history
            echo 'success';
        }
        
        $date = date('Y-m-d');
        $time = new datetime('now',new DateTimeZone('Europe/London'));
        $current_time = $time->format('h:i:s a');

        mysqli_query($conn,"INSERT INTO `histories` (`ID`, `SCHOOL`, `USER ID`, `OPERATION`, `DATE`, `TIME`, `ACTION`) VALUES (NULL, '$initials', '$user', '".mysqli_real_escape_string($conn,$operation)."', '$date', '$current_time', '');");
        echo mysqli_connect_error();
    
    }else{
        echo 'error';
    }
?>