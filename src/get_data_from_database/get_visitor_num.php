<?php
include "src/get_data_from_database/get_walk_in.php";
include "src/get_data_from_database/get_reservation_info.php";
date_default_timezone_set('Asia/Manila');

$reservationNum = 0;
$walkinNum = 0;
$currentDate = date('Y-m-d');

foreach($arrayReservationInfo as $reservationInfo){
   if($reservationInfo['reservationStatus'] == 'Reserved' || $reservationInfo['reservationStatus'] == 'Playing' || $reservationInfo['reservationStatus'] == 'Done'){
      if($reservationInfo['reservationDate'] == $currentDate){
         $reservationNum = $reservationNum + 1;
      }
      else{
         $reservationNum = $reservationNum;
      }
     
   }
}
foreach($arrayWalkinDetails as $walkin){
   if($walkin['walkinStatus'] == 'Reserved' || $walkin['walkinStatus'] == 'Playing' || $walkin['walkinStatus'] == 'Done'){
      if($walkin['walkinDate'] == $currentDate){
         $walkinNum = $walkinNum + 1;
      }
      else{
         $walkinNum = $walkinNum;
      }
   }
}

//$reservationNum = sizeof($arrayReservationInfo);
//$walkinNum = sizeof($arrayWalkinDetails);
$totalVisitor = $reservationNum + $walkinNum;

?>
