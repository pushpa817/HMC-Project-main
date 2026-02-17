<?php
session_start();
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_type = $_POST['user_type'];
    $user_id = $_POST['userID'];
    $password = $_POST['password'];

    // Set the table and ID field based on user type
    switch ($user_type) {
        case 'student':
            $table = 'StudentPersonalDetails';
            $id_field = 'student_id';
            $name_field = 'student_name';
            $session_prefix = 'student';
            break;
        case 'warden':
            $table = 'Wardens';
            $id_field = 'warden_id';
            $name_field = 'warden_name';
            $session_prefix = 'warden';
            break;
        case 'mess_manager':
            $table = 'MessManager';
            $id_field = 'mess_manager_id';
            $name_field = 'mess_manager_name';
            $session_prefix = 'mess_manager';
            break;
        case 'chairman':
            $table = 'Chairman';
            $id_field = 'chairman_id';
            $name_field = 'chairman_name';
            $session_prefix = 'chairman';
            break;
        case 'staff_manager':
            $table = 'StaffManager';
            $id_field = 'staff_manager_id';
            $name_field = 'staff_manager_name';
            $session_prefix = 'staff_manager';
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Select your role']);
            exit;
    }

    // Prepare SQL query to check if the user ID exists
    $query = $conn->prepare("SELECT * FROM $table WHERE $id_field = ?");
    $query->bind_param("s", $user_id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 0) {
        // User ID does not exist
        echo json_encode(['status' => 'error', 'message' => 'Invalid User ID']);
        exit;
    }

    // User ID exists, now check the password
    $user = $result->fetch_assoc();
    if ($user['password'] === $password) {
        // Set role-specific session data
        $_SESSION[$session_prefix . '_id'] = $user_id;
        $_SESSION[$session_prefix . '_name'] = $user[$name_field];

        if ($user_type === 'student') {
            $_SESSION[$session_prefix . '_gender'] = $user['gender'];
        }

        // Role-based redirect
        switch ($user_type) {
            case 'student':
                $redirect = 'Student/dashboard.php';
                break;
            case 'warden':
                $redirect = 'Warden/dashboard.php';
                break;
            case 'mess_manager':
                $redirect = 'MessManager/dashboard.php';
                break;
            case 'chairman':
                $redirect = 'Chairman/dashboard.php';
                break;
            case 'staff_manager':
                $redirect = 'StaffManager/dashboard.php';
                break;
            default:
                $redirect = 'index.php'; // Default redirect
        }

        echo json_encode(['status' => 'success', 'redirect' => $redirect]);
    } else {
        // Invalid password
        echo json_encode(['status' => 'error', 'message' => 'Invalid Password']);
    }
}
