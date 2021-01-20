<!DOCTYPE html>
<html>
   
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Easyskul - CMS::Messaging</title>
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
            $users = array("Administrator","Data Entry","Accountant");
            include '../includes/cms_sidebar.php';
        ?>

            <!-- Page Content Holder -->
            <div id="content">
<?php include '../includes/cms_header.php';
                    
                ?>                                       
                
                <div id="box">
                 
                    <div class="content" style="padding:20px; padding-top:0px;">
                        <div class="col-sm-12">
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <span style="color:#6b6b6b">CMS / Teacher /</span> <span style="color:#3c8dbc">Messaging<span>
                                </div>
                            </div>
                        </div>
                           
                     
                            
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-envelope-o"></i> Send a Message
              </h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
              </div>
              <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
              <form>
                
                <label><small>header : Message from <?php //pick school name
$query_pick_school = mysqli_query($conn,"select * from school_details where `INITIALS`='$initials'");
$school_name  = '';
if($fetch_school_name = mysqli_fetch_assoc($query_pick_school)){
    echo $school_name = $fetch_school_name['SCHOOL NAME'];
} ?></small></label>
                    <?php 
                        $msg = '';
                        $initial_class = '';
                        if(isset($_GET['msg']) && !empty($_GET['msg'])){
                           $msg =  $_GET['msg'];
                           
                        }
                           
                        if(isset($_GET['class']) && !empty($_GET['class'])){
                             $initial_class = $_GET['class'];
                        }
                    ?>
                <textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" id="message" name="msg"><?php echo $msg;?></textarea>
                  <br/><br/>
                <?php 
                    $query_pick = mysqli_query($conn,"select * from school_details where  INITIALS = '$initials' and SMS=''");
                    if(mysqli_num_rows($query_pick)!=null){
                           
                    }else{
                        echo '<button type="button" class="btn btn-primary pull-right" id="send_sms_btn" onclick="send_sms()">Send</button>';
                    }
                  ?>
                  
               <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#guardians" data-toggle="tab">Guardians</a></li>
                    <li><a href="#teachers" data-toggle="tab">Teachers</a></li>
                    <li><a href="#usersa" data-toggle="tab"> Users</a></li>
                </ul>
               <br><br> <div class="tab-content">
                   <div class="active tab-pane" id="guardians">
                       <div class="content">
                        <div class="form-group">
                              <label ><small>Filter by Class </small></label><br/>
                           <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width:100%;" id="class" name="class">
                            <?php
                                   
                                    $qeuery_pick_classes = mysqli_query($conn,"select * from classes where `SCHOOL`='$initials' order by ID asc");
                                    while($fetch = mysqli_fetch_assoc($qeuery_pick_classes)){
                                        echo '<option value="'.htmlentities($fetch['CLASS']).'" >'.htmlentities($fetch['CLASS']).'</option>';
                                    }
                                    
                                    echo '<option value="COMPLETED STUDDENTS">COMPLETED STUDENTS</option>';
                                   
                               ?>

                          </select> 
                            <button type="submit" class="btn btn-default" >Search</button>
                          </div>
                       </div>
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
                          <th>STUDENT ID</th>
                          
                          <th>STUDENT NAME</th>
                          <th>GUARDIAN NAME</th>
                          <th>GUARDIAN NUMBER</th>
                          
                        </tr>
                        </thead>
                        <tbody id="result_box">
                            
                            <?php $counter = 0;
    
    $query1 = mysqli_query($conn,"select * from admitted_students where `SCHOOL`='$initials'   and `PRESENT CLASS`='$initial_class' and `PRESENT CLASS`!=''  order by `STUDENT LAST NAME` asc");
    
    
    $counter = 0;
   
    while($fetch1 = mysqli_fetch_assoc($query1)){
        $student_id = htmlentities($fetch1['ADMISSION NO / ID']);
        $student_name = htmlentities($fetch1['STUDENT LAST NAME'].' '.$fetch1['STUDENT  FIRST NAME']);
        
        $guardian_name = htmlentities($fetch1['GUARDIAN NAME']);
        $guardian_num = htmlentities($fetch1['GUARDIAN TEL']);
        $photo = $fetch1['PHOTO'];
        $counter ++;
        $id = $fetch1['NO'];
        echo '<tr id="row'.$id.'">
              <td><label>
                  <input type="checkbox" id="row_check" name="'.$id.'" class="checkboxes">  <i class="fa fa-check"></i>
              </label> </td>
              <td>'.$counter.'</td>
              <td>'.$student_id.'</td>
              
              <td >'.$student_name.'</td>
              <td>'.$guardian_name.'</td>
              <td id="guardian_num'.$id.'">'.$guardian_num.'</td>
              
            </tr>';
    }?>
                        </tbody>
                      
                      </table>
                   </div>
                   <div class=" tab-pane" id="teachers">
                       
                         <table id="example3" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                             <th>
                              <form class="form">
                                  <label>
                                      <input type="checkbox" id="check_all1">
                                      All <i class="fa fa-check"></i>
                                  </label>
                              </form>
                          </th>
                          <th>#</th>
                          <th>Teacher's Name</th>
                             <th>Teacher Id</th>
                             <th>Contact</th>
                             <th>Teacher Class</th>
                           
                        </tr>
                        </thead>
                        <tbody id="result_box">
                            
                            <?php $counter = 0;
    $query = mysqli_query($conn,"select * from teachers where `SCHOOL`='$initials' and `EMAIL`!='' order by `ID` asc");
    
    if(mysqli_num_rows($query) == null){
        echo 'No class found.';
    }
    while($fetch = mysqli_fetch_assoc($query)){       
        $name = htmlentities($fetch['FIRST NAME'])." ".htmlentities($fetch['LAST NAME']);
        $tId = htmlentities($fetch['TEACHER ID']);
        $contact = htmlentities($fetch['CONTACT']);
        $teacher_class = htmlentities($fetch['TEACHER CLASS']);
        $counter ++;
        $id = $fetch['id'];
        echo '<tr id="rowt'.$id.'">
                <td><label>
                  <input type="checkbox" id="row_check" name="'.$id.'" class="checkboxes1">  <i class="fa fa-check"></i>
              </label> </td>
              <td>'.$counter.'</td>
              <td>'.$name.'</td>
              <td>'.$tId.'</td>
              <td id="teacher_num'.$id.'">'.$contact.'</td>
              <td>'.$teacher_class.'</td>
              
            </tr>';
    }?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th></th>
                          <th>#</th>
                          <th>Teacher's Name</th>
                             <th>Teacher Id</th>
                             <th>Contact</th>
                             <th>Teacher Class</th>
                           

                        </tr>
                        </tfoot>
                      </table>
                       
                   </div>
                   <div class="tab-pane" id="usersa">
                       
                        <table id="example0" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>
                              <form class="form">
                                  <label>
                                      <input type="checkbox" id="check_all2">
                                      All <i class="fa fa-check"></i>
                                  </label>
                              </form>
                          </th>
                                                            <th>#</th>
                                                            <th>USER NAME</th>
                                                            <th>GENDER</th>
                                                            <th>USER ID</th>
                                                            <th>CONTACT</th>
                                                            <th>POSITION</th>
                                                           

                                                        </tr>
                                                    </thead>
                                                    <tbody id="result_box">
                                                        <?php $counter = 0;
    $query = mysqli_query($conn,"select * from `users` where `SCHOOL`='$initials' and `POSITION` !=''  order by `NO` asc");
    
    if(mysqli_num_rows($query) == null){
        //echo $initials;
        //echo 'No class found.';
    }
    while($fetch = mysqli_fetch_assoc($query)){       
        $name = htmlentities($fetch['USER NAME']);
        $gender = htmlentities($fetch['GENDER']);
        $u_Id = htmlentities($fetch['USER ID']);
        
        $contact = htmlentities($fetch['CONTACT']);
        $position = htmlentities($fetch['POSITION']);
        
        $btn='';
        $id = $fetch['USER ID'];
        if(strpos($u_Id,'-TCH') || $position=="MAIN ADMIN"){
            $btn = 'disabled';
        }
        if(strpos($u_Id,'-STD')||strpos($u_Id,'-PT')){
            
        }else{
            $counter ++;
            echo '<tr id="rowu'.$id.'">
            <td><label>
                  <input type="checkbox" id="row_check" name="'.$id.'" class="checkboxes2">  <i class="fa fa-check"></i>
              </label> </td>
              <td>'.$counter.'</td>
              <td>'.$name.'</td>
              <td>'.$gender.'</td>
              <td>'.$u_Id.'</td>
              <td id="user_num'.$id.'">'.$contact.'</td>
              <td>'.$position.'</td>
             
            </tr>';
        }
        
    }?>
                                                    </tbody>
                                                    <tfoot>
                                                         <tr>
                                                            <th></th>
                                                            <th>#</th>
                                                            <th>USER NAME</th>
                                                            <th>GENDER</th>
                                                            <th>USER ID</th>
                                                            <th>CONTACT</th>
                                                            <th>POSITION</th>
                                                           

                                                        </tr>
                                                    </tfoot>
                                                </table>
                   </div>
               </div>
              </div>
                    
               
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
        
        </div></div>
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
            
             
             $(document).ready(function () {
                 readProducts(); 
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                 });
                 $('.list-unstyled li:nth-child(22)').toggleClass('active');
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
             
             
             //for teachers
             
             $('input[type="checkbox"]').on('click',function(){
                if(this.checked){
                    $('#rowt'+this.name).css('background-color','#2e89ab');
                    $('#rowt'+this.name).css('color','#fff');
                    $('.dropdown').css('color',"#3b3b3b");
                    var all_checked = false;
                    
                    var check_boxes = document.getElementsByClassName('checkboxes1');
                    
                    for(var x=0; x < check_boxes.length; x++){
                        if(check_boxes[x].checked){
                            all_checked = true;
                        }else{
                            all_checked = false;
                            break;
                        }
                    }
                    var all_check_box = document.getElementById('check_all1');
                    if(all_checked==true){
                        all_check_box.checked = true;
                    }
                    
                    
                }else{
                    $('#rowt'+this.name).css('background-color','');
                    $('#rowt'+this.name).css('color','#000');
                    
                    var all_check_box = document.getElementById('check_all1');
                    
                    if(all_check_box.checked){
                        all_check_box.checked = false;
                    }
                } 
             });
             
             $('#check_all1').on('click',function(){
                 
                 if(this.checked){
                    var check_boxes = document.getElementsByClassName('checkboxes1');
                    
                    for(var x=0; x < check_boxes.length; x++){
                        check_boxes[x].checked = true;
                        var checkbox_id = check_boxes[x].name;
                        $('#rowt'+checkbox_id).css('background-color','#2e89ab');
                        $('#rowt'+checkbox_id).css('color','#fff');
                        $('.dropdown').css('color',"#3b3b3b");
                    }
                }else{
                    var check_boxes = document.getElementsByClassName('checkboxes1');
                    
                    for(var x=0; x < check_boxes.length; x++){
                        check_boxes[x].checked = false;
                        var checkbox_id = check_boxes[x].name;
                        $('#rowt'+checkbox_id).css('background-color','');
                        $('#rowt'+checkbox_id).css('color','#000');
                    }
                }
             })
             $('document').ready(function(){
                $('input[type="search"]').on('keyup',function(){
                
                var value = $('input[type="search"]').val();
               // console.log(value.length);
                if(value.length < 1){
                    $('#check_all1').removeAttr('disabled','false');
                }else{
                    $('#check_all1').attr('disabled','true');
                }
            });
            });
             
             //for users
             
             $('input[type="checkbox"]').on('click',function(){
                if(this.checked){
                    $('#rowu'+this.name).css('background-color','#2e89ab');
                    $('#rowu'+this.name).css('color','#fff');
                    $('.dropdown').css('color',"#3b3b3b");
                    var all_checked = false;
                    
                    var check_boxes = document.getElementsByClassName('checkboxes2');
                    
                    for(var x=0; x < check_boxes.length; x++){
                        if(check_boxes[x].checked){
                            all_checked = true;
                        }else{
                            all_checked = false;
                            break;
                        }
                    }
                    var all_check_box = document.getElementById('check_all2');
                    if(all_checked==true){
                        all_check_box.checked = true;
                    }
                    
                    
                }else{
                    $('#rowu'+this.name).css('background-color','');
                    $('#rowu'+this.name).css('color','#000');
                    
                    var all_check_box = document.getElementById('check_all2');
                    
                    if(all_check_box.checked){
                        all_check_box.checked = false;
                    }
                } 
             });
             
             $('#check_all2').on('click',function(){
                 
                 if(this.checked){
                    var check_boxes = document.getElementsByClassName('checkboxes2');
                    
                    for(var x=0; x < check_boxes.length; x++){
                        check_boxes[x].checked = true;
                        var checkbox_id = check_boxes[x].name;
                        $('#rowu'+checkbox_id).css('background-color','#2e89ab');
                        $('#rowu'+checkbox_id).css('color','#fff');
                        $('.dropdown').css('color',"#3b3b3b");
                    }
                }else{
                    var check_boxes = document.getElementsByClassName('checkboxes2');
                    
                    for(var x=0; x < check_boxes.length; x++){
                        check_boxes[x].checked = false;
                        var checkbox_id = check_boxes[x].name;
                        $('#rowu'+checkbox_id).css('background-color','');
                        $('#rowu'+checkbox_id).css('color','#000');
                    }
                }
             })
             $('document').ready(function(){
                $('input[type="search"]').on('keyup',function(){
                
                var value = $('input[type="search"]').val();
               // console.log(value.length);
                if(value.length < 1){
                    $('#check_all2').removeAttr('disabled','false');
                }else{
                    $('#check_all2').attr('disabled','true');
                }
            });
            });
         </script>
        
            
    </body>
</html>
