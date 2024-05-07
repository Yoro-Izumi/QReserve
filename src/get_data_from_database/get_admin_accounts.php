<?php
//get admin accounts with select query
//SELECT o.*, c.customer_name, p.product_name FROM orders o INNER JOIN customers c ON o.customer_id = c.id INNER JOIN products p ON o.product_id = p.id";

$getAdminAccountQuery = "SELECT ac.*,ai.*,sh.*,spa.* 
                        FROM admin_accounts ac
                        LEFT JOIN admin_info ai ON ac.adminInfoID = ai.adminInfoID
                        LEFT JOIN admin_shift sh ON ac.adminShiftID = sh.adminShiftID
                        LEFT JOIN super_admin spa ON ac.superAdminID = spa.superAdminID";
$adminAccountConn = mysqli_query($conn,$getAdminAccountQuery);
$arrayAdminAccount = array();
    while($onerowAC = mysqli_fetch_assoc($adminAccountConn)){
        // AC = Admin Account
        //one row of data at a time will be entered in array variable $arrayAdminInfo
        $arrayAdminAccount[] = $onerowAC;
    }

