<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Easyskul - CMS::Dashboard</title>
        <link href="../web_images/logo2.png" rel="icon"/>
         <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="../css/font-awesome.css">
         <link rel="stylesheet" href="../bootstrap-3.3.7-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../css/sidebar.css">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="../css/cms_style.css"/>
        <link rel="stylesheet" href="fullcalendar/fullcalendar.min.css"/>
        <link rel="stylesheet" href="fullcalendar/fullcalendar.print.css" media="print"/>
        <link rel="stylesheet" href="bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"/>
        <script src="../js/jQuery-v2.1.3.js"></script>
        
        <script src="fullcalendar/moment.min.js"></script>
        <script src="fullcalendar/fullcalendar.min.js"></script>
        <script src="sweetalert2-master/dist/sweetalert2.all.min.js"></script>
        <script src="../js/cms.js"></script>
        <script src="//code.tidio.co/oc6tcjthxgtesxrtpwutqwmcbl4txaih.js"></script>

    </head>
    <body>



        <div class="wrapper">
            <!-- Sidebar Holder -->
            <?php 
            $users = array("Data Entry");
            include '../includes/cms_sidebar.php';
        ?>

            <!-- Page Content Holder -->
            <div id="content">
             <?php include '../includes/cms_header.php';
                    include '../includes/redirect_admin.php';
                include '../includes/get_currencies.php';   
            ?>       
<div id="box">
                    <div class="content" style="padding:20px; padding-top:0px;">
                        <div class="col-sm-12">
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <span style="color:#6b6b6b">CMS /</span> <span style="color:#3c8dbc">Dashboard</span>
                                </div>
                            </div>
                        </div>

                <div class="row">
                <div class="content">
                    
                    <?php
                        //dash board php begining select number of users,student,classes,staffs
                        
                        //select number of users
                        $query_select1 = mysqli_query($conn,"select * from users where `SCHOOL`='$initials' and `POSITION` !=''");
                        $number_of_users = 0;
                        while($fetch = mysqli_fetch_assoc($query_select1)){
                            $u_Id = $fetch['USER ID'];
                            
                            if(strpos($u_Id,'-STD') || strpos($u_Id,'-PT')){
                                
                            }else{
                                $number_of_users++;
                            }
                        }
                       
                        if($number_of_users >90){
                            $number_of_users = '90+';
                        }
            
                     //select number of students
$query_select2 = mysqli_query($conn,"select * from admitted_students where `SCHOOL`='$initials'  and `PRESENT CLASS` !=''");                    $number_of_students = mysqli_num_rows($query_select2);
                    
                    if($number_of_students >90){
                        $number_of_students = '90+';
                    }
            
                    //select number of classes
                    $query_select3 = mysqli_query($conn,"select * from `classes` where `SCHOOL`='$initials'");
                    $number_of_classes = mysqli_num_rows($query_select3);
                    
                    if($number_of_classes > 90){
                        $number_of_classes = '90+';
                    }
            
                    //select number of staffs
                    $query_select4 = mysqli_query($conn,"select * from `users` where `SCHOOL`='$initials' and `POSITION` !=''");
                    $number_of_staffs =0;
                    
                    while($fetch = mysqli_fetch_assoc($query_select4)){
                        $userid = $fetch['USER ID'];
                        
                        if(strpos($userid,'-AD')){
                             $number_of_staffs++;
                        }
                        
                    }
                    if($number_of_staffs > 90){
                        $number_of_staffs = '90+';
                    }
                        
                    ?>
                
                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <!-- small box -->
                      <div class="small-box bg-aqua">
                        <div class="inner">
                          <h3><?php echo $number_of_users?></h3>

                          <p style="color:white">User(s)</p>
                        </div>
                        <div class="icon">
                          <i class="fa fa-users"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                          More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                      </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <!-- small box -->
                      <div class="small-box bg-green">
                        <div class="inner">
                          <h3><?php echo $number_of_students?></h3>

                          <p style="color:white">Student(s)</p>
                        </div>
                        <div class="icon">
                          <i class="fa fa-user"></i>
                        </div>
                        <a href="manage_student.php" class="small-box-footer">
                          More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                      </div>
                    </div>
                    
                    
                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <!-- small box -->
                      <div class="small-box bg-yellow">
                        <div class="inner">
                          <h3><?php echo $number_of_classes?></h3>

                          <p style="color:white">Classes</p>
                        </div>
                        <div class="icon">
                          <i class="fa fa-bank"></i>
                        </div>
                        <a href="manage_class.php" class="small-box-footer">
                          More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                      </div>
                    </div>
                    
                    
                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <!-- small box -->
                      <div class="small-box bg-red">
                        <div class="inner">
                          <h3><?php echo $number_of_staffs?></h3>

                          <p style="color:white">Administrator(s)</p>
                        </div>
                        <div class="icon">
                          <i class="fa fa-briefcase"></i>
                        </div>
                        
                      </div>
                    </div>
                    
                        </div>
                        </div>
                 <div class="row">       
                <div class="content">
                    <div class="col-md-12 col-lg-7">
                        <div class="panel-group">
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
                                <textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" id="notice_box" data-toggle="tooltip" data-placement="top" title="Type any infomation who want to post to the noticeboard.">

                                </textarea><br/><br/>
                                  <button class="btn btn-primary pull-left" id="publish_btn" onclick="add_notice('dashboard')" data-toggle="tooltip" data-placement="top" title="Click here to add infomation to the noticebord." type="button">Publish</button>
                              </form>
                            </div>
                          </div>
                        </div>
                        
                       
                        
                        
                    </div>
                    <div class="col-md-12 col-lg-5">
                        
                        <div class="panel-group">
                        <div class="box box-info">
                        <div class="box-header with-border">
                          <i class="fa fa-calendar-o"></i>

                          <h3 class="box-title">Recent Notice</h3>
                        </div>
                        <!-- /.box-header -->
                        
                          <?php
                                        //fetch recent notice posted
                                    
                                        $query_select_notice = mysqli_query($conn,"select * from noticeboard where `SCHOOL`='$initials' order by ID desc");
                                        if($fetch_row = mysqli_fetch_assoc($query_select_notice)){
                                            $info = $fetch_row['INFO'];
                                            $date  = $fetch_row['DATE PUBLISHED'];
                                            $time = $fetch_row['TIME'];
                                            echo '<div class="box-header with-border">
                                                    <span class="pull-right"><small><i class="fa fa-clock-o"></i> '.$date.' '.$time.'</small></span>
                                                    </div>';
                                            if(strlen($info)>700){
                                                $info = substr($info,0,700);
                                                $info .='...';
                                            }
                                            echo '<div class="box-body">'.$info.'</div>';
                                        }
                                    
                                    ?>
                            <div class="box-footer">
                                <a href="manage_notice.php" data-toggle="tooltip" data-placement="right" title="Click here to read more notice">Read More..</a>
                            </div>
                        <!-- /.box-body -->
                      </div>
                      <!-- /.box -->
                    </div>
                              <div class="info-box bg-green" style="color:white;">
                                            <span class="info-box-icon"><i class="fa fa-envelope-o"></i></span>

                                            <div class="info-box-content">
                                                <?php //pick school sms credit left
                                                    $query = mysqli_query($conn,"select * from sms_credit where `SCHOOL`='$initials'");
                                                    $pecentage = 0;
                                                    $left = 0;
                                                    if($fetch = mysqli_fetch_assoc($query)){
                                                        $left = $fetch['SMS LEFT'];
                                                        $used = $fetch['SMS USED'];
                                                        $total = $left + $used;
                                                        $pecentage = sprintf('%0.1f',($left/$total) * 100);
                                                    }
                                                ?>
                                              <span class="info-box-text">SMS left</span>
                                              <span class="info-box-number"><?php echo number_format($left)?></span>

                                              <div class="progress">
                                                <div class="progress-bar" style="width:<?php echo $pecentage;?>%"></div>
                                              </div>
                                                  <span class="progress-description">
                                                    <?php echo $pecentage;?>% Left. click <span class="badge badge-danger" style="background-color:#f39c12; cursor:pointer" data-toggle="modal" data-target="#sms_box" >here</span> to purchase credit
                                                  </span>
                                            </div>
                                            <!-- /.info-box-content -->
                                          </div>          <!--
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    Recent Notice
                                </div>
                                <div class="panel-body" id="view_notice" style="word-wrap: break-word;
    word-break: break-all;">
                                    <?php
                                        //fetch recent notice posted
                                    
//                                        $query_select_notice = mysqli_query($conn,"select * from noticeboard where `SCHOOL`='$initials' order by ID desc");
//                                        if($fetch_row = mysqli_fetch_assoc($query_select_notice)){
//                                            $info = $fetch_row['INFO'];
//                                            if(strlen($info)>300){
//                                                $info = substr($info,0,300);
//                                                $info .='...';
//                                            }
//                                            echo $info;
//                                        }
                                    
                                    ?>
                                </div>
                                 <div class="panel-footer">
                                    <a href="manage_notice.php" data-toggle="tooltip" data-placement="right" title="Click here to read more notice">Read More..</a>
                                 </div>
                            </div>-->
                        
                    </div>
                </div>
</div>
                            <div class="row">
                                <div class="content">
                                    
                                    <div class="col-xs-12">
                                        <div class="panel-group">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <span style="color:#6b6b6b"><i class="fa fa-calendar"></i> Academic Calendar</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="panel-group">
                                            <div class="box box-danger">
                                            
                                            <div class="box-body pad">
                                              <div id='calendar'></div>
                                            </div>
                                          </div>
                                            
                                          
                                        </div>
                                        <div style="display:none">
                                        <table id="example2" class="table table-hover table-bordered table-striped" style="display:none">
                        <thead>
                        <tr>
                          <th>
                              <form class="form">
                                  <label>
                                      <input type="checkbox" id="check_all">
                                     
                                  </label>
                              </form>
                          </th>
                           
                          <th>EVENT</th>
                          
                          <th>DAY</th>
                          
                         
                          
                        </tr>
                        </thead>
                        <tbody id="result_box">
                            
                            <?php $counter = 0;
    
    $query1 = mysqli_query($conn,"select * from events where `SCHOOL`='$initials' order by `ID` asc");
    
    
    $counter = 0;
   
    while($fetch1 = mysqli_fetch_assoc($query1)){
        $id = htmlentities($fetch1['ID']);
        $date = htmlentities($fetch1['DATE']);
        $end_date = $fetch1['END DATE'];
        $color = $fetch1['COLOR'];
        $event = htmlentities($fetch1['EVENT']);
        $counter ++;
        
        echo '<tr id="row'.$id.'">
              <td><label>
                  <input type="checkbox" id="row_check" name="'.$id.'" class="checkboxes"></i>
              </label> </td>
              
              <td class="event_name" id="'.$color.'">'.$event.'</td>
              
              <td class="event_date" id="'.$end_date.'">'.$date.'</td>
              
            </tr>';
    }?>
                        </tbody>
                        <tfoot>
                        </tfoot>
                      </table></div>
                                        
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                        
                    </div>
                </div>  
                <div class="footer">
                                <p>Copyright &copy; <a href="#">Easyskul</a>. All rights reserved.</p>
                            </div> 
                </div>
             
            </div>
        
 <?php 
            include '../includes/sms_box.php';
        ?>




        <script src="../js/boostrap.min.js"></script>
        
        <!--add the table js-->
        <script src="datatables/jquery.dataTables.min.js" id="script1"></script>
        <script src="datatables/dataTables.bootstrap.min.js" id="script2"></script>
        <script src="../js/table.js" id="script3"></script>
        <script src="bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
        <script src="bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>
        <script src="webcam/webcamjs/webcam.min.js"></script>
        <script src="../js/webcam_config.js"></script>
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
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                 });
                 $('.list-unstyled li:nth-child(3)').toggleClass('active');
             });
            
            $(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });
   $(document).ready(function() {
                  
                $('#calendar').fullCalendar({
                
                header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
                },

               
                editable: false,

                eventLimit: true, // allow "more" link when too many events
                
                });
                  
                var event_name = document.getElementsByClassName('event_name');  
                var event_date = document.getElementsByClassName('event_date'); 
                  
                for(var i=0; i<event_name.length; i++){
                  var event = {id:i,title:event_name[i].innerHTML, start:event_date[i].innerHTML,end:event_date[i].id,backgroundColor: event_name[i].id,borderColor: event_name[i].id};
                  $('#calendar').fullCalendar('renderEvent',event,true);
                }
                  
});
         </script>
    </body>
</html>
