<?php 
    include 'check_log.php';
    include 'connect.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Recruitment | CHAIRMAN | HMC</title>
    <link rel="stylesheet" href="chairman_styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 2rem;
        }

        .form-container {
            width: 90%;
            max-width: 800px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            margin-left: 16rem;  
              }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group input:focus, .form-group select:focus {
            border-color: #3498db;
            outline: none;
        }

        .form-buttons {
            text-align: center;
            margin-top: 1rem;
            display: flex;
            gap: 2rem;
            align-items: center;
            justify-content: center;
        }

        .form-buttons a{
            text-decoration: none;
            color: #fff;
        }

        .form-buttons button {
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background-color: #3498db;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-buttons button:hover {
            background-color: #1d70b8;
        }

        .success-message {
            color: green;
            font-size: 16px;
            text-align: center;
        }

        .error-message {
            color: red;
            font-size: 16px;
            text-align: center;
        }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

    <div class="form-container">
        <h2>Recruit New Staff</h2>
      
        <form action="" method="POST">
            <div class="form-group">
                <label for="staff_id">Staff ID:</label>
                <input type="text" id="staff_id" name="staff_id" placeholder="Enter Staff ID" required>
            </div>
            <div class="form-group">
                <label for="staff_name">Name:</label>
                <input type="text" id="staff_name" name="staff_name" placeholder="Enter Staff Name" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="">Select Role</option>
                    <option value="Cleaner">Cleaner</option>
                    <option value="Gardener">Gardener</option>
                    
                </select>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" placeholder="Enter Phone Number" required>
            </div>
            <div class="form-group">
                <label for="hallid">HALL-ID:</label>
                <select id="hallid" name="hall_id" required>
                    <option value="">Select Hall</option>
                    <option value="1">Ramanujan Hall</option>
                    <option value="2">Infinity Hall</option>
                    <option value="3">Sarojini Hall</option>
                    <option value="4">Delta Hall</option>
                </select>
            </div>
            <div class="form-group">
                <label for="dailyPay">Daily-Pay:</label>
                <input type="text" id="dailyPay" name="daily_pay" placeholder="Enter Dailypay" required>
            </div>
            <div class="form-buttons">
                <button type="submit"><a href="dashboard.php">Back</a></button>
                <button type="submit">Add Staff</button>
            </div>
        </form>
    </div>
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $staff_id = $_POST['staff_id'];
                $staff_name = ($_POST['staff_name']);
                $role = ($_POST['role']);
                $phone = ($_POST['phone']);
                $dailyPay = ($_POST['daily_pay']);
                $hallId=($_POST['hall_id']);
                $attended_days = 0; // Default attendance

                $stmt = $conn->prepare("INSERT INTO Staff (staff_id, staff_name, phone,hall_id,role,daily_pay) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$staff_id, $staff_name,$phone,$hallId,$role, $dailyPay]);

                echo "<script>alert('Staff added successfully!')</script>";
            } catch (Exception $e) {
                echo "<script>alert('Error while adding please try again later!')</script>";
            }
        }
    ?> 
</body>
</html>

