<?php
    include 'school_ini_user_id.php';
    include 'get_currencies.php';
   
    if(isset($_REQUEST['key'])){
        $search = $_REQUEST['key'];
        $query = mysqli_query($conn,"select * from admitted_students where `ADMISSION NO / ID` like '".$search."%' and `SCHOOL`='$initials' and `PRESENT CLASS` !='' and `PRESENT CLASS` !='COMPLETED STUDENTS' or `STUDENT LAST NAME` like '".$search."%' and `SCHOOL`='$initials' and `PRESENT CLASS` !='' and `PRESENT CLASS` !='COMPLETED STUDENTS' or `STUDENT  FIRST NAME` like '".$search."%' and `SCHOOL`='$initials' and `PRESENT CLASS` !='' and `PRESENT CLASS` !='COMPLETED STUDENTS' ");
         if(mysqli_num_rows($query)==null){
            echo '<div>No result found.</div>';
        }
        $counter = 0;
        while($fetch = mysqli_fetch_assoc($query)){
            $counter++;
            $student_name = $fetch['STUDENT LAST NAME'].' '.$fetch['STUDENT  FIRST NAME'];
            if($counter < 30){
                echo'<div style="padding-bottom:20px; clear:both; "  onclick="add_row(\'fees\',\''.$fetch['ADMISSION NO / ID'].'\',\''.$student_name.'\')">
                        <img src="upload/'.$fetch['PHOTO'].'" class="img" width="70px"  style="float:left; margin-right:10px; "/>
                        '.$fetch['STUDENT LAST NAME'].' '.$fetch['STUDENT  FIRST NAME'].'<br/>
                         <strong>Student ID:</strong> '.$fetch['ADMISSION NO / ID'].' <br/>
                         <strong>Class: </strong>'. $fetch['PRESENT CLASS'].'<br/>
                         ';
                
                        $query2 = mysqli_query($conn,"select * from school_fees where `STUDENT ID`='".$fetch['ADMISSION NO / ID']."' and `SCHOOL`='$initials' and `STATUS`='ACTIVE'");
                        if($fetch2 = mysqli_fetch_assoc($query2)){
                            echo '
                         <span><strong>Debit</strong> GH¢ '.sprintf('%0.2f',$fetch2['DEBIT']).'</span>';
                        }
                        echo '
                    </div>';
            }
        }
    }else{
        echo '<div>No result found.</div>';
    }
?>