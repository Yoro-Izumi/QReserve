<?php
//get admin information with select query
$getAdminInfoQuery = "SELECT * FROM admin_info";
$adminInfoConn = mysqli_query($conn,$getAdminInfoQuery);
$arrayAdminInfo = array();
    while($onerowAI = mysqli_fetch_assoc($adminInfoConn)){
        // AI = Admin Info
        //one row of data at a time will be entered in array variable $arrayAdminInfo
        $arrayAdminInfo[] = $onerowAI;
    }
   // foreach($arraydata as $data){

?>