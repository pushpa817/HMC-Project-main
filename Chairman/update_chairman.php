<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $chairman_id = htmlspecialchars($_POST['chairman_id']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $id = 'CH999999'; // Assuming you are updating the manager with ID 1


    try {
        // Update database with new image path
        $updateStmt = $conn->prepare("UPDATE Chairman SET chairman_name = :name, phone = :phone, email = :email, photo = :profile_image WHERE chairman_id = :id");
        $updateStmt->bindParam(':name', $name);
        $updateStmt->bindParam(':phone', $phone);
        $updateStmt->bindParam(':email', $email);
        $updateStmt->bindParam(':id', $chairman_id);
        $updateStmt->bindParam(':profile_image', $profileImagePath);

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
