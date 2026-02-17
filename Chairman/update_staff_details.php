<?php
include 'connect.php'; // Connect to the database

// Get the JSON data from the POST request
$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data)) {
    foreach ($data as $entry) {
        $staff_id = $entry['staff_id'];
        $staff_name=$entry['staff_name'];
        $hall_id = $entry['hall_id'];
        $role = $entry['role'];
        $daily_pay = $entry['daily_pay'];
        $phone=$entry['phone'];

        // Update the database with the new bill amount
        $stmt = $conn->prepare("UPDATE Staff SET daily_pay = :daily_pay WHERE staff_id = :staff_id AND staff_name=:staff_name AND hall_id = :hall_id AND role=:role AND phone=:phone");
        $stmt->bindParam(':daily_pay', $daily_pay, PDO::PARAM_INT);
        $stmt->bindParam(':staff_id', $staff_id, PDO::PARAM_STR);
        $stmt->bindParam(':staff_name', $staff_name, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindParam(':hall_id', $hall_id, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_INT);

        $stmt->execute();
    }
    echo "Staff details updated successfully!";
} else {
    echo "No data received.";
}
?>
