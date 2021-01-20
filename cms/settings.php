<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Easyskul - CMS::System Settings</title>
    <link href="../web_images/logo2.png" rel="icon" />
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="../css/font-awesome.css">
    <link rel="stylesheet" href="../bootstrap-3.3.7-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="../css/cms_style.css">
    <!--add the tables css-->
    <link rel="stylesheet" type="text/css" href="datatables/dataTables.bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../bootstrap-3.3.7-dist/css/boostrap-select.min.css" />
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
            $users = array("Administrator");
            include '../includes/cms_sidebar.php';
        ?>
            <!-- Page Content Holder -->
            <div id="content">
                <?php include '../includes/cms_header.php'?>

        
                              <?php 
                        $query_check = mysqli_query($conn,"select * from academic_years where `STATUS`='ACTIVE' and `SCHOOL`='$initials'");
    if(mysqli_num_rows($query_check) == null){
       
        echo "<script>
             $('.list-unstyled li:nth-child(3) ul').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(3) a').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(3) ul').toggleClass('collapse in');
                 $('.list-unstyled li:nth-child(3) a').toggleClass('');
                 $('.list-unstyled li:nth-child(3) ul li:nth-child(2)').toggleClass('active');
        </script>";
       
    }?>
                    <div id="box">

                        <div class="content" style="padding:20px; padding-top:0px;">
                            <div class="col-sm-12">
                                <div class="panel-group">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <span style="color:#6b6b6b">CMS / Settings /</span> <span style="color:#3c8dbc">System Settings</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="padding-bottom:20px;">
                                    <div class="content">
                                        <div class="col-xs-12">
                                            
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="content">
                                        <div class="col-sm-12">
                                            <!-- /.box-header -->
                                            <div class="box box-primary">
                                                <div class="box-header">

                                                    <div class="box-title">
                                                       <i class="fa fa-gears"></i> System Settings
                                                    </div>
                                                    <div class="box-body">
                                                        <div class="col-md-12">
                                                            <div class="nav-tabs-custom">
                                                                <ul class="nav nav-tabs">
                                                                    <li class="active"><a href="#school_profile" data-toggle="tab"><i class="fa fa-university"></i> School Profile</a></li>
                                                                    <li><a href="#profile" data-toggle="tab"><i class="fa fa-database"></i> Data Base</a></li><li>
                                                                    <a href="#terminal_report" data-toggle="tab"><i class="fa fa-file"></i> Terminal Report</a></li>
                                                                </ul>
                                                               <br><br> <div class="tab-content">
                                                                
     
 
                                        <div class="active tab-pane" id="school_profile">
                                            <!-- Post -->
                                              <form class="form-horizontal" id="form" for="form" enctype="multipart/form-data">
                                                  <div class="col-md-10">
                                                      
                                                      <?php
                                                            $query = mysqli_query($conn,"select * from school_details where `INITIALS`='$initials'");

                                                            if(mysqli_num_rows($query) == null){
                                                                echo 'No Results found.';
                                                            }
                                                            if($fetch = mysqli_fetch_assoc($query)){       
                                                                $name = htmlentities($fetch['SCHOOL NAME']);
                                                                $sch_initials = htmlentities($fetch['INITIALS']);
                                                                $address = htmlentities($fetch['SCHOOL ADDRESS']);
                                                                $numbers = htmlentities($fetch['SCHOOL NUMBERS']);
                                                                $smsid = htmlentities($fetch['SCHOOL ID']);
                                                                $id = $fetch['NO'];
                                                                ?>
                                                <div class="form-group">
                                                    <label for="schoolCode" class="col-sm-2 control-label">School Code</label>

                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" readonly value="<?php echo htmlentities($sch_initials); ?>" name="school_code" id="school_code" placeholder="School Code">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="schoolCode" class="col-sm-2 control-label">SMS ID</label>

                                                    <div class="col-sm-10">
                                                        <labe>SMS ID will be the name on the sms you send from the system.<strong>  note:</strong>  it should not be more than 11 characters.</labe>
                                                        <input type="text" class="form-control"  value="<?php echo htmlentities($smsid); ?>" name="sms_id" id="sms_id" placeholder="SMS ID" maxlength="11">
                                                    </div>
                                                </div>
                                                     <input type="hidden" id="sch_id" value="<?php echo $id; ?>"> 
                                                          
                                                <div class="form-group">
                                                    <label for="schoolName" class="col-sm-2 control-label">School Name</label>

                                                    <div class="col-sm-10">
                                                        <input type="text" value="<?php echo htmlentities($name); ?>" class="form-control" name="school_name" id="school_name" placeholder="School Name">
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="phoneNumber" class="col-sm-2 control-label">Phone Number</label>

                                                    <div class="col-sm-10">
                                                        <input type="text" value="<?php echo htmlentities($numbers); ?>" class="form-control" name="school_number" id="school_number" placeholder="">
                                                    </div>
                                                </div>
                    
                    
                                                <div class="form-group">
                                                    <label for="inputExperience" class="col-sm-2 control-label">Address</label>

                                                    <div class="col-sm-10">
                                                        <textarea class="form-control" Placeholder=""  rows="5" cols="5" name="sch_address" id="sch_address"><?php echo htmlentities($address); ?></textarea>
                                                    </div>
                                                </div>
                                                      <?php 
                                                                 $user='';
                                                            $shool ='';
                                                            //redirect user to registration stage if user is in registration stage
                                                            if(isset($_SESSION['email']) && !empty($_SESSION['email'])){
                                                                $user =$_SESSION['email'];
                                                                $query = mysqli_query($conn,"select * from `main admins` where `ADMIN EMAIL`='$user'");
                                                                if($fetch = mysqli_fetch_assoc($query)){
                                                                    $user = $fetch['ADMIN ID'];
                                                                }
                                                            }else if(isset($_SESSION['USER ID']) && !empty($_SESSION['USER ID'])){
                                                                $user = $_SESSION['USER ID'];
                                                            }
 
                                                            $sql = "select * from `main admins` where `ADMIN ID`='$user'";
                                                            $query = mysqli_query($conn,$sql);
                                                                if(mysqli_num_rows($query) == NULL){
                                                                    echo 'No Results Found';
                                                                }
                                                                
                                                                if($fetch1 = mysqli_fetch_assoc($query)){
                                                                    $admin_name = $fetch1['ADMIN NAME'];
                                                    ?>
                                                <div class="form-group">
                                                    <label for="principal" class="col-sm-2 control-label">Principal</label>

                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" value="<?php echo htmlentities($admin_name); ?>" name="principal_name" id="principal_name" placeholder="Principal">
                                                    </div>
                                                </div>
                                                      <?php
                                                        }
                                                        ?>
                                               
                                                        </div>
                                                
                                                 
                                                <div class="col-md-12">
                                                     <div class="form-group">
                                                          <?php
                                                  
                                                    $query_pick = mysqli_query($conn,"select * from school_details where INITIALS ='$initials'");
                                                    if($fetch_details = mysqli_fetch_assoc($query_pick)){
                                                    $school = $fetch_details['SCHOOL NAME'];
                                                    $school_logo = $fetch_details['CREST'];
                                                    }
                                                    if($school_logo == " "){
                                                    $school_logo = 'default_crest.jpg';
                                                    
                                                    }
                                                  ?>
                                                <label class="col-md-6 col-md-offset-2"><small>Please make sure you pick the right logo. Image is automatically resized to fix print outs </small></label><br/>
                                                         <div class="col-xs-6 col-md-offset-2">
                                                <div class="form-control" id="school_image" style="height:200px; width:300px;">
                           <center> <img src="<?php echo "../image_uploads_crests/$school_logo"?>" class="img img-thumbnail " style="height:190px;" id="image"/> </center>
                                                </div><br>
                                                             
                                                <label id="select_pic" class="btn btn-primary" onclick="upload_edit_school_image_from_explorer()" for="school_file">Choose School Creast</label>
                                                <input type="file" class="form-control" style="display:none" id="school_file"  accept="image/*" name="file">
                                                             
                                                </div>
                                              
                                                  
                                            </div>
                                                  <?php
                                                    
                                                       }
                                                    ?>
                                                
                                                </div>
                                                     <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10 pull-right">
                                                        <button type="button" onclick="update_school_info();" id="save_btn" name="save_btn" class="btn btn-danger pull-right">Save</button>
                                                    </div>
                                                </div>
                                                
                                            </form>
                                            <!-- /.post -->
                                        </div>
                                                    
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="profile">
                                            <div class="content">
                                                <div class="col-sm-5" style="word-wrap">
                                                    <div class="form-group">
                                                    <label><small>Note: Clicking on this button will clear all your school records from our data base and we won't be responsible for data lost on the system.</small></label>
                                                    <button type="button" class="btn btn-primary" id="reset_btn" onclick="reset_system();">
                                                        <i class="fa fa-refresh"></i> Reset System
                                                    </button>
                                                    </div>
                                                    <div class="form-group">
                                                    
                                                        <form action="settings.php" method="post">
                                                   <button type="submit" class="btn btn-success" id="reset_btn" name="download_db">
                                                        <i class="fa fa-download"></i> Download Db (EXCEL - offline)
                                                    </button><br/><br/>
                                                    <button type="button" onclick="window.open('backup.php','_blank')" class="btn btn-warning" id="reset_btn" name="download_db">
                                                        <i class="fa fa-download"></i> Download Db (SQL - offline)
                                                    </button><br/><br/>
<!--
                                                    <button type="button" onclick="window.open('restore_db.php','_blank')" class="btn btn-danger" id="reset_btn" name="download_db">
                                                        <i class="fa fa-gears"></i> Restore Db
                                                    </button><br/><br/>
                                                    <button type="button" onclick="window.open('https://easyskul.com/upload.php','_blank')" class="btn btn-info" id="reset_btn" name="download_db">
                                                        <i class="fa fa-upload"></i> Upload Db to server (online)
                                                    </button><br/><br/>
-->
                                                    <?php
                                                            $db = '';
                                                            $query = mysqli_query($conn,"select * from database_names where school = '$initials'");
                                                            if($fetch = mysqli_fetch_assoc($query)){
                                                                $db = $fetch['db_name'];
                                                            }
                                                            ?>
                                                    <button type="button" onclick="window.open('https://easyskul.com/databases/<?php echo $db ?>','_blank')" class="btn btn-primary" id="reset_btn" name="download_db">
                                                        <i class="fa fa-upload"></i> Download Db from server (online)
                                                    </button><br/><br/>
                                                            </form>
                                                    </div>
                                                    <?php 
                                                        if(isset($_POST['download_db'])){
                                                            echo "<script>
                                                                window.open('../includes/download_db.php?t=admitted_students','_blank');
                                                                window.open('../includes/download_db.php?t=attendance','_blank');
                                                                window.open('../includes/download_db.php?t=bills','_blank');
                                                                window.open('../includes/download_db.php?t=classes','_blank');
                                                                window.open('../includes/download_db.php?t=daily_feeding_fee','_blank');
                                                                window.open('../includes/download_db.php?t=daily_fees_payments','_blank');
                                                                window.open('../includes/download_db.php?t=events','_blank');
                                                                window.open('../includes/download_db.php?t=expenses','_blank');
                                                                window.open('../includes/download_db.php?t=feeding_fee','_blank');
                                                                window.open('../includes/download_db.php?t=grading_system','_blank');
                                                                window.open('../includes/download_db.php?t=histories','_blank');
                                                                window.open('../includes/download_db.php?t=library_books','_blank');
                                                                window.open('../includes/download_db.php?t=library_books_status','_blank');
                                                                window.open('../includes/download_db.php?t=marksheet','_blank');
                                                                window.open('../includes/download_db.php?t=noticeboard','_blank');
                                                                window.open('../includes/download_db.php?t=returned_blances','_blank');
                                                                window.open('../includes/download_db.php?t=school_fees','_blank');
                                                                window.open('../includes/download_db.php?t=shelves','_blank');
                                                                window.open('../includes/download_db.php?t=subjects','_blank');
                                                                window.open('../includes/download_db.php?t=teachers','_blank');
                                                                window.open('../includes/download_db.php?t=terminal_reports','_blank');
                                                                window.open('../includes/download_db.php?t=terminal_reports_av','_blank');
                                                                window.open('../includes/download_db.php?t=users','_blank');
                                                            </script>";
                                                        }
                                                    ?>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.tab-pane -->
                                                                
                                                                <!-- /.tab-pane -->
                                        <div class="tab-pane" id="terminal_report">
                                            <div class="content">
                                                <div class="col-sm-7" style="word-wrap">
                                                    <div class="form-group">
                                                    <label><small>Please click on the button below to toggle students position display in terminal report.</small></label>
                                                        <?php
                                                            $sql_2 = mysqli_query($conn,"select * from `school_details` where `INITIALS`='$initials' and `POS`='' ");
                                                               if(mysqli_num_rows($sql_2)!=null){
                                                                 echo ' <button type="button" class="btn btn-success" id="check_btn" onclick="toggle_position()">
                                                        <i class="fa fa-check"></i> Click to turn off
                                                    </button>';
                                                               }else{
                                                                   echo ' <button type="button" class="btn btn-default" id="check_btn" onclick="toggle_position()">
                                                        <i class="fa fa-check"></i> Click to turn on
                                                    </button>';
                                                               }
                                                        
                                                        ?>
                                                   
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.tab-pane -->
                                        
                                                                    <!-- /.tab-pane -->
                                                                </div>
                                                                <!-- /.tab-content -->
                                                            </div>
                                                            <!-- /.nav-tabs-custom -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
    </div>


    <!--modl boxes-->
<!--
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
                                        <input type="text" class="form-control" placeholder="First Name" id="first_name" />
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" placeholder="Last Name" id="last_name" />
                                    </div>
                                    <div class="form-group">
                                        <label>Date Of Birth</label>
                                        <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%">
                                            <input class="form-control" id="date_of_birth" name="date_of_birth" type="text" placeholder="Date of Birth" style="background-color:white;" readonly>
                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                        </div>
                                        <br>
                                    </div>
                                    <div class="form-group" style="margin-top:-20px;">
                                        <label>Gender</label>
                                        <br>
                                        <select class="selectpicker" data-show-subtext="true" data-live-search="false" style="width:100%;" id="gender">
                                            <option value="male"> Male </option>
                                            <option value="female"> Female </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Contact</label>
                                        <input type="text" placeholder="Contact" class="form-control" id="contact" />
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" placeholder="Email" id="email" />
                                        <br>
                                    </div>
                                    <div class="form-group" style="margin-top:-20px;">
                                        <label>Age</label>
                                        <input type="text" class="form-control" id="age" placeholder="Age" />
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" placeholder="Address" id="address" />
                                    </div>
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" class="form-control" placeholder="City" id="city" />
                                    </div>
                                    <div class="form-group">
                                        <label>Classes</label>
                                        <br>
                                        <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width:100%;" id="teacher_class">
                                        
                                     //    $query_class = mysqli_query($conn,"select * from classes where `SCHOOL`='$initials' order by `ID` asc");
                                    //    while($fetch = mysqli_fetch_assoc($query_class)){
                                    //        echo '<option value="'.htmlentities($fetch['CLASS']).'">'.htmlentities($fetch['CLASS']).'</option>';
                                      //  }
  
                                    //    ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Country</label>
                                        <input type="text" placeholder="Country" class="form-control" id="country" />
                                    </div>
                                    <div class="form-group">
                                        <label>Register Date</label>
                                        <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%">
                                            <input class="form-control" type="text" value="" id="regDate" name="regDate" placeholder="Register Date" style="background-color:white;" readonly>
                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label>Job Type</label>
                                        <input type="text" placeholder="Job Type" class="form-control" id="jobType" />
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
-->



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
                                        <input type="text" class="form-control" placeholder="First Name" id="edit_first_name" />
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" placeholder="Last Name" id="edit_last_name" />
                                    </div>
                                    <div class="form-group">
                                        <label>Date Of Birth</label>
                                        <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%">
                                            <input class="form-control" id="edit_date_of_birth" name="edit_date_of_birth" type="text" placeholder="Date of Birth" style="background-color:white;" readonly>
                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                        </div>
                                        <br>
                                    </div>
                                    <div class="form-group" style="margin-top:-20px;">
                                        <label>Gender</label>
                                        <br>
                                        <select class="selectpicker" data-show-subtext="true" data-live-search="false" style="width:100%;" id="edit_gender">
                                            <option value="male"> Male </option>
                                            <option value="female"> Female </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Contact</label>
                                        <input type="text" placeholder="Contact" class="form-control" id="edit_contact" />
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" placeholder="Email" id="edit_email" />
                                        <br>
                                    </div>
                                    <div class="form-group" style="margin-top:-20px;">
                                        <label>Age</label>
                                        <input type="text" class="form-control" id="edit_age" placeholder="Age" />
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" placeholder="Address" id="edit_address" />
                                    </div>
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" class="form-control" placeholder="City" id="edit_city" />
                                    </div>
                                    <div class="form-group">
                                        <label id="edit_teacher_classv">Classes</label>
                                        <br>
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
                                        <input type="text" placeholder="Country" class="form-control" id="edit_country" />
                                    </div>
                                    <div class="form-group">
                                        <label>Register Date</label>
                                        <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%">
                                            <input class="form-control" type="text" value="" id="edit_regDate" name="regDate" placeholder="Register Date" style="background-color:white;" readonly>
                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label>Job Type</label>
                                        <input type="text" placeholder="Job Type" class="form-control" id="edit_jobType" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" style="margin-left:30px;">
                                <input type="hidden" value="" id="hidden_id" />
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

    <script type="text/javascript">
        $(document).ready(function() {
            readProducts();
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });
            
             $('.list-unstyled li:nth-child(23) ul').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(23) a').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(23) ul').toggleClass('collapse in');
                 $('.list-unstyled li:nth-child(23) a').toggleClass('');
                 $('.list-unstyled li:nth-child(23) ul li:nth-child(2)').toggleClass('active');
        });

        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });


        $('.form_date').datetimepicker({
            language: 'en',
            weekStart: 1,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0
        });

        function readProducts() {
            $('#edit_form').load('magecon.php');
        }

    </script>
</body>

</html>
