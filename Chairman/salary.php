<?php 
    ob_start(); // Start output buffering

    include 'check_log.php';
    include 'connect.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salaries | CHAIRMAN | HMC</title>
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
            margin-left: 16rem;
            width: 90%;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #3498db;
            color: #fff;
        }

        .form-buttons {
            text-align: center;
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

        .success-message, .error-message {
            font-size: 16px;
            text-align: center;
        }

        .success-message {
            color: green;
        }

        .error-message {
            color: red;
        }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>

    <div class="form-container">
        <h2>Provide Salaries to Staff</h2>
        <form action="" method="POST">
            <table>
                <thead>
                    <tr>
                        <th>Staff ID</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Daily Pay</th>
                        <th>Attended Days</th>
                        <th>Total Salary</th>
                        <th>Last Payment Date</th> <!-- Added column for Last Payment Date -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        // Fetch staff details with the last payment date
                        $stmt = $conn->prepare("
                            SELECT s.staff_id, s.staff_name, s.role, s.daily_pay, s.attended_days,
                                   MAX(sa.payment_date) AS last_payment_date
                            FROM Staff s
                            LEFT JOIN Salaries sa ON s.staff_id = sa.staff_id
                            GROUP BY s.staff_id
                        ");
                        $stmt->execute();
                        $staffList = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($staffList as $staff) {
                            $totalSalary = $staff['daily_pay'] * $staff['attended_days'];
                            $lastPaymentDate = $staff['last_payment_date'] ?: 'Not Paid Yet'; // Display 'Not Paid Yet' if no payment date
                            echo "<tr>
                                <td>{$staff['staff_id']}</td>
                                <td>{$staff['staff_name']}</td>
                                <td>{$staff['role']}</td>
                                <td>{$staff['daily_pay']}</td>
                                <td>{$staff['attended_days']}</td>
                                <td>{$totalSalary}</td>
                                <td>{$lastPaymentDate}</td> <!-- Display last payment date -->
                                <input type='hidden' name='staff_ids[]' value='{$staff['staff_id']}'>
                            </tr>";
                        }
                    } catch (Exception $e) {
                        echo "<p class='error-message'>Error: {$e->getMessage()}</p>";
                    }
                    ?>
                </tbody>
            </table>
            <div class="form-buttons">
                <button type="submit">Process Salaries</button>
                <button type="submit"><a href="dashboard.php">Back</a></button>
            </div>
        </form>
        <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $staff_ids = $_POST['staff_ids'] ?? [];
        $paymentDate = date('Y-m-d');

        foreach ($staff_ids as $staff_id) {
            // Fetch staff details again to ensure accurate calculation
            $stmt = $conn->prepare("SELECT daily_pay, attended_days FROM Staff WHERE staff_id = ?");
            $stmt->execute([$staff_id]);
            $staff = $stmt->fetch(PDO::FETCH_ASSOC);
        
            // Check if attended_days is greater than 0 before processing salary
            if ($staff['attended_days'] > 0) {
                $salaryAmount = $staff['daily_pay'] * $staff['attended_days'];
        
                // Insert into Salaries table
                $stmt = $conn->prepare("
                    INSERT INTO Salaries (staff_id, salary_amount, payment_date) 
                    VALUES (?, ?, ?)
                ");
                $stmt->execute([$staff_id, $salaryAmount, $paymentDate]);
        
                // Reset attended days after payment
                $resetStmt = $conn->prepare("UPDATE Staff SET attended_days = 0 WHERE staff_id = ?");
                $resetStmt->execute([$staff_id]);
            }
        }
        
        echo "<p class='success-message'>Salaries processed successfully!</p>";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;

    } catch (Exception $e) {
        echo "<p class='error-message'>Error: {$e->getMessage()}</p>";
    }
}

?>

    </div>
</body>
</html>
<?php ob_end_flush(); // End output buffering ?>
