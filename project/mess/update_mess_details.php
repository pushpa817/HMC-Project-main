<?php
include 'connect.php'; // Connect to the database

// Get the JSON data from the POST request
$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data)) {
    foreach ($data as $entry) {
        $student_id = $entry['student_id'];
        $hall_id = $entry['hall_id'];
        $mess_type = $entry['mess_type'];
        $mess_bill = $entry['mess_bill'];

        // Update the database with the new bill amount
        $stmt = $conn->prepare("UPDATE StudentHallDetails SET mess_bill = :mess_bill WHERE student_id = :student_id AND hall_id = :hall_id");
        $stmt->bindParam(':mess_bill', $mess_bill, PDO::PARAM_INT);
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_STR);
        $stmt->bindParam(':hall_id', $hall_id, PDO::PARAM_STR);

        $stmt->execute();
    }
    echo "Mess details updated successfully!";
} else {
    echo "No data received.";
}
?>
