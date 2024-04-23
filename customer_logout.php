<?php
include 'encodeDecode.php';
//encryptData($data,$key); decryptData($data,$key);
$key = "TheGreatestNumberIs73";
session_start();
   if(isset($_SESSION['userMemberID'])){
      session_destroy();
    unset($_SESSION['userMemberID']);
    header('location:customer_landing.php');
    die();

}
