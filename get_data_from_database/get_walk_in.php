<?php
$getWalkinDetailsQuery =    "SELECT wi.*,pt.*,ci.*,ph.*,ac.*,sv.* 
                            FROM pool_table_walk_in wi
                            LEFT JOIN pool_tables pt ON wi.tableID = pt.poolTableID
                            LEFT JOIN customer_info ci ON wi.customerID = ci.customerID
                            LEFT JOIN payment_history ph ON wi.paymentID = ph.paymentID
                            LEFT JOIN admin_accounts ac ON wi.adminID = ac.adminID
                            LEFT JOIN services sv ON wi.serviceID = sv.serviceID";

$walkinDetailsConn = mysqli_query($conn,$getWalkinDetailsQuery);
$arrayWalkinDetails = array();
    while($onerowWI = mysqli_fetch_assoc($walkinDetailsConn)){
        // WI = Walk-in 
        //one row of data at a time will be entered in array variable $arrayWalkinDetails
        $arrayWalkinDetails[] = $onerowWI;
    }
