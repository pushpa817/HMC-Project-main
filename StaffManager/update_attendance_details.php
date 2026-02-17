<?php
include 'connect.php';

$data = json_decode(file_get_contents('php://input'), true);

if (is_array($data)) {
    foreach ($data as $row) {
        $staff_id = $row['staff_id'];
        $attended_days = $row['attended_days'];

        $stmt = $conn->prepare("UPDATE Staff SET attended_days = :attended_days WHERE staff_id = :staff_id");
        $stmt->bindParam(':attended_days', $attended_days, PDO::PARAM_INT);
        $stmt->bindParam(':staff_id', $staff_id, PDO::PARAM_STR);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo "Failed to update staff ID {$staff_id}: " . $e->getMessage();
            exit;
        }
    }
    echo "Attendance updated successfully!";
} else {
    http_response_code(400);
    echo "Invalid data received.";
}
?>
