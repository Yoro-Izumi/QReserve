<?php
//get member account details with select query
$getMemberAccountQuery = "SELECT * FROM member_details";
$memberAccountConn = mysqli_query($conn,$getMemberAccountQuery);
$arrayMemberAccount = array();
    while($onerowMB = mysqli_fetch_assoc($memberAcountConn)){
        // MB = Member Account
        //one row of data at a time will be entered in array variable $arrayMemberAccount
        $arrayMemberAccount[] = $onerowMB;
    }
   // foreach($arraydata as $data){

?>