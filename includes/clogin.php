<?php
session_start();
    include 'mysql_connect.php';
    
    
    if(isset($_REQUEST['password']) && isset($_REQUEST['user'])){
        
        if(empty($_REQUEST['password']) && empty($_REQUEST['user'])){
           echo 'passwordR';
        }else{
            //declare variables
            $user= $_REQUEST['user'];
            $password = md5($_REQUEST['password']);
            
            //check if user exist
            $query=mysqli_query($conn,"SELECT * FROM `cusers` WHERE `user`='".mysqli_real_escape_string($conn,$user)."' and `password`='$password'");
            if(mysqli_num_rows($query) == null){
                    echo 'error';
                $_SESSION['user'] = $user;
            }else{
                    
            $get_user = mysqli_query($conn,"SELECT * FROM `cusers` WHERE `user`='".mysqli_real_escape_string($conn,$user)."' and `password`='$password'");
                
                if($row = mysqli_fetch_assoc($get_user)){
                    $row['user'] = $user;
                $_SESSION['user'] = $user;
                echo 'success';
                }
               
                }
            
            }
        }else{
        echo 'fatal error';
    }
?>