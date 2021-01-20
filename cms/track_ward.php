<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Easyskul - CMS::Track my ward</title>
        <link href="../web_images/logo2.png" rel="icon"/>
         <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="../css/font-awesome.css">
        <link rel="stylesheet" href="../bootstrap-3.3.7-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../css/sidebar.css">
        <link rel="stylesheet" href="../css/cms_style.css">
        
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="../css/cms_style.css">
        <link rel="stylesheet" href="bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="../bootstrap-3.3.7-dist/css/boostrap-select.min.css">
        <!--add the tables css-->
        <link rel="stylesheet" type="text/css" href="datatables/dataTables.bootstrap.css"/>
        <script src="../js/jQuery-v2.1.3.js"></script>
        <script src="sweetalert2-master/dist/sweetalert2.all.min.js"></script>
        <script src="../js/bootstrap-select.min.js"></script>
        <script src="../js/cms.js"></script>
        <script src="//code.tidio.co/oc6tcjthxgtesxrtpwutqwmcbl4txaih.js"></script>

    </head>
    
    
    <body>



        <div class="wrapper">
            <!-- Sidebar Holder -->
            <?php 
            $users = array("Parent");
            include '../includes/cms_sidebar.php';
        ?>

            <!-- Page Content Holder -->
            <div id="content">
<?php include '../includes/cms_header.php';
                    include '../includes/redirect_admin.php';
                ?>                       
                <div id="box">
                 
                    <div class="content" style="padding:20px; padding-top:0px;">
                       
                       
                        <div class="col-sm-12" style="padding-top:20px;">
                                <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <span style="color:#6b6b6b"><?php echo $username; ?> CMS / Track my ward / <strong><?php echo str_replace('-PT','-STD',$user)?></strong></span> <span style="color:#3c8dbc"></span>
                                </div>
                            </div>
                            
                            </div>
                        </div>
                        <div class="col-sm-12" style="padding-top:20px;">
                             <div class="box box-warning">
                                 
                                 <div class="box-body" >
                                    <?php 
                                        $date = date('Y-m-d');
                                        $student_id = str_replace('-PT','-STD',$user);
                                        $query = mysqli_query($conn,"select * from `daily_bus_fee` where `STUDENT ID`='$student_id' and `DATE`='$date'");
                                       $bus_number='';
                                        if($fetch = mysqli_fetch_assoc($query)){
                                            $bus_stop='';
                                            $ctime = '';
                                            $time = '';
                                            $bus_number = $fetch['BUS'];
                                            $query_pick = mysqli_query($conn,"select * from bus_tracking where `BUS NUMBER`='$bus_number' and `DATE`='$date' and `SCHOOL`='$initials'");
                                            while($fetch_bus = mysqli_fetch_assoc($query_pick)){
                                                $bus_stop = $fetch_bus['LOCATION'];
                                                $ctime = $fetch_bus['TIME'];
                                                if($bus_stop == $fetch['DROPED']){
                                                    $time = $fetch_bus['TIME'];
                                                }
                                            }
                                            echo '<div class="col-sm-12 col-md-6">
                                                <form>
                                                    
                                                    <div class="form-group">
                                                   <lable>STUDENT NAME</label><br/><br/>
                                                    <input type="text" value="'.$fetch['STUDENT NAME'].'" class="form-control" readonly/>
                                                   </div>
                                                   
                                                   <div class="form-group">
                                                   <lable>BUS NUMBER</label><br/><br/>
                                                    <input type="text" value="'.$fetch['BUS'].'" class="form-control" readonly/>
                                                   </div>
                                                   
                                                   <div class="form-group">
                                                   <lable>DROPPING AT</label><br/><br/>
                                                    <input type="text" value="'.$fetch['LOCATION'].'" class="form-control" readonly onfocus="view_log(\''.$fetch['LOCATION'].'\')"/>
                                                   </div>
                                                   
                                                </form>
                                            </div>
                                            <div id="bus_track">
                                            <div class="col-sm-12 col-md-6">
                                                <form>
                                                    
                                                    <div class="form-group">
                                                   <lable>BUS SET OFF TIME</label><br/><br/>
                                                    <input type="text" value="'.$fetch['BUS LEFT TIME'].'" class="form-control" readonly/>
                                                   </div>
                                                   
                                                       <div class="form-group">
                                                       <lable>BUS CURRENT STOP</label><br/><br/>
                                                        <input type="text" value="'.$bus_stop.'" class="form-control" readonly onfocus="view_log(\''.$bus_stop.'\')"/>
                                                       </div>

                                                       <div class="form-group">
                                                       <lable>TIME STOPPED</label><br/><br/>
                                                        <input type="text" value="'.$ctime.'" class="form-control" readonly/>
                                                       
                                                   </div>
                                                   
                                                   
                                               
                                            </div>';
                                            echo '<div class="col-sm-12">';
                                            if($fetch['DROPED'] !=''){
                                                 echo '
                                            <button class="btn btn-block btn-success" type="button"  onclick="view_log(\''.$fetch['DROPED'].'\')"  style="margin-bottom:50px;">Dropped at <strong>'.$fetch['DROPED'].' - '.$time.'</strong></button>
                                            ';
                                            }else{
                                                 echo '
                                            <button class="btn btn-block btn-danger" type="button">STILL IN BUS</button>
                                             </form>
                                             
                                            ';
                                            }
                                            echo '</div>';
                                           echo '</div>
                                                   <input type="hidden" value="'.$student_id.'" id = "student_id"/>
                                                   <input type="hidden" value="'.$date.'" id = "date"/>
                                                   <input type="hidden" value="'.$bus_number.'" id = "bus_number"/>
                                                   
                                                   <div id="map_framea"></div>';
                                        }else{
                                            echo '<h2>Sorry! Your child did not board a bus today.</h2>';
                                        }
                                     ?>
                                 </div> 
                                 
                                
                            </div>
                            
                        
                        </div>
                        </div>
                    
                     
                    </div>  
                
                
             
            </div>
        

        </div>


<!--modl boxes-->
         <div class="modal fade" id="fclass" style="z-index:5000;">
             <div class="modal-dialog " style="z-index:5000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                         <h2 class="modal-title"><i class="fa fa-book"></i>Select Class To Generate Report</h2>
                     </div>
                     <div class="modal-body" id="modal_results">
                         <form class="form-inline" role="form">
                             <div class="form-group" style="margin-top:0px;">
                            <label><small id="classv">Present class: </small></label><br/>
                           <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width:100%;" id="class" name="class">
                            <?php
                                    $qeuery_pick_classes = mysqli_query($conn,"select * from classes where `SCHOOL`='$initials' order by ID asc");
                                    while($fetch = mysqli_fetch_assoc($qeuery_pick_classes)){
                                        echo '<option value="'.htmlentities($fetch['CLASS']).'" >'.htmlentities($fetch['CLASS']).'</option>';
                                    }
                               ?>

                          </select>

                        </div>
                             <div class="form-group" style="margin-top:25px;">
                                 <button class="btn btn-danger" onclick="print_bus_fee_history('<?php echo $from?>','<?php echo $to?>')" type="button"><i class="fa fa-print"></i> Generte report</button>
                             </div>
                         </form>
                     </div>
                       
                 </div>
             </div>
         </div>
        
        <div class="modal fade" id="edit_feeding">
             <div class="modal-dialog" style="z-index:3000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         
                         <ol class="breadcrumb"><strong>You are about to make changes to this record. </strong><button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button></ol>
                     </div>
                     <div class="modal-body" id="modal_results2">
                         
                     </div>
                       
                 </div>
             </div>
         </div>
        
        
        
        <!-- jQuery CDN -->
         
         <!-- Bootstrap Js CDN -->
         <script src="../js/boostrap.min.js"></script>
        
        <!--add the table js-->
        <script src="datatables/jquery.dataTables.min.js" id="script1"></script>
        <script src="datatables/dataTables.bootstrap.min.js" id="script2"></script>
        <script src="../js/table.js" id="script3"></script>
        <script src="bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
        <script src="bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>
        <script src="webcam/webcamjs/webcam.min.js"></script>
        <script src="../js/webcam_config.js"></script>
         <script type="text/javascript">
             $(document).ready(function () {
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                 });
                 
                 $('.list-unstyled li:nth-child(11) ul').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(11) a').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(11) ul').toggleClass('collapse in');
                 $('.list-unstyled li:nth-child(11) a').toggleClass('');
                 $('.list-unstyled li:nth-child(11) ul li:nth-child(2)').toggleClass('active');
                setInterval(fetch_bus_location,10000);
             });
            
            
            
             
             $('.form_date').datetimepicker({
                language:  'en',
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                minView: 2,
                forceParse: 0
            });
             
             $('input[type="checkbox"]').on('click',function(){
                if(this.checked){
                    $('#row'+this.name).css('background-color','#2e89ab');
                    $('#row'+this.name).css('color','#fff');
                    $('.dropdown').css('color',"#3b3b3b");
                    var all_checked = false;
                    
                    var check_boxes = document.getElementsByClassName('checkboxes');
                    
                    for(var x=0; x < check_boxes.length; x++){
                        if(check_boxes[x].checked){
                            all_checked = true;
                        }else{
                            all_checked = false;
                            break;
                        }
                    }
                    var all_check_box = document.getElementById('check_all');
                    if(all_checked==true){
                        all_check_box.checked = true;
                    }
                    
                    
                }else{
                    $('#row'+this.name).css('background-color','');
                    $('#row'+this.name).css('color','#000');
                    
                    var all_check_box = document.getElementById('check_all');
                    
                    if(all_check_box.checked){
                        all_check_box.checked = false;
                    }
                } 
             });
             
             $('#check_all').on('click',function(){
                 
                 if(this.checked){
                    var check_boxes = document.getElementsByClassName('checkboxes');
                    
                    for(var x=0; x < check_boxes.length; x++){
                        check_boxes[x].checked = true;
                        var checkbox_id = check_boxes[x].name;
                        $('#row'+checkbox_id).css('background-color','#2e89ab');
                        $('#row'+checkbox_id).css('color','#fff');
                        $('.dropdown').css('color',"#3b3b3b");
                    }
                }else{
                    var check_boxes = document.getElementsByClassName('checkboxes');
                    
                    for(var x=0; x < check_boxes.length; x++){
                        check_boxes[x].checked = false;
                        var checkbox_id = check_boxes[x].name;
                        $('#row'+checkbox_id).css('background-color','');
                        $('#row'+checkbox_id).css('color','#000');
                    }
                }
             })
             
             function fetch_bus_location(){
                 var student_id = $('#student_id').val();
                 var date = $('#date').val();
                 var bus_number = $('#bus_number').val();
                 $.post("../includes/track_ward_bus.php", {
                        student_id:student_id,date:date,bus:bus_number
                 },function(data){
                        $('#bus_track').html(data);
                  })
                 
             }
             
             function view_log(location){
                 
                 location = ' <iframe id="map" src="https://maps.google.com/maps?q='+location+'&hl=en&z=14&amp;output=embed" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>';
                 $('#map_framea').html(location);
             }
             
            
         </script>
        
        
    </body>
</html>
