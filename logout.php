<?php
include 'encodeDecode.php';
//encryptData($data,$key); decryptData($data,$key);
$key = "TheGreatestNumberIs73";

session_start();
session_destroy();
unset($_SESSION['userID']);
header("location:customer_login.php");
