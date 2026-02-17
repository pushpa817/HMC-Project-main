<?php
// logout_mess_manager.php
session_start();
unset($_SESSION['mess_manager_id']);
unset($_SESSION['mess_manager_name']);
header("Location: ../index.php"); 
exit;
?>
