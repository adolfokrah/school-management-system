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

    $teachers = '';

    $qeuery_pick_classes = mysqli_query($conn,"select * from teachers where `SCHOOL`='$initials' order by ID asc");
    while($fetch = mysqli_fetch_assoc($qeuery_pick_classes)){
        $teachers .= '<option value="'.htmlentities($fetch['FIRST NAME']).' '.htmlentities($fetch['LAST NAME']).'" >'.htmlentities($fetch['FIRST NAME']).' '.htmlentities($fetch['LAST NAME']).'</option>';
    }
                                       
    $fields = array();
    if(isset($_REQUEST['id']) && isset($_REQUEST['show'])){
        $id = $_REQUEST['id'];
        $query = mysqli_query($conn,"select * from subjects where `ID`='$id'");
        
        if($fetch = mysqli_fetch_assoc($query)){
            $fields[0]=$fetch['ID'];
            $fields[1]=$fetch['SUBJECT NAME'];
            $fields[2]=$fetch['TEACHER'];
            
            
            echo $data = json_encode($fields);
        }
        
    }else if(isset($_REQUEST['id']) && isset($_REQUEST['subject']) && isset($_REQUEST['class']) &&  isset($_REQUEST['teacher'])){
        $id = $_REQUEST['id'];
        $subject = $_REQUEST['subject'];
        $classname = $_REQUEST['class'];
        $teacher = $_REQUEST['teacher'];
        //check if class already exist
        $query = mysqli_query($conn,"select * from subjects where `SUBJECT NAME`='".mysqli_real_escape_string($conn,$subject)."' and `SCHOOL`='$initials' and `CLASS`='$classname' and `TEACHER`='$teacher'");
        if(mysqli_num_rows($query) < 1){
            if(mysqli_query($conn,"update subjects set `SUBJECT NAME`='".mysqli_real_escape_string($conn,$subject)."',`TEACHER`='$teacher' where `ID`='$id'")){
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