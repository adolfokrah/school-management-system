<?php

 include 'school_ini_user_id.php';
 $bus_number = '';
 $date ='';
 $width =0;
 $locatios  =array();
 $total_locs = 0;
$c_loc ='';
$count=0;
    if(isset($_REQUEST['bus_number']) && isset($_REQUEST['date']) && !empty($_REQUEST['bus_number']) && !empty($_REQUEST['date'])){
        $bus_number = $_REQUEST['bus_number'];
        $date = $_REQUEST['date'];
        
        $query_pick_locations = mysqli_query($conn,"select * from daily_bus_fee where `BUS`='$bus_number' and `DATE`='$date' and `SCHOOL`='$initials'");
        while($fetch_locs = mysqli_fetch_assoc($query_pick_locations)){
            if(!(in_array($fetch_locs['LOCATION'],$locatios))){
                array_push($locatios,$fetch_locs['LOCATION']);
                $total_locs++;
                
            }
        }
       
        ?>
<div class="content" style="padding:0px;">
        <div class="box box-danger">

        <div class="box-header with-border" style="overflow-x:auto; padding:10px;">
            <ol class="breadcrumb">Bus stops <span class="badge bg-aqua"><?php echo $bus_number; ?></span></ol>
            <?php 
                $query = mysqli_query($conn,"select * from `bus_tracking` where `BUS NUMBER`='$bus_number' and `DATE`='$date'and `SCHOOL`='$initials'");
                while($fetch = mysqli_fetch_assoc($query)){
                    $count++;
                    $time = $fetch['TIME'];
                    echo '<span class="label label-primary" style="cursor:pointer" onclick="get_location(\''.htmlentities($fetch['LOCATION']).'\')" data-toggle="tooltip" title="'.$time.'" data-placement="top"><span id="all_busses">'.htmlentities($fetch['LOCATION']).'</span></span> ';
                    $c_loc = htmlentities($fetch['LOCATION']);
                }
       
            $width = ($count/$total_locs)*100;
            $width = $width.'%';
            ?>
            </div>
             
            <div class="box-body">
                <div id="bus_locations" >
                 <div class="progress  active">
                    <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $width;?>" id="pogress_bar">
                      <span class="sr-only">20% Complete</span>

                    </div><img src="../web_images/school_bus.png" width="40px" data-toggle="tooltip" title="<strong>current bus top:</strong> <br/><?php echo $c_loc.' '.$time;?>" data-placement="top" id="popover" style="cursor:pointer" onclick="get_location('<?php echo $c_loc;?>')"/>
                  </div>
             </div>
                <div id="map_frame"></div>
                
            </div>
        </div>
            </div>
     </div>
<?php
    }
?>
<script>$(function(){
                $('[data-toggle="tooltip"]').tooltip({html : true });
            });</script>
