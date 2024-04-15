<?php
//get super admin accounts with select query
$getSuperAdminAccountQuery = "SELECT * FROM super_admin";
$superAdminAccountConn = mysqli_query($conn,$getSuperAdminAccountQuery);
$arraySuperAdminAccount = array();
    while($onerowSPA = mysqli_fetch_assoc($superAdminAccountConn)){
        // SP = Super Admin
        //one row of data at a time will be entered in array variable $arraySuperAdminAccount
        $arraySuperAdminAccount[] = $onerowSPA;
    }
   // foreach($arraydata as $data){

?>