<?php
include 'check_log.php'; //user login check
include 'database.php'; // Include your database connection file


$student_id = $_SESSION['student_id'];

// Fetch personal details along with hall details and roommate
$query = "SELECT * FROM StudentPersonalDetails WHERE student_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$data = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile | Student | HMC</title>
    <link rel="stylesheet" href="student_styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <section class="main-content">
        <div class="profile-header">
            <div class="profile-info">
                <h2 id="userName"><?php echo htmlspecialchars($data['student_name']); ?></h2>
                <p>Student ID <span><?php echo htmlspecialchars($data['student_id']); ?></span></p>
                <p>Branch <span><?php echo htmlspecialchars($data['branch']); ?></span></p>
                <p>Year <span><?php echo htmlspecialchars($data['year']); ?></span></p>
            </div>
            <div class="profile-img" id="profileImage">
                <img src="images/<?php echo htmlspecialchars($data['photo']); ?>" alt="student" id="currentImage">
            </div>
        </div>

        <div class="profile-details-section">
            <div class="details-grid">
                <div class="section-header"><div>Personal Details</div><i class='bx bxs-user-detail profile-icon'></i></div>
                <div class="row"><div class="label">Name</div><div class="value"><?php echo htmlspecialchars($data['student_name']); ?></div></div>
                <div class="row"><div class="label">ID Number</div><div class="value" id='userId'><?php echo htmlspecialchars($data['student_id']); ?></div></div>
                <div class="row"><div class="label">Date of Birth</div><div class="value"><?php echo date('d-m-Y', strtotime($data['dob'])); ?></div></div>
                <div class="row"><div class="label">Gender</div><div class="value"><?php echo htmlspecialchars($data['gender']); ?></div></div>
                <div class="row"><div class="label">College Email</div><div class="value"><?php echo htmlspecialchars($data['college_email']); ?></div></div>
                <div class="row"><div class="label">Personal Email</div><div class="value"><?php echo htmlspecialchars($data['personal_email']); ?></div></div>
                <div class="row"><div class="label">Phone Number</div><div class="value"><?php echo htmlspecialchars($data['phone']); ?></div></div>
                <div class="row"><div class="label">Address</div><div class="value"><?php echo htmlspecialchars($data['address']); ?></div></div>
            </div>
        </div>

            <div class="useful-info">
                <p><span>To change password please <a href="logout.php">logout</a> and click on forgot password.</span></p>
            </div>
    </section>
    

    <?php include 'footer.php'; ?>
</body>
</html>
