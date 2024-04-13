<?php
session_start();
include 'connect_database.php';
include 'encodeDecode.php';
include 'get_data_from_database/get_admin_accounts';
include 'get_data_from_database/get_super_admin_accounts';
include 'get_data_from_database/get_member_account';

//encryptData($data,$key); decryptData($data,$key);
$key = "TheGreatestNumberIs73";



if (isset($_SESSION['username'])){
	header('location:dashboard.html');
	die();
}
if (isset($_SESSION['adminUsername'])){
	header('location:dashboard.html');
	die();
}
if (isset($_SESSION['superAdminUsername'])){
	header('location:dashboard.html');
	die();
}
?>
<?php

	if(isset($_POST['login_admin'])){
      $adminUsername=mysqli_real_escape_string($conn,$_POST['username']);
      $adminPassword=mysqli_real_escape_string($conn,$_POST['password']);
			if(mysqli_num_rows($adminAccountConn) > 0){
				foreach($arrayAdminAccount as $adminAccount){
					if(decryptData($adminAccount['adminUsername'],$key) == $adminUsername){
						echo '<script language="javascript">';
                		echo 'alert("You are now logged in!")';
                		echo '</script>';
						$_SESSION['admin_username'] = $adminUsername;
						header("location:dashboard.html");

				}
					else{
						echo '<script language="javascript">';
                		echo 'alert("Username and Password does not exist")';
                		echo '</script>';
					}
				}
			}
	}
	if(isset($_POST['login_super_admin'])){
		$superAdminUsername=mysqli_real_escape_string($conn,$_POST['username']);
		$superAdminPassword=mysqli_real_escape_string($conn,$_POST['password']);
			  if(mysqli_num_rows($superAdminAccountConn) > 0){
				  foreach($arraySuperAdminAccount as $superAdminAccount){
					  if(decryptData($superAdminAccount['superAdminUsername'],$key) == $superAdminUsername){
						  echo '<script language="javascript">';
						  echo 'alert("You are now logged in!")';
						  echo '</script>';
						  $_SESSION['super_admin_username'] = $superAdminUsername;
						  header("location:dashboard.html");
  
				  }
					  else{
						  echo '<script language="javascript">';
						  echo 'alert("Username and Password does not exist")';
						  echo '</script>';
					  }
				  }
			  }
	  }
	  if(isset($_POST['login_member'])){
		$username=mysqli_real_escape_string($conn,$_POST['username']);
		$password=mysqli_real_escape_string($conn,$_POST['password']);
			  if(mysqli_num_rows($memberAccountConn) > 0){
				  foreach($arrayMemberAccount as $membershipAccount){
					  if(decryptData($membershipAccount['membershipID'],$key) == $username){
						  echo '<script language="javascript">';
						  echo 'alert("You are now logged in!")';
						  echo '</script>';
						  $_SESSION['username'] = $username;
						  header("location:dashboard.html");
  
				  }
					  else{
						  echo '<script language="javascript">';
						  echo 'alert("Username and Password does not exist")';
						  echo '</script>';
					  }
				  }
			  }
	  }

?>