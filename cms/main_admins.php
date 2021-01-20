<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Easyskul - CMS::Main admins</title>
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
        <script src="../js/jQuery-v2.1.3.js"></script>
        
        <script src="fullcalendar/moment.min.js"></script>
        <script src="fullcalendar/fullcalendar.min.js"></script>
        <script src="sweetalert2-master/dist/sweetalert2.all.min.js"></script>
        <script src="../js/cms.js"></script>
    </head>
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
                                    <span style="color:#6b6b6b">Administrator CMS /</span> <span style="color:#3c8dbc">Main admins</span>
                                </div>
                            </div>
                        </div>

                             <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-envelope-o"></i> Send a Message
              </h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
              </div>
              <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
              <form>
                
                <textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" id="message"></textarea>
                  <br/><br/>
               
                <br/><br/>
                  <button type="button" class="btn btn-primary pull-right" id="send_sms_btn" onclick="send_sms_easyskul()">Send</button>
              </form>
            </div>
          </div>
                <div class="row">
               
                            
                <div class="content">
                     <!-- /.box-header -->
             <div class="panel-group">
                <div class="panel panel-primary">
                                                 
                      <div class="panel-heading">
                          All SCHOOLS
                      </div>
                      <div class="panel-body" style="overflow-x:auto">
                          <table id="example" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>
                              <form class="form">
                                  <label>
                                      <input type="checkbox" id="check_all">
                                      All <i class="fa fa-check"></i>
                                  </label>
                              </form>
                          </th>
                          <th>#</th>
                           <th>School INI</th>
                          <th>Admin name</th>
                          <th>Email</th>
                          <th>Contact</th>
                          <th>Registration Stage</th>
                          <th></th>

                        </tr>
                        </thead>
                        <tbody id="result_box">
                            
                            <?php $counter = 0;
    $query = mysqli_query($conn,"select * from `main admins` order by `ADMIN NAME` asc");
    
    if(mysqli_num_rows($query) == null){
        echo 'No class found.';
    }
    while($fetch = mysqli_fetch_assoc($query)){
        
        $name = htmlentities($fetch['ADMIN NAME']);
        $email = htmlentities($fetch['ADMIN EMAIL']);
        $contact = htmlentities($fetch['ADMIN NUMBER']);
        $stage = htmlentities($fetch['REGISTRATION STAGE']);
        $user = $fetch['ADMIN ID'];
        //pick school details
        $str_pos = strpos($user,'-');
        $initials = substr($user,0,$str_pos);
        $counter ++;
        $id = $fetch['NO'];
        echo '<tr id="row'.$id.'">
        <td><label>
                  <input type="checkbox" id="row_check" name="'.$id.'" class="checkboxes">  <i class="fa fa-check"></i>
              </label> </td>
              <td>'.$counter.'</td>
               <td>'.htmlentities($initials).'
              </td>
              <td id="name'.$id.'">'.htmlentities($name).'</td>
             
              <td>
                '.$email.'
              </td>
               <td id="contact'.$id.'">'.htmlentities($contact).'</td>
              <td>
                '.$stage.'
              </td>
               <td>
               <button class="btn btn-danger" onclick="delete_school(\''.$email.'\')"><i class="fa fa-trash"></i></button>
              </td>
            </tr>';
    }?>
                        </tbody>
                        <tfoot>
                        <tr>
                           <th></th>
                           <th>#</th>
                           <th>School INI</th>
                          <th>Admin name</th>
                          <th>Email</th>
                          <th>Contact</th>
                          <th>Registration Stage</th>
                          <th></th>
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
             $(document).ready(function () {
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                 });
             });
            
            $(function(){
                $('[data-toggle="tooltip"]').tooltip();
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
