<?php
include 'encodeDecode.php';
//encryptData($data,$key); decryptData($data,$key);
$key = "TheGreatestNumberIs73";
session_start();
if (isset($_SESSION['userAdminID'])){
         session_destroy();
        unset($_SESSION['userAdminID']);
        header('location:index.php');
        die();
}
     else if(isset($_SESSION['userSuperAdminID'])){
      session_start();
      session_destroy();
        unset($_SESSION['userSuperAdmin']);
        header('location:index.php');
        die();
     }

   else if(isset($_SESSION['userMemberID'])){
      session_start();
      session_destroy();
    unset($_SESSION['userID']);
    header('location:customer_landing.php');
    die();

}

