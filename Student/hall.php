<?php
include 'check_log.php'; // User login check
include 'database.php'; // Database connection

$student_id = $_SESSION['student_id'];
$gender = $_SESSION['student_gender'];


// Determine hall category based on gender
$category = ($gender === 'Male') ? 'Boys' : 'Girls';

// Check if the student has already booked a room
$hasBookingQuery = "SELECT hall_id, room_number FROM StudentHallDetails WHERE student_id = ?";
$stmt = $conn->prepare($hasBookingQuery);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$stmt->store_result();
$hasBooking = $stmt->num_rows > 0;
$stmt->close();

// Only process the form if there is no existing booking
if (!$hasBooking) {
    // Store selected hall_id and room type after form submission
    $selected_hall_id = $_POST['hall_id'] ?? null;
    $selected_room_type = $_POST['room_type'] ?? '';

    // Fetch hall details if hall_id and room type are selected
    if ($selected_hall_id && $selected_room_type) {
        $hallDetailsQuery = "SELECT hall_name, " . 
                            ($selected_room_type === 'Single' ? 'single_room_cost' : 'twin_sharing_room_cost') . 
                            " AS room_cost, hall_type FROM Halls WHERE hall_id = ?";
        $stmt = $conn->prepare($hallDetailsQuery);
        $stmt->bind_param("i", $selected_hall_id);
        $stmt->execute();
        $stmt->bind_result($hall_name, $room_cost, $hall_type);
        $stmt->fetch();
        $stmt->close();
    }
}


// Handle mess type change submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_mess_type'])) {
    $new_mess_type = $_POST['new_mess_type'];
    $updateMessQuery = "UPDATE StudentHallDetails SET mess_type = ? WHERE student_id = ?";
    $stmt = $conn->prepare($updateMessQuery);
    $stmt->bind_param("ss", $new_mess_type, $student_id);

    if ($stmt->execute()) {
        $alertMessage = "Mess type updated successfully!";
        $messageType = 'success';
    } else {
        $alertMessage = "Failed to update mess type. Please try again.";
        $messageType = 'error';
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hall | Student | HMC</title>
    <link rel="stylesheet" href="student_styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
     <!--sidebar-->
    <?php include 'sidebar.php'; ?>

    <section class="main-content">
        <?php if ($hasBooking): ?>
            <div class="hall-details-section">
            <div class="details-grid">
                <?php
                    // Retrieve student hall and room details for booked room
                    $bookingDetailsQuery = "SELECT H.hall_name, H.hall_type, S.room_number, R.room_type, H.single_room_cost, 
                    H.twin_sharing_room_cost, W.warden_name, S.mess_type,
                        (SELECT roommate.student_id 
                        FROM StudentHallDetails roommate 
                        WHERE roommate.hall_id = S.hall_id 
                            AND roommate.room_number = S.room_number 
                            AND roommate.student_id != ?) AS roommate
                    FROM StudentHallDetails S
                    JOIN Rooms R ON S.room_number = R.room_number AND S.hall_id = R.hall_id 
                    JOIN Halls H ON S.hall_id = H.hall_id
                    JOIN Wardens W ON H.warden_id = W.warden_id
                    WHERE S.student_id = ?";

                    $stmt = $conn->prepare($bookingDetailsQuery);
                    $stmt->bind_param("ss", $student_id, $student_id);
                    $stmt->execute();
                    $stmt->bind_result($hall_name, $hall_type, $room_number, $room_type, $single_room_cost, 
                        $twin_sharing_room_cost, $warden_name, $mess_type, $room_mate);
                    $stmt->fetch();
                    $stmt->close();

                // Query to get the mess manager's name
                $messManagerQuery = "SELECT mess_manager_name FROM MessManager LIMIT 1";
                $result = $conn->query($messManagerQuery);
                $mess_manager_name = $result->fetch_assoc()['mess_manager_name'];


                // Determine room cost based on room type
                $room_cost = ($room_type === 'Single') ? $single_room_cost : $twin_sharing_room_cost;
                ?>

                <div class="section-header"><div>Hall Details</div><i class="bx bxs-school profile-icon"></i></div>
                <div class="row"><div class="label">Hall Name</div><div class="value"><?php echo htmlspecialchars($hall_name); ?></div></div>
                <div class="row"><div class="label">Hall Type</div><div class="value"><?php echo htmlspecialchars($hall_type); ?></div></div>
                <div class="row"><div class="label">Room Number</div><div class="value"><?php echo htmlspecialchars($room_number); ?></div></div>
                <div class="row"><div class="label">Room Type</div><div class="value"><?php echo htmlspecialchars($room_type); ?></div></div>
                <div class="row"><div class="label">Room mate</div><div class="value"><?php echo ($room_type === 'Twin Sharing') ? ($room_mate ??"To be Assigned") : "N/A"; ?></div></div>
                <div class="row">
                    <div class="label">Room Rent</div>
                    <div class="value"><i class="bx bx-rupee"></i><?php echo htmlspecialchars($room_cost); ?></div>
                </div>
                <div class="row"><div class="label">Warden</div><div class="value"><?php echo htmlspecialchars($warden_name); ?></div></div>
                <div class="row"><div class="label">Mess Type</div><div class="value"><?php echo htmlspecialchars($mess_type); ?></div></div>
                <div class="row"><div class="label">Mess Manager</div><div class="value"><?php echo htmlspecialchars($mess_manager_name); ?></div></div>

                <div class="row">
                    <div class="value"> <a href="javascript:void(0);" onclick="openModal()">Rules and Regulations</a></div>
                    <div class="value">
                    <a href="complaints.php">
                        <i class='bx bx-send'></i> Request room change
                    </a>  
                    </div>
                </div> 
                <div class="row">
                    <div class="label"></div>
                    <div class="value">
                    <a href="javascript:void(0);" id="changeMessTypeLink" onclick="toggleMessChangeForm()">
                        <i class='bx bxs-chevrons-down' id="messDownIcon" style="transition: transform 0.3s ease;"></i>Change mess type</a>  
                    </div>
                </div> 

                <div id="messChangeSection">
                    <form id="messChangeForm" method="POST" action="">
                    <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>">
                    <select id="newMessType" name="new_mess_type" required>
                        <option value="" disabled selected>-- Select Mess Type --</option>
                        <option value="Vegetarian">Vegetarian</option>
                        <option value="Non Vegetarian">Non Vegetarian</option>
                    </select>
                    <input type="submit" value="update mess type" class="submit-btn">
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal for Rules and Regulations -->
        <div id="rulesModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2 style="text-align: center;">Rules and Regulations</h2>
                
                <ul>
                    <li><strong>Check-in and Check-out</strong>: Students must check in at the start of the semester and vacate the hall by the announced date at the end of the semester. Late check-outs may incur additional charges.</li>
                    <li><strong>Quiet Hours</strong>: Quiet hours are observed from 10:00 PM to 6:00 AM. Please refrain from loud conversations, music, or other disruptive activities during these hours.</li>
                    <li><strong>Room Maintenance</strong>: Residents are responsible for keeping their rooms and common areas clean and tidy. Damages to property will be charged to the responsible individuals.</li>
                    <li><strong>Guest Policy</strong>: Visitors are allowed only in common areas and must sign in at the hall reception. Overnight stays are not permitted for guests.</li>
                    <li><strong>Prohibited Items</strong>: Possession of prohibited items such as drugs, alcohol, flammable materials, or weapons in the hall premises is strictly forbidden.</li>
                    <li><strong>Curfew</strong>: Students are required to be inside the hall premises by 10:30 PM unless prior permission has been granted by the hall warden.</li>
                    <li><strong>Disciplinary Actions</strong>: Violation of any hall rule may lead to disciplinary actions, including warnings, fines, or even expulsion from the hall.</li>
                    <li><strong>Waste Disposal</strong>: Dispose of any waste in the designated bins. Leaving food or waste on tables is discouraged.</li>
                    <li><strong>Guest Meals</strong>: Students can bring a guest to the mess, but a guest pass must be obtained in advance. Charges will apply as per the guest meal rate.</li>
                    <li><strong>Personal Utensils</strong>: Bringing personal utensils or outside food into the mess area is prohibited for hygiene purposes.</li>

                </ul>
                
            </div>
        </div>
        <?php else: ?>
            <div class="room-booking-grid">
                <h3>Room Booking</h3>
                <form method="POST" action="">
                    <label for="roomType">Room Type:</label>
                    <select id="roomType" name="room_type" onchange="this.form.submit()" required>
                        <option value="" disabled selected>-- Select Room Type --</option>
                        <option value="Single" <?php echo $selected_room_type === 'Single' ? 'selected' : ''; ?>>Single</option>
                        <option value="Twin Sharing" <?php echo $selected_room_type === 'Twin Sharing' ? 'selected' : ''; ?>>Twin Sharing</option>
                    </select>

                    <label for="hallSelect">Select Hall:</label>
                    <select id="hallSelect" name="hall_id" required onchange="this.form.submit()">
                        <option value="" disabled selected>-- Select Hall --</option>
                        <?php
                        // Fetch halls based on gender category
                        $hallsQuery = "SELECT hall_id, hall_name FROM Halls WHERE category = ?";
                        $stmt = $conn->prepare($hallsQuery);
                        $stmt->bind_param("s", $category);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($hall = $result->fetch_assoc()) {
                            $hall_id = $hall['hall_id'];
                            $hall_name_option = htmlspecialchars($hall['hall_name']);
                            $selected = ($selected_hall_id == $hall_id) ? 'selected' : '';
                            echo "<option value='$hall_id' $selected>$hall_name_option</option>";
                        }
                        $stmt->close();
                        ?>
                    </select>
                </form>

                <?php
                if ($selected_room_type === 'Single' && $selected_hall_id) {
                    // Fetch all single rooms for the selected hall
                    $query = "SELECT room_number, student_count FROM Rooms WHERE hall_id = ? AND room_type = 'Single'";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $selected_hall_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    echo "<h2>All Single Rooms in " .  htmlspecialchars($hall_name) . "</h2>";
                    
                    // Legend for Room Selection
                    echo '<div class="legend">
                            <div class="legend-item">
                                <div class="legend-box avl"></div>
                                <span>Available Room</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-box ocp"></div>
                                <span>Occupied Room</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-box slc"></div>
                                <span>Selected Room</span>
                            </div>
                        </div>';

                    // Room layout
                    echo "<div class='room-selection'>";
                    $rooms = [];
                    while ($row = $result->fetch_assoc()) {
                        $room_number = htmlspecialchars($row['room_number']);
                        $is_available = $row['student_count'] === 0;
                        $room_class = $is_available ? 'room available' : 'room occupied';
                        $rooms[] = "<div class='$room_class' onclick='selectRoom(this, \"$room_number\", \"$selected_hall_id\", $is_available)'>$room_number</div>";
                    }

                    $layout = [
                        array_reverse(array_slice($rooms, 1, 12)),
                        [$rooms[13], $rooms[0]],
                        [$rooms[14]],
                        [$rooms[15]],
                        [$rooms[16], $rooms[29]],
                        array_slice($rooms, 17, 12),
                    ];

                    foreach ($layout as $row) {
                        echo "<div class='row'>";
                        foreach ($row as $room) {
                            echo $room;
                        }
                        echo "</div>";
                    }

                    echo "</div>";
                    $stmt->close();
                }
                ?>

                <!-- Booking form -->
                <form id="bookingForm" method="POST" action="process_booking.php" onsubmit="return validateSelection()">
                    <?php
                    if ($selected_hall_id) {
                        if ($selected_room_type === 'Single') {
                            echo "<p><label>Hall Type:</label> <span>".htmlspecialchars($hall_type)."</span></p>";
                            echo "<p><label>Room Number:</label> <span id=\"displayRoomNumber\">Please select a room</span></p>";
                            echo "<p><label>Room Rent:</label><span> <i class = \"bx bx-rupee\"></i>".htmlspecialchars($room_cost)."</span></p>";
                        } elseif ($selected_room_type === 'Twin Sharing') {
                            echo "<p><label>Hall Type:</label> <span>".htmlspecialchars($hall_type)."</span></p>";
                            echo "<p><label>Room Number:</label> Twin sharing rooms are randomly allotted</p>";
                            echo "<p><label>Room Rent:</label><span> <i class = \"bx bx-rupee\"></i>".htmlspecialchars($room_cost)."</span></p>";
                        }
                    }
                    ?>
                    <input type="hidden" id="selectedRoom" name="room_number" value="">
                    <input type="hidden" id="selectedHall" name="hall_id" value="<?php echo htmlspecialchars($selected_hall_id); ?>">
                    <input type="hidden" id="selectedRoomType" name="room_type" value="<?php echo htmlspecialchars($selected_room_type); ?>">
                    <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>">
                    
                    <label for="messType">Mess Type:</label>
                    <select id="selectedMessType" name="mess_type">
                        <option value="" disabled selected>-- Select Mess Type --</option>
                        <option value="Vegetarian">Vegetarian</option>
                        <option value="Non Vegetarian">Non Vegetarian</option>
                    </select>

                    <input type="submit" value="Confirm Booking" class="submit-btn">
                </form>
            </div>
        <?php endif; ?>

        <div class="mess-menu-section">
            <?php

            // Retrieve vegetarian menu
            $vegQuery = "SELECT day_of_week, breakfast, lunch, dinner FROM MessMenu WHERE type = 'vegetarian' ORDER BY FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')";
            $vegResult = $conn->query($vegQuery);

            // Retrieve non-vegetarian menu
            $nonVegQuery = "SELECT day_of_week, breakfast, lunch, dinner FROM MessMenu WHERE type = 'non-vegetarian' ORDER BY FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')";
            $nonVegResult = $conn->query($nonVegQuery);
            ?>
                            
                <div class="details-grid veg">
                    <div class="section-header">
                        <div>Vegetarian Menu</div>
                        <i class="ph-fill ph-carrot profile-icon"></i>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Day</th>
                                <th>Breakfast</th>
                                <th>Lunch</th>
                                <th>Dinner</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $vegResult->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['day_of_week']); ?></td>
                                    <td><?php echo htmlspecialchars($row['breakfast']); ?></td>
                                    <td><?php echo htmlspecialchars($row['lunch']); ?></td>
                                    <td><?php echo htmlspecialchars($row['dinner']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Non-Vegetarian Menu Section -->
                <div class="details-grid non-veg">
                    <div class="section-header">
                        <div>Non-Vegetarian Menu</div>
                        <i class="ph-fill ph-fish profile-icon"></i>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Day</th>
                                <th>Breakfast</th>
                                <th>Lunch</th>
                                <th>Dinner</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $nonVegResult->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['day_of_week']); ?></td>
                                    <td><?php echo htmlspecialchars($row['breakfast']); ?></td>
                                    <td><?php echo htmlspecialchars($row['lunch']); ?></td>
                                    <td><?php echo htmlspecialchars($row['dinner']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
        </div>

    </section>

    <?php include 'footer.php'; ?>

    <script>
        function selectRoom(element, roomNumber, hallId, isAvailable) {
            if (!isAvailable) return;
            const displayRoomNumber = document.getElementById('displayRoomNumber');

            if (element.classList.contains('selected')) {
                element.classList.remove('selected');
                document.getElementById('selectedRoom').value = '';
                displayRoomNumber.textContent = 'Please select a room';
            } else {
                document.querySelectorAll('.room').forEach(room => room.classList.remove('selected'));
                element.classList.add('selected');
                document.getElementById('selectedRoom').value = roomNumber;
                displayRoomNumber.textContent = roomNumber;
            }
        }
        function validateSelection() {
            const selectedRoom = document.getElementById('selectedRoom').value;
            const selectedRoomType = document.getElementById('selectedRoomType').value;
            const selectedHall = document.getElementById('selectedHall').value;
            const selectedMessType = document.getElementById('selectedMessType').value;

            // Form validation logic
            if (!selectedRoomType) {
                alert("Please select a room type.");
                return false;
            }
            if (!selectedHall) {
                alert("Please select a hall.");
                return false;
            }
            if (selectedRoomType === 'Single' && !selectedRoom) {
                alert("Please select a room.");
                return false;
            }
            if (!selectedMessType) {
                alert("Please select a mess type.");
                return false;
            }
            if (selectedRoomType === "Twin Sharing") {
                if (!confirm("Confirm your booking for a Twin Sharing room?")) {
                    return false;
                }
            } else {
                if (!confirm("Confirm your booking for a Single room " + selectedRoom + "?")) {
                    return false;
                }
            }

            // Prevent form submission and handle with AJAX
            const formData = new FormData(document.getElementById('bookingForm'));

            // AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "process_booking.php", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    const response = JSON.parse(xhr.responseText);
                    alert(response.message);  // Display the success or error message from PHP
                    if (response.success) {
                        window.location.href = 'hall.php';  // Redirect on success
                    }
                }
            };
            xhr.send(formData);

            return false;  // Prevent the default form submission
        }


        function toggleMessChangeForm() {
            const form = document.getElementById("messChangeSection");
            const messDownIcon = document.getElementById("messDownIcon");
            if (form.style.display === "none" || form.style.display === "") {
                messDownIcon.style.transform = "rotate(180deg)";
                form.style.display = "block";
            } else {
                messDownIcon.style.transform = "rotate(0deg)";
                form.style.display = "none";
            }
        }


        function openModal() {
            document.getElementById("rulesModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("rulesModal").style.display = "none";
        }

        // Optional: Close the modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById("rulesModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

    </script>
</body>
</html>
