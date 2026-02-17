<?php
include 'connect.php'; // Ensure this connects to the database correctly
// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['complaint_id']) && isset($data['response'])) {
    $complaint_id = $data['complaint_id'];
    $response = $data['response'];
    $current_date = date('Y-m-d'); // Set current date for date_resolved

    try {
        // Prepare the update statement
        $stmt = $conn->prepare("UPDATE Complaints SET ATR = :response, status = 'Resolved', date_resolved = :date_resolved WHERE complaint_id = :complaint_id");
        $stmt->bindParam(':response', $response);
        $stmt->bindParam(':date_resolved', $current_date);
        $stmt->bindParam(':complaint_id', $complaint_id);

        // Execute the update query
        if ($stmt->execute()) {
            echo "Complaint updated successfully!";
        } else {
            echo "Failed to update the complaint.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid input.";
}
?>
