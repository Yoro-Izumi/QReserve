<?php
//get customer information with select query
$getReservationInfoQuery = "SELECT ri.*, pt.*, mb.*, ph.*, sc.*, sv.* 
                            FROM pool_table_reservation ri
                            LEFT JOIN pool_tables pt ON ri.tableID = pt.poolTableID
                            LEFT JOIN member_details mb ON ri.memberID = mb.memberID
                            LEFT JOIN payment_history ph ON ri.paymentID = ph.paymentID
                            LEFT JOIN super_admin sc ON ri.superAdminID = sc.superAdminID
                            LEFT JOIN services sv ON ri.serviceID = sv.serviceID";

$reservationInfoConn = mysqli_query($conn,$getReservationInfoQuery);
$arrayReservationInfo = array();
    while($onerowRI = mysqli_fetch_assoc($reservationInfoConn)){
        // RI = Reservation Info
        //one row of data at a time will be entered in array variable $arrayReservationInfo
        $arrayReservationInfo[] = $onerowRI;
    }
   // foreach($arraydata as $data){

?>