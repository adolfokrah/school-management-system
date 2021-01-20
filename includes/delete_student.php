<?php
    include 'school_ini_user_id.php';
    
    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
        $query=mysqli_query($conn,"select * from admitted_students where `NO`='$id'");
        if($fetch = mysqli_fetch_assoc($query)){
            $student_id = $fetch['ADMISSION NO / ID'];
            $file = $fetch['PHOTO'];
            if(file_exists('../cms/upload/'.$file) && $file !="avatar3.jpg"){
                unlink('../cms/upload/'.$file);
            }
            
            mysqli_query($conn,"update admitted_students set `PRESENT CLASS`=''  where `NO` = '$id'");
            mysqli_query($conn,"update users set `EMAIL`='', `POSITION`='' where `USER ID`='$student_id'");
            $parent_id = str_replace('STD','PT',$student_id);
            mysqli_query($conn,"update users set `EMAIL`=', `POSITION`='' where `USER ID`='$parent_id'");
            echo 'success';
        }else{
            echo 'error';
        }
        
    }else if(isset($_REQUEST['all'])){
         
        $query=mysqli_query($conn,"select * from admitted_students where `SCHOOL`='$initials'");
        while($fetch = mysqli_fetch_assoc($query)){
            $file = $fetch['PHOTO'];
            if(file_exists('../cms/upload/'.$file)){
                unlink('../cms/upload/'.$file);
            }
            
            $student_id = $fetch['ADMISSION NO / ID'];
            mysqli_query($conn,"update admitted_students  set `PRESENT CLASS`='' where `STUDENT ID` = '$student_id'");
            mysqli_query($conn,"update users set `EMAIL`='', `POSITION`='' where `USER ID`='$student_id'");
            $parent_id = str_replace('STD','PT',$student_id);
            mysqli_query($conn,"update users set `EMAIL`='',`POSITION`='' where `USER ID`='$parent_id'");
        }
        echo 'success';
    }else{
        echo 'error';
    }
?>