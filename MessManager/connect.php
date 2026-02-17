<?php
// Database connection variables
$host = "localhost";     // Database host
$dbname = "HMC";  // Database name
$username = "root";      // Database username
$password = "";          // Database password

try {
    // Create a new PDO instance and set error mode to exception
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

