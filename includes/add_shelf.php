<?php
    include 'school_ini_user_id.php';
    
  
    if(isset($_REQUEST['categories'])){ 
        $categories = $_REQUEST['categories'];
        $shelf_number = generate_student_id($initials,$conn);
         mysqli_query($conn,"INSERT INTO `shelves` (`ID`, `SCHOOL`, `SHELF NUMBER`, `TOTAL BOOKS`, `BOOKS CATEGORIES`, `BOOKS LEFT`, `BOOKS GIVEN`) VALUES (NULL, '$initials', '$shelf_number', '0', '".mysqli_real_escape_string($conn,$categories)."', '0', '0'); ");
        echo 'success';
    }else{
        echo 'error';
    }


function generate_student_id($school_initial,$conn){
        $select_student_number = mysqli_query($conn,"select * from `shelves` where `SCHOOL`='$school_initial'");
        $number_rows = mysqli_num_rows($select_student_number);
        $number_rows ++;
        $number_rows = str_pad($number_rows,3,"0",STR_PAD_LEFT);

        $shelf_number = "SH".$number_rows;
        
        return $shelf_number;

    }
?>