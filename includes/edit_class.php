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

    

    
    if(isset($_REQUEST['id']) && isset($_REQUEST['show'])){
        $id = $_REQUEST['id'];
        $query = mysqli_query($conn,"select * from classes where `ID`='$id'");
        
        if($fetch = mysqli_fetch_assoc($query)){
            echo '<div class="form-group">
                                 <label>Class Name</label>
                                 <input type="text" class="form-control" id="edit_class_name" value="'.htmlentities($fetch['CLASS']).'"/>
                             </div>
                             <div class="form-group">
                                 <button class="btn btn-primary" type="button" onclick="edit_class_action(\''.$id.'\')" id="edit_class_btn"  data-toggle="tooltip" data-placement="top" title="Click here to see effects">Edit Class</button>
                                
                             </div>';
        }
        
    }else if(isset($_REQUEST['id']) && isset($_REQUEST['classname'])){
        $id = $_REQUEST['id'];
        $classname = $_REQUEST['classname'];
        //check if class already exist
        $query = mysqli_query($conn,"select * from classes where `CLASS`='".mysqli_real_escape_string($conn,$classname)."' and `SCHOOL`='$initials'");
        if(mysqli_num_rows($query) < 1){
            $query1 = mysqli_query($conn,"select * from classes where `ID`='$id'");
            if($fetch = mysqli_fetch_assoc($query1)){
                mysqli_query($conn,"update admitted_students set `PRESENT CLASS`='$classname' where `PRESENT CLASS`='".$fetch['CLASS']."' and `SCHOOL`='$initials'");
            }
            if(mysqli_query($conn,"update classes set `CLASS`='$classname' where `ID`='$id'")){
                
                echo 'success';
            }else{
                echo 'error';
            }
        }else{
            echo 'found';
        }
    }else{
        echo 'error';
    }
?>