<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: X-PINGOTHER, Content-Type');
header('Access-Control-Max-Age: 86400');

    include 'mysql_connect.php';

    if(isset($_POST['initials'])){
    $initials = $_POST['initials'];
    $array = array();
    $query = mysqli_query($conn,"select * from sms_credit where `SCHOOL`='$initials'");
    $pecentage = 0;
    $left = 0;
    if($fetch = mysqli_fetch_assoc($query)){
        $left = $fetch['SMS LEFT'];
        $used = $fetch['SMS USED'];
        $total = $left + $used;
        $pecentage = sprintf('%0.1f',($left/$total) * 100);
        
        array_push($array,$left);
        array_push($array,$pecentage);
        
        
        $unit_price =0;
        $query2 = mysqli_query($conn,"SELECT * FROM `sms_cost`");
        if($fetch2 = mysqli_fetch_assoc($query2)){
            $unit_price = $fetch2['UNIT PRICE'];
            $unit_price = sprintf('%0.2f',$unit_price);
            array_push($array,$unit_price);
        }
        
        echo $data = json_encode($array);
    }
    }else{
        echo 'nothing';
    }
?>