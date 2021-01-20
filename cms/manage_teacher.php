<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Easyskul - CMS::Manage Teacher</title>
        <link href="../web_images/logo2.png" rel="icon"/>
         <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="../css/font-awesome.css">
         <link rel="stylesheet" href="../bootstrap-3.3.7-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../css/sidebar.css">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css">
        
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
            $users = array("Administrator","Data Entry","School Head");
            include '../includes/cms_sidebar.php';
        ?>

            <!-- Page Content Holder -->
            <div id="content">
<?php include '../includes/cms_header.php';
                    include '../includes/redirect_admin.php';
            
            
             $query_check2 = mysqli_query($conn,"select * from teachers where `SCHOOL`='$initials' and `EMAIL`!=''");
        if(mysqli_num_rows($query_check2)==null){
            echo "<script>swal('','Please add teachers before you can be able to add subjects','warning');</script>";
           
        }
            
                ?>                                       
                
                <div id="box">
                 
                    <div class="content" style="padding:20px; padding-top:0px;">
                        <div class="col-sm-12">
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <span style="color:#6b6b6b">CMS / Teacher /</span> <span style="color:#3c8dbc">Manage Teacher</span>
                                </div>
                            </div>
                        </div>
                            
                            <div class="row" style="padding-bottom:20px;">
                            <div class="content">
                                <div class="col-xs-12">
                                    <button class="btn btn-danger" type="button" onclick="delete_all_teachers();" <?php echo $btn_style;?>><i class="fa fa-trash"></i> Delete All</button>
                                    <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#add_teacher" <?php echo $btn_style;?>><i class="fa fa-plus"></i> Add Teacher</button>
                                </div>
                            </div>
                                
                        </div>
                        <div class="row">
                            <div class="content">
                                <div class="col-sm-12">
                                    
            
            <!-- /.box-header -->
             <div class="panel-group">
                <div class="panel panel-primary">
                                                 
                      <div class="panel-heading">
                          All Teachers
                      </div>
                      <div class="panel-body" style="overflow-x:scroll">
                          <table id="example" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>#</th>
                          <th>Teacher's Name</th>
                             <th>Teacher Id</th>
                             <th>Contact</th>
                             <th>Teacher Class</th>
                            <th>Operation</th>

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
        echo '<tr>
              <td>'.$counter.'</td>
              <td>'.$name.'</td>
              <td>'.$tId.'</td>
              <td>'.$contact.'</td>
              <td>'.$teacher_class.'</td>
              <td style="width:30%;"><button class=" btn btn-danger" onclick=delete_teacher(\''.$id.'\'); '.$btn_style.'><i class="fa fa-trash"></i></button> <button class=" btn btn-default" onclick=edit_teacher(\''.$id.'\'); data-toggle="modal" data-target="#edit_teacher" '.$btn_style.'><i class="fa fa-edit"></i> </button>
              <a href="print_teacher_subjects.php?teacher_id='.$tId.'" target="_blank"><button class=" btn btn-warning" data-toggle="tooltip" data-placement="top" title="View subjects teaching"><i class="fa fa-book"></i> </button></a></td>
            </tr>';
    }?>
                        </tbody>
                        <tfoot>
                        <tr>
                          <th>#</th>
                          <th>Teacher's Name</th>
                             <th>Teacher Id</th>
                             <th>Contact</th>
                             <th>Teacher Class</th>
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
                     
                    </div>  
                
                
             
            </div>
        

        </div>


<!--modl boxes-->
         <div class="modal fade" id="add_teacher">
             <div class="modal-dialog" style="z-index:5000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                         <h2 class="modal-title">Add New Teacher</h2>
                     </div>
                     <div class="modal-body">
                         
                            
                         <form class="form" method="POST">
                             <div class="row">
                             <div class="col-sm-12">
                             <div class="col-xs-12">
                             <div class="form-group">
                                 <label>First Name</label>
                                 <input type="text" class="form-control" placeholder="First Name" id="first_name"/>
                             </div>
                             <div class="form-group">
                                 <label>Last Name</label>
                                 <input type="text" class="form-control" placeholder="Last Name" id="last_name"/>
                             </div>
                              
                             
                             <div class="form-group">
                                 <label>Contact</label>
                                 <input type="text" placeholder="Contact" class="form-control" id="contact"/>
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
                                        <option value="NONE">NONE</option>
                                    </select>
                                      </div>
                                 
                                  <div class="form-group">
                                 
                                <button class="btn btn-primary" type="button" onclick="add_teacher()" id="add_teacher_btn">Add Teacher</button>
                                 <button class="btn btn-danger" onclick="window.open('manage_teacher.php','_self');" data-toggle="tooltip" data-placement="top" title="Click here to see added teachers after you have added your teachers.">Done</button>
                             </div>
                                
                                 </div>
                                
                                 </div>
                              
                         </form>
                         
                             </div>
                     </div>
                       
                 </div>
             </div>
        
        </div>
   
        <div class="modal fade" id="edit_teacher">
             <div class="modal-dialog" style="z-index:5000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                         <h2 class="modal-title">Edit Teacher</h2>
                     </div>
                     <div class="modal-body">
                         <form class="form" method="POST">
                             <div class="row">
                             <div class="col-sm-12">
                             <div class="col-xs-12 col-md-12">
                             <div class="form-group">
                                 <label>First Name</label>
                                 <input type="text" class="form-control" placeholder="First Name" id="edit_first_name"/>
                             </div>
                             <div class="form-group">
                                 <label>Last Name</label>
                                 <input type="text" class="form-control" placeholder="Last Name" id="edit_last_name"/>
                             </div>
                              
                             <div class="form-group">
                                 <label>Contact</label>
                                 <input type="text" placeholder="Contact" class="form-control" id="edit_contact"/>
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
                                        <option value="NONE">NONE</option>
                                    </select>
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
        
         <script type="text/javascript">
             
             $(document).ready(function () {
                 readProducts(); 
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                 });
                 
                 $('.list-unstyled li:nth-child(6) ul').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(6) a').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(6) ul').toggleClass('collapse in');
                 $('.list-unstyled li:nth-child(6) a').toggleClass('');
                 $('.list-unstyled li:nth-child(6) ul li:first-child').toggleClass('active');
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
         </script>
        
        
    </body>
</html>
