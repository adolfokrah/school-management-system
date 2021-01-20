<?php
    include 'school_ini_user_id.php';
    
  
    if(isset($_REQUEST['category'])&&isset($_REQUEST['book_name']) &&isset($_REQUEST['Publisher']) &&isset($_REQUEST['shelf'])&&isset($_REQUEST['qty'])){ 
        $category = $_REQUEST['category'];
        $book_name = $_REQUEST['book_name'];
        $Publisher = $_REQUEST['Publisher'];
        $shelf = $_REQUEST['shelf'];
        $qty = $_REQUEST['qty'];
        
        for($x=1; $x<=$qty; $x++){
            $book_number = generate_book_number($initials,$conn);
             mysqli_query($conn,"INSERT INTO `library_books` (`ID`, `SCHOOL`, `BOOK NUMBER`, `BOOK NAME`, `SHELF NUMBER`, `PUBLISHER`, `CATEGORY`, `STATUS`) VALUES (NULL, '$initials', '$book_number', '".mysqli_real_escape_string($conn,$book_name)."', '$shelf', '$Publisher', '$category', 'STORED');");

            $query = mysqli_query($conn,"select * from shelves where `SCHOOL`='$initials' and `SHELF NUMBER`='$shelf'");
            if($fetch_shelve = mysqli_fetch_assoc($query)){
                $total_books = $fetch_shelve['TOTAL BOOKS']+1;
                $books_left  = $fetch_shelve['BOOKS LEFT']+1;
                mysqli_query($conn,"update shelves set `TOTAL BOOKS`='$total_books',`BOOKS LEFT`='$books_left' where `SCHOOL`='$initials' and `SHELF NUMBER`='$shelf'");
            }
        }
        echo 'success';
    }else{
        echo 'error';
    }


function generate_book_number($school_initial,$conn){
        $select_student_number = mysqli_query($conn,"select * from `library_books` where `SCHOOL`='$school_initial'");
        $number_rows = mysqli_num_rows($select_student_number);
        $number_rows ++;
        $number_rows = str_pad($number_rows,3,"0",STR_PAD_LEFT);

        $shelf_number = "BK".$number_rows;
        
        return $shelf_number;

    }
?>