<?php
include 'connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
  
    $id = $_SESSION['warden_id'];

    try {
       
        $query = "
            UPDATE Wardens 
            SET 
                warden_name = :name, 
                phone = :phone, 
                email = :email
            WHERE 
                warden_id = :id
        ";
        
        $updateStmt = $conn->prepare($query);
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
