<?php
//get customer information with select query
$getPaymentHistoryQuery = "SELECT * FROM payment_history";
$paymentHistoryConn = mysqli_query($conn,$getPaymentHistoryQuery);
$arrayPaymentHistory = array();
    while($onerowPH  = mysqli_fetch_assoc($paymentHistoryConn)){
        // PH = Payment History
        //one row of data at a time will be entered in array variable $arrayPaymentHistory
        $arrayPaymentHistory[] = $onerowPH;
    }
   // foreach($arraydata as $data){

?>