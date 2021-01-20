<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Easyskul - CMS::Manage Subjects</title>
        <link href="../web_images/logo2.png" rel="icon"/>
         <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="../css/font-awesome.css">
        <link rel="stylesheet" href="../bootstrap-3.3.7-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../css/sidebar.css">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="../css/cms_style.css">
        <!--add the tables css-->
        <link rel="stylesheet" href="bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="../bootstrap-3.3.7-dist/css/boostrap-select.min.css">
        
        <link rel="stylesheet" href="fullcalendar/fullcalendar.min.css"/>
        <link rel="stylesheet" href="fullcalendar/fullcalendar.print.css" media="print"/>
        <script src="../js/jQuery-v2.1.3.js"></script>
        
        <script src="fullcalendar/moment.min.js"></script>
        <script src="fullcalendar/fullcalendar.min.js"></script>
        <script src="sweetalert2-master/dist/sweetalert2.all.min.js"></script>
        <script src="../js/cms.js"></script>
        <script  src="../js/bootstrap-select.min.js"></script>
        <script src="//code.tidio.co/oc6tcjthxgtesxrtpwutqwmcbl4txaih.js"></script>

    </head>
    
    

<script>

    
    

</script>

<style>

#calendar {
max-width: 900px;
margin: 0 auto;
}
</style>
    <body>



        <div class="wrapper">
           
            <!-- Sidebar Holder -->
        <?php 
            $users = array("Administrator","Data Entry");
            include '../includes/cms_sidebar.php';
        ?>

            <!-- Page Content Holder -->
            <div id="content">
<?php 
    
    include '../includes/cms_header.php';
     include '../includes/redirect_admin.php';
            
                ?>                 
                <div id="box">
                 
                    <div class="content" style="padding:20px; padding-top:0px;">
                        
                        
                            <div class="col-sm-12">
                                <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <span style="color:#6b6b6b">CMS / Academic Calendar </span> 
                                </div>
                            </div>
                        
                            </div>
                        </div>
                        <div class="content">
                            <div class="col-sm-12 col-md-4">
                                <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#event_box"><i class="fa fa-calendar"></i> Add Event</button>
                                
                                
                                    <div class="box box-primary" style="margin-top:30px; overfow-y:auto;">
            
            <!-- /.box-header -->
            <div class="box-body pad">
               <table id="example2" class="table table-hover table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>
                              <form class="form">
                                  <label>
                                      <input type="checkbox" id="check_all">
                                     
                                  </label>
                              </form>
                          </th>
                           
                          <th>EVENT</th>
                          
                          <th>DAY</th>
                          
                         
                          
                        </tr>
                        </thead>
                        <tbody id="result_box">
                            
                            <?php $counter = 0;
    
    $query1 = mysqli_query($conn,"select * from events where `SCHOOL`='$initials' order by `ID` asc");
    
    
    $counter = 0;
   
    while($fetch1 = mysqli_fetch_assoc($query1)){
        $id = htmlentities($fetch1['ID']);
        $date = htmlentities($fetch1['DATE']);
        $end_date = $fetch1['END DATE'];
        $color = $fetch1['COLOR'];
        $event = htmlentities($fetch1['EVENT']);
        $counter ++;
        
        echo '<tr id="row'.$id.'">
              <td><label>
                  <input type="checkbox" id="row_check" name="'.$id.'" class="checkboxes"></i>
              </label> </td>
              
              <td class="event_name" id="'.$color.'">'.$event.'</td>
              
              <td class="event_date" id="'.$end_date.'">'.$date.'</td>
              
            </tr>';
    }?>
                        </tbody>
                        <tfoot>
                              
                              <button type="button" class="btn btn-danger" onclick="delete_event()"><i class="fa fa-trash"></i></button> 
                        </tfoot>
                      </table> 
            </div>
          </div>
                                  
                            </div>
                            <div class="col-sm-12 col-md-8">   
                            <!--calendar-->
                                <div class="box box-danger">
           
                                <div class="box-body pad">
                                  <div id='calendar'></div>
                                                <!--calendar-->
                                </div>
                              </div>
                            
                        
                            </div>
                        </div>
                </div>  
                     
                    </div>  
                
                
             
            </div>
        

        </div>


<!--modl boxes-->
         <div class="modal fade" id="event_box">
             <div class="modal-dialog" style="z-index:5000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                         <h2 class="modal-title">Add New Event</h2>
                     </div>
                     <div class="modal-body">
                         <form class="form">
                             
                                
                             <div class="form-group"> 
                                 <input type="text" class="form-control" id="event_name" placeholder="Event Name"/>
                             </div>
                             <div class="form-group">
                                <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%">
                                    <input class="form-control"  type="text" value="" readonly placeholder="Starts From" style="background-color:white;" id="start"  name="attendance_date" required>
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                </div>
                                <input type="hidden"  value="" />
                            </div>
                             <div class="form-group">
                                <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%">
                                    <input class="form-control"  type="text" value="" readonly placeholder="Ends" style="background-color:white;" id="ends"  name="" required>
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                </div>
                                <input type="hidden"  value="" />
                            </div>
                             <div class="form-group">
                                 <label id="">Choose Color</label><br/>
                                 <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width:100%;" id="event_color">
                                    <option value="#f56954" style="color:#f56954">Red</option>
                                    <option value="#f39c12" style="color:#f39c12">Yellow</option>
                                    <option value="#00a65a" style="color:#00a65a">Green</option>
                                    <option value="#00c0ef" style="color:#00c0ef">Blue</option>
                                  </select>
                             </div>
                             <div class="form-group">
                                 
                                 <button class="btn btn-primary" type="button" onclick="add_event();" id="add_event_btn">Add Event</button>
                                 <a href="academic_calendar.php"><button class="btn btn-success"  data-toggle="tooltip" data-placement="top" title="Click here to see added events" type="button"><i class="fa fa-thumbs-up"></i> Done</button></a>
                             </div>
                         </form>
                     </div>
                       
                 </div>
             </div>
         </div>
        
        
        <div class="modal fade" id="edit_subject">
             <div class="modal-dialog" style="z-index:5000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                         <h2 class="modal-title">Edit Subject</h2>
                     </div>
                     <div class="modal-body">
                         <form class="form" id="edit_form">
                              <form class="form">
                             
                                 <div class="panel-group">
                                  <div class="panel panel-default">

                                      <div class="panel-heading">
                                        <?php echo 'You are about to edit a subject at <strong>'.$class.'</strong>';?>
                                      </div>
                                  </div>
                            </div>
                             
                             <div class="form-group">
                                 <label>Subject Name</label>
                                 <input type="text" class="form-control" id="edit_subject_name"/>
                             </div>
                             <div class="form-group">
                                 <label>Assign Teacher</label><br/>
                                 <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width:100%;" id="edit_sub_teacher">
                                    <?php
                                            $qeuery_pick_classes = mysqli_query($conn,"select * from teachers where `SCHOOL`='$initials' order by ID asc");
                                            while($fetch = mysqli_fetch_assoc($qeuery_pick_classes)){
                                                echo '<option value="'.htmlentities($fetch['FIRST NAME']).' '.htmlentities($fetch['LAST NAME']).'" >'.htmlentities($fetch['FIRST NAME']).' '.htmlentities($fetch['LAST NAME']).'</option>';
                                            }
                                       ?>

                                  </select>
                             </div>
                                
                             <div class="form-group">
                                 
                                 <button class="btn btn-primary" type="button" onclick="edit_subject_action('<?php echo $class;?>');" id="edit_subject_btn" name="">Edit Subject</button>
                                 <a href="manage_subject.php?class=<?php echo $class?>"><button class="btn btn-danger"  data-toggle="tooltip" data-placement="top" title="Click here to see changes" type="button">Done</button></a>
                             </div>
                         </form>
                         </form>
                     </div>
                       
                 </div>
             </div>
         </div>
        
        
        <!-- jQuery CDN -->
         
         <!-- Bootstrap Js CDN -->
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
                 
                 $('.list-unstyled li:nth-child(17) ul').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(17) a').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(17) ul').toggleClass('collapse in');
                 $('.list-unstyled li:nth-child(17) a').toggleClass('');
                 $('.list-unstyled li:nth-child(17) ul li:nth-child(1)').toggleClass('active');
             });
            
            $(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });
              
              $(document).ready(function() {
                  
                $('#calendar').fullCalendar({
                
                header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
                },

               
                editable: false,

                eventLimit: true, // allow "more" link when too many events
                
                });
                  
                var event_name = document.getElementsByClassName('event_name');  
                var event_date = document.getElementsByClassName('event_date'); 
                  
                for(var i=0; i<event_name.length; i++){
                  var event = {id:i,
                               title:event_name[i].innerHTML,
                               start:event_date[i].innerHTML,
                               end:event_date[i].id,
                               backgroundColor: event_name[i].id,
                               borderColor: event_name[i].id
                              };
                  $('#calendar').fullCalendar('renderEvent',event,true);
                }
                  
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
             $('document').ready(function(){
                $('input[type="search"]').on('keyup',function(){
                
                var value = $('input[type="search"]').val();
               // console.log(value.length);
                if(value.length < 1){
                    $('#check_all').removeAttr('disabled','false');
                }else{
                    $('#check_all').attr('disabled','true');
                }
            });
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
         </script>
        
        
    </body>
</html>
