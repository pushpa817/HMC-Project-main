<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $code = $data['code'];

    // Check if the verification code matches the one stored in the session
    if (isset($_SESSION['verification_code']) && $code == $_SESSION['verification_code']) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid verification code.']);
    }
}
?>
