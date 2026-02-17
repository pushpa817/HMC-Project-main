<?php
// logout_mess_manager.php
session_start();
unset($_SESSION['warden_id']);
unset($_SESSION['warden_name']);
unset($_SESSION['hall_id']);
header("Location: ../index.php"); 
exit;
?>
