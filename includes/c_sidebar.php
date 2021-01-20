<?php
 session_start();
    include 'mysql_connect.php';

    if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
        $user = $_SESSION['user'];
    }else{
       echo '<script>

            window.open(\'../index.php\',\'_self\');
        </script>'; 
    }
    
    $query = mysqli_query($conn,"select * from `payment_invoices` where `OPERATION`='SMS CREDIT' and `status`='SUBMITTED' order by `ID` asc");
    $new = mysqli_num_rows($query);

    $query = mysqli_query($conn,"select * from `payment_invoices` where `OPERATION`='VOUCHER' and `status`='SUBMITTED' order by `ID` asc");
    $new1 = mysqli_num_rows($query);
    //pick  details form user name
    $query = mysqli_query($conn,"select * from `cusers` where `user`='$user'");
    if($fetch = mysqli_fetch_assoc($query)){
        $user = $fetch['user'];
    }
    if($user == 'easyskulAdmin'){
        $buttons ='<li data-toggle="tooltip" data-placement="right" title="The Dashboard feature gives  you summary of all features including total number of users,students,staffs and reveiw of academic calendar including events."><a href="cDashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a> </li>
        
                   <li>
                        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="true"><i class="fa fa-envelope-o"></i> SMS</a>
                        <ul class="collapse-in list-unstyled" id="homeSubmenu">
                            <li><a href="sms_unaccepted.php"><i class="fa fa-circle-o"></i> SMS Unaccepted  <span class="pull-right-container">
              <span class="label label-warning pull-right" data-toggle="tooltip" data-placement="top" title="You have '.$new.'unaccepted sms invoice">'.$new.'</span>
        </span></a></li>
                            
                            <li><a href="sms_accepted.php"><i class="fa fa-circle-o"></i> SMS Accepted</a></li>
                        </ul>
                    </li>
                    <li >
                        <a href="#student" data-toggle="collapse" aria-expanded="true"><i class="fa fa-credit-card"></i> Voucher</a>
                        <ul class="collapse-in list-unstyled" id="student">
                            <li><a href="voucher_unaccepted.php"><i class="fa fa-circle-o"></i> Unaccepted Vouchers <span class="label label-danger pull-right" data-toggle="tooltip" data-placement="top" title="You have '.$new1.'unaccepted voucher invoice">'.$new1.'</span>
        </span></a></li>
                            
                            <li><a href="voucher_accepted.php"><i class="fa fa-circle-o"></i> Accepted Vouchers</a></li>
                        </ul>
                    </li>
                    
                    <li data-toggle="tooltip" data-placement="right"><a href="main_admins.php"><i class="fa fa-user"></i> Main Admins</a> </li> 
        <li data-toggle="tooltip" data-placement="right"><a href="../includes/auto_send_expiry_info.php" target="_blank"><i class="fa fa-envelope"></i> Send Accounts expiry info</a> </li> 
        
        <li data-toggle="tooltip" data-placement="right"><a href="generate_result_codes.php" target="_blank"><i class="fa fa-print"></i> Print results vouchers</a> </li> 
                  '
            ;
    }else{
        $user = 'Student';
    }

echo '<nav id="sidebar">
                <div class="sidebar-header">
                    
                    <img src="../web_images/logo.png" width="150px;" class="img "/>
                </div>

                <ul class="list-unstyled components">
                   <div class="row">
                       <div class="content"><div style="font-size:25px; font-family:arial; padding-buttom:5px;"><center>Easy Skul Cpanel</center></div></div>
                   </div>
                    <li class="active">
                        <a style="color:#8a9ca6; font-size:12px">Menu</a>
                    </li>
                    
                    
                    '.$buttons.'
                </ul>

                
            </nav>';
?>