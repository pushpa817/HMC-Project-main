<?php
session_start();
require 'database.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $newPassword = $data['newPassword'];
    
    // Retrieve user ID and type from the session
    $username = $_SESSION['user_id']; // Assuming user ID is stored in the session
    $user_type = $_SESSION['user_type']; // Assuming user type is also stored in the session

    // Set the table based on user type
    switch ($user_type) {
        case 'student':
            $table = 'StudentPersonalDetails';
            $id_field = 'student_id';
            break;
        case 'warden':
            $table = 'Wardens';
            $id_field = 'warden_id';
            break;
        case 'mess_manager':
            $table = 'MessManager';
            $id_field = 'mess_manager_id';
            break;
        case 'chairman':
            $table = 'Chairman';
            $id_field = 'chairman_id';
            break;
        case 'staff_manager':
            $table = 'StaffManager';
            $id_field = 'staff_manager_id';
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid user type']);
            exit;
    }

    // Update the password in the database
    $query = $conn->prepare("UPDATE $table SET password = ? WHERE $id_field = ?");
    $query->bind_param("ss", $newPassword, $username);
    
    if ($query->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Password reset successfully. Please log in again.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to reset password.']);
    }
}
?>
