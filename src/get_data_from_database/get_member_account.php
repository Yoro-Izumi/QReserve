<?php
//get member account details with select query
$getMemberAccountQuery =    "SELECT mb.*, ci.*,spa.*
                             FROM member_details mb 
                             LEFT JOIN customer_info ci ON mb.customerID = ci.customerID
                             LEFT JOIN super_admin spa ON mb.superAdminID = spa.superAdminID";
$memberAccountConn = mysqli_query($conn,$getMemberAccountQuery);
$arrayMemberAccount = array();
    while($onerowMB = mysqli_fetch_assoc($memberAccountConn)){
        // MB = Member Account
        //one row of data at a time will be entered in array variable $arrayMemberAccount
        $arrayMemberAccount[] = $onerowMB;
    }
   // foreach($arraydata as $data){

?>