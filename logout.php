<?php
include 'encodeDecode.php';
//encryptData($data,$key); decryptData($data,$key);
$key = "TheGreatestNumberIs73";

session_start();
session_destroy();

if (isset($_SESSION['userAdminID'])){
     if($userID[1] == 1){
        unset($_SESSION['userAdminID']);
        header('location:index.php');
        die();
     }
}
     else if(isset($_SESSION['userAdminID'])){
        unset($_SESSION['userSuperAdmin']);
        header('location:index.php');
        die();
     }

   else if(isset($_SESSION['userMemberID'])){
    unset($_SESSION['userID']);
    header('location:customer_landing.php');
    die();

}

