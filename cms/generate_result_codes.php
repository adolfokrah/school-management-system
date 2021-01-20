<style>
    #box{
        height: auto;
        margin: auto;
    }
    #box:after{
        content: "";
        display: block;
        float: none;
        
    }
    #btn{
        position: fixed;
        top: 10px;
        right: 10px;
        padding: 5px  15px 5px 15px;
        background-color: forestgreen;
        color: white;
        cursor: pointer;
    }
</style>

<center><form method="get">
    <input type="number" name="value" id="value" placeholder="Please input amuont here"></input>
    <input type="submit" name="submit" id="submit" value="Submit"></input>
</form></center>
<?php
include '../includes/school_ini_user_id.php';
require_once 'tcpdf/tcpdf.php';

function fetchdata($conn){
            

    if(isset($_GET['value']) and !empty($_GET['value'])){
      
        $value = mysqli_real_escape_string($conn, $_GET['value']);
        $output = '';
        if($value <= 5000){
            $output = '';
            set_time_limit(120);
            $randarray = generate($value,$conn); 
            
            
            for($i = 1; $i < count($randarray); $i++){
               $query = mysqli_query($conn, "INSERT INTO `results_vouchers`(`ID`, `CODE`, `USED`) VALUES (NULL,'".$randarray[$i]."','')");

            }
            
           foreach($randarray as $code){
               $output .='<div style="float:left; width:300px; border:0.5px solid #000; text-align:center; font-size:40px;"><b><em>PIN: </em>'.$code.'<br/></b><span style="font-size:15px;">www.easyskul.com</span></div>';
           }
        }
        $output .='<br/><br/>
<button type="button" onclick="window.print()" id="btn">Print</button>';
         return $output;
    }
         

}
function generate($value,$conn){
     $randarray = array();
     //check in db
   
    for($i=0; $i<=$value; $i++){
         $initials = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $initials = str_shuffle($initials);
        $initials = substr($initials,0,1);
        $rand = 'R'.$initials.str_pad("",6,rand(0, 999999),STR_PAD_RIGHT);
        $query = mysqli_query($conn,"select * from results_vouchers where `CODE`='$rand'");
        if(mysqli_num_rows($query) < 1)
        {
            $randarray[$i] = $rand;
           
        }else{
            generate($value,$conn);
        }
    }
    
    return $randarray;
}
echo '<div id="box">'.fetchdata($conn).'</div>';
?>
