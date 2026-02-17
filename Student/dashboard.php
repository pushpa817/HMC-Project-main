<?php
include 'check_log.php'; 
include 'database.php'; 


$student_id = $_SESSION['student_id'];

// Fetch personal details along with hall details and roommate
$query = "SELECT student_name,year,branch FROM StudentPersonalDetails WHERE student_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();


// Check if the student has booked a room
$room_query = "
    SELECT h.hall_name, shd.room_number, shd.mess_type, shd.room_bill, shd.mess_bill, shd.amenity_bill 
    FROM StudentHallDetails shd
    JOIN Halls h ON shd.hall_id = h.hall_id
    WHERE shd.student_id = ?
";
$room_stmt = $conn->prepare($room_query);
$room_stmt->bind_param("s", $student_id);
$room_stmt->execute();
$room_result = $room_stmt->get_result();
$room_data = $room_result->fetch_assoc();
$room_stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Student | HMC</title>
    <link rel="stylesheet" href="student_styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <section class="main-content">
        <div class="dashboard-header">
            <div class="dashboard-info">
                <h2><span>Welcome back </span><?php echo htmlspecialchars($data['student_name']); ?></h2>
                <p>Wishing you a day filled with learning, growth, and positivity. Make it a great one!</p>
            </div>
        </div>

        <?php if ($room_data): ?>
            <div class="dashboard-summary">
            <?php

                $total_due = $room_data['room_bill']+$room_data['mess_bill']+$room_data['amenity_bill'];
                $formattedTotalDue = number_format($total_due, 2, '.', ',');
                // Retrieve vegetarian menu
                $current_day = date("l");
                if($room_data['mess_type'] == 'Vegetarian') $type = "vegetarian";
                else $type = "non-vegetarian";

                $messQuery = "SELECT breakfast, lunch, dinner FROM MessMenu WHERE type = '$type' and day_of_week = '$current_day'";
                $messResult = $conn->query($messQuery);
                $menuData = $messResult->fetch_assoc();
            ?>
                <div class="dashboard-card">
                        <div class="attribute card-head"><span>Today's menu</span></div>
                        <div class="attribute"><span>Breakfast</span><?php echo htmlspecialchars($menuData['breakfast']); ?></div>
                        <div class="attribute"><span>Lunch</span><?php echo htmlspecialchars($menuData['lunch']); ?></div>
                        <div class="attribute"><span>Dinner</span><?php echo htmlspecialchars($menuData['dinner']); ?></div>
                </div>
                <div class="dashboard-card">
                        <div class="attribute card-head"><span>Fee Dues</span></div>
                        <div class="attribute"><span>Room Bill</span><?php echo htmlspecialchars($room_data['room_bill']); ?></div>
                        <div class="attribute"><span>Mess Bill</span><?php echo htmlspecialchars($room_data['mess_bill']); ?></div>
                        <div class="attribute"><span>Amenity Bill</span><?php echo htmlspecialchars($room_data['amenity_bill']); ?></div>
                        <div class="attribute"><span>Total Due</span><span class="due"><?php echo htmlspecialchars($formattedTotalDue); ?></span></div>
                </div>
                <div class="dashboard-card">
                        <div class="attribute card-head"><span>Hall Details</span></div>
                        <div class="attribute"><span>Hall Name</span><?php echo htmlspecialchars($room_data['hall_name']); ?></div>
                        <div class="attribute"><span>Room Number</span><?php echo htmlspecialchars($room_data['room_number']); ?></div>
                        <div class="attribute"><span>Mess Type</span><?php echo htmlspecialchars($room_data['mess_type']); ?></div>
                        <div class="attribute "><span></span><a href="hall.php">more</a></div>
                </div> 
                <div class="dashboard-card">
                        <div class="attribute card-head"><span>Student Details</span></div>
                        <div class="attribute"><span>ID</span><?php echo htmlspecialchars($student_id); ?></div>
                        <div class="attribute"><span>Year</span><?php echo htmlspecialchars($data['year']); ?></div>
                        <div class="attribute"><span>Branch</span><?php echo htmlspecialchars($data['branch']); ?></div>
                        <div class="attribute "><span></span><a href="profile.php">more</a></div>
                </div>
            </div>
        <?php else: ?>
            <div class="useful-info">
                <p>“It looks like you haven’t booked a room yet! Booking a room on campus offers you a personal 
                    space to relax, study, and feel at home. Don’t miss out on the convenience and sense of community 
                    that come with campus life. Head over to the <a href="hall.php">room booking page</a> now to secure your space and make 
                    the most of your campus experience!”</p>
            </div>
        <?php endif; ?>  
    </section>

    <?php include 'footer.php'; ?>

</body>
</html>