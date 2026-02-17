<?php
include 'database.php';  // Database connection

$response = '';
$student_id = $_POST['student_id'];
$hall_id = (int)$_POST['hall_id'];
$amenity_id = (int)$_POST['amenity_id'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$total_cost = (float)$_POST['total_cost'];  // Convert to float

// Check if the student already has a booking for this amenity in the selected date range
$booking_check_query = "
    SELECT *
    FROM AmenityBookings
    WHERE student_id = ? 
      AND amenity_id = ?
      AND hall_id = ?
      AND (
          (start_date <= ? AND end_date >= ?)  -- New start overlaps with an existing booking
          OR 
          (start_date <= ? AND end_date >= ?)  -- New end overlaps with an existing booking
          OR
          (? <= start_date AND ? >= end_date)  -- New booking completely encompasses an existing booking
      )";
$booking_check_stmt = $conn->prepare($booking_check_query);
$booking_check_stmt->bind_param(
    "siissssss",
    $student_id,
    $amenity_id,
    $hall_id,
    $start_date,
    $start_date,
    $end_date,
    $end_date,
    $start_date,
    $end_date
);
$booking_check_stmt->execute();
$booking_check_result = $booking_check_stmt->get_result();



if ($booking_check_result->num_rows > 0) {
    $response = "You already have an active booking for this amenity in selected date range.";
} else {
    // Proceed with booking if no previous booking found
    $conn->begin_transaction();

    try {
        // Insert booking into the database
        $insert_booking_query = "INSERT INTO AmenityBookings (student_id, hall_id, amenity_id, start_date, end_date,total_cost) VALUES (?, ?, ?, ?, ?, ?)";
        $insert_booking_stmt = $conn->prepare($insert_booking_query);
        $insert_booking_stmt->bind_param("siissd", $student_id, $hall_id, $amenity_id, $start_date, $end_date, $total_cost);
        $insert_booking_stmt->execute();

        // Update the student's amenity bill
        $update_bill_query = "UPDATE StudentHallDetails SET amenity_bill = amenity_bill + ? WHERE student_id = ?";
        $update_bill_stmt = $conn->prepare($update_bill_query);
        $update_bill_stmt->bind_param("ds", $total_cost, $student_id);
        $update_bill_stmt->execute();

        $conn->commit();
        $response = "Amenity booked successfully!";
    } catch (Exception $e) {
        $conn->rollback();
        $response = "Booking failed. Please try again. Error: " . $e->getMessage();
    }
}

echo $response;
?>
