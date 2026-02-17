<?php include 'connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Mess Manager | HMC</title>
    <link rel="stylesheet" href="manager_styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
    body {
    font-family: 'Poppins', sans-serif;
    background-color: #f4f4f4;
    color: #333;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: flex-start; /* Align container towards the top */
    min-height: 100vh;
}

.profile-container {
    display: flex;
    justify-content: space-between; /* Place details and image apart */
    align-items: center;
    flex-direction: row-reverse; /* Make the profile image appear on the right */
    width: 90%; /* Adjust to fit the available space */
    max-width: 1000px;
    background-color: #fff;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-top: 40px; /* Move the container towards the top */
    animation: fadeIn 0.5s ease-in;
    transition: transform 0.3s, box-shadow 0.3s;
}

.profile-container:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.profile-info {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    margin-left: 30px; /* Space between details and image */
}

.profile-info h2 {
    font-size: 30px;
    margin-bottom: 10px;
}

.profile-info p {
    margin: 5px 0;
    font-size: 18px;
}

.profile-img {
    width: 180px;
    height: 180px;
    border-radius: 50%;
    border: 4px solid #3498db;
    overflow: hidden;
    flex-shrink: 0;
}

.profile-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.edit-button {
    align-self: flex-start; /* Position button at bottom left */
    margin-top: 20px;
    padding: 8px 12px; /* Smaller size */
    font-size: 15px; /* Adjust font size */
    background-color:#7d2ae8 ;
    color: #fff;
    border: none;
    border-radius: 8px; /* Rounded corners */
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
}

.edit-button:hover {
    background-color: #5d1ec1;
    transform: translateY(-2px); /* Slight lift effect */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}


.form-group {
    display: none;
    width: 100%;
    margin-top: 20px;
    background-color: #f9f9f9;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
    border: 1px solid #ddd;
}

.profile-container.edit-mode .form-group {
    display: block;
}

.profile-container.edit-mode .profile-info {
    display: none;
}

.form-group label {
    display: block;
    font-size: 16px;
    margin-bottom: 5px;
    color: #555;
}

.form-group input {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: border-color 0.3s;
}

.form-group input:focus {
    border-color: #3498db;
    outline: none;
}

.form-buttons {
    display: flex;
    gap: 10px;
}

.form-buttons button {
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    color: #fff;
    transition: background-color 0.3s, transform 0.3s;
}

.form-buttons button[type="submit"] {
    background-color: #2ecc71;
}

.form-buttons button[type="submit"]:hover {
    background-color: #27ae60;
    transform: scale(1.05);
}

.form-buttons button[type="button"] {
    background-color: #e74c3c;
}

.form-buttons button[type="button"]:hover {
    background-color: #c0392b;
    transform: scale(1.05);
}


    </style>
    <script>
        function toggleMenuDisplay() {
            const mainContent = document.querySelector('.main-content');
            mainContent.classList.toggle('show-menu');
        }
    </script>
    <script>
        function enableEdit() {
            document.querySelector('.profile-container').classList.add('edit-mode');
        }
    </script>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <section class="main-content">
        <div class="profile-container">
            <div class="profile-img">
            <img src="https://imgs.search.brave.com/7RXtN41Ez986XSEYKoQRK-KIYmT0zbK_UAQ2ZtoMhF0/rs:fit:500:0:0:0/g:ce/aHR0cHM6Ly9pbWcu/ZnJlZXBpay5jb20v/cHJlbWl1bS1waG90/by8zZC1hY2NvdW50/LWljb24tcHVycGUt/YmFja2dyb3VuZHRy/ZW5kXzEwMjk0Njkt/MjE4MjQ1LmpwZz9z/ZW10PWFpc19oeWJy/aWQ" alt="manager">
            </div>
            <div class="profile-info">
                <?php
                // Fetch mess manager details
                $managerStmt = $conn->prepare("SELECT * FROM MessManager WHERE mess_manager_id = 1");
                $managerStmt->execute();
                $manager = $managerStmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <h2 id="managerName"><?php echo htmlspecialchars($manager['mess_manager_name']); ?></h2>
                <p><b>Mess Number:</b> <span><?php echo htmlspecialchars($manager['mess']); ?></span></p>
                <p><b>Contact:</b> <span><?php echo htmlspecialchars($manager['phone']); ?></span></p>
                <p><b>Email:</b> <span><?php echo htmlspecialchars($manager['email']); ?></span></p>
                <button type="button" class="edit-button" onclick="enableEdit()">Edit</button>
            </div>

            <form action="update_manager.php" method="POST" enctype="multipart/form-data" class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($manager['mess_manager_name']); ?>" required>
                <label for="mess">Mess Number</label>
                <input type="text" id="mess" name="mess" value="<?php echo htmlspecialchars($manager['mess']); ?>" required>
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($manager['phone']); ?>" required>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($manager['email']); ?>" required>
                <label for="profile_image">Profile Image</label>
                <input type="file" id="profile_image" name="profile_image" accept="img/*">
                <div class="form-buttons">
                    <button type="submit">Save</button>
                    <button type="button" onclick="location.reload()">Cancel</button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>