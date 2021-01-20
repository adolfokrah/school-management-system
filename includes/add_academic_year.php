<?php
    include 'school_ini_user_id.php';

    //redirect user to registration stage if user is in registration stage
if(isset($_REQUEST['academic']) && isset($_REQUEST['term'])  && isset($_REQUEST['school'])){
    
        $academic =$_REQUEST['academic'];
        $term =$_REQUEST['term'];
       $school = $_REQUEST['school'];
    $status = 'ACTIVE';

  
        //check if academic year input already exxist
     $sql = "select * from `academic_years` where `SCHOOL`='$initials' and `ACADEMIC YEAR`='$academic' and `TERM`='$term' and (`STATUS`='' or `STATUS`='ACTIVE')";
    $query = mysqli_query($conn,$sql);
    
    if(mysqli_num_rows($query) > 0){
        echo 'this found';
        
    }else{
        
          mysqli_query($conn,"INSERT INTO `academic_years` (`ID`, `SCHOOL`, `ACADEMIC YEAR`, `TERM`, `STATUS`) VALUES (NULL, '$initials','$academic', '$term','');");

                    echo mysqli_connect_error();
    
                    echo 'success';
        
    }
            
    }else{
        echo 'error';
    }
?>
