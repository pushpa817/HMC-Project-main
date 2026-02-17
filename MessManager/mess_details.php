<?php 
    include 'connect.php';
    include 'check_log.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details | Mess Manager | HMC</title>
    <link rel="stylesheet" href="manager_styles.css">
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
                <option value="student_id">Student ID</option>
                <option value="hall_id">Hall ID</option>
                <option value="mess_type">Mess Type</option>
            </select>
            <input type="text" id="search" placeholder="Search..." onkeyup="filterTable()">
            <button onclick="filterTable()">Search</button>
            <button onclick="changeBillAmounts()">Update</button>
        </div>

        <table class="details-table" id="messDetailsTable">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Hall ID</th>
                    <th>Mess Type</th>
                    <th>Mess Bill</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->prepare("SELECT student_id, hall_id, mess_type, mess_bill FROM StudentHallDetails");
                $stmt->execute();
                $messDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (empty($messDetails)) {
                    echo "<tr><td colspan='4'>No records found.</td></tr>";
                } else {
                    foreach ($messDetails as $detail) {
                        echo "<tr>";
                        echo "<td>{$detail['student_id']}</td>";
                        echo "<td>{$detail['hall_id']}</td>";
                        echo "<td>" . ucfirst($detail['mess_type']) . "</td>";
                        echo "<td><i class='bx bx-rupee'></i>{$detail['mess_bill']}</td>";
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
            'hall_id': 1,
            'mess_type': 2,
        }[column];

        for (let i = 1; i < tr.length; i++) {
            const td = tr[i].getElementsByTagName("td");
            if (td.length > 0) {
                const txtValue = td[columnIndex].textContent || td[columnIndex].innerText;
                tr[i].style.display = txtValue.toLowerCase().indexOf(filter) > -1 ? "" : "none";
            }
        }
    }

    function changeBillAmounts() {
        const newVegBill = prompt("Enter amount to add to the current Vegetarian bill:");
        const newNonVegBill = prompt("Enter amount to add to the current Non Vegetarian bill:");

        if (newVegBill !== null && newNonVegBill !== null) {
            if (!isNaN(newVegBill) && !isNaN(newNonVegBill)) {
                const data = [];

                document.querySelectorAll('#messDetailsTable tr').forEach((row, index) => {
                    if (index > 0) {
                        const cells = row.getElementsByTagName('td');
                        if (cells.length > 0) {
                            const student_id = cells[0].textContent.trim();
                            const hall_id = cells[1].textContent.trim();
                            const mess_type = cells[2].textContent.trim();
                            let currentBill = parseFloat(cells[3].textContent.trim().replace(/₹|\s/g, ''));

                            if (mess_type === 'Non Vegetarian') {
                                currentBill += parseFloat(newNonVegBill);
                            } else if (mess_type === 'Vegetarian') {
                                currentBill += parseFloat(newVegBill);
                            }

                            cells[3].innerHTML = `<i class='bx bx-rupee'></i>${currentBill}`;
                            data.push({ student_id, hall_id, mess_type, mess_bill: currentBill });
                        }
                    }
                });

                fetch('update_mess_details.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                })
                .then(response => response.text())
                .then(result => {
                    alert(result);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            } else {
                alert("Please enter valid numeric values for the bill amounts.");
            }
        }
    }
    </script>
</body>
</html>
