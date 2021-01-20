<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Easyskul - CMS::Time Table</title>
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
            $users = array("Administrator","Accountant","School Head","Teacher");
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
                        if(isset($_GET['class']) && !empty($_GET['class'])){
                            $initial_class = $_GET['class'];
                        }else{
                                $initial_class = '';
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
                            <form action="time_table.php" method="get" class="form-inline" role="form" id="form">
                            <label><small>Filter by Class </small></label><br/>
                           <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width:100%;" id="class" name="class">
                            <?php
                                   
                                    $qeuery_pick_classes = mysqli_query($conn,"select * from classes where `SCHOOL`='$initials' order by ID asc");
                                    while($fetch = mysqli_fetch_assoc($qeuery_pick_classes)){
                                        echo '<option value="'.htmlentities($fetch['CLASS']).'" >'.htmlentities($fetch['CLASS']).'</option>';
                                    }
                                    
                                
                               ?>

                          </select> <button type="submit" class="btn btn-default">Search</button>
                                <div <?php echo $btn_style;?>>
                          
                               <?php
                                    if(strpos($user,'-TCH')){
                                        
                                    }else{
                                        echo '<button type="button" class="btn btn-primary pull-right"   style="margin-left:10px;"  onclick="upload_pdf(\''.$initial_class.'\');" id="btn_upload" data-toggle="toolpit" data-placement="top" title="Please make sure you select a pdf document."> <i class="fa fa-upload"></i> upload</button>
                                <input type="file" class="form-control pull-right" name="file" accept="application/pdf"/>';
                                    }
    
                                ?>
                                
                               </div> 
                        </form>
                        </div>
                        </div>
                        <div class="content">
                            <div class="col-sm-12" style="padding-top:20px;">
                                <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <span style="color:#6b6b6b">CMS / Time Table </span>
                                </div>
                            </div>
                        
                            </div>
                        </div>
                        </div>
                        <?php 
                            if(isset($_GET['id']) && !empty($_GET['id'])){
                                $id = $_GET['id'];
                                $query2 = mysqli_query($conn,"select * from time_table where `ID`='$id'");
                                if($fetch = mysqli_fetch_assoc($query2)){
                                    if(file_exists('time_tables/'.$fetch['FILE'])){
                                        unlink('time_tables/'.$fetch['FILE']);
                                    }
                                    mysqli_query($conn,"delete from time_table where `ID`='$id'");
                                }
                            }
                        ?>
                        <div class="col-sm-12" style="padding-top:20px;">
                            <div class="panel-group">
                                <div class="panel panel-primary">
                                    <div class="panel-heading" >
                                      Uploaded Files
                                    </div>
                                    <div class="panel-body" style="overflow-x:auto">
                                        
                                       <table id="example" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                           <th>#</th>
                          <th>ACADEMIC YEAR</th>
                          
                          <th>TERM</th>
                          <th>ACTION</th>
                          
                        </tr>
                        </thead>
                        <tbody id="result_box">
                            
                            <?php $counter = 0;
    
    $query1 = mysqli_query($conn,"select * from time_table where `SCHOOL`='$initials' and `CLASS`='$initial_class' order by `ACADEMIC YEAR` and `TERM` asc");
    
    
    $counter = 0;
   
    while($fetch1 = mysqli_fetch_assoc($query1)){
        $id = htmlentities($fetch1['ID']);
        $academic_year = htmlentities($fetch1['ACADEMIC YEAR']);
        $file = $fetch1['FILE'];
        $term = htmlentities($fetch1['TERM']);
        
        $counter ++;
        $btn = ' <a href="time_table.php?id='.$id.'&class='.$initial_class.'"><li '.$btn_style.'><i class="fa fa-trash"></i> Delete</li></a>';
        if(strpos($user,'-TCH')){
            $btn = '';
        }
        
        echo '
              <td>'.$counter.'</td>
              <td>'.$academic_year.'</td>
              
              <td>'.$term.'</td>
                   <td>
                                         <div class="dropdown">
                                         
                                        <button class="btn btn-default"  data-toggle="dropdown" id="drop">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu" id="dropdown" class="dropdown">
                        
                       '.$btn.'
                        
                        <a href="time_table.php?file='.$file.'&class='.$initial_class.'"><li><i class="fa fa-book"></i> View</li></a>
                    </ul>
              </div></td>
              
                   
              

            </tr>';
    }?>
                        </tbody>
                        <tfoot>
                        <tr>
                           
                           <th>#</th>
                          <th>ACADEMIC YEAR</th>
                          
                          <th>TERM</th>
                          <th>ACTION</th>
                          
                        </tr>
                        </tfoot>
                      </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                       <?php 
                            if(isset($_GET['file']) && !empty($_GET['file'])){
                                $file = $_GET['file'];
                                echo '<object data="time_tables/'.$file.'" type="application/pdf" width="100%" height="700px"></object> ';
                            }
                            
                            
                        ?>
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
                 $('.list-unstyled li:nth-child(15)').toggleClass('active');
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
