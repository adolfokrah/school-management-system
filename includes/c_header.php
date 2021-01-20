<?php
   

    echo'<nav class="navbar navbar-primary">
    <div class="container-fluid">

        <div class="navbar-header pull-left" >
            <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                <i class="fa fa-bars"></i> 
            </button>
        </div>
        <div class="dropdown pull-right">
                <li style="color:white; padding:15px; cursor:pointer; list-style-type:none;" class="dropdown-toggle" data-toggle="dropdown" id="li"><a href="#"><img src="../web_images/avatar.png" class="img img-circle" width="25px;"/> '.$username.'</a><span class="caret"></span></li>
                
                <ul class="dropdown-menu">
                    <li class="dropdown-header">More Actions</li>
                    
                    <li><a href="../clogout.php"><i class="fa fa-lock"></i> Logout</a></li>
                    
                </ul>
           
        
    </div>
</nav>';




?>