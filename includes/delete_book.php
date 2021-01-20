<?php
    include 'school_ini_user_id.php';

    //redirect user to registration stage if user is in registration stage
    if( isset($_REQUEST['ids']) && isset($_REQUEST['shelfs'])){
        $ids = $_REQUEST['ids'];
        $shelf = $_REQUEST['shelfs'];
        $counter=0;
        foreach($ids as $id){
            mysqli_query($conn,"update library_books set `SHELF NUMBER`=''  where ID ='$id'");
            
            $query = mysqli_query($conn,"select * from shelves where `SCHOOL`='$initials' and `SHELF NUMBER`='".$shelf[$counter]."'");
            if($fetch_shelve = mysqli_fetch_assoc($query)){
                $total_books = $fetch_shelve['TOTAL BOOKS']-1;
                $books_left = $fetch_shelve['BOOKS LEFT']-1;
                if($total_books < 1){
                    $total_books = 0;
                }
                if($books_left < 1){
                    $books_left = 0;
                }
                mysqli_query($conn,"update shelves set `TOTAL BOOKS`='$total_books',`BOOKS LEFT`='$books_left' where `SCHOOL`='$initials' and `SHELF NUMBER`='".$shelf[$counter]."'");
            }
            $counter ++;
        }
        echo 'success';
        }
?>