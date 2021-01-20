<?php
    include 'school_ini_user_id.php';
    //redirect user to registration stage if user is in registration stage
    if( isset($_REQUEST['student_id']) && isset($_REQUEST['row_id']) && isset($_REQUEST['from']) && isset($_REQUEST['to'])){
        $student_id = $_REQUEST['student_id'];
        $id = $_REQUEST['row_id'];
        $from = $_REQUEST['from'];
        $to = $_REQUEST['to'];
        
        $query = mysqli_query($conn,"select * from feeding_fee where `STUDENT ID`='$student_id'");
        if($fetch = mysqli_fetch_assoc($query)){
            echo '<form role="form" id="form" enctype="multipart/form-data">
                                       
                                            <div class="form-group">
                                                <input type="text" readonly value="'.$fetch['STUDENT ID'].'" class="form-control" id="f_student_id"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" readonly value="'.$fetch['STUDENT NAME'].'" class="form-control"/>
                                            </div>
                             
                                            <div class="form-group">
                                                <label>Current Arreas</label><br/>
                                                <input type="text"  value="'.sprintf('%0.2f',$fetch['ARREAS']).'" class="form-control" id="f_arreas"/>
                                            </div>
                             
                                            <div class="form-group">
                                                <label>Current Blance</label><br/>
                                                <input type="text"  value="'.sprintf('%0.2f',$fetch['BALANCE']).'" class="form-control" id="f_balance"/>
                                            </div>
                             
                                            <div class="form-group">
                                                <label>Days left</label><br/>
                                                <input type="text"  value="'.$fetch['DAYS LEFT'].'" class="form-control" id="f_days_left"/>
                                            </div>
                                            <div class="form-group" >
                                                <button type="button" class="btn btn-block btn-warning"  onclick="delete_feeding_fee(\''.$id.'\',\''.$from.'\',\''.$to.'\');" id="btn" >Confirm and delete</button>
                                               <input type="hidden" id="row_id"/>
                                            </div>
                                        </div>
                                    </form>';
        }
    }
?>