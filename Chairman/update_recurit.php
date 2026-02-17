<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $staff_id = htmlspecialchars($_POST['mess']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $id = 1; // Assuming you are updating the manager with ID 1

    // Image upload logic
    $uploadDir = 'uploads/'; // Ensure this directory exists and is writable
    $profileImagePath = $manager['photo']; // Keep the old image path if no new image is uploaded

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $imageName = basename($_FILES['profile_image']['name']);
        $targetFilePath = $uploadDir . $imageName;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Validate file type
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowedTypes)) {
            // Attempt to move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFilePath)) {
                $profileImagePath = $targetFilePath; // Update the path if upload is successful
            } else {
                echo "<script>alert('Failed to upload image.');</script>";
            }
        } else {
            echo "<script>alert('Only JPG, JPEG, PNG, and GIF files are allowed.');</script>";
        }
    }

    try {
        // Update database with new image path
        $updateStmt = $conn->prepare("UPDATE MessManager SET mess_manager_name = :name, mess = :mess, phone = :phone, email = :email, photo = :profile_image WHERE mess_manager_id = :id");
        $updateStmt->bindParam(':name', $name);
        $updateStmt->bindParam(':mess', $mess);
        $updateStmt->bindParam(':phone', $phone);
        $updateStmt->bindParam(':email', $email);
        $updateStmt->bindParam(':id', $id);
        $updateStmt->bindParam(':profile_image', $profileImagePath);

        $updateStmt->execute();

        echo "<script>
                alert('Details updated successfully.');
                window.location.href = 'recurit_staff.php'; 
              </script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error updating details: " . $e->getMessage() . "');</script>";
    }
}
?>
