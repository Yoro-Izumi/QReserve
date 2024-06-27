<?php
//get all services with select query
$getServicesQuery = "SELECT sv.*,spa.*
                    FROM services sv
                    LEFT JOIN super_admin spa ON sv.superAdminID = spa.superAdminID";

$servicesConn = mysqli_query($conn,$getServicesQuery); //execute query
$arrayServices = array();
while($onerowSV = mysqli_fetch_assoc($servicesConn)){
    // SV = Services
    //one row of data at a time will be entered in array variable $arrayServices
    $arrayServices[] = $onerowSV;
}
// foreach($arraydata as $data){


