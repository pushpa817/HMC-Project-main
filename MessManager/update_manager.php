<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $id = $_SESSION['mess_manager_id'];

    try {
        // Update database with new image path
        $updateStmt = $conn->prepare("UPDATE MessManager SET mess_manager_name = :name, phone = :phone, email = :email WHERE mess_manager_id = :id");
        $updateStmt->bindParam(':name', $name);
        $updateStmt->bindParam(':phone', $phone);
        $updateStmt->bindParam(':email', $email);
        $updateStmt->bindParam(':id', $id);

        $updateStmt->execute();

        echo "<script>
                alert('Details updated successfully.');
                window.location.href = 'dashboard.php'; 
              </script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error updating details: " . $e->getMessage() . "');</script>";
    }
}
?>
