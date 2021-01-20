<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Easyskul - CMS::Student Profile</title>
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
        
    </head>
    
    
    <body>



        <div class="wrapper">
            <!-- Sidebar Holder -->
            <?php 
            $users = array("Administrator","Data Entry","School Head","Student","Parent");
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
                                    <span style="color:#6b6b6b">CMS / Student / Manage Student /</span> <span style="color:#3c8dbc">Student Profile </span>
                                </div>
                            </div>
                        
                            </div>
                        </div>
                        
                        <div class="col-sm-12">
                            <div class="panel-group">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        Student Personal Information
                                    </div>
                                    <div class="panel-body">
                                        <div class="content">
                                       <?php
                                            $guardian_name='';
                                            $guardian_addr='';
                                            $guardian_ocup='';
                                            $guardian_tel='';
                                            $guardian_rd = '';
                                            $guardian_rs='';
                                            $student_id = '';
                                            if(isset($_GET['student_id']) && !empty($_GET['student_id'])){
                            
                                                $row_id = $_GET['student_id'];
                                                //select student details
                                                $query = mysqli_query($conn,"select * from admitted_students where NO = '$row_id'");
                                                if($fetch = mysqli_fetch_assoc($query)){
                                                    $guardian_name = $fetch['GUARDIAN NAME'];
                                                    $guardian_addr = $fetch['GUARDIAN ADDRESS'];
                                                    $guardian_ocup = $fetch['GUARDIAN OCCUPATION'];
                                                    $guardian_tel = $fetch['GUARDIAN TEL'];
                                                    $guardian_rd = $fetch['GUARDIAN RD'];
                                                    $guardian_rs = $fetch['GUARDIAN RELATIONSHIP STATUS'];
                                                    $photo = $fetch['PHOTO'];
                                                    $student_id = $fetch['ADMISSION NO / ID'];
                                                    echo'<form class="form form-horizontal"><div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                               <center><img src="upload/'.$photo.'" class="img img-thumbnail img-reponsive" style="width:100%; max-width:220px;"/></center><br/><br/>
                                               <a href="print_student_info.php?student_id='.$student_id.'" target="_blank"><button class="btn btn-primary btn-block" type="button" data-toggle="tooltip" data-placement="bottom" title="Click here to print student profile."><i class="fa fa-print"> </i> Print</button></a>
                                               </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                                  
                                                    <div class="form-group">
                                                        <label>FIRST NAME</label>
                                                        <input type="text" readonly value="'.htmlentities($fetch['STUDENT  FIRST NAME']).'" class="form-control" style="background-color:; width:90%; border:none; box-shadow:none;"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>LAST NAME</label>
                                                        <input type="text" readonly value="'.htmlentities($fetch['STUDENT LAST NAME']).'" class="form-control" style="background-color:; width:90%; border:none; box-shadow:none;"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>DATE OF BIRTH</label>
                                                        <input type="text" readonly value="'.htmlentities($fetch['STD DATE OF BIRTH']).'" class="form-control" style="background-color:; width:90%; border:none; box-shadow:none;"/>
                                                    </div>
                                                   <div class="form-group">
                                                        <label>STUDENT DISABILITIES</label>
                                                        <input type="text" readonly value="'.htmlentities($fetch['STUDENT DISABILITIES']).'" class="form-control" style="background-color:; width:90%; border:none; box-shadow:none;"/>
                                                    </div>
                                                    
                                                  
                                               </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                                   <div class="form-group">
                                                        <label>HOME TOWN</label>
                                                        <input type="text" readonly value="'.htmlentities($fetch['HOME TOWN']).'" class="form-control" style="background-color:; width:90%; border:none; box-shadow:none;"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>NATIONALITY</label>
                                                        <input type="text" readonly value="'.htmlentities($fetch['NATIONALITY']).'" class="form-control" style="background-color:; width:90%; border:none; box-shadow:none;"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>RELIGIOUS DENOMINATION</label>
                                                        <input type="text" readonly value="'.htmlentities($fetch['STD RELIGIOUS DENOMINATION']).'" class="form-control" style="background-color:; width:90%; border:none; box-shadow:none;"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>FORMER SCHOOL</label>
                                                        <input type="text" readonly value="'.htmlentities($fetch['FORMER SCHOOL']).'" class="form-control" style="background-color:; width:90%; border:none; box-shadow:none;"/>
                                                    </div>
                                               </div>
                                               
                                                   <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                                   <div class="form-group">
                                                        <label>DATE OF ADMISSION</label>
                                                        <input type="text" readonly value="'.htmlentities($fetch['DATE OF ADMISSION']).'" class="form-control" style="background-color:; width:90%; border:none; box-shadow:none;"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>PRESENT CLASS</label>
                                                        <input type="text" readonly value="'.htmlentities($fetch['PRESENT CLASS']).'" class="form-control" style="background-color:; width:90%; border:none; box-shadow:none;"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>GENDER</label>
                                                        <input type="text" readonly value="'.htmlentities($fetch['GENDER']).'" class="form-control" style="background-color:; width:90%; border:none; box-shadow:none;"/>
                                                    </div><div class="form-group">
                                                        <label>STUDENT ID</label>
                                                        <input type="text" readonly value="'.htmlentities($fetch['ADMISSION NO / ID']).'" class="form-control" style="background-color:; width:90%; border:none; box-shadow:none;"/>
                                                    </div>
                                               </div>
                                               </form>';
                                                }
                                                
                                            }
                                        ?>
                                            </div>
                                    </div>
                                        
                                </div>
                            </div>
                        </div>
                    <div class="content">
                        <div class="panel-group">
                            
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        Other Information
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12">

                                      <!-- tabs left -->
                                      <div class="tabbable tabs-left">
                                        <ul class="nav nav-tabs " style="font-size:18px;" id="nav_tabs">
                                          <li class="active"><a href="#guardian" data-toggle="tab">Guardian Information</a></li>
                                          <li><a href="#school_fees" data-toggle="tab">School Fees</a></li>
                                          
                                        </ul>
                                        <div class="tab-content">
                                         <div class="tab-pane active" id="guardian" style="padding-top:10px;">
                                             <div class="col-sm-12 col-md-4">
                                                 <div class="form-group">
                                                    <label>GUARDIAN NAME</label>
                                                    <input type="text" readonly value="<?php echo $guardian_name;?>" class="form-control" style=" width:90%; border:none; box-shadow:none;"/>
                                                 </div>
                                                 <div class="form-group">
                                                    <label>GUARDIAN ADDRESS</label>
                                                    <input type="text" readonly value="<?php echo $guardian_addr;?>" class="form-control" style=" width:90%; border:none; box-shadow:none;"/>
                                                 </div>
                                                 <div class="form-group">
                                                    <label>GUARDIAN OCCUPATION</label>
                                                    <input type="text" readonly value="<?php echo $guardian_ocup?>" class="form-control" style=" width:90%; border:none; box-shadow:none;"/>
                                                 </div>
                                            </div>
                                             <div class="col-sm-12 col-md-4">
                                                 <div class="form-group">
                                                    <label>GUARDIAN TEL</label>
                                                    <input type="text" readonly value="<?php echo $guardian_tel?>" class="form-control" style=" width:90%; border:none; box-shadow:none;"/>
                                                 </div>
                                                 <div class="form-group">
                                                    <label>GUARDIAN RELIGIOUS DENOMINATION</label>
                                                    <input type="text" readonly value="<?php echo $guardian_rd;?>" class="form-control" style=" width:90%; border:none; box-shadow:none;"/>
                                                 </div>
                                                 <div class="form-group">
                                                    <label>GUARDIAN RELATIONSHIP TO STUDENT</label>
                                                    <input type="text" readonly value="<?php echo $guardian_rs;?>" class="form-control" style=" width:90%; border:none; box-shadow:none;"/>
                                                 </div>
                                            </div>
                                            
                                        </div>
                                         <div class="tab-pane" id="school_fees" style="padding-top:10px;">
                                             <div class="col-sm-12" style="overflow-x:auto">
                                                    <table id="example" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                           <th>#</th>
                          <th>ACADEMIC YEAR</th>
                          
                          <th>TERM</th>
                          <th>FEES</th>
                          <th>PAYMENT</th>
                          <th>DEBIT</th>
                          <th>CREDIT</th>
                        </tr>
                        </thead>
                        <tbody id="result_box">
                            
                            <?php
                                
                                $counter  = 0;
                                $query_pick_fees = mysqli_query($conn,"select * from school_fees where `STUDENT ID`='$student_id' order by  `TERM` and `ACADEMIC YEAR` asc");
                                while($fetch = mysqli_fetch_assoc($query_pick_fees)){
                                    
                                    $counter ++;
                                    echo '<tr>
                                    <td>'.$counter.'</td>
                                    <td>'.$fetch['ACADEMIC YEAR'].'</td>
                                    <td>'.$fetch['TERM'].'</td>
                                    <td>'.sprintf('%0.2f',$fetch['AMOUNT']).'</td>
                                    <td>'.sprintf('%0.2f',$fetch['PAYMENT']).'</td>
                                    <td>'.sprintf('%0.2f',$fetch['DEBIT']).'</td>
                                    <td>'.sprintf('%0.2f',$fetch['CREDIT']).'</td>
                                    
                                    
                                </tr>';
                                    
                                }
                                
                            ?>
                        </tbody>
                        <tfoot>
                        <tr>
                           <th>#</th>
                          <th>ACADEMIC YEAR</th>
                          
                          <th>TERM</th>
                          <th>FEES</th>
                          <th>PAYMENT</th>
                          <th>DEBIT</th>
                          <th>CREDIT</th>
                        </tr>
                        </tfoot>
                      </table>
                                            </div>
                                             <button type="button" class="btn btn-danger" onclick="print_student_info('<?php echo $student_id;?>')" data-toggle="tooltip" data-placement="right" title="Click here to print fees records.If the search box above is not empty, records will be printed according to your search."><i class="fa fa-print"></i> Print Preview</button>
                                         </div>
                                            
                                            
                                
                                      <!-- /tabs -->

                    </div>  
                                    </div>
                                </div>
                            
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
         </script>
        
            </div></div>
    </body>
</html>
