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
    $counter = 0;
    $query = mysqli_query($conn,"select * from classes where `SCHOOL`='$initials'");
    
    if(mysqli_num_rows($query) == null){
        echo 'No class found.';
    }
    while($fetch = mysqli_fetch_assoc($query)){
        
        $class = $fetch['CLASS'];
        $counter ++;
        $id = $fetch['ID'];
        echo '<tr>
              <td>'.$counter.'</td>
              <td>'.$class.'
              </td>
              <td style="width:30%;"><button class=" btn btn-danger" onclick=delete_class(\''.$id.'\');><i class="fa fa-trash"></i> Delete</button> <button class=" btn btn-default" onclick=edit_class(\''.$id.'\');><i class="fa fa-edit"></i> Edit</button></td>

            </tr>';
    }
?>