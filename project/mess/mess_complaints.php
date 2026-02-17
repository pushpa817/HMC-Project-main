<?php include 'connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mess Complaints | HMC</title>
    <link rel="stylesheet" href="manager_styles.css">
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
        $stmt = $conn->prepare("SELECT * FROM Complaints WHERE status = 'Pending'");
        $stmt->execute();
        $complaints = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($complaints as $complaint) {
            echo "<div class='complaint-container'>";
            echo "<div class='complaint-header'>Complaint ID: {$complaint['complaint_id']}</div>";
            echo "<div class='complaint-detail'>Student ID: {$complaint['student_id']}</div>";
            echo "<div class='complaint-detail'>Hall ID: {$complaint['hall_id']}</div>";
            echo "<div class='complaint-detail'>Status: {$complaint['status']}</div>";
            echo "<div class='complaint-detail'>Description: {$complaint['description']}</div>";
            echo "<div class='complaint-detail'>Date Raised: {$complaint['date_raised']}</div>";
            echo "<div class='complaint-detail'>Date Resolved: " . (!empty($complaint['date_resolved']) ? $complaint['date_resolved'] : 'N/A') . "</div>";
            echo "<div class='complaint-detail'>ATR: " . (!empty($complaint['ATR']) ? $complaint['ATR'] : 'N/A') . "</div>";

            echo "<button class='respond-button' onclick='showResponseForm({$complaint['complaint_id']})'>Respond</button>";
            echo "<div class='response-form' id='form-{$complaint['complaint_id']}'>";
            echo "<textarea placeholder='Enter your response...'></textarea>";
            echo "<button class='submit-response' onclick='submitResponse({$complaint['complaint_id']})'>Submit</button>";
            echo "</div>";

            echo "</div>";
        }
        ?>
    </section>
    <script>
        function showResponseForm(complaintId) {
            document.getElementById('form-' + complaintId).style.display = 'block';
        }

        function submitResponse(complaintId) {
            const responseText = document.querySelector('#form-' + complaintId + ' textarea').value;
            if (responseText.trim() === '') {
                alert('Please enter a response.');
                return;
            }
            fetch('update_complaint_response.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ complaint_id: complaintId, response: responseText })
            })
            .then(response => response.text())
            .then(result => {
                alert(result);
                // Reload page to ensure the responded complaint is hidden
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</body>
</html>