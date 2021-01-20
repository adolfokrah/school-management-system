<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Easyskul - CMS::PAYMET INVOICE</title>
        <link href="../web_images/logo2.png" rel="icon"/>
         <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="../css/font-awesome.css">
        <link rel="stylesheet" href="../bootstrap-3.3.7-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../css/sidebar.css">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="../css/cms_style.css">
        <!--add the tables css-->
        <link rel="stylesheet" href="bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="../bootstrap-3.3.7-dist/css/boostrap-select.min.css">
        
        <link rel="stylesheet" href="fullcalendar/fullcalendar.min.css"/>
        <link rel="stylesheet" href="fullcalendar/fullcalendar.print.css" media="print"/>
        <script src="../js/jQuery-v2.1.3.js"></script>
        
        <script src="fullcalendar/moment.min.js"></script>
        <script src="fullcalendar/fullcalendar.min.js"></script>
        <script src="sweetalert2-master/dist/sweetalert2.all.min.js"></script>
        <script src="../js/cms.js"></script>
        <script  src="../js/bootstrap-select.min.js"></script>
    </head>
    
    

<script>

    
    

</script>

<style>

#calendar {
max-width: 900px;
margin: 0 auto;
}

   
</style>
    <body>

<?php 
        

 include '../includes/school_ini_user_id.php';
        $email = '';
        if(isset($_SESSION['email']) && !empty($_SESSION['email']) || isset($_SESSION['USER ID']) && !empty($_SESSION['USER ID'])){
        $email = $_SESSION['email'];
    }elseif(isset($_GET['user']) && !empty($_GET['user'])){
            $user = $_GET['user'];   
}else{
    die('PLEASE LOGIN BEFORE YOU CAN PURCHASE VOUCHER CLICK <a href="../index.php" style="color:blue">HERE</a>');
}
 $date = date('Y-m-d');
 $operation = '';      
        
        
         //pick user details
                $username = '';
                $usernumber = '';
                $useremail = '';
                $school = '';
                $location = '';
                $school_num = '';
                $query = mysqli_query($conn,"select * from `main admins` where `ADMIN ID`='$user'");
                if($fetch  = mysqli_fetch_assoc($query)){
                    $username = $fetch['ADMIN NAME'];
                    $usernumber = $fetch['ADMIN NUMBER'];
                    $useremail = $fetch['ADMIN EMAIL'];
                    
                    $query2 = mysqli_query($conn,"select * from `school_details` where `ADMIN EMAIL`='$useremail'");
                    if($fetch = mysqli_fetch_assoc($query2)){
                        $initials = $fetch['INITIALS'];
                    }
                    
                }else{
                    $query = mysqli_query($conn,"select * from `users` where `USER ID`='$user'");
                    if($fetch  = mysqli_fetch_assoc($query)){
                        $username = $fetch['USER NAME'];
                        $usernumber = $fetch['CONTACT'];
                        $useremail = $fetch['EMAIL'];
                        $initials = $fetch['SCHOOL'];
                    }
                }
            
                //PICK SCHOOL NAME
                $query_name = mysqli_query($conn,"select * from `school_details` where `INITIALS`='$initials'");
                if($fetch = mysqli_fetch_assoc($query_name)){
                    $school = $fetch['SCHOOL NAME'];
                    $location = $fetch['CITY/TOWN'];
                    $school_num=$fetch['SCHOOL ADDRESS'];
                }
       

 if(isset($_GET['qty'])&&!empty($_GET['qty'])&&isset($_GET['amount'])&&!empty($_GET['amount'])&&isset($_GET['unit_price'])&&!empty($_GET['unit_price'])){
     $qty = $_GET['qty'];
     $amount = $_GET['amount'];
     $unit_price = $_GET['unit_price'];
     $year = date('Y');
     $in_number = invoice_number($year,$conn);
     $operation = 'SMS';
     
       
     
     $query3 = mysqli_query($conn,"INSERT INTO `payment_invoices` (`ID`, `SCHOOL`, `USER ID`,`USER NAME` ,`EMAIL`,`NUMBER`, `INVOICE NUMBER`, `DATE`, `OPERATION`, `UNIT PRICE`, `QUANTITY`, `STATUS`) VALUES (NULL, '$initials', '$user','$username','$useremail','$usernumber', '$in_number', '$date', 'SMS CREDIT', '$unit_price', '$qty','');");
     
 }else if(isset($_GET['voucher'])){
     $qty = '1';
     $amount = '200';
     $unit_price = '200';
     $year = date('Y');
     $in_number = invoice_number($year,$conn);
     $operation = 'VOUCHER';
     mysqli_query($conn,"INSERT INTO `payment_invoices` (`ID`, `SCHOOL`, `USER ID`,`USER NAME` ,`EMAIL`,`NUMBER`,`INVOICE NUMBER`, `DATE`, `OPERATION`, `UNIT PRICE`, `QUANTITY`, `STATUS`) VALUES (NULL, '$initials', '$user','$username','$useremail','$usernumber', '$in_number', '$date', 'VOUCHER', '$unit_price', '$qty','');");
 }

function invoice_number($year,$conn){



        $select_student_number = mysqli_query($conn,"select * from `payment_invoices`");
        $number_rows = mysqli_num_rows($select_student_number);
        $number_rows ++;
        $number_rows = str_pad($number_rows,9,"0",STR_PAD_LEFT);

        $student_id = "ES-"."IN"."_".$year."".$number_rows."I";
        
        return $student_id;

    }
        
    //pick invoice
    $id = '';
    $query = '';
    if(isset($_GET['id']) && !empty($_GET['id'])){
        $id = $_GET['id'];
        $qurery_pick = mysqli_query($conn,"select * from payment_invoices where `ID`='$id'");
    }else{
        $qurery_pick = mysqli_query($conn,"select * from payment_invoices where `USER ID`='$user' and `STATUS`='' order by ID desc");
    }
    
    $btn='';
    $style= '';
    $rows = '';
    $invoice_number='';
    $unit_price = 0;
    $quantity = 0;
    $title = '';
    $moblile_number = '';
    $info = '';
    $print = '';
    $user_id='';
    if($fetch = mysqli_fetch_assoc($qurery_pick)){
        $invoice_number = $fetch['INVOICE NUMBER'];
        $unit_price = $fetch['UNIT PRICE'];
        $quantity = $fetch['QUANTITY'];
        $date = $fetch['DATE'];
        $status = $fetch['STATUS'];
        $operation = $fetch['OPERATION'];
        $id = $fetch['ID'];
        $moblile_number = $fetch['MOBILE MONEY NUMBER'];
        $useremail = $fetch['EMAIL'];
        $username = $fetch['USER NAME'];
        $usernumber  = $fetch['NUMBER'];
        $user_id = $fetch['USER ID'];
        $info = '';
        $print = '';
        if($status == ""){
             $btn='<button type="button" class="btn btn-warning" onclick="submit_invoice(\''.$operation.'\',\''.$invoice_number.'\',\''.$id.'\',\''.$user.'\');" id="invoice_btn"><i class="fa fa-visacard" ></i> Submit Invoice</button>';
            $title = "Please input the mobile number here.";
            $info = '<p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
          Send money to this number: <strong>MTN - 0245301631</strong>
          Please provide the number you sent the money from in to  the text box above, after press on the submit invoice button.<br/><strong style="color:red;">NOTE: Please make sure you send the money before you submit the invoice</strong>
        </p>';
            $print= '';
        }else if($status == "SUBMITTED"){
             $btn ='';
            $style = 'readonly';
            $title = "Submitted";
            $info = '<p class="text-muted well well-sm no-shadow" style="margin-top: 10px; color:white; background-color:green">
            INVOICE SUBMITTED
        </p>';
            $print  = '<button type="button" class="btn btn-danger" onclick="window.print()"><i class="fa fa-print"></i> Print</button>';
        }else{
             $btn ='';
            $style = 'readonly';
            $title = "Submitted";
            $info = '<p class="text-muted well well-sm no-shadow" style="margin-top: 10px; color:white; background-color:orange">
            INVOICE ACCEPTED
        </p>';
            $print  = '<button type="button" class="btn btn-danger" onclick="window.print()"><i class="fa fa-print"></i> Print</button>';
        }
        $rows = '<td>1</td>
            <td>'.$fetch['OPERATION'].'</td>
            <td>'.sprintf('%0.2f',$fetch['UNIT PRICE']).'</td>
            <td>'.$fetch['QUANTITY'].'</td>
            <td>'.sprintf('%0.2f',($fetch['QUANTITY'] * $fetch['UNIT PRICE'])).'</td>';
    }
?>

        <div class="wrapper"   style="width:900px; margin:auto;" id="box" >
           
            <div class="content" style="width:900px; margin:auto;" >
                <div>
                    <section class="invoice" style="width:900px; margin:auto;">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <p class="page-header">
          <img src="tcpdf/examples/images/receipt_logo.png" width="200px;"/>
          <small class="pull-right">Date: <?php echo $date;?></small>
        </p>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div  style="width:300px; float:left;">
        From
        <address>
          <strong>easyskul.com</strong><br>
          Accra-Ghana<br>
          Phone: (+233) 024 530 1631 <br>
          Email: info@easyskul.com
        </address>
      </div>
      <!-- /.col -->
      <div  style="width:300px; float:left;">
        To
        <address>
          <?php 
              
            echo '
          <strong>'.$username.'</strong><br>
          '.$useremail.'<br>
          '.$usernumber.'<br>
          <strong>'.$user_id.'</strong>
        ';
            ?>
            
        </address>
      </div>
      <!-- /.col -->
      <div  style="width:300px; float:left;">
        <b>Invoice #<?php echo $invoice_number;?></b><br>
        <br>
          <b><?php echo $school.' - '.$initials;?></b><br/>
          <?php echo $location;?><br/>
          <?php echo $school_num?>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>#</th>
            <th>Operation</th>
            <th>Unit Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <?php echo $rows;?>
          </tr>
          
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-6">
        <p class="lead">Payment Methods:</p>
        <img src="../web_images/mobile_money.png" alt="Mobile money">
        <br/><br/>
        <form>
            <div class="form-group">
                <label>Your Mobile money number  here:</label>
                <input class="form-control" type="tel" placeholder="Your mobile money number here" id="mobile_number" <?php echo $style ?> data-toggle="tooltip" data-placement="top" title="<?php echo $title; ?>" style="outline:green thin solid" value="<?php echo $moblile_number; ?>"/>
            </div>
        </form>
        <?php echo $info; ?>
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
        <p class="lead">Amount Due </p>

        <div class="table-responsive">
          <table class="table table-striped">
            <tr>
              <th style="width:50%">Subtotal:</th>
              <td><?php echo sprintf('%0.2f',$quantity*$unit_price)?></td>
            </tr>
            <tr>
              <th>Discount (0%)</th>
              <td>GHS 0.00</td>
            </tr>
            
            <tr>
              <th>Total:</th>
              <td><?php echo sprintf('%0.2f',$quantity*$unit_price)?></td>
            </tr>
          </table>
            
            <div class="pull-right">
                <?php echo $print ?>
            <?php echo $btn; ?>
            </div>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  
                </div>
            </div>
        
<!--modl boxes-->
         <div class="modal fade" id="event_box">
             <div class="modal-dialog" style="z-index:5000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                         <h2 class="modal-title">Add New Event</h2>
                     </div>
                     <div class="modal-body">
                         <form class="form">
                             
                                
                             <div class="form-group"> 
                                 <input type="text" class="form-control" id="event_name" placeholder="Event Name"/>
                             </div>
                             <div class="form-group">
                                <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%">
                                    <input class="form-control"  type="text" value="" readonly placeholder="Starts From" style="background-color:white;" id="start"  name="attendance_date" required>
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                </div>
                                <input type="hidden"  value="" />
                            </div>
                             <div class="form-group">
                                <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%">
                                    <input class="form-control"  type="text" value="" readonly placeholder="Ends" style="background-color:white;" id="ends"  name="" required>
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                </div>
                                <input type="hidden"  value="" />
                            </div>
                             <div class="form-group">
                                 <label id="">Choose Color</label><br/>
                                 <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width:100%;" id="event_color">
                                    <option value="#f56954" style="color:#f56954">Red</option>
                                    <option value="#f39c12" style="color:#f39c12">Yellow</option>
                                    <option value="#00a65a" style="color:#00a65a">Green</option>
                                    <option value="#00c0ef" style="color:#00c0ef">Blue</option>
                                  </select>
                             </div>
                             <div class="form-group">
                                 
                                 <button class="btn btn-primary" type="button" onclick="add_event();" id="add_event_btn">Add Event</button>
                                 <a href="academic_calendar.php"><button class="btn btn-success"  data-toggle="tooltip" data-placement="top" title="Click here to see added events" type="button"><i class="fa fa-thumbs-up"></i> Done</button></a>
                             </div>
                         </form>
                     </div>
                       
                 </div>
             </div>
         </div>
        
        
        <div class="modal fade" id="edit_subject">
             <div class="modal-dialog" style="z-index:5000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                         <h2 class="modal-title">Edit Subject</h2>
                     </div>
                     <div class="modal-body">
                         <form class="form" id="edit_form">
                              <form class="form">
                             
                                 <div class="panel-group">
                                  <div class="panel panel-default">

                                      <div class="panel-heading">
                                        <?php echo 'You are about to edit a subject at <strong>'.$class.'</strong>';?>
                                      </div>
                                  </div>
                            </div>
                             
                             <div class="form-group">
                                 <label>Subject Name</label>
                                 <input type="text" class="form-control" id="edit_subject_name"/>
                             </div>
                             <div class="form-group">
                                 <label>Assign Teacher</label><br/>
                                 <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width:100%;" id="edit_sub_teacher">
                                    <?php
                                            $qeuery_pick_classes = mysqli_query($conn,"select * from teachers where `SCHOOL`='$initials' order by ID asc");
                                            while($fetch = mysqli_fetch_assoc($qeuery_pick_classes)){
                                                echo '<option value="'.htmlentities($fetch['FIRST NAME']).' '.htmlentities($fetch['LAST NAME']).'" >'.htmlentities($fetch['FIRST NAME']).' '.htmlentities($fetch['LAST NAME']).'</option>';
                                            }
                                       ?>

                                  </select>
                             </div>
                                
                             <div class="form-group">
                                 
                                 <button class="btn btn-primary" type="button" onclick="edit_subject_action('<?php echo $class;?>');" id="edit_subject_btn" name="">Edit Subject</button>
                                 <a href="manage_subject.php?class=<?php echo $class?>"><button class="btn btn-danger"  data-toggle="tooltip" data-placement="top" title="Click here to see changes" type="button">Done</button></a>
                             </div>
                         </form>
                         </form>
                     </div>
                       
                 </div>
             </div>
         </div>
        
        
        <!-- jQuery CDN -->
         
         <!-- Bootstrap Js CDN -->
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
                 
                 $('.list-unstyled li:nth-child(17) ul').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(17) a').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(17) ul').toggleClass('collapse in');
                 $('.list-unstyled li:nth-child(17) a').toggleClass('');
                 $('.list-unstyled li:nth-child(17) ul li:nth-child(1)').toggleClass('active');
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
                  var event = {id:i,
                               title:event_name[i].innerHTML,
                               start:event_date[i].innerHTML,
                               end:event_date[i].id,
                               backgroundColor: event_name[i].id,
                               borderColor: event_name[i].id
                              };
                  $('#calendar').fullCalendar('renderEvent',event,true);
                }
                  
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
