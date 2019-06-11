<?php 
include '../inc/database.php';
include 'inc/fun.php'; 

$_SESSION['username'] = null;
$_SESSION['firstname'] = null;
$_SESSION['lastname'] = null;
$_SESSION['role'] = null;

$_SESSION['SuccessMessage'] = " This Use Has Been Log Out Successfuly";
Redirect("login");

?>