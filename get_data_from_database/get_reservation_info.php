<?php
//get customer information with select query
$getReservationInfoQuery = "SELECT * FROM pool_table_reservation";
$reservationInfoConn = mysqli_query($conn,$getReservationInfoInfoQuery);
$arrayReservationInfo = array();
    while($onerowRI = mysqli_fetch_assoc($reservationInfoConn)){
        // RI = Reservation Info
        //one row of data at a time will be entered in array variable $arrayReservationInfo
        $arrayReservationInfo[] = $onerowRI;
    }
   // foreach($arraydata as $data){

?>