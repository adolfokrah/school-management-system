<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Easyskul - CMS::Add Notice</title>
        <link href="../web_images/logo2.png" rel="icon"/>
         <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="../css/font-awesome.css">
         <link rel="stylesheet" href="../bootstrap-3.3.7-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../css/sidebar.css">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"/>
        <link rel="stylesheet" href="../css/cms_style.css"/>
        <!--add the tables css-->
        <link rel="stylesheet" type="text/css" href="datatables/dataTables.bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="../bootstrap-3.3.7-dist/css/boostrap-select.min.css"/>
        <script src="../js/jQuery-v2.1.3.js"></script>
        <script src="../js/bootstrap-select.min.js"></script>
        <script src="sweetalert2-master/dist/sweetalert2.all.min.js"></script>
        <script src="../js/cms.js"></script>
        <script src="//code.tidio.co/oc6tcjthxgtesxrtpwutqwmcbl4txaih.js"></script>

    </head>
    <body>



        <div class="wrapper">
            <!-- Sidebar Holder -->
           <?php 
            $users = array("Administrator","Data Entry");
            include '../includes/cms_sidebar.php';
            ?>

            <!-- Page Content Holder -->
            <div id="content">
            <?php include '../includes/cms_header.php';
                    include '../includes/redirect_admin.php';
            
            
                ?>     
                <div class="content">
                    <div class="col-sm-12">
                        <div class="btn btn-warning" data-toggle="modal" data-target="#add_bus"><i class="fa fa-plus"></i> Add Bus</div>
                        <div class="btn btn-danger" onclick="delete_bus('')" id="d_bus"><i class="fa fa-trash"></i> Delete All</div>
                        
                    </div><br/><br/>
                    <div class="col-sm-12">
                        <div class="box box-warning">
                            
                            <div class="box-header with-border">
                                <?php 
                                $query = mysqli_query($conn,"select * from busses where `SCHOOL`='$initials' and `STATUS` !='DELETED'");
                                $active = 0;
                                $faulty = 0;
                                while($fetch = mysqli_fetch_assoc($query)){
                                    if($fetch['STATUS']=='FAULTY'){
                                        $faulty ++;
                                    }else{
                                        $active ++;
                                    }
                                }
                                echo '<a href="manage_busses"><span class="label label-primary" style="cursor:pointer">Total buses : <span id="all_busses">'.mysqli_num_rows($query).'</span></span></a>
                                <a href="manage_busses?status=active"><span class="label label-success" style="cursor:pointer">Active buses : <span id="active_busses">'.$active.'</span></span></a>
                                <a href="manage_busses?status=faulty"><span class="label label-danger" style="cursor:pointer">Faulty buses : <span id="faulty_busses">'.$faulty.'</span></span></a>';
                                    ?>
                            </div>
                            <div class="box-body" style="overflow-y:auto; height:600px;" id="busses_box">
                                <?php 
                                    $query ='';
                                    if(isset($_GET['status']) && !empty($_GET['status'])){
                                        $status = $_GET['status'];
                                         $query = mysqli_query($conn,"select * from busses where `SCHOOL`='$initials' and `STATUS`='$status' and `STATUS` !='DELETED'");
                                    }else{
                                        $query = mysqli_query($conn,"select * from busses where `SCHOOL`='$initials' and `STATUS` !='DELETED'");
                                    }
                                
                                   if(mysqli_num_rows($query)==null){
                                       echo '<div class="alert alert-info" id="alert">No buses found.</div>';
                                   }
                                $id = 0;
                                while($fetch = mysqli_fetch_assoc($query)){
                                    $header = 'success';
                                    if(htmlentities($fetch['STATUS']) == "FAULTY"){
                                        $header = 'warning';
                                    }
                                    $locs = '';
                                    $locations = $fetch['LOCATIONS'];
                                    $locs_array = explode(',',$locations);
                                    $colors = ["label-primary","label-danger","label-warning","label-info","label-default","label-success"];
                                    
                                    foreach($locs_array as $location){
                                        $color = rand(0,sizeof($locs_array));
                                        $locs .= '<span class="label '.$colors[$color].'" onclick="find_map(\''.$location.'\')" style="cursor:pointer">'.$location.'</span> ';
                                    }
                                    
                                   $id = $fetch['ID'];
                                    echo '<div class="col-xs-12 col-sm-6 col-md-4">
                                    <!-- Widget: user widget style 1 -->
                                      <div class="box box-widget widget-user-2 box-'.$header.'" style="box-shadow:0px 0px 4px 1px #ccc;">
                                        <!-- Add the bg color to the header using any of the bg-* classes -->
                                        <div class="header" style="padding:10px;">
                                         <img src="../web_images/school_bus.png" class="img img-responsive"/>
                                        </div>
                                        <div class="box-footer no-padding">
                                          <ul class="nav nav-stacked">
                                            <li><a><label>Bus Number</label> <small id="bus_number'.$fetch['ID'].'">'.htmlentities($fetch['BUS NUMBER']).'</small></a></li>
                                            <li><a><label>Driver</label> <small id="bus_driver'.$fetch['ID'].'">'.htmlentities($fetch['BUS DRIVER']).'</small></a></li>
                                            <li><a><label>Driver Tel</label> <small id="driver_tel'.$fetch['ID'].'">'.htmlentities($fetch['DRIVER TEL']).'</small></a></li>
                                            <li><a><label>Status</label> <small><span class="label label-'.$header.'" id="bus_status'.$fetch['ID'].'">'.htmlentities($fetch['STATUS']).'</span></small></a></li>
                                            <li><a class="loca_btn"  onclick="toggle_location_btn(\''.$id.'\');" id="locs_btn'.$id.'" style="cursor:pointer"><i class="fa fa-location-arrow"></i> Locations <span style="display:none" id="locs'.$fetch['ID'].'">'.$locs.'</span></a></li>
                                            <li onclick="edit_show_bus(\''.$id.'\');" data-toggle="modal" data-target="#edit_bus"><a><i class="fa fa-edit"></i> Edit</a></li>
                                            <li><a style="background-color:#d9534f; color:white; cursor:pointer" onclick="delete_bus(\''.htmlentities($fetch['BUS NUMBER']).'\')" id="d_bus1"><i class="fa fa-trash"></i> Delete</a></li>
                                           </a></li>
                                          </ul>
                                        </div>
                                      </div>
                                      
                                      <!-- /.widget-user -->
                                <input type="hidden" value="'.$locations.'" id="bus_locations'.$id.'"/>
                                </div>';
                                }
                                echo '<input type="hidden" value="'.$id.'" id="last_bus_id"/>
                                    
                                ';
                                ?>
                        
                            </div>
                        </div>
                    </div>
                </div>
             <div class="content" style="padding:0px;">
             <div class="col-sm-12" style="border-top:5px solid #d9534f; background-color:white; padding:0px;">
                 <div id="bus_locations" style="overflow-x:auto; padding:10px;"></div>
                 <div id="map_frame"></div>
            </div>

        </div>


<!--modl boxes-->
         <div class="modal fade" id="add_bus">
             <div class="modal-dialog" style="z-index:5000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                         <h2 class="modal-title">Add New Bus</h2>
                     </div>
                     <div class="modal-body" >
                         <div id="bus_box"></div>
                            
                         <form class="form" method="POST">
                            <div class="form-group">
                                <input  class="form-control" placeholder="Bus Number" type="text" id="bus_number"/> 
                            </div>
                             <div class="form-group">
                                <input class="form-control" placeholder="Driver Name" type="text" id="bus_driver"/> 
                            </div>
                             <div class="form-group">
                                <input  class="form-control" placeholder="Driver Number" type="text" id="driver_number"/> 
                            </div>
                            <textarea class="form-control" id="locations" placeholder="Locations eg. American Junction,Top Hill,Blue top estate etc."></textarea>
                             <br/> <a href="https://www.google.com/maps/place/Ghana/@7.04229,-1.220977,7z/data=!4m5!3m4!1s0xfd75acda8dad6c7:0x54d7f230d093d236!8m2!3d7.946527!4d-1.023194?hl=en" target="_blank"><button class="btn btn-warning pull-right" type="button" data-toggle="tooltip" data-replacement="top" title="Copy locations from map"><i class="fa fa-map-marker"></i></button></a>
                             <div class="form-group" style="margin-top:-20px;">
                                 <label>Status</label><br>
                                <select class="selectpicker" data-show-subtext="true" data-live-search="false" style="width:100%;" id="status">
                                    <option value="ACTIVE"> Active </option>
                                    <option value="FAULTY"> Faulty </option>
                                    </select>
                                </div>
                             <div class="form-group">
                                 <button type="button" class="btn btn-success btn-block" onclick="add_busses()" id="add_bus_btn"><i class="fa fa-save"></i> Save </button>
                             </div>
                         </form>
                         
                             </div>
                     </div>
                       
                 </div>
             </div>
        
        <!--modl boxes-->
         <div class="modal fade" id="edit_bus">
             <div class="modal-dialog" style="z-index:5000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                         <h2 class="modal-title">Edit Bus</h2>
                     </div>
                     <div class="modal-body" >
                         <div id="bus_box_edit"></div>
                            
                         <form class="form" method="POST">
                            <div class="form-group">
                                <input  class="form-control" placeholder="Bus Number" type="text" id="bus_number_edit"/> 
                            </div>
                             <div class="form-group">
                                <input class="form-control" placeholder="Driver Name" type="text" id="bus_driver_edit"/> 
                            </div>
                             <div class="form-group">
                                <input  class="form-control" placeholder="Driver Number" type="text" id="driver_number_edit"/> 
                            </div>
                            <textarea class="form-control" id="locations_edit" placeholder="Locations eg. American Junction,Top Hill,Blue top estate etc."></textarea>
                             <br/> <a href="https://www.google.com/maps/place/Ghana/@7.04229,-1.220977,7z/data=!4m5!3m4!1s0xfd75acda8dad6c7:0x54d7f230d093d236!8m2!3d7.946527!4d-1.023194?hl=en" target="_blank"><button class="btn btn-warning pull-right" type="button" data-toggle="tooltip" data-replacement="top" title="Copy locations from map"><i class="fa fa-map-marker"></i></button></a>
                             <div class="form-group" style="margin-top:-20px;">
                                 <label>Status</label><br>
                                <select class="selectpicker" data-show-subtext="true" data-live-search="false" style="width:100%;" id="status_edit">
                                    <option value="ACTIVE"> Active </option>
                                    <option value="FAULTY"> Faulty </option>
                                    </select>
                                </div>
                             <div class="form-group">
                                 <button type="button" class="btn btn-success btn-block"  id="add_bus_edit_btn"><i class="fa fa-save"></i> Save </button>
                             </div>
                         </form>
                         
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
        <script src="bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

         <script type="text/javascript">
             $(function () {
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                //bootstrap WYSIHTML5 - text editor
                $(".textarea").wysihtml5();
                 $('.wysihtml5-toolbar li:last-child').remove();
                 $('.wysihtml5-toolbar li:last-child').remove();
              });
             
             $(document).ready(function () {
                 readProducts(); 
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                 });
                 $('.list-unstyled li:nth-child(11) ul').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(11) a').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(11) ul').toggleClass('collapse in');
                 $('.list-unstyled li:nth-child(11) a').toggleClass('');
                 $('.list-unstyled li:nth-child(11) ul li:nth-child(1)').toggleClass('active');
             });
            
            $(function(){
                $('[data-toggle="tooltip"]').tooltip();
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
             
              function readProducts(){
                $('#edit_form').load('magecon.php'); 
              }     
              $('.dropdown-toggle').removeAttr('aria-expanded');
         </script>
        
        
    </body>
</html>
