<?php
    include 'school_ini_user_id.php';
    
    
    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
        //select number of users
        $message = 'success';
        $query_select1 = mysqli_query($conn,"select * from users where `NO`='$id'");
        
        while($fetch = mysqli_fetch_assoc($query_select1)){
            $u_Id = $fetch['USER ID'];
            $position = $fetch['POSITION'];
            if($position == 'MAIN ADMIN'){
                $message = 'admin';
            }else{
                mysqli_query($conn,"update `users` set `EMAIL='',`POSITION`=''  where `NO` = '$id'");
                $message = 'success';
            }
            if(strpos($u_Id,'-TCH')){
            mysqli_query($conn,"update teachers set `EMAIL`='',`TEACHER CLASS`='' where `NO` = '$id'");
            }
            echo $message;;
        }
       
        
    }else if(isset($_REQUEST['all'])){
        //select number of users
        $message = 'success';
        $query_select1 = mysqli_query($conn,"select * from users where `SCHOOL`='$initials'");
        
        while($fetch = mysqli_fetch_assoc($query_select1)){
            $u_Id = $fetch['USER ID'];
            $position = $fetch['POSITION'];
            if($position == 'MAIN ADMIN' || $position == "STUDENT"|| $position == "GUARDIAN"){
               // $message = 'admin';
            }else{
                mysqli_query($conn,"update `users` set `EMAIL='',`POSITION`=''  where `USER ID` = '$u_Id'");
                $message = 'success';
            }
            
            if(strpos($u_Id,'-TCH')){
            mysqli_query($conn,"update teachers set `EMAIL`='',`TEACHER CLASS`='' where `TEACHER ID` = '$u_Id'");
                
            }
            
        }
        echo $message;
        
    }else{
        echo 'error';
    }
?>