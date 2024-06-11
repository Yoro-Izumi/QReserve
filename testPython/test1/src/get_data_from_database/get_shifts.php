<?php
//get all shift with select query
$getShiftsQuery = "SELECT * FROM admin_shift";
$shiftsConn = mysqli_query($conn,$getShiftsQuery); //execute query
$arrayShifts = array();
    while($onerowSH = mysqli_fetch_assoc($shiftsConn)){
        // SH = Shift
        //one row of data at a time will be entered in array variable $arrayShifts
        $arrayShifts[] = $onerowSH;
    }
   // foreach($arraydata as $data){

?>