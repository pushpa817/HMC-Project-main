<?php
// Database connection variables
$server = "localhost";     // Database host
$dbname = "HMC";  // Database name
$username = "root";      // Database username
$password = "";          // Database password

try {
    // Create a new PDO instance and set error mode to exception
    $conn = new PDO("mysql:host=$server;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

