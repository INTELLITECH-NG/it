<?php
$servername = "localhost";
$username = "intellit1_db";
$password = "jyMmb==u7+s8";
$database = "intellit1_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

$connDB = mysqli_select_db($conn,'intellitech');
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
