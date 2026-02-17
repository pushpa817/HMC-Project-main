<?php
include 'connect.php'; // Include your database connection

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $tableId = $data['tableId'];
    $updates = $data['data'];

    foreach ($updates as $update) {
        $stmt = $conn->prepare("UPDATE MessMenu SET breakfast = :breakfast, lunch = :lunch, dinner = :dinner WHERE day_of_week = :day AND type = :type");
        $stmt->bindParam(':breakfast', $update['breakfast']);
        $stmt->bindParam(':lunch', $update['lunch']);
        $stmt->bindParam(':dinner', $update['dinner']);
        $stmt->bindParam(':day', $update['day']);
        $type = ($tableId === 'vegetarian-table') ? 'vegetarian' : 'non-vegetarian';
        $stmt->bindParam(':type', $type);
        $stmt->execute();
    }

    echo json_encode(['message' => 'Changes saved successfully!']);
} else {
    echo json_encode(['message' => 'Failed to receive data']);
}
