<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Easyskul - CMS::Pay Fees</title>
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
    
    <style>
* {
  box-sizing: border-box;
}

.autocomplete {
  /*the container must be positioned relative:*/
  position: relative;
  display: inline-block;
  text-align: left;
}
input {
  border: 1px solid transparent;
  background-color: white;
  padding: 10px;
  font-size: 16px;
}
input[type=text] {
  background-color: #fff;
  width: 100%;
  border:thin solid #ccc;
  
}
input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
  cursor: pointer;
}
.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}
.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}
.autocomplete-items div:hover {
  /*when hovering an item:*/
  background-color: #e9e9e9; 
}
.autocomplete-active {
  /*when navigating through the items using the arrow keys:*/
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}
        #pay{
            margin-left: 5px;
        }
        .loader{
            border-left:medium solid white;
            border-bottom:medium solid transparent;
            border-top:medium solid transparent;
            border-right:medium solid transparent;
            border-radius: 100%;
            height: 20px;
            width: 20px;
            float: left;
            margin-right: 5px;
            display: none;
            -webkit-animation: rotation 0.3s infinite linear;
        }
        
        @-webkit-keyframes rotation {
            from {
                    -webkit-transform: rotate(0deg);
            }
            to {
                    -webkit-transform: rotate(359deg);
            }
        }
        #msg_box{
            margin: 5px;
        }
        #iframe {
            width: 100%;
            border: none;
            height: 800px;
        }
</style>
    <body>



        <div class="wrapper">
            <!-- Sidebar Holder -->
            <?php 
            $users = array("Administrator","Accountant");
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
                        
                        <div class="col-xs-12">
                            
                            <form autocomplete="off" action="/action_page.php">
                                      <div class="autocomplete" style="width:100%;">
                                        <input id="myInput" type="text" name="myCountry" placeholder="Search Student by ID, First name or last name" style="padding-left: 40px;
  background-image: url(../web_images/ic_search_black_24dp.png); background-repeat:no-repeat; background-position:10px ">
                                        <div id="myInputautocomplete-list" class="autocomplete-items">
                                             
                                        </div>
                                      </div>
                                      
                                    </form>
                            
                            <center>
                                <form class="form-inline" role="form"> 
                                <div class="form-group">
                                    <!--<label>Row: </label> <input type="number"  style="width:70px;" class="form-control" value="1" id="row_box"/>
                                    <button type="button" class="btn btn-danger" id="row_btn" onclick="add_row('fees')"><i class="fa fa-plus"></i> ADD</button>-->
                                    <!--Make sure the form has the autocomplete function switched off:-->
                                    
                                    
                                    
                                </div><br/>
                                    
                                </form>
                                
                            </center>
                            <br/>
                           
                            <div class="box box-primary">
                                        <div class="box-body">
                                       <div class="col-sm-12 col-md-6" style="border:thin solid #ccc; border-radius:3px;">
                                        Chose date by :<br/>
                                        <div class="col-xs-12" style="background-color:#f2f2f2; border:thin solid #ccc;">
                                          
                                             <label><input type="radio" class="option" id="pdate_check" value="pdate" name="option1"/> Previous Date</label><div class="form-group"> 
                                            
                                    <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%">
                                        <input class="form-control"  type="text" value="" readonly placeholder="Previous Date" style="background-color:white;" id="pdate" disabled>
                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                    </div>
                                    <input type="hidden"  value="" />
                                        </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-7" style="padding-top:10px;">
                                             <div class="form-group">
                                        <label><input type="radio" class="option" checked name="option1"/> Current Date</label>
                                    </div>
                                        </div>
                                       </div>
                                   <div class="col-xs-12"><hr/></div>
                                    
                                        <div class="col-xs-12" style="padding-top:10px; padding-bottom:20px; background-color:#f2f2f2; border:thin solid #ccc;" >

                                            <center>

                                                <form class="form-inline" role="form" > 

                                                    <ul id="row_result_box">
                                                        <li id="" class="row_list">
                                                            <div class="form-group" style="padding:5px;">
                                                                <div id="msg_box"></div>
                                                                
                                                            <input type="text" class="form-control" placeholder="Student ID" name="student_id" value="" id="pstudent_id" />
                                                                
                                                            <input type="text" class="form-control" placeholder="Amount" name="p_amount" id="pamount"/>
                                                                
                                                            <input type="text" class="form-control" placeholder="Paid by" name="paidby" id="ppaidby"/>
                                                                
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </form>
                                            </center>

<div class="col-xs-12"><center><button type="button" class="btn btn-primary" id="make_payment" onclick="make_payment()" style="display:block">
    <div class="loader" id="loader1"></div>
    Make Payment</button></center><button type="button" class="btn btn-danger pull-right print_btn" id="print_btn"><i class="fa fa-print"></i><div class="loader" id="loader"></div> Issue Receipt(s)</button></div>
                                            
                                        </div>
                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                       
                        <div class="content">
                            
                                        <?php 
                                             $query = mysqli_query($conn,"select * from `daily_fees_payments` where `RECEIVED BY`='$user' and `SCHOOL`='$initials' and `GENERATED`='NO'");
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
                                            You have '.$number.' receipt(s) not generated. <span class="badge badge-primary print_btn" style="cursor:pointer" onclick="close_hint(\'#hint_box\');"><div class="loader" id="loader2"></div> Generate</span <i class="fa fa-close pull-right" style="cursor:pointer" onclick="close_hint(\'#hint_box\')"></i>
                                        </div>     
                                    </div>
                                </div>
                            </div>';
                                              }
                                        
                                        ?>
                                   
                        </div>
                        <div class="col-xs-12" id="receipt">
                            <iframe src="" id="iframe"></iframe>
                        </div>
                    </div>
                </div>
            </div>

<!--modl boxes-->
         <div class="modal fade" id="camera" style="z-index:5000;">
             <div class="modal-dialog " style="z-index:5000;">
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
                                 
                                 <button class="btn btn-default btn-block" type="button" id="capture_edit" data-dismiss="modal"><i class="fa fa-camera" ></i> Capture</button>
                                 
                             </div>
                         </form>
                     </div>
                       
                 </div>
             </div>
         </div>
        
        <div class="modal fade" id="edit_student">
             <div class="modal-dialog modal-lg" style="z-index:3000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                         <h2 class="modal-title"><i class="fa fa-user"></i> Edit Student Profile</h2>
                     </div>
                     <div class="modal-body">
                         <form role="form" id="form" enctype="multipart/form-data">
                                        <div class="col-xs-12 col-md-4">
                                            <h4>Student Personal Information</h4>
                                            <input type="hidden" value="" id="student_id"/>
                                            <hr/>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Student First Name" id="first_name"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Student Last/Middle Name" id="last_name"/>
                                            </div>
                                            <div class="form-group"> 
                                                <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%">
                                                    <input class="form-control"  type="text" value="" readonly placeholder="Date of Birth" style="background-color:white;" id="date_of_birth">
                                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                </div>
                                                <input type="hidden"  value="" />
                                            </div>
                                            
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="hometown" placeholder="Home Town"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="nationality" placeholder="Nationality"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="rgd" placeholder="Student Religious Denomination">
                                            </div>
                                            <div class="form-group">
                                                <input type="tel" class="form-control" id="former_school" placeholder="Name of Former School (Optional)">
                                            </div><br/>
                                            
                                            <div class="form-group" style="margin-top:0px;">
                                                <label><small id="classv">Present class: </small></label><br/>
                                               <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width:100%;" id="class_edit">
                                                <?php
                                                        $qeuery_pick_classes = mysqli_query($conn,"select * from classes where `SCHOOL`='$initials' order by ID asc");
                                                        while($fetch = mysqli_fetch_assoc($qeuery_pick_classes)){
                                                            echo '<option value="'.htmlentities($fetch['CLASS']).'" >'.htmlentities($fetch['CLASS']).'</option>';
                                                        }
                                                   ?>

                                              </select>

                                            </div>
                                            <div class="form-group" style="margin-top:-5px;">
                                                <label><small id="genderv">Gender: </small></label><br/>
                                               <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width:100%;" id="gender">
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                              </select>

                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-md-4">
                                            <h4>Guardian Information</h4>
                                            <hr/>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Guardian Name" id="guardianname"/>
                                            </div>
                                            
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Guardian Address" id="guardianaddress"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Guardian Occupation" id="guardianoccupation"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Guardian Tel" id="guardiantel"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Guardian Religious Denomination" id="guardianrgd"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Relationship To Student" id="relationship"/>
                                            </div>
                                            <div class="form-group">
                                                <label><small>Does the student have any disability? eg.Sickle cell, Blindness etc.</small></label>
                                                <input type="text" class="form-control" placeholder="Disability" id="disability"/>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-4">
                                            <h4>Office Use</h4>
                                            <hr/>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Admission Fee" id="fee"/>
                                            </div>
                                            <div class="form-group"> 
                                                <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%">
                                                    <input class="form-control"  type="text" value="" readonly placeholder="Paid Date" style="background-color:white;" id="paid_date">
                                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                </div>
                                                <input type="hidden"  value="" /><br/>
                                            </div>
                                            <div class="form-group" style="margin-top:-20px;"> 
                                                <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width:100%">
                                                    <input class="form-control"  type="text" value="" readonly placeholder="Date Admitted" style="background-color:white;" id="admission_date">
                                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                </div>
                                                <input type="hidden"  value="" /><br/>
                                            </div>
                                            <div class="form-group" style="margin-top:-20px;">
                                                <label><small>Choose Student Picture</small></label>
                                                <div class="form-control" id="student_image">
                                                    
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="button" class="btn btn-default" id="configure_cam" data-toggle="modal" data-target="#camera"><i class="fa fa-camera" ></i> Take A Photo</button><br/><br/>
                                                <label for="file" class="btn btn-default " onclick="upload_edit_student_image_from_explorer();" id="choose_pic_edit"><i class="fa fa-upload"></i> Choose A Photo</label>
                                                <input type="file" id="file" style="display:none" accept="image/*" name="file"/>
                                            </div>
                                            <div class="form-group" >
                                                <button type="button" class="btn btn-block btn-primary"  onclick="edit_student();" id="add_student" ><i class="fa fa-plus" ></i> Save Changes</button>
                                            </div>
                                        </div>
                                        <img src="" style="display:none" id="hidden_student_image"/>
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
                 $('.list-unstyled li:nth-child(9) ul').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(9) a').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(9) ul').toggleClass('collapse in');
                 $('.list-unstyled li:nth-child(9) a').toggleClass('');
                 $('.list-unstyled li:nth-child(9) ul li:nth-child(2)').toggleClass('active');
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
                 $('.option').on('click',function(){
                    var option = $(this).val();
                    if(option !="pdate"){
                        $('#pdate').val("");
                        $('#pdate').attr('disabled',true);
                        $('#calendar').attr('disabled',true);
                    }else{
                        $('#pdate').removeAttr('disabled',true); 
                    }
                 });
            })
            
  var inp = document.getElementById("myInput");      
  var currentFocus = 0; 
  inp.addEventListener("input", function(e) {
      var x = $('#myInputautocomplete-list');
      if(inp.value == ""){
          console.log('hello');
          x.html("");
      }else{
          x.html("<div><img src=\"../web_images/Eclipse-1s-200px.gif\" width=\"40px\"/> Please wait...</div>");
          
           $.post("../includes/fetch_students.php",{key:inp.value},
              function(data){
                x.html(data);
               
                
              })
      }
      
  })           
             
 
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById("myInputautocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
    
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x){
              console.log(x[currentFocus].className);
              if(x[currentFocus].className =="autocomplete-active"){
                  //add_row('fees');
              }
              x[currentFocus].click();
              
          }
        }
      }
  });
             
   console.log(currentFocus);
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    $('#myInputautocomplete-list').html('');
    
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
     
      closeAllLists(e.target);
      });


var add_rows = 0;
function add_row(action,id,student_name){
    
    $('#pstudent_id').val(id);
    $('#pamount').val('');
    $('#ppaidby').val('');
    $('#msg_box').html(student_name);
    
}
$('.print_btn').on("click",function(){
    $('#hint_box').css('display','none');
    $('#loader').css('display','block');
    var iframe = document.getElementById('iframe');
    iframe.src="print_receipt.php";
    iframe.onload=function(){
        $('#loader').css('display','none');
        $('#print_btn').css('display','none');
        
    }
})


         </script>
        
        
    </body>
</html>
