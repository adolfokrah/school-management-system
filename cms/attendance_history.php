<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Easyskul - CMS::Attendanc History</title>
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
            $users = array("Administrator","Data Entry","Teacher","School Head");
            include '../includes/cms_sidebar.php';
        ?>

            <!-- Page Content Holder -->
            <div id="content">
<?php include '../includes/cms_header.php';
                    include '../includes/redirect_admin.php';
                ?>                       
                <div id="box">
                  <?php 
                        $initial_class = '';      
                        $date = '';
                        if(isset($_GET['class']) && !empty($_GET['class']) && isset($_GET['attendance_date']) && !empty($_GET['attendance_date'])){
                            $initial_class = $_GET['class'];
                            $date = $_GET['attendance_date'];
                        }else{
                                $initial_class = '';
                                $date = '0000-00-00';
                                $query_pick_initial_class = mysqli_query($conn,"select * from classes where `SCHOOL`='$initials' order by ID asc");
                                if($fetch = mysqli_fetch_assoc($query_pick_initial_class)){
                                    $initial_class = htmlentities($fetch['CLASS']);
                                }
                        }
            ?>
    
                    
                    <input type="hidden" id="initial_class" value="<?php echo $initial_class;?>"/>
                    <div class="content" style="padding:20px; padding-top:0px;">
                        
                        
                            
                        <div class="content">
                        <div class="col-sm-12">
                            <form action="attendance_history.php" method="get">
                            <div class="col-sm-12 col-md-3">
                            
                            <div class="form-group">
                                <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%">
                                    <input class="form-control"  type="text" value="" readonly placeholder="Date" style="background-color:white;" id=""  name="attendance_date" required>
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                </div>
                                <input type="hidden"  value="" />
                            </div>
                                <div class="form-group">
                            <label><small>Filter by Class </small></label><br/>
                           <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width:100%;" id="class" name="class">
                            <?php
                                   
                                    $qeuery_pick_classes = mysqli_query($conn,"select * from classes where `SCHOOL`='$initials' order by ID asc");
                                    while($fetch = mysqli_fetch_assoc($qeuery_pick_classes)){
                                        echo '<option value="'.htmlentities($fetch['CLASS']).'" >'.htmlentities($fetch['CLASS']).'</option>';
                                    }
                                    
                                
                               ?>

                          </select>
                            </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-default">Search</button>
                                </div>
                                </div>
                                <div class="col-sm-12 col-md-9">
                                <div <?php echo $btn_style;?>>
                                <button type="button" class="btn btn-primary pull-right"   style="margin-left:10px;" data-toggle="modal" data-target="#take_attedance" onclick="fetch_attendace_info('<?php echo $initial_class;?>','<?php echo $date; ?>');"> <i class="fa fa-save"></i> Save Changes</button></div>
                                <button type="button" class="btn btn-danger pull-right"  onclick="attendance_report('<?php echo $initial_class;?>','<?php echo $date; ?>');"><i class="fa fa-print"></i> Print Report</button>
                                </div>
                        </form>
                        </div>
                            <div class="content">
                                <div class="col-sm-12">
                                <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <span style="color:#6b6b6b">CMS / Attendance /</span> <span style="color:#3c8dbc"> Attendance History / <?php echo htmlentities($initial_class).' / Date - <strong> ( '.$date.' )</strong>';?> </span>
                                </div>
                            </div>
                        
                            </div>
                        </div>
                            </div>
                        </div>
                        <div class="content">
                        <div class="col-sm-12" style="padding-top:20px;">
                            <div class="panel-group">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        List Of Student
                                    </div>
                                    <div class="panel-body" style="overflow-x:auto">
                                        
                                       <table id="example" class="table table-bordered table-striped">
                                           
                                                                    <?php $counter = 0;
    
    $query1 = mysqli_query($conn,"select * from attendance where `SCHOOL`='$initials'  and `DATE` ='$date' and `CLASS`='$initial_class' order by `STUDENT NAME` asc");
    
    
    $counter = 0;
    $checked = '';
    $output = '';                       
    $all_checked = 'checked';
    $style = '';
    if(mysqli_num_rows($query1) < 1){
        $all_checked = '';
    }
    while($fetch1 = mysqli_fetch_assoc($query1)){
        $student_id = htmlentities($fetch1['STUDENT ID']);
        $student_name = htmlentities($fetch1['STUDENT NAME']);
        $status = $fetch1['STATUS'];
        
        //check rows
        
        if($status == 'PRESENT'){
            $checked = 'checked';
            $style = 'style="background-color:#2e89ab;color:#fff;"';
            if($all_checked != ''){
                $all_checked = 'checked';
            }
        }else{
            $all_checked = '';
            $checked = '';
            $style = '';
        }
        
        $counter ++;
        $id = $fetch1['ID'];
        $output .= '<tr id="row'.$student_id.'" '.$style.'>
              <td><label>
                  <input type="checkbox" id="row_check" name="'.$student_id.'" class="checkboxes" '.$checked.'>  <i class="fa fa-check"></i>
              </label> </td>
              <td>'.$counter.'</td>
              <td>'.$student_id.'</td>
              
              <td>'.$student_name.'</td>
              <td>'.$status.'</td>
              
                   
              

            </tr>';
    }?>
                        <thead>
                        <tr>
                          <th>
                              <form class="form">
                                  <label>
                                      <input type="checkbox" id="check_all"  <?php echo $all_checked;?>>
                                      All <i class="fa fa-check"></i>
                                  </label>
                              </form>
                          </th>
                           <th>#</th>
                          <th>STUDENT ID</th>
                          
                          <th>STUDENT NAME</th>
                          <th>STATUS</th>
                          
                        </tr>
                        </thead>
                        <tbody id="result_box">
                            
                        <?php echo $output; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                           <th></th>
                           <th>#</th>
                          <th>STUDENT ID</th>
                         
                          <th>STUDENT NAME</th>
                          <th>STATUS</th>
                          
                        </tr>
                        </tfoot>
                      </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                       
                </div>  
                     
                    </div>  
                
                <!--modl boxes-->
         <div class="modal fade" id="take_attedance">
             <div class="modal-dialog " style="z-index:5000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                         <h2 class="modal-title"><i class="fa fa-book"></i> TAKE ATTENDANCE</h2>
                     </div>
                     <div class="modal-body">
                         <form class="form">
                             
                             <div class="form-group">
                                 <label id="p_teacher_name">Select Class Teacher</label><br/>
                                 <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width:100%;" id="Teacher_Name">
                                    <?php
                                            $qeuery_pick_classes = mysqli_query($conn,"select * from teachers where `SCHOOL`='$initials' order by ID asc");
                                            while($fetch = mysqli_fetch_assoc($qeuery_pick_classes)){
                                                echo '<option value="'.htmlentities($fetch['FIRST NAME']).' '.htmlentities($fetch['LAST NAME']).'" >'.htmlentities($fetch['FIRST NAME']).' '.htmlentities($fetch['LAST NAME']).'</option>';
                                            }
                                       ?>

                                  </select>
                             </div>
                             
                             <div class="form-group"> 
                                <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%">
                                    <input class="form-control"  type="text" value="" readonly placeholder="Date" style="background-color:white;" id="attendance_date">
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                </div>
                                <input type="hidden"  value="" /><br/>
                            </div>
                             <div class="form-group">
                                 <input type="hidden" value="" id="pdate"/>
                                 <button class="btn btn-primary" type="button" onclick="update_attedance();"  id="continue"><i class="fa fa-save"></i> Continue</button>
                                 
                             </div>
                         </form>
                     </div>
                       
                 </div>
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
                 
                 $('.list-unstyled li:nth-child(7) ul').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(7) a').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(7) ul').toggleClass('collapse in');
                 $('.list-unstyled li:nth-child(7) a').toggleClass('');
                 $('.list-unstyled li:nth-child(7) ul li:last-child').toggleClass('active');
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
         </script>
        
        
    </body>
</html>
