<?php
 session_start();
    include 'mysql_connect.php';
    
    $user='';
    $school='';
    $username='';
    $school_logo='';
    $buttons = '';
    $btn_style  = '';
    //redirect user to registration stage if user is in registration stage
    if(isset($_SESSION['email']) && !empty($_SESSION['email'])){
        $user =$_SESSION['email'];
    }else if(isset($_SESSION['USER ID']) && !empty($_SESSION['USER ID'])){
        $user = $_SESSION['USER ID'];
    }else{
       echo '<script>

            window.open(\'../index.php\',\'_self\');
        </script>'; 
    }
    
    //pick  details form user name
    $query = mysqli_query($conn,"select * from `main admins` where `ADMIN EMAIL`='$user' or `ADMIN ID`='$user'");
    if($fetch = mysqli_fetch_assoc($query)){
        $user = $fetch['ADMIN ID'];
    }


    //pick school details
$str_pos = strpos($user,'-');
$initials = substr($user,0,$str_pos);

$query_pick = mysqli_query($conn,"select * from school_details where INITIALS ='$initials'");
if($fetch_details = mysqli_fetch_assoc($query_pick)){
    $school = $fetch_details['SCHOOL NAME'];
    $school_logo = $fetch_details['CREST'];
}


    if(strpos($user,'-AD')){
        
        redirect_session($initials,$conn);
        
        $username = 'Administrator';
        
        $buttons ='<li data-toggle="tooltip" data-placement="right" title="The Dashboard feature gives  you summary of all features including total number of users,students and preview of academic calendar including events."><a href="admin_dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a> </li> 
                   <li data-toggle="tooltip" data-placement="right" title="This Feature Allows you to manage all classes in the school such as Adding Class and subjects. Click here to explore this feature.">
                        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false"><i class="fa fa-edit"></i> Class</a>
                        <ul class="collapse list-unstyled" id="homeSubmenu">
                            <li><a href="manage_class.php"><i class="fa fa-circle-o"></i> Manage Class</a></li>
                            
                            <li><a href="manage_subject.php"><i class="fa fa-circle-o"></i> Manage Subjects</a></li>
                        </ul>
                    </li>
                    <li data-toggle="tooltip" data-placement="right" title="The student feature allows you to manage all students in the school, admitt new student and more">
                        <a href="#student" data-toggle="collapse" aria-expanded="false"><i class="fa fa-user"></i> Student</a>
                        <ul class="collapse list-unstyled" id="student">
                             <li><a href="import_data.php?import=true"><i class="fa fa-circle-o"></i> Import Data</a></li>
                            <li><a href="add_student.php"><i class="fa fa-circle-o"></i> Add Student</a></li>
                            <li><a href="admitted_students.php"><i class="fa fa-circle-o"></i> Admission History</a></li>
                            <li><a href="completed_students.php"><i class="fa fa-circle-o"></i> Completed Student(s)</a></li>
                            <li><a href="manage_student.php"><i class="fa fa-circle-o"></i> Manage Student(s)</a></li>
                        </ul>
                    </li>
                    <li data-toggle="tooltip" data-placement="right" title="You can also manage teachers in the school with this feature, assign them to classes and more.">
                        <a href="#teacher" data-toggle="collapse" aria-expanded="false"><i class="fa fa-briefcase"></i> Teacher</a>
                        <ul class="collapse list-unstyled" id="teacher">
                            
                            <li><a href="manage_teacher.php"><i class="fa fa-circle-o"></i> Manage Teacher(s)</a></li>
                            
                        </ul>
                    </li>
                     <li data-toggle="tooltip" data-placement="right" title="Student attendance can be recorded here and kept in the system. Student can either be marked as present or absent depending on the students\' attendance status.">
                        <a href="#attendance" data-toggle="collapse" aria-expanded="false"><i class="fa fa-clock-o"></i> Attendance</a>
                        <ul class="collapse list-unstyled" id="attendance">
                            <li><a href="take_attedance.php"><i class="fa fa-circle-o"></i> Take Attendance  </a></li>
                            <li><a href="attendance_history.php"><i class="fa fa-circle-o"></i> Attendance History</a></li>
                            
                        </ul>
                    </li>
                    <li data-toggle="tooltip" data-placement="right" title="This feature allows you to add and store students marks according to subject in other to generate terminal reports and more.">
                        <a href="#marksheet" data-toggle="collapse" aria-expanded="false"><i class="fa fa-copy"></i> Marksheet</a>
                        <ul class="collapse list-unstyled" id="marksheet">
                            <li><a href="manage_marksheet.php"><i class="fa fa-circle-o"></i> Manage Marksheet  </a></li>
                           
                            
                        </ul>
                    </li>
                    <li data-toggle="tooltip" data-placement="right" title="This feaute allows you to keep records and track of all fees collection, fees can be sorted according to debetors, fullpayment, creditors and part payment records. ">
                        <a href="#schoolfees" data-toggle="collapse" aria-expanded="false"><i class="fa fa-money"></i> Fees</a>
                        <ul class="collapse list-unstyled" id="schoolfees">
                            <li><a href="pay_fees.php"><i class="fa fa-circle-o"></i> PayFees</a></li>
                            <li><a href="termly_fees_records.php"><i class="fa fa-circle-o"></i> Termly Fees Records</a></li>
                            <li><a href="daily_fees_records.php"><i class="fa fa-circle-o"></i> Daily Fees Records</a></li>
                            <li><a href="return_balances.php"><i class="fa fa-circle-o"></i> Returned Fees Balances</a></li>
                        </ul>
                    </li>
                    <li data-toggle="tooltip" data-placement="right" title="This feature allows you to keep records and track of feeding fee collection in the school.">
                        <a href="#feedingffee" data-toggle="collapse" aria-expanded="false"><i class="fa fa-spoon"></i> Feeding Fee</a>
                        <ul class="collapse list-unstyled" id="feedingffee">
                            <li><a href="keep_feeding_fee_records.php"><i class="fa fa-circle-o"></i> Keep Fees Records</a></li>
                            
                            <li><a href="feeding_fee_history.php"><i class="fa fa-circle-o"></i> Feeding Fee History</a></li>
                            <li><a href="feeding_fee_debitors_creditors"><i class="fa fa-circle-o"></i> Debitors / Creditors </a></li>
                        </ul>
                    </li>
                    <li data-toggle="tooltip" data-placement="right" title="The Transport feature keeps track of all transport fees and allows you to manage transport system in the school" >
                        <a href="#transport" data-toggle="collapse" aria-expanded="false"><i class="fa fa-car"></i> Transport</a>
                        <ul class="collapse list-unstyled" id="transport">
                            <li><a href="manage_buses"><i class="fa fa-circle-o"></i> Manage Buses</a></li>
                            <li><a href="tracking"><i class="fa fa-circle-o"></i> Tracking</a></li>
                            <li><a href="keep_bus_payment_records"><i class="fa fa-circle-o"></i> Keep Payment Records</a></li>
                            <li><a href="bus_payment_histories"><i class="fa fa-circle-o"></i> Payment Histories</a></li>
                            <li><a href="bus_debitors_creditors"><i class="fa fa-circle-o"></i> Debitors / Creditors</a></li>
                        </ul>
                    </li>
                    <li data-toggle="tooltip" data-placement="right" title="Expenses allows you to keep track and records of the expenses of the school and print reports as well"><a href="expenses.php?new=new"><i class="fa fa-expand"></i> Expenses</a> </li>
                    <li data-toggle="tooltip" data-placement="right" title="The billing feature helps you to bill students with items such as school fees,tution fee and any other item. It also gives you access to print students\' bill.">
                        <a href="#billing" data-toggle="collapse" aria-expanded="false"><i class="fa fa-bug"></i> Billing</a>
                        <ul class="collapse list-unstyled" id="billing">
                            <li><a href="bill_items.php"><i class="fa fa-circle-o"></i> Bill Item(s)</a></li>
                            
                            <li><a href="manage_bills.php"><i class="fa fa-circle-o"></i> Billed items</a></li>
                        </ul>
                    </li>
                    
                    <li data-toggle="tooltip" data-placement="right" title="All Accounting operation made can be sumed up and printed out using this feature. It allows you to search within day range range."><a href="sammary_report.php"><i class="fa fa-paste"></i> Summary Report</a> </li>
                    
                    
                    <li data-toggle="tooltip" data-placement="right" title="This feature allows you to upload time table for varios classes in the school. Being class timetable or exam timetables.">
                        <a href="time_table.php"><i class="fa fa-calendar-o"></i> Time table</a>
                    </li>
                    <li data-toggle="tooltip" data-placement="right" title="This feature allows you to generate and manage students terminal reports.">
                        <a href="#report" data-toggle="collapse" aria-expanded="false"><i class="fa fa-envelope-o"></i> Terminal Report</a>
                        <ul class="collapse list-unstyled" id="report">
                            <li><a href="add_report.php"><i class="fa fa-circle-o"></i> Add Report</a></li>
                            <li><a href="manage_report.php"><i class="fa fa-circle-o"></i> Manage Reports</a></li>
                            <li><a href="grading_sys.php"><i class="fa fa-circle-o"></i> Grading system</a></li>
                            <li><a href="promotion_status.php"><i class="fa fa-circle-o"></i> Promotion Status</a></li>
                        </ul>
                    </li>
                    <li data-toggle="tooltip" data-placement="right" title="The academic calendar feature allows you to create academic calendar base on current term, add events and more.">
                        <a href="#acalendar" data-toggle="collapse" aria-expanded="false"><i class="fa fa-calendar"></i> Academic Calendar</a>
                        <ul class="collapse list-unstyled" id="acalendar">
                            
                            <li><a href="academic_calendar.php"><i class="fa fa-circle-o"></i> Manage Calendar</a></li>
                        </ul>
                    </li>
                    <li data-toggle="tooltip" data-placement="right" title="Any info by you can be broadcasted to all users including parents,students and teachers. Click on the add notice to broadcast any info.">
                        <a href="#notice" data-toggle="collapse" aria-expanded="false"><i class="fa fa-table"></i> Notice Board</a>
                        <ul class="collapse list-unstyled" id="notice">
                            <li><a href="add_notice.php"><i class="fa fa-circle-o"></i> Add Notice</a></li>
                            <li><a href="manage_notice.php"><i class="fa fa-circle-o"></i> Manage Notice</a></li>
                        </ul>
                    </li>
                    <li data-toggle="tooltip" data-placement="right" title="This feature allows you to manage books kept in the library, add new books to shelfs and more.">
                        <a href="#library" data-toggle="collapse" aria-expanded="false"><i class="fa fa-book"></i> Library</a>
                        <ul class="collapse list-unstyled" id="library">
                            <li><a href="manage_shelf.php"><i class="fa fa-circle-o"></i> Manage Shelf</a></li>
                            <li><a href="manage_books.php"><i class="fa fa-circle-o"></i> Manage Books</a></li>
                            <li><a href="library_history.php"><i class="fa fa-circle-o"></i> History</a></li>
                        </ul>
                    </li>
                    <li data-toggle="tooltip" data-placement="right" title="This system can be used by many users there for this feature allows you to add and manage users on the system.">
                        <a href="#users" data-toggle="collapse" aria-expanded="false"><i class="fa fa-users"></i> Users</a>
                        <ul class="collapse list-unstyled" id="users">
                            <li><a href="manage_users.php"><i class="fa fa-circle-o"></i> Manage User(s)</a></li>
                            <li><a href="recover_password.php"><i class="fa fa-circle-o"></i> Recover user(s) password</a></li>
                            
                        </ul>
                    </li>
                    <li data-toggle="tooltip" data-placement="right" title="This feature allows you to manage staffs in the school, genterate payslips, add new staff and more." style="display:none;">
                        <a href="#user" data-toggle="collapse" aria-expanded="false"><i class="fa fa-briefcase"></i> Staffs</a>
                        <ul class="collapse list-unstyled" id="user">
                            <li><a href="#"><i class="fa fa-circle-o"></i> Add Staf(s)</a></li>
                            <li><a href="#"><i class="fa fa-circle-o"></i> Manage Staff(s)</a></li>
                            
                        </ul>
                    </li>
                    
                    <li data-toggle="tooltip" data-placement="right" title="The Messaging feature allows you to send customized messages to people eg.parents,users etc through sms."><a href="messaging.php"><i class="fa fa-envelope-o"></i> Messaging</a> </li> 
                    
                    <li data-toggle="tooltip" data-placement="right" title="This feature allows you to change the system settings such as school details, your profile, add,activate and remove academic years.">
                        <a href="#settings" data-toggle="collapse" aria-expanded="false"><i class="fa fa-gears"></i> Settings</a>
                        <ul class="collapse list-unstyled" id="settings">
                            <li><a href="manage_academic_year.php"><i class="fa fa-circle-o"></i> Manage Academic Year(s)</a></li>
                            <li><a href="settings.php"><i class="fa fa-circle-o"></i> System Settings</a></li>
                            <li><a href="my_profile.php"><i class="fa fa-circle-o"></i> My Profile</a></li>
                            
                        </ul>
                    </li>
                    
                    <li data-toggle="tooltip" data-placement="right" title="This feature allows you to manage payment invoices">
                        <a href="#invoices" data-toggle="collapse" aria-expanded="false"><i class="fa fa-credit-card"></i> Payment invoices</a>
                        <ul class="collapse list-unstyled" id="invoices">
                            <li><a href="submitted_invoices.php"><i class="fa fa-circle-o"></i> submitted Invoices</a></li>
                            <li><a href="unsubmitted_invoices.php"><i class="fa fa-circle-o"></i> Unsumbitted invoices</a></li>
                            
                        </ul>
                    </li>
                    
                      <li data-toggle="tooltip" data-placement="right" title="The feature allows you to see all accounting operations of the accounts."><a href="histories.php"><i class="fa fa-clock-o"></i> Operation Histories</a> </li>
                      '
            ;
        
        $query_check = mysqli_query($conn,"select * from academic_years where `STATUS`='ACTIVE' and `SCHOOL`='$initials'");
if(mysqli_num_rows($query_check) == null){
    $buttons = ' 
                    <li data-toggle="tooltip" data-placement="right" title="This feature allows you to change the system settings such as school details, your profile, add,activate and remove academic years.">
                        <a href="#settings" data-toggle="collapse" aria-expanded="false"><i class="fa fa-gears"></i> Settings</a>
                        <ul class="collapse list-unstyled" id="settings">
                            <li><a href="manage_academic_year.php"><i class="fa fa-circle-o"></i> Manage Academic Year(s)</a></li>
                            <li><a href="settings.php"><i class="fa fa-circle-o"></i> System Settings</a></li>
                            <li><a href="my_profile.php"><i class="fa fa-circle-o"></i> My Profile</a></li>
                            
                        </ul>
                    </li>';
}
        
        
    }else if(strpos($user,'-AC')){
        redirect_session($initials,$conn);
        $username='Accountant';
        
        $buttons = '<li data-toggle="tooltip" data-placement="right" title="The Dashboard feature gives  you summary of all features including total number of users,students and preview of academic calendar including events."><a href="accountant_dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a> </li> 
        
        <li data-toggle="tooltip" data-placement="right" title="This feaute allows you to keep records and track of all fees collection, fees can be sorted according to debetors, fullpayment, creditors and part payment records. ">
                        <a href="#schoolfees" data-toggle="collapse" aria-expanded="true"><i class="fa fa-money"></i> Fees</a>
                        <ul class="collapse in list-unstyled" id="schoolfees" >
                            <li><a href="pay_fees.php"><i class="fa fa-circle-o"></i> PayFees</a></li>
                            <li><a href="termly_fees_records.php"><i class="fa fa-circle-o"></i> Termly Fees Records</a></li>
                            <li><a href="daily_fees_records.php"><i class="fa fa-circle-o"></i> Daily Fees Records</a></li>
                            <li><a href="return_balances.php"><i class="fa fa-circle-o"></i> Returned Fees Balances</a></li>
                        </ul>
                    </li>
                    
                    <li data-toggle="tooltip" data-placement="right" title="This feature allows you to keep records and track of feeding fee collection in the school.">
                        <a href="#feedingffee" data-toggle="collapse" aria-expanded="true"><i class="fa fa-spoon"></i> Feeding Fee</a>
                        <ul class="collapse in list-unstyled" id="feedingffee">
                            <li><a href="keep_feeding_fee_records.php"><i class="fa fa-circle-o"></i> Keep Fees Records</a></li>
                            
                            <li><a href="feeding_fee_history.php"><i class="fa fa-circle-o"></i> Feeding Fee History</a></li>
                        </ul>
                    </li>
                    <li data-toggle="tooltip" data-placement="right" title="Expenses allows you to keep track and records of the expenses of the school and print reports as well"><a href="expenses.php?new=new"><i class="fa fa-expand"></i> Expenses</a> </li>
                    
                    <li data-toggle="tooltip" data-placement="right" title="The billing feature helps you to bill students with items such as school fees,tution fee and any other item. It also gives you access to print students\' bill.">
                        <a href="#billing" data-toggle="collapse" aria-expanded="true"><i class="fa fa-bug"></i> Billing</a>
                        <ul class="collapse in list-unstyled" id="billing">
                            <li><a href="bill_items.php"><i class="fa fa-circle-o"></i> Bill Item(s)</a></li>
                            
                            <li><a href="manage_bills.php"><i class="fa fa-circle-o"></i> Billed items</a></li>
                        </ul>
                    </li>
                    
                    <li data-toggle="tooltip" data-placement="right" title="The Transport feature keeps track of all transport fees and allows you to manage transport system in the school" >
                        <a href="#transport" data-toggle="collapse" aria-expanded="false"><i class="fa fa-car"></i> Transport</a>
                        <ul class="collapse list-unstyled" id="transport">
                            <li><a href="manage_buses"><i class="fa fa-circle-o"></i> Manage Buses</a></li>
                            <li><a href="tracking"><i class="fa fa-circle-o"></i> Tracking</a></li>
                            <li><a href="keep_bus_payment_records"><i class="fa fa-circle-o"></i> Keep Payment Records</a></li>
                            <li><a href="bus_payment_histories"><i class="fa fa-circle-o"></i> Payment Histories</a></li>
                            <li><a href="bus_debitors_creditors"><i class="fa fa-circle-o"></i> Debitors / Creditors</a></li>
                        </ul>
                    </li>
                    
                    <li data-toggle="tooltip" data-placement="right" title="All Accounting operation made can be sumed up and printed out using this feature. It allows you to search within day range range."><a href="sammary_report.php"><i class="fa fa-paste"></i> Summary Report</a> </li>
                    
                    <li data-toggle="tooltip" data-placement="right" title="The Messaging feature allows you to send customized messages to people eg.parents,users etc through sms."><a href="messaging.php"><i class="fa fa-envelope-o"></i> Messaging</a> </li> 
                        <li data-toggle="tooltip" data-placement="right" title="This system can be used by many users there for this feature allows you to add and manage users on the system.">
                        <a href="#invoices" data-toggle="collapse" aria-expanded="false"><i class="fa fa-credit-card"></i> Payment invoices</a>
                        <ul class="collapse list-unstyled" id="invoices">
                            <li><a href="submitted_invoices.php"><i class="fa fa-circle-o"></i> submitted Invoices</a></li>
                            <li><a href="unsubmitted_invoices.php"><i class="fa fa-circle-o"></i> Unsumbitted invoices</a></li>
                            
                        </ul>
                    </li>    
            <li data-toggle="tooltip" data-placement="right" title="Click your to access your profile settings."><a href="my_profile.php"><i class="fa fa-user"></i> My Profile</a> </li>
                    ';
    }else if(strpos($user,'-DE')){
        $username = 'Data Entry';
        redirect_session($initials,$conn);
        $buttons = '<li data-toggle="tooltip" data-placement="right" title="The Dashboard feature gives  you summary of all features including total number of users,students and preview of academic calendar including events."><a href="data_entry_dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a> </li> 
        
                   <li data-toggle="tooltip" data-placement="right" title="This Feature Allows you to manage all classes in the school such as Adding Class and subjects. Click here to explore this feature.">
                        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false"><i class="fa fa-edit"></i> Class</a>
                        <ul class="collapse list-unstyled" id="homeSubmenu">
                            <li><a href="manage_class.php"><i class="fa fa-circle-o"></i> Manage Class</a></li>
                            
                            <li><a href="manage_subject.php"><i class="fa fa-circle-o"></i> Manage Subjects</a></li>
                        </ul>
                    </li>
                    <li data-toggle="tooltip" data-placement="right" title="The student feature allows you to manage all students in the school, admitt new student and more">
                        <a href="#student" data-toggle="collapse" aria-expanded="false"><i class="fa fa-user"></i> Student</a>
                        <ul class="collapse list-unstyled" id="student">
                        <li><a href="import_data.php"><i class="fa fa-circle-o"></i> Import Data</a></li>
                            <li><a href="add_student.php"><i class="fa fa-circle-o"></i> Add Student</a></li>
<li><a href="admitted_students.php"><i class="fa fa-circle-o"></i> Admission History</a></li>
                            <li><a href="completed_students.php"><i class="fa fa-circle-o"></i> Completed Student(s)</a></li>                            <li><a href="manage_student.php"><i class="fa fa-circle-o"></i> Manage Student(s)</a></li>
                        </ul>
                    </li>
                    <li data-toggle="tooltip" data-placement="right" title="You can also manage teachers in the school with this feature, assign them to classes and more.">
                        <a href="#teacher" data-toggle="collapse" aria-expanded="false"><i class="fa fa-briefcase"></i> Teacher</a>
                        <ul class="collapse list-unstyled" id="teacher">
                            
                            <li><a href="manage_teacher.php"><i class="fa fa-circle-o"></i> Manage Teacher(s)</a></li>
                            
                        </ul>
                    </li>
                     <li data-toggle="tooltip" data-placement="right" title="Student attendance can be recorded here and kept in the system. Student can either be marked as present or absent depending on the students\' attendance status.">
                        <a href="#attendance" data-toggle="collapse" aria-expanded="false"><i class="fa fa-clock-o"></i> Attendance</a>
                        <ul class="collapse list-unstyled" id="attendance">
                            <li><a href="take_attedance.php"><i class="fa fa-circle-o"></i> Take Attendance  </a></li>
                            <li><a href="attendance_history.php"><i class="fa fa-circle-o"></i> Attendance History</a></li>
                            
                        </ul>
                    </li>
                    <li data-toggle="tooltip" data-placement="right" title="This feature allows you to add and store students marks according to subject in other to generate terminal reports and more.">
                        <a href="#marksheet" data-toggle="collapse" aria-expanded="false"><i class="fa fa-copy"></i> Marksheet</a>
                        <ul class="collapse list-unstyled" id="marksheet">
                            <li><a href="manage_marksheet.php"><i class="fa fa-circle-o"></i> Manage Marksheet  </a></li>
                           
                            
                        </ul>
                    </li>
                    
                    <li data-toggle="tooltip" data-placement="right" title="This feature allows you to upload time table for varios  classes in the school. Being class timetable or exam timetables.">
                        <a href="time_table.php"><i class="fa fa-calendar-o"></i> Time table</a>
                    </li>
                    <li data-toggle="tooltip" data-placement="right" title="This feature allows you to generate and manage students terminal reports.">
                        <a href="#report" data-toggle="collapse" aria-expanded="false"><i class="fa fa-envelope-o"></i> Terminal Report</a>
                        <ul class="collapse list-unstyled" id="report">
                            <li><a href="add_report.php"><i class="fa fa-circle-o"></i> Add Report</a></li>
                            <li><a href="manage_report.php"><i class="fa fa-circle-o"></i> Manage Reports</a></li>
                            <li><a href="grading_sys.php"><i class="fa fa-circle-o"></i> Grading system</a></li>
                            <li><a href="promotion_status.php"><i class="fa fa-circle-o"></i> Promotion Status</a></li>
                        </ul>
                    </li>
                    <li data-toggle="tooltip" data-placement="right" title="The academic calendar feature allows you to create academic calendar base on current term, add events and more.">
                        <a href="#acalendar" data-toggle="collapse" aria-expanded="false"><i class="fa fa-calendar"></i> Academic Calendar</a>
                        <ul class="collapse list-unstyled" id="acalendar">
                            
                            <li><a href="academic_calendar.php"><i class="fa fa-circle-o"></i> Manage Calendar</a></li>
                        </ul>
                    </li>
                    <li data-toggle="tooltip" data-placement="right" title="Any info by you can be broadcasted to all users including parents,students and teachers. Click on the add notice to broadcast any info.">
                        <a href="#notice" data-toggle="collapse" aria-expanded="false"><i class="fa fa-table"></i> Notice Board</a>
                        <ul class="collapse list-unstyled" id="notice">
                            <li><a href="add_notice.php"><i class="fa fa-circle-o"></i> Add Notice</a></li>
                            <li><a href="manage_notice.php"><i class="fa fa-circle-o"></i> Manage Notice</a></li>
                        </ul>
                    </li>
                    
                     <li data-toggle="tooltip" data-placement="right" title="The Messaging feature allows you to send customized messages to people eg.parents,users etc through sms."><a href="messaging.php"><i class="fa fa-envelope-o"></i> Messaging</a> </li>
                       <li data-toggle="tooltip" data-placement="right" title="This system can be used by many users there for this feature allows you to add and manage users on the system.">
                        <a href="#invoices" data-toggle="collapse" aria-expanded="false"><i class="fa fa-credit-card"></i> Payment invoices</a>
                        <ul class="collapse list-unstyled" id="invoices">
                            <li><a href="submitted_invoices.php"><i class="fa fa-circle-o"></i> submitted Invoices</a></li>
                            <li><a href="unsubmitted_invoices.php"><i class="fa fa-circle-o"></i> Unsumbitted invoices</a></li>
                            
                        </ul>
                    </li>  
            <li data-toggle="tooltip" data-placement="right" title="The Dashboard feature gives  you summary of all features including total number of users,students and preview of academic calendar including events."><a href="my_profile.php"><i class="fa fa-user"></i> My Profile</a> </li>
                    ';
    }else if(strpos($user,'-LB')){
        $username='Libarian';
        redirect_session($initials,$conn);
        $buttons = '<li data-toggle="tooltip" data-placement="right" title="The Dashboard feature gives  you summary of all features including total number of users,students and preview of academic calendar including events."><a href="libarian_dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a> </li> 
        
        <li data-toggle="tooltip" data-placement="right" title="This feature allows you to manage books kept in the library, add new books to shelfs and more.">
                        <a href="#library" data-toggle="collapse" aria-expanded="true"><i class="fa fa-book"></i> Library</a>
                        <ul class="collapse in list-unstyled" id="library">
                            <li><a href="manage_shelf.php"><i class="fa fa-circle-o"></i> Manage Shelf</a></li>
                            <li><a href="manage_books.php"><i class="fa fa-circle-o"></i> Manage Books</a></li>
                            <li><a href="library_history.php"><i class="fa fa-circle-o"></i> History</a></li>
                        </ul>
                    </li>
                    
            <li data-toggle="tooltip" data-placement="right" title="The Dashboard feature gives  you summary of all features including total number of users,students and preview of academic calendar including events."><a href="my_profile.php"><i class="fa fa-user"></i> My Profile</a> </li>';
    }else if(strpos($user,'-HD')){
        $username = 'School Head';
        redirect_session($initials,$conn);
        $btn_style = 'style="display:none"';
        $buttons ='<li data-toggle="tooltip" data-placement="right" title="The Dashboard feature gives  you summary of all features including total number of users,students and preview of academic calendar including events."><a href="head_dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a> </li> 
                   <li data-toggle="tooltip" data-placement="right" title="This Feature Allows you to manage all classes in the school such as Adding Class and subjects. Click here to explore this feature.">
                        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false"><i class="fa fa-edit"></i> Class</a>
                        <ul class="collapse list-unstyled" id="homeSubmenu">
                            
                            <li><a href="manage_subject.php"><i class="fa fa-circle-o"></i> Manage Subjects</a></li>
                        </ul>
                    </li>
                    <li data-toggle="tooltip" data-placement="right" title="The student feature allows you to manage all students in the school, admitt new student and more">
                        <a href="#student" data-toggle="collapse" aria-expanded="false"><i class="fa fa-user"></i> Student</a>
                        <ul class="collapse list-unstyled" id="student">
<li><a href="admitted_students.php"><i class="fa fa-circle-o"></i> Admission History</a></li>
                            <li><a href="completed_students.php"><i class="fa fa-circle-o"></i> Completed Student(s)</a></li>                            <li><a href="manage_student.php"><i class="fa fa-circle-o"></i> Manage Student(s)</a></li>
                        </ul>
                    </li>
                    <li data-toggle="tooltip" data-placement="right" title="You can also manage teachers in the school with this feature, assign them to classes and more.">
                        <a href="#teacher" data-toggle="collapse" aria-expanded="false"><i class="fa fa-briefcase"></i> Teacher</a>
                        <ul class="collapse list-unstyled" id="teacher">
                            
                            <li><a href="manage_teacher.php"><i class="fa fa-circle-o"></i> Manage Teacher(s)</a></li>
                            
                        </ul>
                    </li>
                     <li data-toggle="tooltip" data-placement="right" title="Student attendance can be recorded here and kept in the system. Student can either be marked as present or absent depending on the students\' attendance status.">
                        <a href="#attendance" data-toggle="collapse" aria-expanded="false"><i class="fa fa-clock-o"></i> Attendance</a>
                        <ul class="collapse list-unstyled" id="attendance">
                            <li><a href="attendance_history.php"><i class="fa fa-circle-o"></i> Attendance History</a></li>
                            
                        </ul>
                    </li>
                    <div style="display:none">
                        <li data-toggle="tooltip" data-placement="right" title="This feature allows you to add and store students marks according to subject in other to generate terminal reports and more.">
                        <a href="#marksheet" data-toggle="collapse" aria-expanded="false"><i class="fa fa-copy"></i> Marksheet</a>
                        <ul class="collapse list-unstyled" id="marksheet">
                            <li><a href="manage_marksheet.php"><i class="fa fa-circle-o"></i> Manage Marksheet  </a></li>
                           
                            
                        </ul>
                    </li>
                    </div>
                    <li></li><li></li><li></li>
                    <li data-toggle="tooltip" data-placement="right" title="This feaute allows you to keep records and track of all fees collection, fees can be sorted according to debetors, fullpayment, creditors and part payment records. ">
                        <a href="#schoolfees" data-toggle="collapse" aria-expanded="false"><i class="fa fa-money"></i> Fees</a>
                        <ul class="collapse list-unstyled" id="schoolfees">
                            
                            <li><a href="termly_fees_records.php"><i class="fa fa-circle-o"></i> Termly Fees Records</a></li>
                            <li><a href="daily_fees_records.php"><i class="fa fa-circle-o"></i> Daily Fees Records</a></li>
                        </ul>
                    </li>
                    
                    <li data-toggle="tooltip" data-placement="right" title="The billing feature helps you to bill students with items such as school fees,tution fee and any other item. It also gives you access to print students\' bill.">
                        <a href="#billing" data-toggle="collapse" aria-expanded="false"><i class="fa fa-bug"></i> Billing</a>
                        <ul class="collapse list-unstyled" id="billing">
                            <li><a href="bill_items.php"><i class="fa fa-circle-o"></i> Bill Item(s)</a></li>
                            
                        </ul>
                    </li>
                    
                    <li data-toggle="tooltip" data-placement="right" title="All Accounting operation made can be sumed up and printed out using this feature. It allows you to search within day range range."><a href="sammary_report.php"><i class="fa fa-paste"></i> Summary Report</a> </li>
                    
                    
                    <li data-toggle="tooltip" data-placement="right" title="This feature allows you to upload time table for varios  classes in the school. Being class timetable or exam timetables.">
                        <a href="time_table.php"><i class="fa fa-calendar-o"></i> Time table</a>
                    </li>
                    <li data-toggle="tooltip" data-placement="right" title="This feature allows you to generate and manage students terminal reports.">
                        <a href="#report" data-toggle="collapse" aria-expanded="false"><i class="fa fa-envelope-o"></i> Terminal Report</a>
                        <ul class="collapse list-unstyled" id="report">
                        <li></li>
                            <li><a href="manage_report.php"><i class="fa fa-circle-o"></i> Manage Reports</a></li>
                            
                            <li></li>
                            <li><a href="promotion_status.php"><i class="fa fa-circle-o"></i> Promotion Status</a></li>
                        </ul>
                    </li>
                    
                    <li data-toggle="tooltip" data-placement="right" title="This feature allows you to manage books kept in the library, add new books to shelfs and more.">
                        <a href="#library" data-toggle="collapse" aria-expanded="false"><i class="fa fa-book"></i> Library</a>
                        <ul class="collapse list-unstyled" id="library">
                            <li><a href="manage_shelf.php"><i class="fa fa-circle-o"></i> Manage Shelf</a></li>
                            <li><a href="manage_books.php"><i class="fa fa-circle-o"></i> Manage Books</a></li>
                            <li><a href="library_history.php"><i class="fa fa-circle-o"></i> History</a></li>
                        </ul>
                    </li>
                    
                      <li data-toggle="tooltip" data-placement="right" title="The feature allows you to see all accounting operations of the accounts."><a href="histories.php"><i class="fa fa-clock-o"></i> Operation Histories</a> </li>

<li data-toggle="tooltip" data-placement="right" title="The Dashboard feature gives  you summary of all features including total number of users,students and preview of academic calendar including events."><a href="my_profile.php"><i class="fa fa-user"></i> My Profile</a> </li>';
    }else if(strpos($user,'-TCH')){
        $username="Teacher";
        $class = '';
        //pick teacher class
        $teacher_class = mysqli_query($conn,"select * from teachers where `TEACHER ID`='$user'");
        if($fetch = mysqli_fetch_assoc($teacher_class)){
            $class= $fetch['TEACHER CLASS'];
        }
        redirect_session($initials,$conn);
        $buttons = '<li data-toggle="tooltip" data-placement="right" title="The Dashboard feature gives  you summary of all features including total number of users,students and preview of academic calendar including events."><a href="head_dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a> </li> 
        
        <li data-toggle="tooltip" data-placement="right" title="Student attendance can be recorded here and kept in the system. Student can either be marked as present or absent depending on the students\' attendance status.">
                        <a href="#attendance" data-toggle="collapse" aria-expanded="true"><i class="fa fa-clock-o"></i> Attendance</a>
                        <ul class="collapse in list-unstyled" id="attendance">
                            <li><a href="take_attedance.php"><i class="fa fa-circle-o"></i> Take Attendance  </a></li>
                            <li><a href="attendance_history.php"><i class="fa fa-circle-o"></i> Attendance History</a></li>
                            
                        </ul>
                    </li>
        <li data-toggle="tooltip" data-placement="right" title="This feature allows you to add and store students marks according to subject in other to generate terminal reports and more.">
                        <a href="#marksheet" data-toggle="collapse" aria-expanded="false"><i class="fa fa-copy"></i> Marksheet</a>
                        <ul class="collapse list-unstyled" id="marksheet">
                            <li><a href="manage_marksheet.php"><i class="fa fa-circle-o"></i> Manage Marksheet  </a></li>
                           
                            
                        </ul>
                    </li>
                    <li data-toggle="tooltip" data-placement="right" title="Click here to view class timetable.">
                        <a href="time_table.php"><i class="fa fa-calendar-o"></i> Time table</a>
                    </li>
                    
                    <li data-toggle="tooltip" data-placement="right" title="Click here to view students in the class you are teaching.">
                        <a href="manage_student.php?class='.$class.'"><i class="fa fa-university"></i> My Class</a>
                    </li>
                    
                    <li data-toggle="tooltip" data-placement="right" title="Click here to view subjects your are assign to teach in this school..">
                       <a href="print_teacher_subjects.php?teacher_id='.$user.'" target="_blank"><i class="fa fa-file"></i> My Subjects</a>
                    </li>
                    
                    
        <li data-toggle="tooltip" data-placement="right" title="The Dashboard feature gives  you summary of all features including total number of users,students and preview of academic calendar including events."><a href="my_profile.php"><i class="fa fa-user"></i> My Profile</a> </li>';
    }else if(strpos($user,'-PT')){
        $username = "Parent";
        $id = '';
        $p_student_id = str_replace('-PT','-STD',$user);
        $query = mysqli_query($conn,"select * from admitted_students where `ADMISSION NO / ID`='$p_student_id'");
        if($fetch = mysqli_fetch_assoc($query)){
            $id = $fetch['NO'];
        }
        
        $new = '';
        //pick new reports
        $query1 = mysqli_query($conn,"select * from `terminal_reports_av` where `VIEWED`='' and `STUDENT ID`='$p_student_id'");
        if(mysqli_num_rows($query1)>0){
            $new = mysqli_num_rows($query1);
        }
        $buttons = '
        <li data-toggle="tooltip" data-placement="right"><a href="parent_dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a> </li>
        
        <li data-toggle="tooltip" data-placement="right" title="Click here to check your wards fees report"><a href="student_fees.php"><i class="fa fa-money"></i> Fees</a> </li>
        
        <li data-toggle="tooltip" data-placement="right" title="This Feature helps you to check on your wards attendance in school"><a href="student_attendance_history.php"><i class="fa fa-calendar"></i> Attendance History</a> </li>
        
        <li data-toggle="tooltip" data-placement="right" title=""><a href="track_ward"><i class="fa fa-car"></i> Track my child</a> </li>
        
        <li data-toggle="tooltip" data-placement="right" title="Click here to check your wards Terminal reports."><a href="student_terminal_reports.php?student_id='.$p_student_id.'"><i class="fa fa-folder"></i> Terminal Reports 
        <span class="pull-right-container">
              <span class="label label-warning pull-right" data-toggle="tooltip" data-placement="top" title="You have '.$new.' new report(s)">'.$new.'</span>
        </span>
            
        </a> </li>
        
        <li data-toggle="tooltip" data-placement="right" title="Cick here to check your wards profile"><a href="student_profile.php?student_id='.$id.'"><i class="fa fa-graduation-cap"></i> Wards\' Profile</a> </li>
        
        <li data-toggle="tooltip" data-placement="right" title="This feature allows you to view your profile and change your password."><a href="my_profile.php"><i class="fa fa-user"></i> My Profile</a> </li>
        
        <li><a href="../logout.php"><i class="fa fa-lock"></i> Log out</a> </li>
        ';
    }else if(strpos($user,'-STD')){
        $username = "Student";
        $id = '';
        $p_student_id = str_replace('-PT','-STD',$user);
        $query = mysqli_query($conn,"select * from admitted_students where `ADMISSION NO / ID`='$p_student_id'");
        if($fetch = mysqli_fetch_assoc($query)){
            $id = $fetch['NO'];
        }
        
        $new = '';
        //pick new reports
        $query1 = mysqli_query($conn,"select * from `terminal_reports_av` where `VIEWED`='' and `STUDENT ID`='$p_student_id'");
        if(mysqli_num_rows($query1)>0){
            $new = mysqli_num_rows($query1);
        }
        $buttons = '
        <li data-toggle="tooltip" data-placement="right"><a href="student_dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a> </li>
        
        <li data-toggle="tooltip" data-placement="right" title="Click here to check your  fees report"><a href="student_fees.php"><i class="fa fa-money"></i> Fees</a> </li>
        
        <li data-toggle="tooltip" data-placement="right" title="This Feature helps you to check on your  attendance in school"><a href="student_attendance_history.php"><i class="fa fa-calendar"></i> Attendance History</a> </li>
        
        <li data-toggle="tooltip" data-placement="right" title="Click here to check your  Terminal reports."><a href="student_terminal_reports.php?student_id='.$p_student_id.'"><i class="fa fa-folder"></i> Terminal Reports 
        <span class="pull-right-container">
              <span class="label label-warning pull-right" data-toggle="tooltip" data-placement="top" title="You have '.$new.' new report(s)">'.$new.'</span>
        </span>
            
        </a> </li>
        
        <li data-toggle="tooltip" data-placement="right" title="Cick here to check your  profile"><a href="student_profile.php?student_id='.$id.'"><i class="fa fa-graduation-cap"></i> My Profile</a> </li>
        
        <li data-toggle="tooltip" data-placement="right" title="Click here to view your class timetable.">
                        <a href="student_time_table.php"><i class="fa fa-calendar-o"></i> Time table</a>
                    </li>
                    
        <li data-toggle="tooltip" data-placement="right" title="This feature allows you to view your profile and change your password."><a href="my_profile.php"><i class="fa fa-user"></i> My Profile settings</a> </li>
        
        <li><a href="../logout.php"><i class="fa fa-lock"></i> Log out</a> </li>
        ';
    }





if($school_logo == " "){
    $school_logo = 'default_crest.jpg';
}
echo '<nav id="sidebar">
                <div class="sidebar-header">
                    
                    <img src="../web_images/logo.png"  width="150px" class="img "/>
                </div>

                <ul class="list-unstyled components" style="padding-top:0px;">
                   <div style="background-color:#0f1011; padding-top:10px;">
                   <div class="row">
                       <div class="content"><div class="col-sm-3 col-xs-3"><center><img src="../image_uploads_crests/'.$school_logo.'" class="img img-responsive" style="margin-left:15px; margin-bottom:15px; border-radius:2px;"/></center></div> <div class="col-sm-8 col-xs-8">'.$school.'</div></div>
                   </div>
                   
                   </div>
                    
                   
                    <li class="active" >
                    <div class="col-sm-12">
                    
                        <div class="form-group">
                           <form action="gsearch" method="get"> <input type="text" class="form-control" placeholder="Student ID / Name" id="side_search" name="search"/>
                       </form>
                       </div>
                   
                   </div>
                        <a style="color:#8a9ca6; font-size:12px;border-bottom:#7f8182 thin solid;  background-color:#0f1011;">Menu</a>
                    </li>
                    
                    
                    '.$buttons.'
                </ul>

                
            </nav>';

$found = "false";
foreach($users as $auser){
    if($username == $auser){
       $found = "true";
    }
}
if($found == "false"){
    redirect($user);
    die();
}

function redirect($userid){
    
     if(strpos($userid,'-AC')){
     echo "<script>window.open('accountant_dashboard.php','_self')</script>";

    }else if(strpos($userid,'-LB')){
        echo "<script>window.open('libarian_dashboard.php','_self')</script>";
    }else if(strpos($userid,'-HD')){
        echo "<script>window.open('head_dashboard.php','_self')</script>";
    }else if(strpos($userid,'-TCH')){
        echo "<script>window.open('teacher_dashboard.php','_self')</script>";
    }else if(strpos($userid,'-STD')){
        echo "<script>window.open('student_dashboard.php','_self')</script>";
    }else if(strpos($userid,'-PT')){
        echo "<script>window.open('parent_dashboard.php','_self')</script>";
    }else if(strpos($userid,'-DE')){
        echo "<script>window.open('data_entry_dashboard.php','_self')</script>";
    }else if(strpos($userid,'-AD')){
        echo "<script>window.open('admin_dashboard.php','_self')</script>";
    }
}

function redirect_session($initials,$conn){
    $query_pick_code = mysqli_query($conn,"select * from school_entered_vouchers where `SCHOOL`='$initials'");
        if($fetch_code = mysqli_fetch_assoc($query_pick_code)){
            $days = 0;
            $datetime1 = new DateTime(date('Y-m-d'));

            $datetime2 = new DateTime($fetch_code['EXPIRY DATE']);

            if($datetime1 > $datetime2){
                echo "<script>window.open('../session_expired.php','_self')</script>";
                die();
            }
            
        }
}
?>

