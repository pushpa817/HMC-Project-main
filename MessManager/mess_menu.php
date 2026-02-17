<?php 
include 'connect.php'; // Include your database connection
    include 'check_log.php';
// Fetch all menu items and organize them by type and day
$stmt = $conn->prepare("SELECT * FROM MessMenu ORDER BY FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')");
$stmt->execute();
$menus = $stmt->fetchAll(PDO::FETCH_ASSOC);

$menuData = [
    'vegetarian' => [],
    'non-vegetarian' => []
];

foreach ($menus as $menu) {
    $menuData[$menu['type']][] = $menu;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mess Menu | Mess Manager | HMC</title>
    <link rel="stylesheet" href="manager_styles.css"> 
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* Styling for table and buttons */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
        }
        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #8238e4;
        }
        .menu-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .menu-table th, .menu-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .menu-table th {
            background-color: #8238e4;
            color: white;
        }
        .heading-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .heading-container h2 {
            margin: 0;
        }

        
        .edit-button, .save-button {
            padding: 5px 10px;
            background-color: #8238e4;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 0;
            font-size:20px;
            display: inline-block;
        }
        .edit-button:hover, .save-button:hover {
            background-color: #2980b9;
        }
    </style>
    <script>
        function enableEdit(tableId) {
        const table = document.getElementById(tableId);
        const cells = table.querySelectorAll('td');
        cells.forEach((cell, index) => {
            // Skip the first column (day column)
            if (index % 4 !== 0) {
                cell.contentEditable = true;
            }
        });
        // Show the save button when the edit button is clicked
        document.getElementById('save-' + tableId).style.display = 'inline-block';
        }


        function saveChanges(tableId) {
        const table = document.getElementById(tableId);
        const rows = table.querySelectorAll('tbody tr');
        const data = [];

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const day = cells[0].innerText;
            const breakfast = cells[1].innerText;
            const lunch = cells[2].innerText;
            const dinner = cells[3].innerText;
            data.push({ day, breakfast, lunch, dinner });
        });

        // Send the data to a PHP script for saving
        fetch('update_menu.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ tableId, data })
        })
        .then(response => response.json())
        .then(result => {
            alert(result.message);
            rows.forEach(row => {
                row.querySelectorAll('td').forEach(cell => {
                    cell.contentEditable = false;
                });
            });

            // Hide the save button after saving
            document.getElementById('save-' + tableId).style.display = 'none';
        })
        .catch(error => console.error('Error:', error));
    }

    </script>
</head>
<body>

    <?php include 'sidebar.php'; ?>
    <div class="main-content">
    <h1>Mess Menu</h1>

    <div class="heading-container">
        <h2>Vegetarian Menu</h2>
        <button class="edit-button" onclick="enableEdit('vegetarian-table')">Edit</button>
    </div>
    <button class="save-button" id="save-vegetarian-table" onclick="saveChanges('vegetarian-table')" style="display: none;">Save Changes</button>
    <table class="menu-table" id="vegetarian-table">
        <thead>
            <tr>
                <th>Day</th>
                <th>Breakfast</th>
                <th>Lunch</th>
                <th>Dinner</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($menuData['vegetarian'] as $menu) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($menu['day_of_week']); ?></td>
                    <td><?php echo htmlspecialchars($menu['breakfast']); ?></td>
                    <td><?php echo htmlspecialchars($menu['lunch']); ?></td>
                    <td><?php echo htmlspecialchars($menu['dinner']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="heading-container">
        <h2>Non-Vegetarian Menu</h2>
        <button class="edit-button" onclick="enableEdit('non-vegetarian-table')">Edit</button>
    </div>
    <button class="save-button" id="save-non-vegetarian-table" onclick="saveChanges('non-vegetarian-table')" style="display: none;">Save Changes</button>
    <table class="menu-table" id="non-vegetarian-table">
        <thead>
            <tr>
                <th>Day</th>
                <th>Breakfast</th>
                <th>Lunch</th>
                <th>Dinner</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($menuData['non-vegetarian'] as $menu) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($menu['day_of_week']); ?></td>
                    <td><?php echo htmlspecialchars($menu['breakfast']); ?></td>
                    <td><?php echo htmlspecialchars($menu['lunch']); ?></td>
                    <td><?php echo htmlspecialchars($menu['dinner']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


</body>
</html>
