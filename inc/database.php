<?php
// $servername = "localhost";
// $username = "intellitech";
// $password = "intellitech";
// $database = "intellitech";

// // Create connection
// $conn = mysqli_connect($servername, $username, $password, $database);

// $connDB = mysqli_select_db($conn,'intellitech');
// // Check connection
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }

$servername = "localhost";
$username = "bitgtwnt_inter";
$password = "Kt8T]roE6[+q";
$database = "bitgtwnt_inter";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

$connDB = mysqli_select_db($conn, 'intellitech');
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
