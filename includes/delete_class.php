<?php
    session_start();
    include 'mysql_connect.php';
    
    $user='';
    $shool ='';
    //redirect user to registration stage if user is in registration stage
    if(isset($_SESSION['email']) && !empty($_SESSION['email'])){
        $user =$_SESSION['email'];
        $query = mysqli_query($conn,"select * from `main admins` where `ADMIN EMAIL`='$user'");
        if($fetch = mysqli_fetch_assoc($query)){
            $user = $fetch['ADMIN ID'];
        }
    }else if(isset($_SESSION['USER ID']) && !empty($_SESSION['USER ID'])){
        $user = $_SESSION['USER ID'];
    }

    //pick school details
    $str_pos = strpos($user,'-');
    $initials = substr($user,0,$str_pos);
    
    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
        $query=mysqli_query($conn,"select * from classes where `ID`='$id'");
        if($fetch = mysqli_fetch_assoc($query)){
            $class= $fetch['CLASS'];
            $query=mysqli_query($conn,"select * from admitted_students where `PRESENT CLASS`='$class' and `SCHOOL`='$initials'");
            if(mysqli_num_rows($query) < 1){
                
            
            mysqli_query($conn,"delete from classes where ID = '$id'");
            mysqli_query($conn,"delete from subjects where `CLASS` = '$class' and `SCHOOL`='$initials'");
            
             $query=mysqli_query($conn,"select * from admitted_students where `PRESENT CLASS`='$class' and `SCHOOL`='$initials'");
            while($fetch = mysqli_fetch_assoc($query)){
                $student_id = $fetch['ADMISSION NO / ID'];
                $file = $fetch['PHOTO'];
                if(file_exists('../cms/upload/'.$file) && $file !="avatar3.jpg"){
                    unlink('../cms/upload/'.$file);
                }
                $id = $fetch['NO'];
                mysqli_query($conn,"update admitted_students set `PRESENT CLASS`=''  where `NO` = '$id'");
                mysqli_query($conn,"update users  set `EMAIL`='',`POSITION`=''  where `USER ID`='$student_id'");
                $parent_id = str_replace('STD','PT',$student_id);
                mysqli_query($conn,"update users  set `EMAIL`='',`POSITION`='' where `USER ID`='$parent_id'");
                
            }
                mysqli_query($conn,"update teachers  set `TEACHER CLASS`='' where `TEACHER CLASS`='$class' and `SCHOOL`='$initials'");
                mysqli_query($conn,"delete from subjects where `CLASS`='$class' and `SCHOOL`='$initials'");
            echo 'success';
            }else{
                 echo 'notempty';
            }
        }
        
        
    }else if(isset($_REQUEST['all'])){
        $query=mysqli_query($conn,"select * from admitted_students where `SCHOOL`='$initials'");
        if(mysqli_num_rows($query) < 1){
            
        
        mysqli_query($conn,"delete from classes where  `SCHOOL`='$initials'");
        mysqli_query($conn,"delete from subjects where  `SCHOOL`='$initials'");
        
             
            while($fetch = mysqli_fetch_assoc($query)){
                $student_id = $fetch['ADMISSION NO / ID'];
                $file = $fetch['PHOTO'];
                if(file_exists('../cms/upload/'.$file) && $file !="avatar3.jpg"){
                    unlink('../cms/upload/'.$file);
                }
                $id = $fetch['NO'];
                mysqli_query($conn,"update admitted_students set `PRESENT CLASS`=''  where `NO` = '$id'");
                mysqli_query($conn,"update users  set `EMAIL`='',`POSITION`=''  where `USER ID`='$student_id'");
                $parent_id = str_replace('STD','PT',$student_id);
                mysqli_query($conn,"update users  set `EMAIL`='',`POSITION`='' where `USER ID`='$parent_id'");
               
            }
             mysqli_query($conn,"delete from subjects where  `SCHOOL`='$initials'");
             mysqli_query($conn,"update teachers  set `TEACHER CLASS`='' where  `SCHOOL`='$initials'");
               
        
        echo 'success';
        }else{
            echo 'notempty';
        }
    }else{
        echo 'error';
    }
?>