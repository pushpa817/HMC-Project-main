<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $id = $_SESSION['staff_manager_id'];
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);

       try {
        // Update database with new image path
        $updateStmt = $conn->prepare("UPDATE StaffManager SET staff_manager_name = :name, phone = :phone, email = :email WHERE staff_manager_id = :id");
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
