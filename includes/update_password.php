<?php
    include 'school_ini_user_id.php';
            
        if(isset($_REQUEST['admin_pid']) && !empty($_REQUEST['admin_pid']) && isset($_REQUEST['old_password']) && !empty($_REQUEST['old_password']) && isset($_REQUEST['new_password']) && !empty($_REQUEST['new_password']) && isset($_REQUEST['c_password']) && !empty($_REQUEST['c_password'])){
            
            $admin_pid = $_REQUEST['admin_pid'];
            $administrator_old_password = md5($_REQUEST['old_password']);
            $administrator_new_password = $_REQUEST['new_password'];
            $administrator_c_password = $_REQUEST['c_password'];
            $sql = '';
            
            $sql = "select * from `users` where `USER ID`='$user'";
            $query_admin = mysqli_query($conn,$sql);
            
                    
            if($fetch = mysqli_fetch_assoc($query_admin)){
                $administrator_password = $fetch['PASSWORD'];
            }
            
            //compare passwords in the database
            if($administrator_password == $administrator_old_password){
                if(strlen($administrator_new_password) > 6){
                    //check if password contains these characters
                    if (preg_match("/^[a-zA-Z0-9]*$/", $administrator_new_password)){
                        
                        //conpare new passwords 
                        if($administrator_new_password == $administrator_c_password){
                            
                            // hash new password
                            $administrator_password = md5($administrator_new_password);
                        
                            //update old password with the new one
                        
                        $query = mysqli_query($conn,"update `main admins` set `ADMIN PASSWORD`='".mysqli_real_escape_string($conn,$administrator_password)."' where `ADMIN ID`='$user'");
                            
                        $query = mysqli_query($conn,"update `users` set `PASSWORD`='".mysqli_real_escape_string($conn,$administrator_password)."' where `USER ID`='$user'");
                        
                            echo 'success';
                        }else{
                            echo 'not';
                            
                        }
                        
                    }else{
                        //if not print error message
                        echo 'strong';
                        
                    }
                }else{
                    echo 'six';
                    
                }
                
            }else{
                echo 'incorrect';
                
            } 
      
}
?>