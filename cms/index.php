<?php 
    session_start();

    if(isset($_SESSION['email']) && !empty($_SESSION['email']) || isset($_SESSION['USER ID']) && !empty($_SESSION['USER ID'])){
                $userid = $_SESSION['USER ID'];
                @ $email = $_SESSION['EMAIL'];
                
                     echo '<script>
                    
                        window.open(\'admin_dashboard.php\',\'_self\');
                    </script>';
            }else{
                 echo '<script>
                    
                        window.open(\'../index.php\',\'_self\');
                    </script>';
            }
?>