<?php
    include 'school_ini_user_id.php';
    
    
    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
        $query=mysqli_query($conn,"select * from teachers where `ID`='$id'");
        if($fetch = mysqli_fetch_assoc($query)){
            $teacher_id = $fetch['TEACHER ID'];
            mysqli_query($conn,"update teachers set `EMAIL`='',`TEACHER CLASS`='' where `ID` = '$id'");
            mysqli_query($conn,"update subjects  set `TEACHER`='' where `TEACHER` = '$teacher_id'");
            mysqli_query($conn,"update usersset `SCHOOL`=''  where `USER ID`='$teacher_id'");
           
            echo 'success';
        }else{
            echo 'error';
        }
        
    }else if(isset($_REQUEST['all'])){
        
        $query=mysqli_query($conn,"select * from teachers where `SCHOOL`='$initials'");
        while($fetch = mysqli_fetch_assoc($query)){
            $teacher_id = $fetch['TEACHER ID'];
            mysqli_query($conn,"update teachers set `EMAIL`='',`TEACHER CLASS`='' where `TEACHER ID` = '$teacher_id'");
            mysqli_query($conn,"update users set `SCHOOL`='' where `USER ID`='$teacher_id'");
            mysqli_query($conn,"update subjects  set `TEACHER`='' where `TEACHER` = '$teacher_id'");
            
        }
        echo 'success';
    }else{
        echo 'error';
    }
?>