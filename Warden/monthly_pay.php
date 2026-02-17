<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require 'connect.php';

// Initialize variables
$amenities_cost = 0;
$room_cost = 0;
$total_bill = 0;
$room_bill = 0;
$status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'] ?? null;
    $hall_id = $_SESSION['hall_id'];


    // Calculate the bill
    if (isset($_POST['calculate_bill']) && $student_id) {
        $amenity_query = $conn->prepare("
            SELECT room_bill,amenity_bill FROM StudentHallDetails WHERE student_id = :student_id AND hall_id = :hall_id
        ");
        $amenity_query->bindParam(':student_id', $student_id, PDO::PARAM_STR);
        $amenity_query->bindParam(':hall_id', $hall_id, PDO::PARAM_STR);

        if (!$amenity_query->execute()) {
            die("Error executing amenity query: " . implode(", ", $amenity_query->errorInfo()));
        }
        $amenity_details = $amenity_query->fetch(PDO::FETCH_ASSOC);

        if ($amenity_details) {
            $amenities_cost = $amenity_details['amenity_bill'];
            $room_bill = $amenity_details['room_bill'];
        } else {
            echo "<script>alert('Student not found!'); window.location.href = 'monthly_pay.php';</script>";
            exit;
        }

        $room_query = $conn->prepare("
            SELECT r.room_type, h.single_room_cost, h.twin_sharing_room_cost
            FROM Rooms r
            JOIN Halls h ON r.hall_id = h.hall_id
            WHERE r.room_number = (
                SELECT room_number FROM StudentHallDetails WHERE student_id = :student_id AND hall_id = r.hall_id
            )
        ");
        $room_query->bindParam(':student_id', $student_id, PDO::PARAM_STR);
        if (!$room_query->execute()) {
            die("Error executing room query: " . implode(", ", $room_query->errorInfo()));
        }
        $room_details = $room_query->fetch(PDO::FETCH_ASSOC);

        if ($room_details) {
            $room_type = $room_details['room_type'];
            $room_cost = ($room_type === 'single') ? $room_details['single_room_cost'] : $room_details['twin_sharing_room_cost'];
        } else {
            echo "<script>alert('Error while fetching!'); window.location.href = 'monthly_pay.php';</script>";
            exit;
        }

        $total_bill = $room_bill + $amenities_cost;
    }

    if (isset($_POST['update_bill']) && $student_id) {
        // Fetch the current room bill
        $current_room_bill = $_POST['current_room_bill'];
        $room_cost = $_POST['room_cost'];
    
        // Calculate the updated total room bill
        $new_room_bill = $current_room_bill + $room_cost;
    
        // Update the room bill
        $update_query = $conn->prepare("UPDATE StudentHallDetails SET room_bill = :room_bill WHERE student_id = :student_id");
        $update_query->bindParam(':room_bill', $new_room_bill, PDO::PARAM_STR);
        $update_query->bindParam(':student_id', $student_id, PDO::PARAM_STR);
    
        if ($update_query->execute()) {
            $status = "Bill updated successfully.";
            // Fetch amenities and room costs again
            $amenity_query = $conn->prepare("
                SELECT room_bill, amenity_bill FROM StudentHallDetails WHERE student_id = :student_id
            ");
            $amenity_query->bindParam(':student_id', $student_id, PDO::PARAM_STR);
            if ($amenity_query->execute()) {
                $amenity_details = $amenity_query->fetch(PDO::FETCH_ASSOC);
                $amenities_cost = $amenity_details['amenity_bill'];
                $room_bill = $amenity_details['room_bill'];
            } else {
                die("Error fetching amenity details.");
            }

            // Fetch room details again
            $room_query = $conn->prepare("
                SELECT r.room_type, h.single_room_cost, h.twin_sharing_room_cost
                FROM Rooms r
                JOIN Halls h ON r.hall_id = h.hall_id
                WHERE r.room_number = (
                    SELECT room_number FROM StudentHallDetails WHERE student_id = :student_id
                )
            ");
            $room_query->bindParam(':student_id', $student_id, PDO::PARAM_STR);
            if ($room_query->execute()) {
                $room_details = $room_query->fetch(PDO::FETCH_ASSOC);
                $room_type = $room_details['room_type'];
                $room_cost = ($room_type === 'single') ? $room_details['single_room_cost'] : $room_details['twin_sharing_room_cost'];
            } else {
                die("Error fetching room details.");
            }

            // Recalculate the total bill
            $total_bill = $room_bill + $amenities_cost;

        } else {
            $status = "Failed to update bill.";
        }
    }
    

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Bill | WARDEN | HMC</title>
    <link rel="stylesheet" href="warden_styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .bill-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 40px auto;
            transition: opacity 0.5s ease;
            border: 1px solid #ddd;
        }

        .bill-header {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
            text-transform: uppercase;
        }

        .bill-details {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .bill-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .bill-row span {
            font-weight: normal;
        }

        .total-row {
            font-weight: bold;
            font-size: 22px;
            color: #007BFF;
        }

        .status {
            text-align: center;
            color: green;
            font-size: 18px;
        }

        .form-container {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }

        input[type="text"] {
            padding: 12px;
            font-size: 16px;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 15px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus {
            border-color: #007BFF;
        }

        button {
            padding: 12px 25px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }

        .update-btn {
            background-color: #007BFF;
            transition: background-color 0.3s ease;
        }

        .update-btn:hover {
            background-color: #0056b3;
        }

        .update-btn:active {
            transform: translateY(2px);
        }

        .bill-container {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>

    <div class="main-content">
    <div class="form-container">
        <form method="POST">
            <label for="student_id">Enter Student ID:</label>
            <input type="text" id="student_id" name="student_id" required value="<?php echo isset($_POST['student_id']) ? htmlspecialchars($_POST['student_id']) : ''; ?>">
            <button type="submit" name="calculate_bill">Calculate Bill</button>
        </form>
    </div>

    <div class="bill-container" id="bill-container" style="display: <?php echo isset($_POST['calculate_bill']) ? 'block' : 'none'; ?>;">
        <div class="bill-header">Student Bill</div>
        <div class="bill-details">
            <div class="bill-row">
                <span>Current Room Bill:</span>
                <span>₹<?php echo $room_bill; ?></span>
            </div>
            <div class="bill-row">
                <span>Amenities Bill:</span>
                <span>₹<?php echo $amenities_cost; ?></span>
            </div>
            <div class="bill-row">
                <span>Room Rent:</span>
                <span>₹<?php echo $room_cost; ?></span>
            </div>
            <div class="bill-row total-row">
                <span>Total Bill:</span>
                <span>₹<?php echo $total_bill; ?></span>
            </div>
        </div>
        <div class="status">
            <?php echo $status; ?>
        </div>
        <form method="POST">
            <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>">
            <input type="hidden" name="current_room_bill" value="<?php echo htmlspecialchars($room_bill); ?>">
            <input type="hidden" name="room_cost" value="<?php echo htmlspecialchars($room_cost); ?>">

            <button type="submit" name="update_bill" class="update-btn">Update Room Bill</button>
        </form>
    </div>

    </div>

    <script>
        const billContainer = document.getElementById('bill-container');
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'])): ?>
            billContainer.style.display = 'block';
        <?php endif; ?>
    </script>
</body>
</html>
