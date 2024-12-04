<?php
session_start();
$db_host = "localhost";
$db_user = "root"; // Change this from $db_root to $db_user
$db_pass = "";
$db_name = "accounts";

// Establish connection
$connect = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check if connection failed
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
