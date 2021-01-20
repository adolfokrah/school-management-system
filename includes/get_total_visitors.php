
<?php
    include 'mysql_connect.php';
    $data = array();


    
    $dates = array();
    //select visitors
    if(isset($_REQUEST['date'])){
    $date= $_REQUEST['date'];
    $query = mysqli_query($conn,"SELECT * FROM `visitors` WHERE `DATE` LIKE '".$date."%' ");
    $num_rows = mysqli_num_rows($query);
    echo '<span class="description-percentage text-green"><i class="fa fa-caret-up"></i>'.sprintf('%0.2f',(($num_rows/1000)*100)).'%</span>
    <h5 class="description-header">'.number_format($num_rows).'</h5>
    <span class="description-text">TOTAL</span>
    <input type="hidden" value='.$date.' id="date"/>' 
    ;
    }
?>