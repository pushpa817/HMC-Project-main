<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['chairman_id'])) {
    // User is not logged in, redirect to login page
    header("Location: ../index.php");
    exit;
}
?>
