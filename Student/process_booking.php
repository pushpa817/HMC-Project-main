<?php
include 'check_log.php'; 
include 'database.php'; 

$student_id = $_POST['student_id'];
$hall_id = isset($_POST['hall_id']) ? (int)$_POST['hall_id'] : null;
$room_type = $_POST['room_type'];
$room_number = isset($_POST['room_number']) ? (int)$_POST['room_number'] : null;
$mess_type = $_POST['mess_type'];
$room_cost = 0; 
$mess_cost = 0;

$response = [];

try {
    // Start transaction
    $conn->begin_transaction();

    // Check if student already has a booking
    $checkBookingQuery = "SELECT * FROM StudentHallDetails WHERE student_id = ?";
    $stmt = $conn->prepare($checkBookingQuery);
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $existingBooking = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($existingBooking) {
        throw new Exception("You already have a room booked.");
    }

    if ($room_type === 'Single') {
        // Check if the selected single room is available
        $checkRoomQuery = "SELECT student_count FROM Rooms WHERE hall_id = ? AND room_number = ? AND room_type = 'Single'";
        $stmt = $conn->prepare($checkRoomQuery);
        $stmt->bind_param("ii", $hall_id, $room_number);
        $stmt->execute();
        $stmt->bind_result($student_count);
        $stmt->fetch();
        $stmt->close();

        if ($student_count > 0) {
            throw new Exception("Selected room is not available. Please try a different room.");
        }

        // Update the Rooms table to mark room as occupied
        $updateRoomQuery = "UPDATE Rooms SET student_count = 1 WHERE hall_id = ? AND room_number = ?";
        $stmt = $conn->prepare($updateRoomQuery);
        $stmt->bind_param("ii", $hall_id, $room_number);
        if (!$stmt->execute()) {
            throw new Exception("Error updating Rooms table: " . $stmt->error);
        }
        $stmt->close();

    } elseif ($room_type === 'Twin Sharing') {
        // Try to find a twin-sharing room with student_count = 1
        $findTwinRoomQuery = "SELECT room_number FROM Rooms WHERE hall_id = ? AND room_type = 'Twin Sharing' AND student_count = 1 LIMIT 1";
        $stmt = $conn->prepare($findTwinRoomQuery);
        $stmt->bind_param("i", $hall_id);
        $stmt->execute();
        $stmt->bind_result($room_number);
        $stmt->fetch();
        $stmt->close();

        // If no room with student_count = 1, find a room with student_count = 0
        if (!$room_number) {
            $findTwinRoomQuery = "SELECT room_number FROM Rooms WHERE hall_id = ? AND room_type = 'Twin Sharing' AND student_count = 0 LIMIT 1";
            $stmt = $conn->prepare($findTwinRoomQuery);
            $stmt->bind_param("i", $hall_id);
            $stmt->execute();
            $stmt->bind_result($room_number);
            $stmt->fetch();
            $stmt->close();
        }

        // If still no room is available, return an error
        if (!$room_number) {
            throw new Exception("No twin-sharing rooms available in the selected hall.");
        }

        // Update the Rooms table to increment the student count
        $updateRoomQuery = "UPDATE Rooms SET student_count = student_count + 1 WHERE hall_id = ? AND room_number = ?";
        $stmt = $conn->prepare($updateRoomQuery);
        $stmt->bind_param("ii", $hall_id, $room_number);
        if (!$stmt->execute()) {
            throw new Exception("Error updating Rooms table: " . $stmt->error);
        }
        $stmt->close();
    }

    // Insert booking details into StudentHallDetails with zero room and mess costs
    $insertBookingQuery = "INSERT INTO StudentHallDetails (student_id, hall_id, room_number, mess_type, room_bill, mess_bill) 
                           VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertBookingQuery);
    $stmt->bind_param("siisdd", $student_id, $hall_id, $room_number, $mess_type, $room_cost, $mess_cost);
    if (!$stmt->execute()) {
        throw new Exception("Error inserting into StudentHallDetails: " . $stmt->error);
    }
    $stmt->close();

    // Commit transaction
    $conn->commit();

    // Success response
    $response['message'] = "Room booking confirmed!";
    $response['success'] = true;

} catch (Exception $e) {
    // Rollback transaction if any error occurs
    $conn->rollback();
    $response['message'] = $e->getMessage();
    $response['success'] = false;
}

// Return JSON response
echo json_encode($response);
?>
