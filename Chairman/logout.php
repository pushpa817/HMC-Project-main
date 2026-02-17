<?php
// logout_mess_manager.php
session_start();
unset($_SESSION['chairman_id']);
unset($_SESSION['chairman_name']);
header("Location: ../index.php"); 
exit;
?>
