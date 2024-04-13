<?php
//get admin accounts with select query
$getAdminAccountQuery = "SELECT * FROM admin_accounts";
$adminAccountConn = mysqli_query($conn,$getAdminAccountQuery);
$arrayAdminAccount = array();
    while($onerowAC = mysqli_fetch_assoc($adminAcountConn)){
        // AC = Admin Account
        //one row of data at a time will be entered in array variable $arrayAdminInfo
        $arrayAdminAccount[] = $onerowAC;
    }
