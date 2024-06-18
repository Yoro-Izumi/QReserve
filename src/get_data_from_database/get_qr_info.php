<?php
//get customer information with select query
$getQrInfoQuery = "SELECT * FROM qr_code";

$qrInfoConn = mysqli_query($conn,$getQrInfoQuery);
$arrayQrInfo = array();
    while($onerowQR = mysqli_fetch_assoc($qrInfoConn)){
        // RI = Reservation Info
        //one row of data at a time will be entered in array variable $arrayReservationInfo
        $arrayQrInfo[] = $onerowQR;
    }
   // foreach($arraydata as $data){

?>