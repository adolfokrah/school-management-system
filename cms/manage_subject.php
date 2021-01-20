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
        <link rel="stylesheet" type="text/css" href="datatables/dataTables.bootstrap.css"/>
        <link rel="stylesheet" href="../bootstrap-3.3.7-dist/css/boostrap-select.min.css" id="boostrap_select2">
        <script src="../js/jQuery-v2.1.3.js"></script>
        <script src="sweetalert2-master/dist/sweetalert2.all.min.js"></script>
        <script src="../js/cms.js"></script>
        <script  src="../js/bootstrap-select.min.js"></script>
        <script src="//code.tidio.co/oc6tcjthxgtesxrtpwutqwmcbl4txaih.js"></script>

    </head>
    <body>



        <div class="wrapper">
            <!-- Sidebar Holder -->
            <?php 
            $users = array("Administrator","Data Entry","School Head");
            include '../includes/cms_sidebar.php';
        ?>

            <!-- Page Content Holder -->
            <div id="content">
<?php include '../includes/cms_header.php';
                    include '../includes/redirect_admin.php';
            
                $query_check2 = mysqli_query($conn,"select * from teachers where `SCHOOL`='$initials'");
        if(mysqli_num_rows($query_check2)==null){
            echo "<script>window.open('manage_teacher.php','_self');</script>";
            die();
        }
                ?>        
                
                
                <div id="box">
                 
                    <div class="content" style="padding:20px; padding-top:0px;">
                        
                        
                            <div class="col-sm-12">
                                <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <span style="color:#6b6b6b">CMS / Class /</span> <span style="color:#3c8dbc">Manage Subjects</span>
                                </div>
                            </div>
                        
                            </div>
                        </div>
                        
                        <div class="col-sm-12 col-md-12 col-lg-5">
                            <div class="panel-group">
                                <div class="panel panel-primary">

                                      <div class="panel-heading">
                                          Class
                                      </div>
                                     <div class="panel-body">
                                         <ul class="list-unstyled" id="list_">
                                            <?php
                                                //select availalble classes
                                                $query = mysqli_query($conn,"select * from classes where `SCHOOL`='$initials' order by `ID` asc");

                                                if(mysqli_num_rows($query) == null){
                                                    echo 'No class found.';
                                                }
                                                
                                              while($fetch = mysqli_fetch_assoc($query)){
                                                  $class = $fetch['CLASS'];
                                                  $query_pick_subject_number = mysqli_query($conn,"select * from subjects where `SCHOOL`='$initials' and `CLASS`='$class'");
                                                  $number_of_subjects = mysqli_num_rows($query_pick_subject_number);
                                                  echo '<a href="manage_subject.php?class='.$class.'"><li>'.$class.' ('.$number_of_subjects.')</li></a>';
                                              }
                                                
                                             ?>
                                         </ul>
                                     </div>
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="col-sm-12 col-md-12 col-lg-7">
                        <div class="panel-group">
                <div class="panel panel-primary">
                                                 
                      <div class="panel-heading">
                         Manage Subjects
                      </div>
                    
                     <?php 
                        $rows = '';
                        $class = 'No Class selected';
                        //display subject according to selected class
                        if(isset($_GET['class']) && !empty($_GET['class'])){
                            $class = $_GET['class'];
                            
                            $counter = 0;
                            $query_pick_subjects = mysqli_query($conn,"select * from subjects where `SCHOOL`='$initials' and `CLASS`='$class' order by ID asc");
                            
                            while($fetch_subjects = mysqli_fetch_assoc($query_pick_subjects)){
                                $subject = $fetch_subjects['SUBJECT NAME'];
                                $counter ++;
                                $id = $fetch_subjects['ID'];
                                $teacher_id = $fetch_subjects['TEACHER'];
                                $query_pick_teacher = mysqli_query($conn,"select * from `teachers` where `TEACHER ID`='$teacher_id'");
                                $teacher = '';
                                if($fetch_teacher = mysqli_fetch_assoc($query_pick_teacher)){
                                    $teacher = $fetch_teacher['FIRST NAME'].' '.$fetch_teacher['LAST NAME'];
                                }
                                $rows .='<tr>
              <td>'.$counter.'</td>
              <td>'.htmlentities($subject).'
              </td><td>'.htmlentities($teacher).'</td>
              <td style="width:30%;"><button class=" btn btn-danger" onclick=delete_subject(\''.$id.'\'); '.$btn_style.'></i> Delete</button> <button class=" btn btn-default" onclick=edit_subject(\''.$id.'\'); data-toggle="modal" data-target="#edit_subject" '.$btn_style.'><i class="fa fa-edit"></i> Edit</button></td>

            </tr>';
                            }
                        }
                    ?>
                      <div class="panel-body" style="overflow-x:auto">
                    <div class="panel-group">
                          <div class="panel panel-default">
                                                 
                              <div class="panel-heading" id="class"><?php echo $class?></div>
                          </div>
                    </div>
                          <button class="btn btn-danger" type="button" onclick="delete_all_subjects('<?php echo $class;?>');" <?php echo $btn_style?>><i class="fa fa-trash"></i> Delete All</button>
                         
                                    <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#add_subject" <?php echo $btn_style?> type="button"><i class="fa fa-plus"></i> Add Subjects</button>
                              
                             
                          <table id="example2" class="table table-bordered table-striped">
                                 
                        <thead>
                        <tr>
                          <th>#</th>
                          <th>Subject Name</th>
                         <th>Teacher</th>
                          <th>Operation</th>

                        </tr>
                        </thead>
                        <tbody id="result_box">
                            
                            <?php echo $rows; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                           <th>#</th>
                          <th>Subject Name</th>
                         <th>Teacher</th>
                          <th>Operation</th>
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
         <div class="modal fade" id="add_subject">
             <div class="modal-dialog" style="z-index:5000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                         <h2 class="modal-title">Add New Subject</h2>
                     </div>
                     <div class="modal-body">
                         <form class="form">
                             
                                 <div class="panel-group">
                                  <div class="panel panel-default">

                                      <div class="panel-heading">
                                        <?php echo 'You are about to add a new subject to <strong>'.$class.'</strong>';?>
                                      </div>
                                  </div>
                            </div>
                             
                             <div class="form-group">
                                 <label>Subject Name</label>
                                 <input type="text" class="form-control" id="add_subject_name"/>
                             </div>
                             <div class="form-group">
                                 <label>Assign Teacher</label><br/>
                                 <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width:100%;" id="sub_teacher">
                                    <?php
                                            $qeuery_pick_classes = mysqli_query($conn,"select * from teachers where `SCHOOL`='$initials' and `EMAIL`!='' order by ID asc");
                                            while($fetch = mysqli_fetch_assoc($qeuery_pick_classes)){
                                                echo '<option value="'.htmlentities($fetch['TEACHER ID']).'" >'.htmlentities($fetch['FIRST NAME']).' '.htmlentities($fetch['LAST NAME']).'</option>';
                                            }
                                       ?>

                                  </select>
                             </div>
                             <div class="form-group">
                                 
                                 <button class="btn btn-primary" type="button" onclick="add_subject('<?php echo $class;?>');" id="add_subject_btn">Add Subject</button>
                                 <a href="manage_subject.php?class=<?php echo $class?>"><button class="btn btn-danger"  data-toggle="tooltip" data-placement="top" title="Click here to see added subjects after you have added your subjects." type="button">Done</button></a>
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
                                                echo '<option value="'.htmlentities($fetch['TEACHER ID']).'" >'.htmlentities($fetch['FIRST NAME']).' '.htmlentities($fetch['LAST NAME']).'</option>';
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
         <script src="../js/boostrap.min.js"></script>
        
        <!--add the table js-->
        <script src="datatables/jquery.dataTables.min.js" id="script1"></script>
        <script src="datatables/dataTables.bootstrap.min.js" id="script2"></script>
        <script src="../js/table.js" id="script3"></script>
         <script type="text/javascript">
             $(document).ready(function () {
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                 });
                 
                 $('.list-unstyled li:nth-child(4) ul').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(4) a').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(4) ul').toggleClass('collapse in');
                 $('.list-unstyled li:nth-child(4) a').toggleClass('');
                 $('.list-unstyled li:nth-child(4) ul li:last-child').toggleClass('active');
             });
            
            $(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });

             
              $('document').ready(function(){
                $('#file').change(function() {
                        var Class = $('#class').html();
                        console.log(Class);
                        if(Class == "No Class selected"){
                            swal('','no class selected','error');
                        }else{
                            $('#upload').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:13px;;"></i> uploading...');
                            $('#upload').attr('disabled','true');
                            var fd = new FormData(document.getElementById("form")); 
                            fd.append("class",Class)
                            $.ajax({
                              url: "upload_subjects_csv.php",
                              type: "POST",
                              data: fd,
                              processData: false,  // tell jQuery not to process the data
                              contentType: false   // tell jQuery not to set contentType
                            }).done(function( data ) {
                                if(data=='success'){
                                    window.open('manage_subject.php?class='+Class,'_self');
                                }else{
                                    swal(data);
                                    $('#upload').html('<i class="fa fa-upload"></i> upload');
                            $('#upload').removeAttr('disabled','true');
                                }
                                
                            });
                            return false;
                        }
                        
                    });
            })
         </script>
        
        
    </body>
</html>
