<?php
    $categories = array();
    //redirect user to registration stage if user is in registration stage
//pick shelf cat
    $query = mysqli_query($conn,"select * from shelves where `SHELF NUMBER`='$shelf' and `SCHOOL`='$initials'");
    if($fetch=mysqli_fetch_assoc($query)){
        $categories = explode(',', $fetch['BOOKS CATEGORIES']);
        
    }

?>
