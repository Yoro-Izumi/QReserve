<?php
$getWalkinDetailsQuery = "SELECT * FROM pool_table_walk_in";
$walkinDetailsConn = mysqli_query($conn,$getWalkinDetailsQuery);
$arrayWalkinDetails = array();
    while($onerowWI = mysqli_fetch_assoc($walkinDetailsConn)){
        // WI = Walk-in
        //one row of data at a time will be entered in array variable $arrayWalkinDetails
        $arrayWalkinDetails[] = $onerowWI;
    }
