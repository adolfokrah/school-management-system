<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Easyskul - CMS::Dashboard</title>
        <link href="../web_images/logo2.png" rel="icon"/>
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
         <!-- Morris charts -->
        <link rel="stylesheet" href="morris/morris.css">
        <script src="../js/jQuery-v2.1.3.js"></script>
        
        <script src="fullcalendar/moment.min.js"></script>
        <script src="fullcalendar/fullcalendar.min.js"></script>
        <script src="sweetalert2-master/dist/sweetalert2.all.min.js"></script>
        <script src="../js/cms.js"></script>
    </head>
    <style>
        #calendar{
            padding-top: 5px;
            padding-left: 0px;
        }
        #calendar:after{
            content: "";
            clear: both;
            display: block;
            float: none;
            
        }
        #calendar li{
            float: left;
            list-style-type: none;
           border-radius: 5px;
            cursor: pointer;
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            margin-left: 6px;
            
            margin-bottom: 5px;
           
            
        }
        #calendar li:hover{
            background: linear-gradient(0deg,#ccc,#b1b1b1);
            color: white;
        }
       #calendar li.active{
            background:linear-gradient(0deg,#226992,#3c8dbc);
            color:white;
        }
        .popup{
            width:200px;
            background-color: white;
            position: absolute;
            right: 10px;
            bottom: 30px;
            box-shadow: 0px 0px 4px 1px #666666;
            border-radius: 5px;
            padding-top: 5px;
            display: none;
            opacity: 0;
            transition: 1s ease-in;
            z-index: 5000;
        }
    </style>
    <body>



        <div class="wrapper">
            <!-- Sidebar Holder -->
            <?php include '../includes/c_sidebar.php'?>

            <!-- Page Content Holder -->
            <div id="content">
             <?php include '../includes/c_header.php';
            ?>       
                
                <div id="box">
                    <div class="content" style="padding:20px; padding-top:0px;">
                        <div class="col-sm-12">
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <span style="color:#6b6b6b">Administrator CMS /</span> <span style="color:#3c8dbc">Dashboard</span>
                                </div>
                            </div>
                        </div>

                <div class="row">
                <div class="content">

                         <div class="content">
                    
                    <?php
                        //dash board php begining select number of users,student,classes,staffs
                        
                        //select number of users
                        $query_select1 = mysqli_query($conn,"select * from `school_details`");
                        $number_of_users = mysqli_num_rows($query_select1);
            
                     //select number of students
                    $query_select2 = mysqli_query($conn,"select * from `main admins`  where `REGISTRATION STAGE` !='done'");
                    $number_of_students = mysqli_num_rows($query_select2);
                    
                    //select number of classes
                    $query_select3 = mysqli_query($conn,"select * from `main admins`  where `REGISTRATION STAGE` ='done'");
                    $number_of_classes = mysqli_num_rows($query_select3);
                    
                    //select number of classes
                    $date = date('Y-m-d');
                    $expired = mysqli_query($conn,"select * from `school_entered_vouchers`  where `EXPIRY DATE` < '$date'");
                    $ex = mysqli_num_rows($expired);
            
                    
                    ?>
                
                    
                    <div class="col-xs-12 col-sm-6 col-md-6">
                      <!-- small box -->
                      <div class="small-box bg-aqua">
                        <div class="inner">
                          <h3><?php echo number_format($number_of_users)?></h3>

                          <p style="color:white">TOTAL SCHOOLS</p>
                        </div>
                        <div class="icon">
                          
                        </div>
                        
                      </div>
                    </div>

                  <div class="col-xs-12 col-sm-6 col-md-6">
                      <!-- small box -->
                      <div class="small-box bg-green">
                        <div class="inner">
                          <h3><?php echo number_format($number_of_students)?></h3>

                          <p style="color:white">UNACTIVATED ACCOUNTS</p>
                        </div>
                        <div class="icon">
                          
                        </div>
                        
                      </div>
                             </div>
                    
                    
                    <div class="col-xs-12 col-sm-6 col-md-6">
                      <!-- small box -->
                      <div class="small-box bg-yellow">
                        <div class="inner">
                          <h3><?php echo number_format($number_of_classes)?></h3>

                          <p style="color:white">ACTIVATED ACCOUNTS</p>
                        </div>
                        <div class="icon">
                          
                        </div>
                       
                      </div>
                    </div>
                    
                     <a href="../includes/auto_send_expiry_info.php" target="_blank" ><div class="col-xs-12 col-sm-6 col-md-6" data-toggle="tooltip" data-placement="top" title="Click to send messages">
                      <!-- small box -->
                      <div class="small-box bg-red">
                        <div class="inner">
                          <h3><?php echo number_format($ex)?></h3>

                          <p style="color:white">EXPIRED ACCOUNTS</p>
                        </div>
                        <div class="icon">
                          
                        </div>
                        
                      </div>
                         </div></a>
                    
                        </div>
                    </div>
                    
                   
                </div> 
                            <div class="content">
                            
                         <!-- LINE CHART -->
                          <div class="box box-info">
                            <div class="box-header with-border">
                                
                              <h3 class="box-title" id="box_title">Visitors :  <?php echo date('M-Y');?></h3>
                                <div class="pull-right box-tools ">
                            <?php
                                    $cmonth = date('m');
                                     $cyear = date('Y');
                                    echo'
                                    <div class="popup">
                                        <input type="text" value="'.$cyear.'" style="border:none; outline:none; padding-left:20px; width:115px;" id="c_year"/>
                                    <button class="btn btn-default" onclick="decrease_year()"><i class="fa fa-angle-left" ></i></button><button class="btn btn-default" onclick="increase_year()" ><i class="fa fa-angle-right" ></i></button>
                                    <ul id="calendar">
                                        <li onclick="set_date(1)" id="1">JAN</li>
                                        <li onclick="set_date(2)" id="2">FAB</li>
                                        <li onclick="set_date(3)" id="3">MAR</li>
                                        <li onclick="set_date(4)" id="4">APR</li>
                                        <li onclick="set_date(5)" id="5">MAY</li>
                                        <li onclick="set_date(6)" id="6">JUN</li>
                                        <li onclick="set_date(7)" id="7">JUL</li>
                                        <li onclick="set_date(8)" id="8">AUG</li>
                                        <li onclick="set_date(9)" id="9">SEP</li>
                                        <li onclick="set_date(10)" id="10">OCT</li>
                                        <li onclick="set_date(11)" id="11">NOV</li>
                                        <li onclick="set_date(12)" id="12">DEC</li>
                                    </ul>
                                    </div>';
                            ?>
                            <button class="btn btn-default" onclick="show_popover()" data-toggle="tooltip" data-placement="top" title="View Calendar"><i class="fa fa-calendar" ></i></button>
                                </div>
                            </div>
                            <div class="box-body chart-responsive" >
                              <div class="chart" id="line-chart" style="height: 300px;">
                              <p id="loader"><center><i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> loading chart...</center></p>
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="row" style="text-align:center">
                                    <div class="col-sm-4 col-xs-6 col-sm-offset-4 col-xs-offset-3">
                                      <div class="description-block border-right border-left">
                                        <?php
                                                
                                                $date= $cyear.'-'.$cmonth.'-';
                                                $query = mysqli_query($conn,"SELECT * FROM `visitors` WHERE `DATE` LIKE '".$date."%' ");
                                                $num_rows = mysqli_num_rows($query);
                                                echo '<span class="description-percentage text-green"><i class="fa fa-caret-up"></i>'.sprintf('%0.2f',(($num_rows/1000)*100)).'%</span>
                                        <h5 class="description-header">'.number_format($num_rows).'</h5>
                                        <span class="description-text">TOTAL</span>
                                        <input type="hidden" value='.$date.' id="date"/>' 
                                        ;
                                            
                                        ?>
                                        
                                      </div>
                                      <!-- /.description-block -->
                                    </div>
                                     </div>  
                            </div>
                            <!-- /.box-body -->
                          </div>
                          <!-- /.box -->         
                   
                            </div>
                <div class="content">
                     <!-- /.box-header -->
             <div class="box box-primary">
                <div class="box-header with-border">
                                                 
                      <div class="box-title">
                          All SCHOOLS
                      </div>
                      <div class="panel-body" style="overflow-x:auto">
                          <table id="example" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>#</th>
                          <th>School Name</th>
                          <th>Initails</th>

                        </tr>
                        </thead>
                        <tbody id="result_box">
                            
                            <?php $counter = 0;
    $query = mysqli_query($conn,"select * from `school_details` order by `SCHOOL NAME` asc");
    
    if(mysqli_num_rows($query) == null){
        echo 'No class found.';
    }
    while($fetch = mysqli_fetch_assoc($query)){
        $style = '';
        
        $school = htmlentities($fetch['SCHOOL NAME']);
        $initials = htmlentities($fetch['INITIALS']);
        
        //pick expired accounts
        $todays_date = date('Y-m-d');
        
        $query_pick = mysqli_query($conn,"select * from  `school_entered_vouchers` where `EXPIRY DATE` < '$todays_date' and `SCHOOL`='$initials'");
        if(mysqli_num_rows($query_pick)){
            $style  = 'style="background-color:red; color:white" data-toggle="tooltip" data-placement="top" title="Expired Account"';
        }
        $counter ++;
        $id = $fetch['NO'];
        echo '<tr '.$style.'>
              <td>'.$counter.'</td>
              <td>'.htmlentities($school).'
              </td>
              <td>
                '.$initials.'
              </td>
            </tr>';
    }?>
                        </tbody>
                        <tfoot>
                        <tr>
                           <th>#</th>
                          <th>School name</th>
                          <th>Initials</th>
                        </tr>
                        </tfoot>
                      </table>
                      </div>
                </div>
            </div>
                </div>
                <div class="footer">
                                <p>Copyright &copy; <a href="#">Easyskul</a>. All rights reserved.</p>
                            </div> 
                </div>
             
            </div>
                </div></div></div>





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
        <!-- Morris.js charts -->
        <script src="../js/raphael-min.js"></script>
        <script src="morris/morris.min.js"></script>
         <script type="text/javascript">
             
             $(document).ready(function () {
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                 });
                 
             });
            
            $(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });

             $(function () {
                "use strict";
                 var date=$('#date').val();
                 get_chart(date);
                    
                $("[data-toggle='popover']").popover();
                 
                
             })
             
             
             function get_chart(date){
                 //console.log(date);
                 new_date = date.indexOf('-');
                 day = date.slice(new_date+1,new_date+3);
                 day = parseInt(day);
                 $('#calendar li').removeClass();
                  $('.description-block').html("");
                 $('#'+day).toggleClass('active');
                 $.post("../includes/get_visitors.php", {date:date},
                    function (data) {
                        // LINE CHART
                        $('#loader').css('display','none');
                       // console.log(data);
                       data = JSON.parse(data);
                        var line = new Morris.Line({
                          element: 'line-chart',
                          resize: true,
                         data:[
                            {
                                "date":"2019",
                                "visitors":90
                            }
                         ],
                          xkey: 'date',
                          ykeys: ['visitors','Login users'],
                          labels: ['Visitors ','Login users'],
                          lineColors: ['#ff5252','#3c8dbc'],
                          hideHover: 'auto'
                            
                        });

                     line.setData(data);
                     get_total(date)
                    })
             }
             
             function increase_year(){
                  var current_year = parseInt($('#c_year').val())+1;
                  $('#c_year').val(current_year);
                  var months = document.getElementsByClassName('active');
                  var month = months[1].id;
                  var text_date = $('#'+month).html()+"-"+current_year;
                     if(month < 10){
                         month = "0"+month;
                     }
                 date = current_year+'-'+month+'-';
                 console.log(date);
                  $('.chart').html('<p id="loader"><center><i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> loading chart...</center></p>');
                 
                 
                  get_chart(date);
                  
                  $('#box_title').html('Visitors : '+text_date);
             }
             function decrease_year(){
                  var current_year = parseInt($('#c_year').val())-1;
                  $('#c_year').val(current_year);
                  var months = document.getElementsByClassName('active');
                  var month = months[1].id;
                   var text_date = $('#'+month).html()+"-"+current_year;
                  $('.chart').html('<p id="loader"><center><i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> loading chart...</center></p>');
                 if(month < 10){
                         month = "0"+month;
                     }
                 date = current_year+'-'+month+'-';
                  get_chart(date);
                 $('#box_title').html('Visitors : '+text_date);
             }
             
             function set_date(month){
                  var year =$('#c_year').val();
                  var text_date = $('#'+month).html()+"-"+year;
                
                 if(month < 10){
                     month = "0"+month;
                 }
                  date = year+'-'+month+'-';
                  $('.chart').html('<p id="loader"><center><i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> loading chart...</center></p>');
                  get_chart(date);
                 $('#box_title').html('Visitors : '+text_date)
                 
                  $('.popup').css('display','none');
                 $('.popup').css('opacity','0');
                 
                 
             }
            
             function show_popover(){
                 console.log('hello');
                  $('.popup').css('display','block');
                 $('.popup').css('opacity','1');
             }
             
             
             function get_total(date){
                 $('.description-block').html('<p id="loader"><center><i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Calculating total...</center></p>');
                  $.post("../includes/get_total_visitors.php", {date:date},
                    function (data) {
                      $('.description-block').html(data);
                  })
             }
         </script>
    </body>
</html>
