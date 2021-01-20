<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Easyskul - CMS::Manage Notice</title>
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
            $users = array("Administrator","Data Entry");
            include '../includes/cms_sidebar.php';
        ?>

            <!-- Page Content Holder -->
            <div id="content">
<?php include '../includes/cms_header.php';
                    include '../includes/redirect_admin.php';
                ?>                                       
                <div id="box">
                 
                    <div class="content" style="padding:20px; padding-top:0px;">
                        
                        
                        <div class="col-sm-12">
                           
                        </div>
                        
                           <div class="content">
                                <div class="col-sm-12" style="padding-top:10px;">
                                <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <span style="color:#6b6b6b">CMS / Manage Notice /</span> 
                                </div>
                                 
                            </div>
                        
                            </div>
                                    
                                    <div class="content">
                            
                                
                               <button type="button" class="btn btn-danger pull-right"  onclick="delete_notice();" style="margin-left:10px;"><i class="fa fa-trash"></i> Delete</button>
                        </div>
                        </div>
                           </div>
                        <div class="col-sm-12" style="padding-top:20px;">
                            <div class="panel-group">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        All notice
                                    </div>
                                    <div class="panel-body" style="overflow-x:auto">
                                        
                                       <table id="example" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>
                              <form class="form">
                                  <label>
                                      <input type="checkbox" id="check_all">
                                      All <i class="fa fa-check"></i>
                                  </label>
                              </form>
                          </th>
                           <th>#</th>
                          <th>POSTED BY</th>
                          
                          <th>INFO</th>
                          <th>ACTION</th>
                          
                        </tr>
                        </thead>
                        <tbody id="result_box">
                            
                            <?php $counter = 0;
    
    $query1 = mysqli_query($conn,"select * from noticeboard where `SCHOOL`='$initials' order by `ID` desc");
    
    
    $counter = 0;
   
    while($fetch1 = mysqli_fetch_assoc($query1)){
        $posted_by = htmlentities($fetch1['POSTED BY']);
        $info = htmlspecialchars_decode($fetch1['INFO']);
        if(strlen($info) > 100){
            $info = substr($info,0,100);
            $info .='...';
        }
        $counter ++;
        $id = $fetch1['ID'];
        echo '<tr id="row'.$id.'">
              <td><label>
                  <input type="checkbox" id="row_check" name="'.$id.'" class="checkboxes">  <i class="fa fa-check"></i>
              </label> </td>
              <td>'.$counter.'</td>
              <td>'.$posted_by.'</td>
              
              <td>'.$info.'</td>
              
              <td><a href="edit_notice.php?id='.$id.'"><button type="button" class="btn btn-warning"><i class="fa fa-edit"></i> Edit</button></a></td>
            </tr>';
    }?>
                        </tbody>
                        <tfoot>
                        <tr>
                           <th></th>
                               
                           <th>#</th>
                          <th>POSTED BY</th>
                          
                          <th>INFO</th>
                          <th>ACTION</th>
                          
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
        

        </div>


<!--modl boxes-->
         <div class="modal fade" id="camera" style="z-index:5000;">
             <div class="modal-dialog " style="z-index:5000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                         <h2 class="modal-title"><i class="fa fa-camera"></i> Take A Photo</h2>
                     </div>
                     <div class="modal-body">
                         <form class="form">
                             
                             
                             <div class="form-group" id="capture_image">
                                 
                             </div>
                             <div class="form-group">
                                 
                                 <button class="btn btn-default btn-block" type="button" id="capture_edit" data-dismiss="modal"><i class="fa fa-camera" ></i> Capture</button>
                                 
                             </div>
                         </form>
                     </div>
                       
                 </div>
             </div>
         </div>
        
        <div class="modal fade" id="edit_student">
             <div class="modal-dialog modal-lg" style="z-index:3000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                         <h2 class="modal-title"><i class="fa fa-user"></i> Edit Student Profile</h2>
                     </div>
                     <div class="modal-body">
                         <form role="form" id="form" enctype="multipart/form-data">
                                        <div class="col-xs-12 col-md-4">
                                            <h4>Student Personal Information</h4>
                                            <input type="hidden" value="" id="student_id"/>
                                            <hr/>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Student First Name" id="first_name"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Student Last/Middle Name" id="last_name"/>
                                            </div>
                                            <div class="form-group"> 
                                                <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%">
                                                    <input class="form-control"  type="text" value="" readonly placeholder="Date of Birth" style="background-color:white;" id="date_of_birth">
                                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                </div>
                                                <input type="hidden"  value="" />
                                            </div>
                                            
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="hometown" placeholder="Home Town"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="nationality" placeholder="Nationality"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="rgd" placeholder="Student Religious Denomination">
                                            </div>
                                            <div class="form-group">
                                                <input type="tel" class="form-control" id="former_school" placeholder="Name of Former School (Optional)">
                                            </div><br/>
                                            
                                            <div class="form-group" style="margin-top:0px;">
                                                <label><small id="classv">Present class: </small></label><br/>
                                               <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width:100%;" id="class_edit">
                                                <?php
                                                        $qeuery_pick_classes = mysqli_query($conn,"select * from classes where `SCHOOL`='$initials' order by ID asc");
                                                        while($fetch = mysqli_fetch_assoc($qeuery_pick_classes)){
                                                            echo '<option value="'.htmlentities($fetch['CLASS']).'" >'.htmlentities($fetch['CLASS']).'</option>';
                                                        }
                                                   ?>

                                              </select>

                                            </div>
                                            <div class="form-group" style="margin-top:-5px;">
                                                <label><small id="genderv">Gender: </small></label><br/>
                                               <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width:100%;" id="gender">
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                              </select>

                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-md-4">
                                            <h4>Guardian Information</h4>
                                            <hr/>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Guardian Name" id="guardianname"/>
                                            </div>
                                            
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Guardian Address" id="guardianaddress"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Guardian Occupation" id="guardianoccupation"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Guardian Tel" id="guardiantel"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Guardian Religious Denomination" id="guardianrgd"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Relationship To Student" id="relationship"/>
                                            </div>
                                            <div class="form-group">
                                                <label><small>Does the student have any disability? eg.Sickle cell, Blindness etc.</small></label>
                                                <input type="text" class="form-control" placeholder="Disability" id="disability"/>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-4">
                                            <h4>Office Use</h4>
                                            <hr/>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Admission Fee" id="fee"/>
                                            </div>
                                            <div class="form-group"> 
                                                <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%">
                                                    <input class="form-control"  type="text" value="" readonly placeholder="Paid Date" style="background-color:white;" id="paid_date">
                                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                </div>
                                                <input type="hidden"  value="" /><br/>
                                            </div>
                                            <div class="form-group" style="margin-top:-20px;"> 
                                                <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%">
                                                    <input class="form-control"  type="text" value="" readonly placeholder="Date Admitted" style="background-color:white;" id="admission_date">
                                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                </div>
                                                <input type="hidden"  value="" /><br/>
                                            </div>
                                            <div class="form-group" style="margin-top:-20px;">
                                                <label><small>Choose Student Picture</small></label>
                                                <div class="form-control" id="student_image">
                                                    
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="button" class="btn btn-default" id="configure_cam" data-toggle="modal" data-target="#camera"><i class="fa fa-camera" ></i> Take A Photo</button><br/><br/>
                                                <label for="file" class="btn btn-default " onclick="upload_edit_student_image_from_explorer();" id="choose_pic_edit"><i class="fa fa-upload"></i> Choose A Photo</label>
                                                <input type="file" id="file" style="display:none" accept="image/*" name="file"/>
                                            </div>
                                            <div class="form-group" >
                                                <button type="button" class="btn btn-block btn-primary"  onclick="edit_student();" id="add_student" ><i class="fa fa-plus" ></i> Save Changes</button>
                                            </div>
                                        </div>
                                        <img src="" style="display:none" id="hidden_student_image"/>
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
        <script src="webcam/webcamjs/webcam.min.js"></script>
        <script src="../js/webcam_config.js"></script>
         <script type="text/javascript">
             $(document).ready(function () {
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                 });
                 
                 $('.list-unstyled li:nth-child(18) ul').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(18) a').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(18) ul').toggleClass('collapse in');
                 $('.list-unstyled li:nth-child(18) a').toggleClass('');
                 $('.list-unstyled li:nth-child(18) ul li:nth-child(2)').toggleClass('active');
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
