<?php
//get customer information with select query
$getTableHoursInfoQuery = "SELECT * FROM hour_price";
$tableHoursConn = mysqli_query($conn,$getTableHoursInfoQuery);
$arrayTableHours = array();
    while($onerowTH = mysqli_fetch_assoc($tableHoursConn)){
        // TH = table hours
        //one row of data at a time will be entered in array variable $arrayTableHours
        $arrayTableHours[] = $onerowTH;
    }
