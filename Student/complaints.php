<?php
include 'check_log.php'; // User login check
include 'database.php'; // Database connection

$student_id = $_SESSION['student_id'];

// Fetch hall_id based on student_id from StudentHallDetails table
$hall_id = null;
$sql = "SELECT hall_id FROM StudentHallDetails WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$stmt->bind_result($hall_id);
$stmt->fetch();
$stmt->close();

// Fetch previous complaints for this student
$complaints = [];
if ($hall_id) {
    $sql = "SELECT complaint_type,date_raised, description, status, date_resolved, ATR 
            FROM Complaints 
            WHERE student_id = ? 
            ORDER BY 
                status ASC,
                date_raised DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $student_id);
    
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $complaints[] = $row;
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaints | Student | HMC</title>
    <link rel="stylesheet" href="student_styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <section class="main-content">
    <?php if ($hall_id): ?>
        <div class="complaint-form-section">
            <div class="details-grid">
                <div class="section-header"><div>Raise a complaint</div><i class='bx bxs-envelope profile-icon'></i></div>
                <form id="complaintForm" action="submit_complaint.php" method="POST">
                    <input type="hidden" id="hall_id" name="hall_id" value="<?php echo htmlspecialchars($hall_id); ?>" readonly>
                    <label for="complaint_type">Complaint Type:</label>
                    <select id="complaint_type" name="complaint_type" required>
                        <option value="" disabled selected>-- Select complaint type --</option>
                        <option value="Hall">Hall</option>
                        <option value="Mess">Mess</option>
                    </select>

                    <label for="description">Description:</label><br>
                    <textarea id="description" name="description" rows="4" cols="50" required></textarea>

                    <button type="submit" class="submit-btn">Submit Complaint</button>
                </form>
            </div>
        </div>

        <div class="previous-complaint-section">
            <div class="details-grid">
            <div class="section-header"><div>Previous complaints</div><i class="bx bx-history profile-icon"></i></div>
            <?php if (!empty($complaints)): ?>
                <div class="complaints-container">
                <?php foreach ($complaints as $complaint): ?>
                    <div class="complaint-card">
                        <div class="attribute"><span>Date Raised</span><?php echo htmlspecialchars($complaint['date_raised']); ?></div>
                        <div class="attribute"><span>Complaint Type</span><?php echo htmlspecialchars($complaint['complaint_type']); ?></div>
                        <div class="attribute"><span>Description</span></div>
                        <div class="attribute description"><?php echo htmlspecialchars($complaint['description']); ?></div>
                        <div class="attribute"><span>Status</span><?php echo htmlspecialchars($complaint['status']); ?></div>
                        
                        <?php if ($complaint['status'] == 'Resolved'): ?>
                            <div class="attribute"><span>Date Resolved</span><?php echo htmlspecialchars($complaint['date_resolved']); ?></div>
                            <div class="attribute"><span>ATR</span></div>
                            <div class="attribute description"><?php echo htmlspecialchars($complaint['ATR']); ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No previous complaints found.</p>
            <?php endif; ?>
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

    <script>
        $(document).ready(function() {
            $("#complaintForm").submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                $.ajax({
                    type: "POST",
                    url: "submit_complaint.php",
                    data: $(this).serialize(),
                    success: function(response) {
                        const responseData = JSON.parse(response);
                        
                        // Display an alert message based on the response
                        if (responseData.type === "success") {
                            alert(responseData.message); // Show success alert
                            $("#complaintForm")[0].reset(); // Clear the form
                            
                            // Reload the page after the alert
                            location.reload();
                        } else {
                            alert("Error: " + responseData.message); // Show error alert
                        }
                    }
                });
            });
        });

    </script>
</body>
</html>
