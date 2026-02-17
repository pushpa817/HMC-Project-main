<?php
include 'connect.php';
include 'check_log.php';
session_start();
if (!isset($_SESSION['warden_id'])) {
    echo "<script>
            alert('Please log in to access this page.');
            window.location.href = 'login.php';
          </script>";
    exit;
}
$warden_id = $_SESSION['warden_id'];
try {
    $wardenStmt = $conn->prepare("SELECT hall_id FROM Wardens WHERE warden_id = :warden_id");
    $wardenStmt->bindParam(':warden_id', $warden_id);
    $wardenStmt->execute();
    $wardenDetails = $wardenStmt->fetch(PDO::FETCH_ASSOC);

    if (!$wardenDetails) {
        echo "<script>alert('Invalid warden credentials.');</script>";
        exit;
    }

    $hall_id = $wardenDetails['hall_id'];

    $AmenitiesStmt = $conn->prepare("SELECT ab.booking_id,ab.student_id, a.amenity_name,ab.start_date,ab.end_date,ab.total_cost
                                     FROM AmenityBookings ab
                                     JOIN Amenities a ON ab.amenity_id = a.amenity_id
                                     WHERE ab.hall_id = :hall_id");
    $AmenitiesStmt->bindParam(':hall_id', $hall_id);
    $AmenitiesStmt->execute();
    $AmenitiesDetails = $AmenitiesStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amenities | WARDEN | HMC</title>
    <link rel="stylesheet" href="warden_styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
    .complaint-container {
        border: 1px solid #ddd;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        padding: 20px;
        margin: 15px;
        display: inline-block;
        width: 45%;
        vertical-align: top;
        background-color: #fff;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .complaint-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }
    .complaint-header {
        font-weight: bold;
        margin-bottom: 10px;
        color: #4a4a4a;
        font-size: 1.2rem;
        position: relative;
    }
    .complaint-header::after {
        content: '';
        display: block;
        width: 50px;
        height: 2px;
        background-color: #8238e4;
        margin-top: 5px;
    }
    .complaint-detail {
        margin: 5px 0;
        color: #555;
    }
    .respond-button {
        padding: 10px 20px;
        margin-top: 10px;
        background-color: #8238e4;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.3s ease;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
    }
    .respond-button:hover {
        background-color: #6732b5;
        transform: scale(1.05);
    }
    .respond-button:active {
        background-color: #512a94;
        transform: scale(0.98);
    }
    .response-form {
        display: none;
        margin-top: 10px;
        animation: fadeIn 0.5s ease-in-out;
    }
    .response-form textarea {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        resize: vertical;
        transition: border-color 0.3s;
    }
    .response-form textarea:focus {
        border-color: #8238e4;
        outline: none;
    }
    .submit-response {
        margin-top: 10px;
        background-color: #45a049;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }
    .submit-response:hover {
        background-color: #368b3d;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .submit-response:active {
        background-color: #2b7031;
    }
    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
</style>

</head>
<body>
    <?php include 'sidebar.php'; ?>
    <section class="main-content">
        <?php
        // Fetch only pending complaints

        foreach ($AmenitiesDetails as $amenity) {
            echo "<div class='complaint-container'>";
            echo "<div class='complaint-header'>Booking ID: {$amenity['booking_id']}</div>";
            echo "<div class='complaint-detail'>Amenity: {$amenity['amenity_name']}</div>";
            echo "<div class='complaint-detail'>Student ID: {$amenity['student_id']}</div>";
            echo "<div class='complaint-detail'>Starting Date: {$amenity['start_date']}</div>";
            echo "<div class='complaint-detail'>Ending Date: {$amenity['end_date']}</div>";
            echo "<div class='complaint-detail'>Total Cost: {$amenity['total_cost']}</div>";
            $currentDate = date('Y-m-d');
            $status = (strtotime($amenity['end_date']) >= strtotime($currentDate)) ? 'active' : 'expired';
            echo "<div class='complaint-detail'>Status: {$status}</div>";            echo "</div>";
        }
        ?>
    </section>
  
</body>
</html>
