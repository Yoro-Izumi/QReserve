<?php
//get customer information with select query
$getPoolTableInfoQuery = "SELECT * FROM pool_tables";
$poolTablesConn = mysqli_query($conn,$getPoolTableInfoQuery);
$arrayPoolTables = array();
    while($onerowPT = mysqli_fetch_assoc($poolTablesConn)){
        // PT = pool tables
        //one row of data at a time will be entered in array variable $arrayPoolTables
        $arrayPoolTables[] = $onerowPT;
    }
   // foreach($arraydata as $data){

?>