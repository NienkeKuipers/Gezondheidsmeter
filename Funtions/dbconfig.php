<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "gezondheidsmeter";

// Create connection
$db_connection = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$db_connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
