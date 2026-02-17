<?php
$servername = "localhost";
$username = "root"; // change if your username is different
$password = ""; // change if your password is different
$dbname = "HMC"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
