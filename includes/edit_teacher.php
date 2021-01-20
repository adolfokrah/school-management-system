<?php
 
    include 'school_ini_user_id.php';
    if(isset($_REQUEST['id']) && isset($_REQUEST['show'])){
        $id = $_REQUEST['id'];
        $query = mysqli_query($conn,"select * from teachers where `ID`='$id' and `SCHOOL`='$initials'");
        $fields = array();
        if($fetch = mysqli_fetch_assoc($query)){            
            $fields[0]=$fetch['TEACHER ID'];
            $fields[1]=$fetch['FIRST NAME'];
            $fields[2]=$fetch['LAST NAME'];
           
            $fields[3]=$fetch['CONTACT'];
           
            $fields[4]=$fetch['TEACHER CLASS'];
           
            echo json_encode($fields);
        }
        
    }else if(isset($_REQUEST['first_name']) && isset($_REQUEST['last_name']) && isset($_REQUEST['teacher_class'])&&isset($_REQUEST['contact'])&&isset($_REQUEST['id'])){
        
        $first_name = mysqli_real_escape_string($conn,$_REQUEST['first_name']);
        $last_name = mysqli_real_escape_string($conn,$_REQUEST['last_name']);
        $teacher_class = mysqli_real_escape_string($conn,$_REQUEST['teacher_class']);
       
        $contact = mysqli_real_escape_string($conn,$_REQUEST['contact']);
       
        $id = mysqli_real_escape_string($conn,$_REQUEST['id']);
        //check if class already exist
        $query = mysqli_query($conn,"select * from teachers where `TEACHER ID` != '$id' and `TEACHER CLASS`='".$teacher_class."' and `SCHOOL`='$initials' and `TEACHER CLASS` !='NONE'");
        if(mysqli_num_rows($query) < 1){
            if(mysqli_query($conn,"update teachers set `FIRST NAME`='$first_name', `LAST NAME`='$last_name',`CONTACT`='$contact',`TEACHER CLASS`='$teacher_class' where `TEACHER ID`='$id' and `SCHOOL`='$initials' ")){
                $name = $last_name.' '.$first_name;
                mysqli_query($conn,"update users set `USER NAME`='$name' where `USER ID`='$id'");
                echo 'success';
            }else{
                echo 'error';
            }
        }else{
            echo 'found';
        }
    }else{
        //echo 'error'.$date_of_birth;
    }
?>