<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Easyskul - CMS::Add Student</title>
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
                                <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <?php
                                        if(isset($_GET['import']) && !empty($_GET['import'])){
                                            echo '<span style="color:red">Plese note, almost all fields are optional but before you upload your file, make sure you match important fields to your .csv file columns. <br/>Please make sure <strong>class name</strong> and <strong>gender names</strong> correspond to what you inserted previously in the system.<br/> Your first column should be <strong>0</strong> </span>';
                                        }else{
                                            echo  'Please send your excel files containing the students information irrespective to their classes to <strong>info@easyskul.com</strong>';
                                            die();
                                        }
                                    ?>
                                </div>
                            </div>
                        
                            </div>
                        </div>
                       <?php 
                        $query_pick = mysqli_query($conn,"select * from school_details where  INITIALS = '$initials' and SMS=''");
    if(mysqli_num_rows($query_pick)!=null){
            
    }else{
                        
                                             $query = mysqli_query($conn,"select * from `admitted_students` where  `SCHOOL`='$initials' and `SMS`='' and `GUARDIAN TEL` !=''");
                                              $number = mysqli_num_rows($query);
                                              if($number > 0){
                                                  if($number > 50){
                                                      $number = '50 and more';
                                                  }
                                                      echo '
                                                      <div class="col-xs-12 col-md-6 col-md-offset-3 col-sm-offset-0" style="padding-top:10px;" id="hint_box">
                                <div class="panel-group" >
                                    <div class="panel panel-success">
                                                      <div class="panel-heading"  style="border-radius:5px;">
                                                      <i class="fa fa-envelop"></i> 
                                            You have '.$number.' sms to be sent.<span class="badge badge-primary" style="cursor:pointer" onclick="send_student_id();" id="sms_btn">send</span> <i class="fa fa-close pull-right" style="cursor:pointer" onclick="close_hint(\'#hint_box\')"></i>
                                        </div>     
                                    </div>
                                </div>
                            </div>';
                                              }
    }
                                        ?>
                        <div class="col-sm-12">
                            <div class="panel-group">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        Add A New Student
                                    </div>
                                    <div class="panel-body">
                                        <form role="form" id="form" enctype="multipart/form-data" method="post">
                                         <input type="file" name="file" id="file"/>
                                         <input type="submit" value="upload" name="submit"/>
                                         <?php include 'upload_student_data.php';?>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                       
                </div>  
                     
                    </div>  
                
                
             
            </div>
        

        </div>


<!--modl boxes-->
         <div class="modal fade" id="camera">
             <div class="modal-dialog" style="z-index:5000;">
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
                                 
                                 <button class="btn btn-default btn-block" type="button" id="capture" data-dismiss="modal"><i class="fa fa-camera" ></i> Capture</button>
                                 
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
        <script src="webcam/webcamjs/webcam.min.js"></script>
        <script src="../js/webcam_config.js"></script>
         <script type="text/javascript">
             $(document).ready(function () {
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                 });
                 
                 $('.list-unstyled li:nth-child(5) ul').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(5) a').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(5) ul').toggleClass('collapse in');
                 $('.list-unstyled li:nth-child(5) a').toggleClass('');
                 $('.list-unstyled li:nth-child(5) ul li:first-child').toggleClass('active');
                 
                 
                 var selects = document.getElementsByClassName('selectpicker');
                 for(i = 0; i < selects.length; i++){
                     
                     $(selects[i]).selectpicker('refresh');
                     $(selects[i]).html('<option value="hello">hello</option>');
                 }
                
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
        
        
    </body>
</html>
