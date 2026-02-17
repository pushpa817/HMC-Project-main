<?php
include 'check_log.php'; // User login check
include 'database.php'; // Database connection

$student_id = $_SESSION['student_id'];
$hall_id = $_POST['hall_id'] ?? null;
$complaint_type = $_POST['complaint_type'] ?? '';
$description = $_POST['description'] ?? '';
$date_raised = date("Y-m-d"); // Current date

$response = ["message" => "", "type" => ""];

// Insert complaint into the database
$sql = "INSERT INTO Complaints (student_id, hall_id, complaint_type, description, date_raised) 
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sisss", $student_id, $hall_id, $complaint_type, $description, $date_raised);

if ($stmt->execute()) {
    $response["message"] = "Complaint registered successfully.";
    $response["type"] = "success";
} else {
    $response["message"] = "Error registering complaint: " . $stmt->error;
    $response["type"] = "error";
}

$stmt->close();
$conn->close();

echo json_encode($response); // Send JSON response
?>
