<?php
include 'connect.php'; // Connect to the database

// Get the JSON data from the POST request
$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data)) {
    foreach ($data as $entry) {
        $student_id = $entry['student_id'];
        $hall_id = $entry['hall_id'];
        $room_number=$entry['room_number'];
        $room_type = $entry['room_type'];
        $mess_bill = $entry['room_bill'];

        // Update the database with the new bill amount
        $stmt = $conn->prepare("UPDATE StudentHallDetails SET room_bill = :room_bill WHERE student_id = :student_id AND hall_id = :hall_id AND room_number=:room_number");
        $stmt->bindParam(':room_bill', $room_bill, PDO::PARAM_INT);
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_STR);
        $stmt->bindParam(':hall_id', $hall_id, PDO::PARAM_STR);
        $stmt->bindParam(':room_number', $room_number, PDO::PARAM_INT);
        $stmt->execute();
    }
    echo "Room details updated successfully!";
} else {
    echo "No data received.";
}
?>
