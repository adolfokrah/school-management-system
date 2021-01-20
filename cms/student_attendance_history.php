<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Easyskul - CMS::Attendanc History</title>
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
            $users = array("Parent","Student");
            include '../includes/cms_sidebar.php';
        ?>

            <!-- Page Content Holder -->
            <div id="content">
<?php include '../includes/cms_header.php';
                    include '../includes/redirect_admin.php';
                ?>                       
                <div id="box">
                  
                    <div class="content" style="padding:20px; padding-top:0px;">
                        
                        
                            
                        <div class="content">
                      
                            <div class="content">
                                <div class="col-sm-12">
                                <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <?php  $academic_year = '';
        $term = '';
        $query_pick = mysqli_query($conn,"select * from academic_years where `SCHOOL`='$initials' and `STATUS`='ACTIVE'");
        if($fetch_row = mysqli_fetch_assoc($query_pick)){
            $academic_year = $fetch_row['ACADEMIC YEAR'];
            $term = $fetch_row['TERM'];
        }
                                    ?>
                                    <span style="color:#6b6b6b">CMS / Attendance /</span> <span style="color:#3c8dbc"> Attendance History / Student ID - <?php echo $p_student_id;?> - Academic year: <?php echo $academic_year?> - Term: <?php echo $term;?> </span>
                                </div>
                            </div>
                        
                            </div>
                        </div>
                            </div>
                        </div>
                        <div class="content">
                        <div class="col-sm-12" style="padding-top:20px;">
                            <div class="panel-group">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        List Of Student
                                    </div>
                                    <div class="panel-body" style="overflow-x:auto">
                                        
                                       <table id="example4" class="table table-bordered table-striped">
                                           
                                                                    <?php $counter = 0;
   
                                           
    $query1 = mysqli_query($conn,"select * from attendance where `SCHOOL`='$initials'  and `STUDENT ID` ='$p_student_id' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term' order by `DATE` asc");
    
    
    $counter = 0;
    $checked = '';
    $output = '';                       
    $all_checked = 'checked';
    $style = '';
    if(mysqli_num_rows($query1) < 1){
        $all_checked = '';
    }
    while($fetch1 = mysqli_fetch_assoc($query1)){
        $student_id = htmlentities($fetch1['STUDENT ID']);
        $student_name = htmlentities($fetch1['STUDENT NAME']);
        $status = $fetch1['STATUS'];
        $date = $fetch1['DATE'];
        //check rows
        
        if($status == 'PRESENT'){
            $checked = 'checked';
            $style = 'style="background-color:#2e89ab;color:#fff;"';
            if($all_checked != ''){
                $all_checked = 'checked';
            }
        }else{
            $all_checked = '';
            $checked = '';
            $style = '';
        }
        
        $counter ++;
        $id = $fetch1['ID'];
        $output .= '<tr id="row'.$student_id.'" '.$style.'>
              <td>'.$date.'</td>
              <td>'.$counter.'</td>
              <td>'.$student_id.'</td>
              
              <td>'.$student_name.'</td>
              <td>'.$status.'</td>
              
                   
              

            </tr>';
    }?>
                        <thead>
                        <tr>
                          <th>
                              DATE
                          </th>
                           <th>#</th>
                          <th>STUDENT ID</th>
                          
                          <th>STUDENT NAME</th>
                          <th>STATUS</th>
                          
                        </tr>
                        </thead>
                        <tbody id="result_box">
                            
                        <?php echo $output; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                           <th>DATE</th>
                           <th>#</th>
                          <th>STUDENT ID</th>
                         
                          <th>STUDENT NAME</th>
                          <th>STATUS</th>
                          
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
