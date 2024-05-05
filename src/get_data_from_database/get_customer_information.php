<?php
//get customer information with select query
$getCustomerInformationQuery = "SELECT * FROM customer_info";
$customerInformationConn = mysqli_query($conn,$getCustomerInformationQuery); //execute query
$arrayCustomerInformation = array();
    while($onerowCI = mysqli_fetch_assoc($customerInformationConn)){
        // CI = Customer Information
        //one row of data at a time will be entered in array variable $arrayCustomerInformation
        $arrayCustomerInformation[] = $onerowCI;
    }
   // foreach($arraydata as $data){

?>