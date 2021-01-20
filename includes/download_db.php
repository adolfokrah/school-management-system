<?php 
    include 'school_ini_user_id.php';

if(isset($_GET['t']) && !empty($_GET['t'])){
    $table_name = $_GET['t'];
    exportMysqlToCsv($table_name,$conn,$initials);
}
function exportMysqlToCsv($table_name,$conn,$initials){

    $sql_data="select * from `".$table_name."` where `SCHOOL`='$initials'";
    $result_data=mysqli_query($conn,$sql_data);
    if(mysqli_num_rows($result_data) > 0){
        
    
    $results=array();
    $date = date('Y-M-D');
    $filename = $initials.'_'.$table_name.'_'.$date.'.xls';
    // Download file
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Content-Type: application/vnd.ms-excel");

    $flag = false;
    while ($row = mysqli_fetch_assoc($result_data)) {
        if (!$flag) {
            // display field/column names as first row
            echo implode("\t", array_keys($row)) . "\r\n";
            $flag = true;
        }
        echo implode("\t", array_values($row)) . "\r\n";
    }
}
}
?>