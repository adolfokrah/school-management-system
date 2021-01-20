<?php

    //PICK SCHOOL COUNTYR CURRENCY FROM DB
    $currency = 'GHS';
    $query_pick_currency = mysqli_query($conn,"select * from school_details where `INITIALS`='$initials'");
    if($fetch_school = mysqli_fetch_assoc($query_pick_currency)){
        $country = $fetch_school['COUNTRY'];
        $query_pick = mysqli_query($conn,"select * from currencies where `COUNTRY`='$country'");
        if($fetch_currency = mysqli_fetch_assoc($query_pick)){
            $currency = $fetch_currency['CURRENCY'];
        }
    }
?>