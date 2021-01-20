<?php
    //declare message functions
    
    //error_box
    function error_box($message){
        echo'<div class="panel panel-danger" >
            
             <div class="panel-heading">
                <div class="panel-title">
                    Error 
                </div>
             </div>
                <div class="panel-body" style="color:black">
                    '.$message.'
                </div>
            
            
        </div>';
    }
?>