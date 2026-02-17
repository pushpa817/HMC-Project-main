<?php 
    include 'check_log.php';
    include 'connect.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance | STAFF MANAGER | HMC</title>
    <link rel="stylesheet" href="staffmanager_styles.css">
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
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <section class="main-content">
        <div class="search-container">
            <select id="columnSelect">
                <option value="staff_id">Staff ID</option>
                <option value="role">Role</option>
                <option value="staff_name">Name</option>
            </select>
            <input type="text" id="search" placeholder="Search..." onkeyup="filterTable()">
            <button onclick="filterTable()">Search</button>
            <button onclick="changeAttendance()">Update</button>
        </div>

        <table class="details-table" id="messDetailsTable">
            <thead>
                <tr>
                    <th>Staff ID</th>
                    <th>Staff Name</th>
                    <th>Role</th>
                    <th>Attendance</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->prepare("SELECT staff_id,staff_name, role,attended_days FROM Staff");
                $stmt->execute();
                $staffDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (empty($staffDetails)) {
                    echo "<tr><td colspan='4'>No records found.</td></tr>";
                } else {
                    foreach ($staffDetails as $detail) {
                        echo "<tr>";
                        echo "<td>{$detail['staff_id']}</td>";
                        echo "<td>{$detail['staff_name']}</td>";
                        echo "<td>{$detail['role']} </td>";
                        echo "<td>{$detail['attended_days']} </td>";
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
            'staff_id': 0,
            'staff_name':1,
            'role': 2
        }[column];

        for (let i = 1; i < tr.length; i++) {
            const td = tr[i].getElementsByTagName("td");
            if (td.length > 0) {
                const txtValue = td[columnIndex].textContent || td[columnIndex].innerText;
                tr[i].style.display = txtValue.toLowerCase().indexOf(filter) > -1 ? "" : "none";
            }
        }
    }

    function changeAttendance() {
    const roles = ['Cleaner', 'Gardener'];
    const attendanceUpdates = {};

    roles.forEach(role => {
        const attendance = prompt(`Enter attendance to add to the current ${role}s:`);
        if (attendance !== null) {
            if (isNaN(attendance)) {
                alert(`Invalid input for ${role}. Please enter a numeric value.`);
            } else {
                attendanceUpdates[role] = parseInt(attendance);
            }
        }
    });

    if (Object.keys(attendanceUpdates).length > 0) {
        updateAttendanceOnServer(attendanceUpdates);
    }
}

function updateAttendanceOnServer(attendanceUpdates) {
    const rows = document.querySelectorAll('#messDetailsTable tbody tr');
    const data = [];

    rows.forEach(row => {
        const cells = row.getElementsByTagName('td');
        if (cells.length > 0) {
            const staffId = cells[0].textContent.trim();
            const role = cells[2].textContent.trim();
            let attendance = parseInt(cells[3].textContent);

            if (attendanceUpdates[role] !== undefined) {
                attendance += attendanceUpdates[role];
                cells[3].textContent = attendance;
                data.push({ staff_id: staffId, role: role, attended_days: attendance });
            }
        }
    });

    fetch('update_attendance_details.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Server error: ${response.status}`);
        }
        return response.text();
    })
    .then(result => {
        alert(result);
        location.reload();
    })
    .catch(error => {
        alert('Failed to update attendance. Please try again.');
        console.error('Error:', error);
    });
}


    </script>
</body>
</html>
