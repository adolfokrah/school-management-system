<?php
    include 'school_ini_user_id.php';

    //redirect user to registration stage if user is in registration stage
    if( isset($_REQUEST['book_number']) && isset($_REQUEST['shelf_number'])){
        $book_number = $_REQUEST['book_number'];
        $shelf_number = $_REQUEST['shelf_number'];
        
        $date = date('Y-m-d');
         $time = new datetime('now',new DateTimeZone('Europe/London'));
        $current_time = $time->format('h:i a');
        
        
        $query_shelf = mysqli_query($conn,"select * from shelves where `SHELF NUMBER`='$shelf_number' and `SCHOOL`='$initials'");
                                
            if($fetch_shelf = mysqli_fetch_assoc($query_shelf)){
                $books_given = $fetch_shelf['BOOKS GIVEN']-1;
                $book_left = $fetch_shelf['BOOKS LEFT']+1;

                if($books_given < 1){
                    $books_given =0;
                }

                mysqli_query($conn,"update `shelves` set `BOOKS GIVEN`='$books_given',`BOOKS LEFT`='$book_left' where `SHELF NUMBER`='$shelf_number' and `SCHOOL`='$initials'");

                mysqli_query($conn,"update `library_books_status` set `DATE RETURNED`='$date',`TIME RETURNED`='$current_time' where `BOOK NUMBER`='$book_number' and `SCHOOL`='$initials'");
                
                mysqli_query($conn,"update `library_books` set `STATUS`='STORED' where `BOOK NUMBER`='$book_number' and `SCHOOL`='$initials'");

               echo 'success';
            }
        }
        
?>