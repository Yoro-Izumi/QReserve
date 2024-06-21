<?php
// get_reservation_info.php
function getReservations() {
    include "connect_database.php";
    include "src/get_data_from_database/get_reservation_info.php";
    include "src/get_data_from_database/get_walk_in.php";

    $reservations = [];

  foreach($arrayReservationInfo as $reservation){
    array_push($reservations,$reservation['reservationTimeStart']);
  }
  foreach($arrayWalkinDetails as $walkin){
    array_push($reservations,$walkin['walkinTimeStart']);
  }

  /*  $query = "SELECT reservationTimeStart FROM pool_table_reservation";
    $result = $conn->query($query);

    $reservations = [];
    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row['reservation_time'];

        $a=array("a"=>"red","b"=>"green");
        array_push($a,"blue","yellow");
        print_r($a);
    */

    return $reservations;
}

?>