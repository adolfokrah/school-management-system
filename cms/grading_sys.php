<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Easyskul - CMS::Grading System</title>
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
            
                    $query_check2 = mysqli_query($conn,"select * from grading_system where `SCHOOL`='$initials'");
        if(mysqli_num_rows($query_check2)==null){
            echo "<script>swal('','Please set grading system before you can be able to generate reports','warning');</script>";
            
        }
                ?>                    
                <div id="box">
                  <?php 
                        $pass_mark = '';
                        $exam_mark = '';
                        $class_mark = '';
                            $probation_mark ='';
                        $A = '';
                        $B = '';
                        $C = '';
                        $D = '';
                        $E = '';
                        $F = '';
                        $initial_class = '';                       
                        if(isset($_GET['class_mark']) && !empty($_GET['class_mark']) && isset($_GET['exam_mark']) && !empty($_GET['exam_mark'])&&isset($_GET['pass_mark']) && !empty($_GET['pass_mark'])&&isset($_GET['A']) && !empty($_GET['A'])&&isset($_GET['C']) && !empty($_GET['C'])&&isset($_GET['D']) && !empty($_GET['D'])&&isset($_GET['E']) && !empty($_GET['E'])&&isset($_GET['B']) && !empty($_GET['B'])&&isset($_GET['F'])&& !empty($_GET['probation_mark'])&&isset($_GET['probation_mark'])){
                            $pass_mark = $_GET['pass_mark'];
                            $exam_mark = $_GET['exam_mark'];
                            $class_mark = $_GET['class_mark'];
                            $probation_mark = $_GET['probation_mark'];
                            $A = $_GET['A'];
                            $B = $_GET['B'];
                            $C = $_GET['C'];
                            $D = $_GET['D'];
                            $E = $_GET['E'];
                            $F = $_GET['F'];
                            //CHECK IF GRADING ALREADY EXIST
                            $query = mysqli_query($conn,"select * from grading_system where `SCHOOL`='$initials'");
                            if($fetch = mysqli_fetch_assoc($query)){
                                
                                mysqli_query($conn,"update grading_system set `PASS MARK`='$pass_mark',`EXAM MARK`='$exam_mark',`CLASS MARK`='$class_mark',`PROBATION MARK`='$probation_mark',`A`='$A',`B`='$B',`C`='$C',`D`='$D',`E`='$E',`F`='$F' where `SCHOOL`='$initials'");
                                
                            }else{
                                mysqli_query($conn,"INSERT INTO `grading_system` (`ID`, `SCHOOL`, `CLASS MARK`, `EXAM MARK`, `PASS MARK`,`PROBATION MARK`, `A`, `B`, `C`, `D`, `E`, `F`) VALUES (NULL, '$initials', '$class_mark', '$exam_mark', '$pass_mark','$probation_mark', '$A', '$B', '$C', '$D', '$E', '$F');");
                            }
                            echo "<script>
                                swal('Done','','success');
                            </script>";
                        }else{
                            
                           
                        }
            
                        
                            $query = mysqli_query($conn,"select * from grading_system where `SCHOOL`='$initials'");
                            if($fetch = mysqli_fetch_assoc($query)){
                                
                            $pass_mark = $fetch['PASS MARK'];
                            $exam_mark = $fetch['EXAM MARK'];
                            $class_mark = $fetch['CLASS MARK'];
                            $probation_mark = $fetch['PROBATION MARK'];
                            $A = $fetch['A'];
                            $B = $fetch['B'];
                            $C = $fetch['C'];
                            $D = $fetch['D'];
                            $E = $fetch['E'];
                            $F = $fetch['F'];
                            }
            ?>
    
                    
                        <div class="content">
                            <div class="col-sm-12" style="padding-top:20px;">
                                <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <span style="color:#6b6b6b">CMS / Grading system </span>
                                </div>
                                <center><label style="color:red">Plase make sure you set these grading systems before generating report.</label></center>
                            </div>
                                </div></div>
                                    <div class="col-sm-12 col-md-6 col-md-offset-3 col-sm-offset-0">
                                        <form class="form-inline" role="form" style="text-align:center" method="get" action="grading_sys.php">
                                            <div class="form-group">
                                                <label>Class Mark Percentage: </label> <input type="number" class="form-control" placeholder="eg. 30%" required name="class_mark" value="<?php echo $class_mark ?>"/>
                                            </div><br/><br/>
                                            <div class="form-group">
                                                <label>Exam Mark Percentage: </label> <input type="number" class="form-control" placeholder="eg. 70%" required name="exam_mark" value="<?php echo $exam_mark ?>"/>
                                            </div><br/><br/>
                                            <div class="form-group">
                                                <label>Pass Mark: </label> <input type="number" class="form-control" placeholder="eg. 50" required name="pass_mark" value="<?php echo $pass_mark ?>"/>
                                            </div><br/><br/>
                                            <div class="form-group">
                                                <label>Probation Mark: </label> <input type="number" class="form-control" placeholder="eg. 36" required name="probation_mark" value="<?php echo $probation_mark ?>"/>
                                            </div><br/><br/>
                                            <p>Grades</p>
                                            
                                            <div class="form-group">
                                                <label>A: </label> <input type="number" class="form-control" placeholder="Mark eg. 80 That is 80 - 100" required name="A" value="<?php echo $A ?>"/> 
                                            </div><br/><br/>
                                            <div class="form-group">
                                                <label>B: </label> <input type="number" class="form-control" placeholder="Mark eg. 70 That is 70 - 79" required name="B" value="<?php echo $B ?>"/>
                                            </div><br/><br/>
                                            <div class="form-group">
                                                <label>C: </label> <input type="number" class="form-control" placeholder="Mark eg. 50 That is 50 - 69" required name="C" value="<?php echo $C ?>"/>
                                            </div><br/><br/>
                                            <div class="form-group">
                                                <label>D: </label> <input type="number" class="form-control" placeholder="Mark eg. 30 That is 30 - 49" required name="D" value="<?php echo $D ?>"/>
                                            </div><br/><br/>
                                            <div class="form-group">
                                                <label>E: </label> <input type="number" class="form-control" placeholder="Mark eg. 25 That is 25 - 29" required name="E" value="<?php echo $E ?>"/>
                                            </div><br/><br/>
                                            <div class="form-group">
                                                <label>F: </label> <input type="number" class="form-control" placeholder="Mark eg. 0 That is 0  - 24" required name="F" value="<?php echo $F ?>"/>
                                            </div><br/><br/>
                                            
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Save Changes</button>
                                            </div>
                                        </form>
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
                                 <label>Select Class Teacher</label><br/>
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
                                 
                                 <button class="btn btn-primary" type="button" onclick="take_attedance();"  id="continue"><i class="fa fa-save"></i> Continue</button>
                                 
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
                 
                 $('.list-unstyled li:nth-child(16) ul').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(16) a').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(16) ul').toggleClass('collapse in');
                 $('.list-unstyled li:nth-child(16) a').toggleClass('');
                 $('.list-unstyled li:nth-child(16) ul li:nth-child(3)').toggleClass('active');
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
