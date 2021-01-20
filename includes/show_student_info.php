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

    
                                       
    $fields = array();
    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
        $query = mysqli_query($conn,"select * from admitted_students where `NO`='$id'");
        
        if($fetch = mysqli_fetch_assoc($query)){
            $fields[0]=$fetch['STUDENT  FIRST NAME'];
            $fields[1]=$fetch['STUDENT LAST NAME'];
            $fields[2]=$fetch['STD DATE OF BIRTH'];
            $fields[3]='';
            $fields[4]=$fetch['HOME TOWN'];
            $fields[5]=$fetch['NATIONALITY'];
            $fields[6]=$fetch['STD RELIGIOUS DENOMINATION'];
            $fields[7]=$fetch['FORMER SCHOOL'];
            $fields[8]=$fetch['PRESENT CLASS'];
            $fields[9]=strtoupper($fetch['GENDER']);
            $fields[10]=$fetch['PRESENT CLASS'];
            $fields[11]=$fetch['GUARDIAN NAME'];
            $fields[12]=$fetch['GUARDIAN ADDRESS'];
            $fields[13]=$fetch['GUARDIAN OCCUPATION'];
            $fields[14]=$fetch['GUARDIAN TEL'];
            $fields[15]=$fetch['GUARDIAN RD'];
            $fields[16]=$fetch['GUARDIAN RELATIONSHIP STATUS'];
            $fields[17]=$fetch['STUDENT DISABILITIES'];
            $fields[18]=$fetch['ADMISSION FEE'];
            $fields[19]=$fetch['PAIDDATE'];
            $fields[20]=$fetch['YEAR OF ADMISSION'];
            $fields[21]=$fetch['NO'];
            $fields[22]=$fetch['PHOTO'];
            
            $_SESSION['student_row_id']=$fetch['NO'];
            
            
            echo $data = json_encode($fields);
        }
        
    }
?>