

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Easyskul - CMS::Add Notice</title>
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
    <body style="background-color:white;">



        <div class="wrapper">
            <!-- Sidebar Holder -->
           <?php 
            
 include '../includes/school_ini_user_id.php';
            ?>

            <!-- Page Content Holder -->
            <div id="content">
           <table id="example4" class="table table-hover table-striped">
            <thead>
            <tr>
               <th>#</th>
              <th>STUDENT ID</th>
              <th>STUDENT NAME</th>
              <th>CLASS</th>
              <th>DROPPING AT</th>
              <th>GUARDIAN NUMBER</th>
              <th>STATUS</th>


            </tr>
            </thead>
            <tbody id="result_box">
                 <?php 
                    if(isset($_GET['bus_number'])&&isset($_GET['from'])&&isset($_GET['location'])){
                        $bus_number = $_GET['bus_number'];
                        $date = $_GET['from'];
                        $query = mysqli_query($conn,"select * from daily_bus_fee where `BUS`='$bus_number' and `DATE`='$date' and `SCHOOL`='$initials' order by `STUDENT NAME` asc");
                        $counter = 0;
                        $location_rows = 0;
                        while($fetch = mysqli_fetch_assoc($query)){
                            $counter++;
                            $student_id = $fetch['STUDENT ID'];
                            $student_name = $fetch['STUDENT NAME'];
                            $student_class = $fetch['CLASS'];
                            $location = $fetch['LOCATION'];
                            $style='';
                            $title = '';
                            $guardian_tel= '';
                            
                            $query_pick  = mysqli_query($conn,"select * from admitted_students where `ADMISSION NO / ID`='$student_id'");
                            if($fetch_number = mysqli_fetch_assoc($query_pick)){
                                $guardian_tel = $fetch_number['GUARDIAN TEL'];
                            }
                            if($fetch['DROPED'] == $_GET['location'] && $fetch['LOCATION']==$fetch['DROPED']){
                                $style = 'class="success" style="cursor:pointer;"';
                                $status = 'DROPPED';
                                $title = 'Dropped at right location';
                            }else if($fetch['DROPED'] == $_GET['location'] && $fetch['LOCATION']!=$fetch['DROPED']){
                                $style = 'class="danger" style="cursor:pointer;"';
                                $status = 'DROPPED';
                                $title = 'Dropped at wrong location, supposed to drop at '.$fetch['LOCATION'];
                            }else{
                                $status = 'LEFT';
                                $title = 'Not drop yet, dropping at '.$fetch['LOCATION'];
                            }
                            
                            $query_pick_loc = mysqli_query($conn,"select * from `bus_tracking` where `SCHOOL`='$initials' and `LOCATION`='".$_GET['location']."' and `BUS NUMBER`='$bus_number' and `DATE`='$date'");
                            if($fetch_location = mysqli_fetch_assoc($query_pick_loc)){
                                $location_rows = $fetch_location['ID'];
                            }
                            
                            $query_pick_loc2 = mysqli_query($conn,"select * from `bus_tracking` where `SCHOOL`='$initials' and `BUS NUMBER`='$bus_number' and `LOCATION`='".$fetch['DROPED']."' and `DATE`='$date'");
                            while($fetch_location = mysqli_fetch_assoc($query_pick_loc2)){
                               
                                
                                
                                if($fetch_location['ID'] < $location_rows && $fetch['DROPED'] != ''){
                                    
                                }else{
                                     echo '<tr '.$style.' data-toggle="tooltip" data-placement="top" title="'.$title.'">
                                        <td>'.$counter.'</td>
                                        <td>'.$student_id.'</td>
                                        <td>'.$student_name.'</td>
                                        <td>'.$student_class.'</td>
                                        <td>'.$location.'</td>
                                        <td>'.$guardian_tel.'</td>
                                        <td>'.$status.'</td>
                                        </tr>';
                                }
                                
                                 
                            }
                            if(mysqli_num_rows($query_pick_loc2)==null){
                                 $title = 'Didn\'t drop at destination';
                                 echo '<tr '.$style.' data-toggle="tooltip" data-placement="top" title="'.$title.'">
                                        <td>'.$counter.'</td>
                                        <td>'.$student_id.'</td>
                                        <td>'.$student_name.'</td>
                                        <td>'.$student_class.'</td>
                                        <td>'.$location.'</td>
                                        <td>'.$guardian_tel.'</td>
                                        <td>'.$status.'</td>
                                        </tr>';
                            }
                          
                        }
                    }
                ?>   
            </tbody>

            </table>
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
             
             
            
            $(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });
            
         </script>
        
    </body>
</html>
