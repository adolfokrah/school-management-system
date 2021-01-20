<?php
   $btn2  ='';
    $btn_style2 = '';
    if($username != "Administrator"){
        $btn_style2 = 'style="display:none"';
    }

    $user_header_name = ''; 
    $position = '';
    //pick user name
    $query = mysqli_query($conn,"select * from `main admins` where `ADMIN ID`='$user'");
    if($fetch = mysqli_fetch_assoc($query)){
        $user_header_name = $fetch['ADMIN NAME'];
            $position = 'Main Administrator';
    }else{
        $query = mysqli_query($conn,"select * from `users` where `USER ID`='$user'");
        if($fetch=mysqli_fetch_assoc($query)){
            $user_header_name = $fetch['USER NAME'];
            $position = $fetch['POSITION'];
        }
    }
    
    $user_image="avatar3.jpg";
    $user_id  = str_replace('-PT','-STD',$user);
    $query_pick_student_image = mysqli_query($conn,"select * from admitted_students where `ADMISSION NO / ID`='$user_id' ");
    if($fetch = mysqli_fetch_assoc($query_pick_student_image)){
        $user_image = $fetch['PHOTO'];
        $user_header_name=$fetch['STUDENT LAST NAME'].' '.$fetch['STUDENT  FIRST NAME'];
            $position = 'Student';
        if(strpos($user,'-PT')){
            $user_header_name=$fetch['GUARDIAN NAME'];
            $position = 'Guardian';
        }
    }
    
   // $school_back = "default_cover.jpg";

//    if($username =='Administrator'){
//        echo ' <div class="hint-cover">
//    <div class="container">
//        <div class="row">
//            <div class="col-sm-12 col-md-6 col-md-offset-3">
//            <div class="modal-dialog modal-box" style="z-index:5000; margin-top:20%; border:none; ">
//                 <div class="modal-content">
//                     <div class="modal-header">
//                         <button class="closebtn close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
//                          <h3 style="color:black;">Tip for today !!!</h3>
//                     </div>
//                     <div class="modal-body">
//                         <img src="../web_images/teacher-teaching-students-clipart-8.jpg" width="100%"/>
//                         <p style="color:black;">
//                             Easyskul provides you a quick and convinient way to manage teachers in the school, assign them to classes and subjects. They can also login to thier portal with their unique IDs  and input students results, take students attendance and manage classes assigned to  as well.
//                            <strong>Click</strong> on show me and let me teach you how it\'s done !
//                         </p>
//                         <p style="text-align:right"><a href="manage_teacher">Show me</a> <a class="closebtn" style="cursor:pointer"><i class="fa fa-thumbs-up"></i> Got it</a></p>
//                     </div>
//                       
//                 </div>
//             </div>
//            </div>
//        </div>
//    </div>
//</div>';
//    }


    echo'<nav class="navbar navbar-primary">
    <div class="container-fluid">

        <div class="navbar-header pull-left" >
            <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                <i class="fa fa-bars"></i> 
            </button>
            
            
        </div>
        
        <div class="dropdown pull-right">
        
              
              
               
                <li style="color:white; padding:15px; cursor:pointer; list-style-type:none;" class="dropdown-toggle" data-toggle="dropdown" id="li"><a href="myprofile.php"><img src="../web_images/avatar.png" class="img img-circle" width="25px;"/> '.$user_header_name.' </a><span class="caret"></span></li>
                
                <ul class="dropdown-menu" style="padding-top:0px; width:280px;" >
                    
                      <!-- Widget: user widget style 1 -->
                      <div class="box box-widget widget-user-2">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header">
                          <div class="widget-user-image">
                            <img class="img-circle" src="upload/'.$user_image.'" alt="User Avatar" style="border:3px solid #ccc;">
                          </div>
                          <!-- /.widget-user-image -->
                          <h5 class="widget-user-username">'.$user_header_name.'</h5>
                          <h5 class="widget-user-desc">'.$position.'</h5>
                          
                        </div>
                        <div class="box-footer no-padding">
                          <ul class="nav nav-stacked">
                            <li><a href="my_profile.php">My Profile <span class="pull-right badge bg-blue"><i class="fa fa-user"></i></span></a></li>
                            <li><a href="settings.php" '.$btn_style2.'>Settings <span class="pull-right badge bg-aqua" ><i class="fa fa-gears"></i></span></a></li>
                            <li><a href="../logout.php">Logout<span class="pull-right badge bg-green"><i class="fa fa-lock"></i></span></a></li>
                          </ul>
                        </div>
                      </div>
                      <!-- /.widget-user -->
                   
                </ul>
           
        
    </div>';
    
//    <div class="dropdown pull-right">
//            <li style="color:white; padding:15px; cursor:pointer; list-style-type:none;" class="dropdown-toggle" data-toggle="dropdown" id="li"><i class="fa fa-bell"></i> <span class="badge badge-danger" style="margin-top:-20px; margin-left:-10px; background-color:red">5</span></li>
//            
//                <ul class="dropdown-menu" style="padding-top:0px; width:280px;" >
//                    
//                      <!-- Widget: user widget style 1 -->
//                      <div class="box box-widget widget-user-2">
//                        <!-- Add the bg color to the header using any of the bg-* classes -->
//                        <div class="widget-user-header" style="background-image:url(); color:#000; text-shadow:none">
//                          <div class="widget-user-image" style="background-image:url()">
//                           NOTIFICATIONS <span class="pull-right label label-warning">5 New</span> 
//                          </div>
//                         
//                          
//                        </div>
//                        <div class="box-footer no-padding">
//                          <ul class="nav nav-stacked">
//                            <li><a href="my_profile.php"><i class="fa fa-envelope"></i> Welcome to easyskul <br/><strong> 11-JAN-2018 5:00 AM</a></strong></li>
//                            
//                            <li><a href="my_profile.php">Your sms is runing down<br/><strong> 11-JAN-2018 5:00 AM</a></strong></li></a></li>
//                            
//                            <li><a href="my_profile.php">You have succefully activated your account, your account expires on ...<br/><strong> 11-JAN-2018 5:00 AM</a></strong></li></a></li>
//                            
//                          </ul>
//                          
//                        </div>
//                      </div>
//                      <!-- /.widget-user -->
//                   <li><a href="my_profile.php"><center>view all</center></li>
//                </

echo '</nav>';




?>
