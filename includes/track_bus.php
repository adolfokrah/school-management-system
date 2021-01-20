<?php

 include 'school_ini_user_id.php';
 $from = '';
    if(isset($_REQUEST['from'])){
        $from = $_REQUEST['from'];
    }
?>


                            <div class="box-header with-border">
                                    <?php 
                                        $total_busses = 0;
                                        $total_picked = 0;
                                        $total_droped = 0;
                                        $total_left = 0;
                                        $buses = '';
                                        $query = mysqli_query($conn,"select * from busses where `SCHOOL`='$initials'");
                                        while($fetch = mysqli_fetch_assoc($query)){
                                            $bus_number = $fetch['BUS NUMBER'];
                                            $query_check = mysqli_query($conn,"select * from daily_bus_fee where `DATE`= '$from' and `SCHOOL`='$initials' and `BUS`='$bus_number'");
                                            
                                            
                                            $b_total_picked =0;
                                            $b_total_droped =0;
                                            $b_total_left =0;
                                            
                                            while($fetch_2 = mysqli_fetch_assoc($query_check)){
                                                 $total_picked++;
                                                 $b_total_picked++;
                                                 if($fetch_2['DROPED'] ==''){
                                                     $total_left++;
                                                     $b_total_left++;
                                                 }else{
                                                     $total_droped++;
                                                     $b_total_droped++;
                                                 }
                                                
                                             }
                                            if(mysqli_num_rows($query_check)>0){
                                                $total_busses++;
                                                
                                                $buses .='
                                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <!-- Widget: user widget style 1 -->
                                      <div class="box box-widget widget-user-2 box-success" style="box-shadow:0px 0px 4px 1px #ccc;">
                                        <!-- Add the bg color to the header using any of the bg-* classes -->
                                        <div class="header" style="padding:10px;">
                                         <img src="../web_images/school_bus.png" class="img img-responsive"/>
                                        </div>
                                        <div class="box-footer no-padding">
                                          <ul class="nav nav-stacked">
                                            <li><a>Bus Number <span class="pull-right badge bg-blue">'.$bus_number.'</a></span></li>
                                            <li><a>Total Students Picked <span class="pull-right badge bg-green">'.$b_total_picked.'</span></a></li>
                                            <li><a>Total Students Dropped <span class="pull-right badge bg-red">'.$b_total_droped.'</span></a></li>
                                            <li><a>Total Students Left <span class="pull-right badge bg-aqua">'.$b_total_left.'</span></a></li>
                                            <li><a style="cursor:pointer" onclick="track_bus(\''.$bus_number.'\')";><i class="fa fa-map-marker"></i> Track</a></li>
                                           
                                          </ul>
                                        </div>
                                      </div>
                                      
                                      <!-- /.widget-user -->
                                
                                </div>
                                            ';
                                                
                                            }
                                            
                                        }
                                    echo '<span class="label label-primary" style="cursor:pointer">Total buses : <span id="all_busses">'.$total_busses.'</span></span>
                                <span class="label label-success" style="cursor:pointer">Total Students Picked : <span id="active_busses">'.$total_picked.'</span></span>
                                <span class="label label-danger" style="cursor:pointer">Total Students Droped : <span id="faulty_busses">'.$total_droped.'</span></span>
                                <span class="label label-warning" style="cursor:pointer">Total Students Left : <span id="faulty_busses">'.$total_left.'</span></span>';
                                    ?>
                                 </div>
                                <div class="box-body">
                                    <div class="col-sm-12" style="overflow-y:auto; height:600px;" id="busses_box">
                                        <?php echo $buses;?>
                                    </div>
                                    </div>
<script>$(function () { $("[data-toggle='popover']").popover(); }); </script>