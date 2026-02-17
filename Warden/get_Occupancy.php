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

    
    $occupancyStmt = $conn->prepare("SELECT student_id, hall_id, room_number
                                     FROM StudentHallDetails 
                                     WHERE hall_id = :hall_id");
    $occupancyStmt->bindParam(':hall_id', $hall_id);
    $occupancyStmt->execute();
    $occupancyDetails = $occupancyStmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Hall Occupancy | WARDEN | HMC</title>
    <link rel="stylesheet" href="warden_styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .details-table th, .details-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .details-table th {
            background-color: #8238e4;
            color: white;
        }
        .details-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .details-table tr:hover {
            background-color: #ddd;
        }
        .section-header {
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }
        .search-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .search-container select, .search-container input {
            padding: 10px;
            margin-right: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .search-container button {
            padding: 10px 15px;
            font-size: 16px;
            background-color: #8238e4;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .search-container button:hover {
            background-color: #45a049;
        }
        .main-content .heading{
           color:#8238e4;
           font-weight: bold;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <section class="main-content">
       <center> <div class="heading">
            <h2>Occupancy Of Rooms:</h2>
        </div></center><br/>
        <div class="search-container">
            <select id="columnSelect">
                <option value="student_id">Student ID</option>
                <option value="room_number">Room NO.</option>
            </select>
            <input type="text" id="search" placeholder="Search..." onkeyup="filterTable()">
            <button onclick="filterTable()">Search</button>
        </div>

        <table class="details-table" id="messDetailsTable">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Hall ID</th>
                    <th>Room NO.</th>
                </tr>
            </thead>
            <tbody>
                <?php

                if (empty($occupancyDetails)) {
                    echo "<tr><td colspan='4'>No records found.</td></tr>";
                } else {
                    foreach ($occupancyDetails as $detail) {
                        echo "<tr>";
                        echo "<td>{$detail['student_id']}</td>";
                        echo "<td>{$detail['hall_id']}</td>";
                        echo "<td>{$detail['room_number']}</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </section>

    <script>
    function filterTable() {
        const input = document.getElementById('search');
        const filter = input.value.toLowerCase();
        const column = document.getElementById('columnSelect').value;
        const table = document.getElementById("messDetailsTable");
        const tr = table.getElementsByTagName("tr");

        const columnIndex = {
            'student_id': 0,
            'room_number': 2,
        }[column];

        for (let i = 1; i < tr.length; i++) {
            const td = tr[i].getElementsByTagName("td");
            if (td.length > 0) {
                const txtValue = td[columnIndex].textContent || td[columnIndex].innerText;
                tr[i].style.display = txtValue.toLowerCase().indexOf(filter) > -1 ? "" : "none";
            }
        }
    }
    </script>
</body>
</html>
