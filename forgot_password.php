<?php
session_start();
require 'database.php'; // Include your database connection
require 'vendor/autoload.php'; // Include Composer's autoloader if using Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents("php://input"), true);
    $username = $data['username'];
    $userType = $data['user_type'];

    // Sanitize user input
    $username = htmlspecialchars(strip_tags($username));
    $userType = htmlspecialchars(strip_tags($userType));

    // Define table name based on user type
    $tableName = '';
    switch ($userType) {
        case 'student':
            $tableName = 'StudentPersonalDetails';
            break;
        case 'warden':
            $tableName = 'Wardens';
            break;
        case 'mess_manager':
            $tableName = 'MessManager';
            break;
        case 'chairman':
            $tableName = 'Chairman';
            break;
        case 'staff_manager':
            $tableName = 'StaffManager';
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Select your role!']);
            exit;
    }

    // Prepare query based on user type
    $query = $conn->prepare("SELECT * FROM $tableName WHERE {$userType}_id = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $email = $userType === 'student' ? $user['college_email'] : $user['email'];

        // Generate a random verification code
        $verificationCode = rand(100000, 999999); // 6-digit code
        $_SESSION['verification_code'] = $verificationCode;

        $_SESSION['user_id'] = $username;
        $_SESSION['user_type'] = $userType;

        // Send verification code
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'vc319122004@gmail.com'; 
            $mail->Password = 'mqnt ilaz djhj tzlk';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('no-reply@yourdomain.com', 'HMC');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Verification Code';
            $mail->Body    = "Your verification code is: <strong>$verificationCode</strong>";

            $mail->send();
            echo json_encode(['status' => 'success', 'message' => 'Verification code sent to your registered email.']);
        } catch (Exception $e) {
            error_log('Mail error: ' . $mail->ErrorInfo); // Log the error
            echo json_encode(['status' => 'error', 'message' => 'Failed to send verification code.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found.']);
    }
}
?>
