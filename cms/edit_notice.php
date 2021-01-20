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
                
                <div id="box">
                 
                    <div class="content" style="padding:20px; padding-top:0px;">
                        <div class="col-sm-12">
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <span style="color:#6b6b6b">CMS / Edit Notice</span>
                                </div>
                            </div>
                        </div>
                           
                     
                            
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Publish a notice
              </h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
              </div>
              <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
              <form>
                <textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" id="notice_box">
                    <?php 
                        $id = '';
                        if(isset($_GET['id']) && !empty($_GET['id'])){
                            $id = $_GET['id'];
                            
                            $query = mysqli_query($conn,"select * from noticeboard where `ID`='$id'");
                            if($fetch = mysqli_fetch_assoc($query)){
                                echo $fetch['INFO'];
                            }
                        }
                    ?>
                </textarea><br/><br/>
                  <button type="button" class="btn btn-primary pull-right" id="publish_btn" onclick="edit_notice('<?php echo $id;?>')">Edit</button>
              </form>
            </div>
          </div>
                            
                            
                    </div>  
                
                    </div></div>
             
            </div>
        

        </div>


<!--modl boxes-->
         <div class="modal fade" id="add_teacher">
             <div class="modal-dialog modal-lg" style="z-index:5000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                         <h2 class="modal-title">Add New Teacher</h2>
                     </div>
                     <div class="modal-body">
                         
                            
                         <form class="form" method="POST">
                             <div class="row">
                             <div class="col-sm-12">
                             <div class="col-xs-12 col-md-6">
                             <div class="form-group">
                                 <label>First Name</label>
                                 <input type="text" class="form-control" placeholder="First Name" id="first_name"/>
                             </div>
                             <div class="form-group">
                                 <label>Last Name</label>
                                 <input type="text" class="form-control" placeholder="Last Name" id="last_name"/>
                             </div>
                              <div class="form-group">
                                  <label>Date Of Birth</label>
                                    <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%">
                                        <input class="form-control" id="date_of_birth" name="date_of_birth" type="text"  placeholder="Date of Birth" style="background-color:white;" readonly>
                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                    </div>
                                    <br>
                                </div>
                             <div class="form-group" style="margin-top:-20px;">
                                 <label>Gender</label><br>
                                <select class="selectpicker" data-show-subtext="true" data-live-search="false" style="width:100%;" id="gender">
                                    <option value="male"> Male </option>
                                    <option value="female"> Female </option>
                                    </select>
                                </div>
                             <div class="form-group">
                                 <label>Contact</label>
                                 <input type="text" placeholder="Contact" class="form-control" id="contact"/>
                             </div>
                             <div class="form-group">
                                 <label>Email</label>
                                 <input type="email" class="form-control" placeholder="Email" id="email"/><br>
                             </div>
                                 <div class="form-group" style="margin-top:-20px;">
                                     <label>Age</label>
                                                <input type="text" class="form-control" id="age" placeholder="Age"/>
                                            </div>
                                 </div>
                                  <div class="col-xs-12 col-md-6">
                             <div class="form-group">
                                 <label>Address</label>
                                 <input type="text" class="form-control" placeholder="Address" id="address"/>
                             </div>
                             <div class="form-group">
                                 <label>City</label>
                                 <input type="text" class="form-control" placeholder="City" id="city"/>
                             </div>
                            <div class="form-group">
                                 <label>Classes</label><br>
                                    <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width:100%;" id="teacher_class">
                                        <?php
                                         $query_class = mysqli_query($conn,"select * from classes where `SCHOOL`='$initials' order by `ID` asc");
                                        while($fetch = mysqli_fetch_assoc($query_class)){
                                            echo '<option value="'.htmlentities($fetch['CLASS']).'">'.htmlentities($fetch['CLASS']).'</option>';
                                        }
  
                                        ?>
                                    </select>
                                      </div>
                                      
                             <div class="form-group">
                                 <label>Country</label>
                                 <input type="text" placeholder="Country" class="form-control" id="country"/>
                             </div>
                             <div class="form-group">
                                  <label>Register Date</label>
                                    <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%">
                                        <input class="form-control"  type="text" value="" id="regDate" name="regDate"  placeholder="Register Date" style="background-color:white;" readonly>
                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                    </div>
                                    
                                </div>
                             <div class="form-group">
                                 <label>Job Type</label>
                                 <input type="text" placeholder="Job Type" class="form-control" id="jobType"/>
                             </div>
                                 </div>
                                 </div>
                                 <div class="form-group" style="margin-left:30px">
                                 
                                <button class="btn btn-primary" type="button" onclick="add_teacher()" id="add_teacher_btn">Add Teacher</button>
                                 <button class="btn btn-danger" onclick="window.open('manage_teacher.php','_self');" data-toggle="tooltip" data-placement="top" title="Click here to see added teachers after you have added your teachers.">Done</button>
                             </div>
                                 </div>
                              
                         </form>
                         
                             </div>
                     </div>
                       
                 </div>
             </div>
        
        
   
        <div class="modal fade" id="edit_teacher">
             <div class="modal-dialog modal-lg" style="z-index:5000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                         <h2 class="modal-title">Edit Teacher</h2>
                     </div>
                     <div class="modal-body">
                         <form class="form" method="POST">
                             <div class="row">
                             <div class="col-sm-12">
                             <div class="col-xs-12 col-md-6">
                             <div class="form-group">
                                 <label>First Name</label>
                                 <input type="text" class="form-control" placeholder="First Name" id="edit_first_name"/>
                             </div>
                             <div class="form-group">
                                 <label>Last Name</label>
                                 <input type="text" class="form-control" placeholder="Last Name" id="edit_last_name"/>
                             </div>
                              <div class="form-group">
                                  <label>Date Of Birth</label>
                                    <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%">
                                        <input class="form-control" id="edit_date_of_birth" name="edit_date_of_birth" type="text"  placeholder="Date of Birth" style="background-color:white;" readonly>
                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                    </div>
                                    <br>
                                </div>
                             <div class="form-group" style="margin-top:-20px;">
                                 <label>Gender</label><br>
                                <select class="selectpicker" data-show-subtext="true" data-live-search="false" style="width:100%;" id="edit_gender">
                                    <option value="male"> Male </option>
                                    <option value="female"> Female </option>
                                    </select>
                                </div>
                             <div class="form-group">
                                 <label>Contact</label>
                                 <input type="text" placeholder="Contact" class="form-control" id="edit_contact"/>
                             </div>
                             <div class="form-group">
                                 <label>Email</label>
                                 <input type="email" class="form-control" placeholder="Email" id="edit_email"/><br>
                             </div>
                                 <div class="form-group" style="margin-top:-20px;">
                                     <label>Age</label>
                                                <input type="text" class="form-control" id="edit_age" placeholder="Age"/>
                                            </div>
                                 </div>
                                  <div class="col-xs-12 col-md-6">
                             <div class="form-group">
                                 <label>Address</label>
                                 <input type="text" class="form-control" placeholder="Address" id="edit_address"/>
                             </div>
                             <div class="form-group">
                                 <label>City</label>
                                 <input type="text" class="form-control" placeholder="City" id="edit_city"/>
                             </div>
                            <div class="form-group">
                                 <label id="edit_teacher_classv">Classes</label><br>
                                    <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width:100%;" id="edit_teacher_class">
                                        <?php
                                         $query_class = mysqli_query($conn,"select * from classes where `SCHOOL`='$initials' order by `ID` asc");
                                        while($fetch = mysqli_fetch_assoc($query_class)){
                                            echo '<option value="'.htmlentities($fetch['CLASS']).'">'.htmlentities($fetch['CLASS']).'</option>';
                                        }
  
                                        ?>
                                    </select>
                                      </div>
                                      
                             <div class="form-group">
                                 <label>Country</label>
                                 <input type="text" placeholder="Country" class="form-control" id="edit_country"/>
                             </div>
                             <div class="form-group">
                                  <label>Register Date</label>
                                    <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%">
                                        <input class="form-control"  type="text" value="" id="edit_regDate" name="regDate"  placeholder="Register Date" style="background-color:white;" readonly>
                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                    </div>
                                    
                                </div>
                             <div class="form-group">
                                 <label>Job Type</label>
                                 <input type="text" placeholder="Job Type" class="form-control" id="edit_jobType"/>
                             </div>
                                 </div>
                                 </div>
                                 <div class="form-group" style="margin-left:30px;">
                                 <input type="hidden" value="" id="hidden_id"/>
                                <button class="btn btn-primary" type="button" onclick="edit_teacher_action()" id="edit_teacher_btn">Edit Teacher</button>
                             </div>
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
