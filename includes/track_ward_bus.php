<?php

 include 'school_ini_user_id.php';
 $from = '';
    if(isset($_REQUEST['student_id']) && isset($_REQUEST['date']) && isset($_REQUEST['bus'])){
        $student_id = $_REQUEST['student_id'];
        $date = $_REQUEST['date'];
        
        $query = mysqli_query($conn,"select * from `daily_bus_fee` where `STUDENT ID`='$student_id' and `DATE`='$date'");
        $bus_number='';
        if($fetch = mysqli_fetch_assoc($query)){
         
            $bus_stop='';
            $ctime = '';
            $time = '';
            $bus_number = $fetch['BUS'];
            $query_pick = mysqli_query($conn,"select * from bus_tracking where `BUS NUMBER`='$bus_number' and `DATE`='$date' and `SCHOOL`='$initials'");
            while($fetch_bus = mysqli_fetch_assoc($query_pick)){
                $bus_stop = $fetch_bus['LOCATION'];
                $ctime = $fetch_bus['TIME'];
                if($bus_stop == $fetch['DROPED']){
                    $time = $fetch_bus['TIME'];
                }
            }
         echo '<div class="col-sm-12 col-md-6">
            <form>

                <div class="form-group">
               <lable>BUS SET OFF TIME</label><br/><br/>
                <input type="text" value="'.$fetch['BUS LEFT TIME'].'" class="form-control" readonly/>
               </div>

                   <div class="form-group">
                   <lable>BUS CURRENT STOP</label><br/><br/>
                    <input type="text" value="'.$bus_stop.'" class="form-control" readonly onfocus="view_log(\''.$bus_stop.'\')"/>
                   </div>

                   <div class="form-group">
                   <lable>TIME STOPPED</label><br/><br/>
                    <input type="text" value="'.$ctime.'" class="form-control" readonly/>

               </div>



        </div>';
            echo '<div class="col-sm-12">';
        if($fetch['DROPED'] !=''){
             echo '
        <button class="btn btn-block btn-success" type="button" onclick="view_log(\''.$fetch['DROPED'].'\')"  style="margin-bottom:50px;">Dropped at <strong>'.$fetch['DROPED'].' - '.$time.'</strong></button>
        ';
        }else{
             echo '
        <button class="btn btn-block btn-danger" type="button">STILL IN BUS</button>
         </form>
        ';
        }
            echo '</div>';
      }
    }
?>
