<?php
//get customer information with select query
$getPaymentHistoryQuery =   "SELECT ph.*,ci.* FROM payment_history ph
                            LEFT JOIN customer_info ci ON ph.customerID = ci.customerID ";
$paymentHistoryConn = mysqli_query($conn,$getPaymentHistoryQuery);
$arrayPaymentHistory = array();
    while($onerowPH  = mysqli_fetch_assoc($paymentHistoryConn)){
        // PH = Payment History
        //one row of data at a time will be entered in array variable $arrayPaymentHistory
        $arrayPaymentHistory[] = $onerowPH;
    }
   // foreach($arraydata as $data){
/*"SELECT ac.*,ai.*,sh.* 
FROM admin_accounts ac
INNER JOIN admin_info ai ON ac.adminInfoID = ai.adminInfoID
INNER JOIN admin_shift sh ON ac.adminShiftID = sh.adminShiftID" */
?>