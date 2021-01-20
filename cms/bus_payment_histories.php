<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Easyskul - CMS::Daily bus payment Records</title>
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
            $users = array("Administrator","Accountant","School Head");
            include '../includes/cms_sidebar.php';
        ?>

            <!-- Page Content Holder -->
            <div id="content">
<?php include '../includes/cms_header.php';
                    include '../includes/redirect_admin.php';
                ?>                       
                <div id="box">
                 
                    <div class="content" style="padding:20px; padding-top:0px;">
                        <?php 
                        $from = '';
                        $to ='';
                        $group  = '';
                        if(isset($_GET['from_date']) && !empty($_GET['from_date']) && isset($_GET['to_date']) && !empty($_GET['to_date'])  && isset($_GET['group']) && !empty($_GET['group'])){
                            $from = $_GET['from_date'];
                            $to = $_GET['to_date'];
                            $group = $_GET['group'];
                        }else{
                                $initial_class = '';
                                $query_pick_initial_class = mysqli_query($conn,"select * from classes where `SCHOOL`='$initials' order by ID asc");
                                if($fetch = mysqli_fetch_assoc($query_pick_initial_class)){
                                    $initial_class = htmlentities($fetch['CLASS']);
                                }
                                }
                        ?>
                        
                            
                        <div class="col-sm-12">
                            <form action="bus_payment_histories" method="get" class="form-inline" role="form">
                           <div class="form-group"> 
                                                <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%">
                                                    <input class="form-control"  type="text" value="" readonly placeholder="From" style="background-color:white;" id="date_of_birth" name="from_date">
                                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                </div>
                                                <input type="hidden"  value="" /><br/>
                                            </div>
                                
                               <div class="form-group"> 
                                                <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%">
                                                    <input class="form-control"  type="text" value="" readonly placeholder="To" style="background-color:white;" id="date_of_birth" name="to_date">
                                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                </div>
                                                <input type="hidden"  value="" /><br/>
                                            </div>
                                <div class="form-group">
                                    <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width:100%;" id="" name="group">
                                    <option value="ALL">ALL</option>
                                    <option value="IN">IN</option>
                                    <option value="OUT">OUT</option>
                                    <option value="IN & OUT">IN & OUT</option>

                          </select>
                                </div>
                           <div class="form-group"><button type="submit" class="btn btn-default" >Search</button></div>
                                
                           
                        </form>
                        </div>
                        <div class="col-sm-12" style="padding-top:20px;">
                                <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <span style="color:#6b6b6b"><?php echo $username; ?> CMS / bus fee /</span> <span style="color:#3c8dbc"> Fee History - <strong> <?php echo $from;?> - <?php echo $to;?> Group - <?php echo $group;?></strong></span>
                                </div>
                            </div>
                        
                            </div>
                        </div>
                        <div class="col-sm-12" style="padding-top:20px;">
                            <div class="panel-group">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        RECORDS
                                    </div>
                                    <div class="panel-body" style="overflow-x:auto">
                                        
                                        <table id="example4" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                           <th>#</th>
                          <th>STUDENT ID</th>
                          <th>STUDENT NAME</th>
                          <th>CLASS</th>
                          <th>DATE</th>
                            <th>AMOUNT PER DAY</th>
                            <th>AMOUNT PAID</th>
                            <th> PAID FOR</th>
                          <th>DAYS</th>
                          <th>ACTION</th>
                          
                        </tr>
                        </thead>
                        <tbody id="result_box">
                           
                            <?php
                                 $results = '';
                                $counter  = 0;
                                if($group == "ALL"){
                                    $query_pick_fees = mysqli_query($conn,"select * from daily_bus_fee where `DATE` between '$from' and '$to' and `SCHOOL`= '$initials' order by  `TERM` and `STUDENT NAME` and `CLASS` asc");
                                }else{
                                    $query_pick_fees = mysqli_query($conn,"select * from daily_bus_fee where `DATE` between '$from' and '$to' and `SCHOOL`= '$initials' and `CATEGORY`='$group' order by  `TERM` and `STUDENT NAME` and `CLASS` asc");
                                }
                            
                                
                                while($fetch = mysqli_fetch_assoc($query_pick_fees)){
                                    $id = $fetch['ID'];
                                    $counter ++;
                                        $results .= '<tr>
                                        <td>'.$counter.'</td>
                                        
                                        <td>'.htmlentities($fetch['STUDENT ID']).'</td>
                                        <td>'.htmlentities($fetch['STUDENT NAME']).'</td>
                                        <td>'.htmlentities($fetch['CLASS']).'</td>
                                        <td>'.$fetch['DATE'].'</td>
                                        <td>'.sprintf('%0.2f',$fetch['AMOUNT PER DAY']).'</td>
                                        <td>'.sprintf('%0.2f',$fetch['AMOUNT']).'</td>
                                        <td>'.$fetch['CATEGORY'].'</td>
                                        
                                       
                                        <td>'.$fetch['DAYS'].'</td>
                                        
                                         <td>
                                         <button class="btn btn-danger" data-target="#edit_feeding" data-toggle="modal" '.$btn_style.' onclick="fetch_bus_fee_records(\''.$fetch['STUDENT ID'].'\',\''.$fetch['ID'].'\',\''.$from.'\',\''.$to.'\');"><i class="fa fa-trash"></i> Delete</button>
                                         </td>

                                    </tr>';
                                    
                                }
                               echo $results;
                            ?>
                        </tbody>
                        <tfoot>
                        <tr>
                             <th>#</th>
                          <th>STUDENT ID</th>
                          <th>STUDENT NAME</th>
                          <th>CLASS</th>
                          <th>DATE</th>
                            
                            <th>AMOUNT PER DAY</th>
                            <th>AMOUNT PAID</th>
                            <th>PAID FOR</th>
                          <th>DAYS</th>
                          <th>ACTION</th>
                        </tr>
                        </tfoot>
                      </table>
                                         <?php  $group = str_replace('&','_',$group);?>
                                        <div class="dropdown">
                                         
                                        <button class="btn btn-danger"  data-toggle="dropdown" ><i class="fa fa-print"></i> Generat Report <span class="caret"></span></button>
                    <ul class="dropdown-menu" id="dropdown" class="dropdown">
                        <li data-toggle="modal" data-target="#fclass">By Class from selected date</li>
                        <a href="print_bus_fee_history.php?from=<?php echo $from?>&to=<?php echo $to;?>&class=&group=<?php echo $group;?>" target="_blank"><li>From selected date</li></a>
                    </ul>
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
         <div class="modal fade" id="fclass" style="z-index:5000;">
             <div class="modal-dialog " style="z-index:5000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                         <h2 class="modal-title"><i class="fa fa-book"></i>Select Class To Generate Report</h2>
                     </div>
                     <div class="modal-body" id="modal_results">
                         <form class="form-inline" role="form">
                             <div class="form-group" style="margin-top:0px;">
                            <label><small id="classv">Present class: </small></label><br/>
                           <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width:100%;" id="class" name="class">
                            <?php
                                    $qeuery_pick_classes = mysqli_query($conn,"select * from classes where `SCHOOL`='$initials' order by ID asc");
                                    while($fetch = mysqli_fetch_assoc($qeuery_pick_classes)){
                                        echo '<option value="'.htmlentities($fetch['CLASS']).'" >'.htmlentities($fetch['CLASS']).'</option>';
                                    }
                               ?>

                          </select>

                        </div>
                           
                             <div class="form-group" style="margin-top:25px;">
                                 <button class="btn btn-danger" onclick="print_bus_fee_history('<?php echo $from?>','<?php echo $to?>','<?php echo $group?>')" type="button"><i class="fa fa-print"></i> Generte report</button>
                             </div>
                         </form>
                     </div>
                       
                 </div>
             </div>
         </div>
        
        <div class="modal fade" id="edit_feeding">
             <div class="modal-dialog" style="z-index:3000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         
                         <ol class="breadcrumb"><strong>You are about to make changes to this record. </strong><button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button></ol>
                     </div>
                     <div class="modal-body" id="modal_results2">
                         
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
                 
                 $('.list-unstyled li:nth-child(11) ul').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(11) a').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(11) ul').toggleClass('collapse in');
                 $('.list-unstyled li:nth-child(11) a').toggleClass('');
                 $('.list-unstyled li:nth-child(11) ul li:nth-child(4)').toggleClass('active');
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
             
            
         </script>
        
        
    </body>
</html>
