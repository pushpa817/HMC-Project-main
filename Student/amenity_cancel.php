<?php
include 'database.php';  // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'];

    // Validate the booking ID
    if (empty($booking_id)) {
        die("Invalid booking ID.");
    }

    // Start the transaction
    $conn->begin_transaction();

    try {
        // Step 1: Retrieve the total_cost for the booking to be canceled
        $stmt = $conn->prepare("SELECT total_cost, student_id FROM AmenityBookings WHERE booking_id = ?");
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($total_cost, $student_id);
            $stmt->fetch();
        } else {
            throw new Exception("Booking not found.");
        }

        // Step 2: Update the amenity_bill for the student
        $update_stmt = $conn->prepare("UPDATE StudentHallDetails SET amenity_bill = amenity_bill - ? WHERE student_id = ?");
        $update_stmt->bind_param("ds", $total_cost, $student_id);
        if (!$update_stmt->execute()) {
            throw new Exception("Error updating amenity bill.");
        }

        // Step 3: Delete the booking from AmenityBookings table
        $delete_stmt = $conn->prepare("DELETE FROM AmenityBookings WHERE booking_id = ?");
        $delete_stmt->bind_param("i", $booking_id);

        if (!$delete_stmt->execute()) {
            throw new Exception("Error canceling booking.");
        }

        // Commit the transaction
        $conn->commit();

        // Return success response
        echo "Booking canceled successfully.";

        // Close statements
        $stmt->close();
        $update_stmt->close();
        $delete_stmt->close();
    } catch (Exception $e) {
        // Rollback the transaction if an error occurred
        $conn->rollback();

        // Return error message
        echo "Failed: " . $e->getMessage();
    } finally {
        // Close the connection
        $conn->close();
    }
}
?>
