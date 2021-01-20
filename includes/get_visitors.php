
<?php
    include 'mysql_connect.php';
    $data = array();


    
    $dates = array();
    //select visitors
    if(isset($_REQUEST['date'])){
    $date= $_REQUEST['date'];
    $query = mysqli_query($conn,"SELECT * FROM `visitors` WHERE `DATE` LIKE '".$date."%' ");
    while($fetch_date = mysqli_fetch_assoc($query)){
        if(!in_array($fetch_date['DATE'],$dates)){
            array_push($dates,$fetch_date['DATE']);
        }
    }

    foreach($dates as $date){
        $query_pick_total = mysqli_query($conn,"select * from `visitors` where `DATE`='$date'");
        $visitors = 0;
        $login_users = 0;
        while($fetch = mysqli_fetch_assoc($query_pick_total)){
            if($fetch['LOGIN IN'] !=''){
                $login_users++;
            }else{
                $visitors++;
            }
        }
        $new_array = array('date'=>$date,'visitors'=>$visitors,'Login users'=>$login_users);
        array_push($data,$new_array);
    }
    
    echo json_encode($data);
    }
?>