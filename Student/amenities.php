<?php
include 'check_log.php'; // User login check
include 'database.php'; // Database connection

$student_id = $_SESSION['student_id'];

$hall_id = null;
// Retrieve hall_id from StudentHallDetails
if ($student_id) {
    $hall_query = "SELECT hall_id FROM StudentHallDetails WHERE student_id = ?";
    $hall_stmt = $conn->prepare($hall_query);
    $hall_stmt->bind_param("s", $student_id);
    $hall_stmt->execute();
    $hall_result = $hall_stmt->get_result();

    if ($hall_result->num_rows > 0) {
        $hall_row = $hall_result->fetch_assoc();
        $hall_id = $hall_row['hall_id'];
    }
}

$amenities_result = [];
if ($hall_id) {
    // Fetch amenities for the student's hall
    $amenities_query = "SELECT amenity_id, amenity_name, amenity_cost FROM Amenities WHERE hall_id = ?";
    $amenities_stmt = $conn->prepare($amenities_query);
    $amenities_stmt->bind_param("i", $hall_id);
    $amenities_stmt->execute();
    $amenities_result = $amenities_stmt->get_result();
}

$bookedAmenities = [];
if($hall_id){
    $booked_amenities_query = "SELECT a.amenity_name, ab.booking_id, ab.start_date, ab.end_date, ab.total_cost
                                FROM AmenityBookings ab
                                JOIN Amenities a ON ab.amenity_id = a.amenity_id
                                WHERE ab.student_id = ?
                                ORDER BY 
                                    (CURDATE() BETWEEN ab.start_date AND ab.end_date) DESC, 
                                    ab.start_date DESC";

    $booked_amenities_stmt = $conn->prepare($booked_amenities_query);
    $booked_amenities_stmt->bind_param("s", $student_id);
    $booked_amenities_stmt->execute();
    $result = $booked_amenities_stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $bookedAmenities[] = $row;
    }

    $booked_amenities_stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amenities | Student | HMC</title>
    <link rel="stylesheet" href="student_styles.css">
    <!--Icons-->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Include flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Include flatpickr JS and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
     <!--sidebar-->
    <?php include 'sidebar.php'; ?>

    <section class="main-content">
    <?php if ($hall_id): ?>
        <div class="amenity-form-section">
            <div class="details-grid">
                <div class="section-header"><div>Book an amenity</div><i class='bx bxs-widget profile-icon'></i></div>
                    <form id="amenityBookingForm" onsubmit="return validateAmenitySelection()">
                        <label for="amenity">Select Amenity:</label>
                        <select name="amenity_id" id="amenitySelect">
                            <option value="" disabled selected>--Select an Amenity--</option>
                            <?php while ($amenity = $amenities_result->fetch_assoc()): ?>
                                <option value="<?php echo $amenity['amenity_id']; ?>" data-cost="<?php echo $amenity['amenity_cost']; ?>">
                                    <?php echo htmlspecialchars($amenity['amenity_name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>

                        <label for="amenity_cost">Amenity Cost:</label>
                        <input type="text" name="amenity_cost" id="amenityCostDisplay" readonly>

                        <label for="date_range">Select Date Range:</label>
                        <input type="text" name="date_range" id="date_range">

                        <input type="hidden" name="start_date" id="startDate">
                        <input type="hidden" name="end_date" id="endDate">

                        <label for="total_cost">Total Cost:</label>
                        <input type="text" name="total_cost" id="totalCostDisplay" readonly>

                        <input type="hidden" name="hall_id" value="<?php echo htmlspecialchars($hall_id); ?>">
                        <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>">

                        <p>You can cancel the amenity booking until it is activated (before the start date).<br>
                        Cancellation is not available once the amenity has been activated.</p>
                        <button type="submit" class="submit-btn">Book Amenity</button>
                    </form>
            </div>
        </div>

        <div class="booked-amenities-section">
            <div class="details-grid">
            <div class="section-header"><div>Booked amenities</div><i class="bx bx-history profile-icon"></i></div>
            <?php if (!empty($bookedAmenities)): ?>
                <div class="amenities-container">
                <?php $currentDate = date("Y-m-d"); ?>
                <?php foreach ($bookedAmenities as $amenity): ?>
                    <?php 
                        if ($currentDate > $amenity['end_date']) {
                            $status = 'completed';
                        } elseif ($currentDate < $amenity['start_date']) {
                            $status = 'activates soon';
                        } else {
                            $status = 'active';
                        }
                    ?>
                    <div class="complaint-card">
                        <div class="attribute"><span>Booking ID</span><?php echo htmlspecialchars($amenity['booking_id']); ?></div>
                        <div class="attribute"><span>Amenity Name</span><?php echo htmlspecialchars($amenity['amenity_name']); ?></div>
                        <div class="attribute"><span>Start Date</span><?php echo htmlspecialchars($amenity['start_date']); ?></div>
                        <div class="attribute"><span>End Date</span><?php echo htmlspecialchars($amenity['end_date']); ?></div>
                        <div class="attribute"><span>Total Cost</span><?php echo htmlspecialchars($amenity['total_cost']); ?></div>
                        <div class="attribute"><span>Status</span><div class="<?php echo 'amenity-'.htmlspecialchars($status); ?>"><?php echo htmlspecialchars($status); ?></div></div>
                        
                        <?php if ($currentDate < $amenity['start_date']): ?>
                            <form id="cancelForm-<?php echo $amenity['booking_id']; ?>" action="amenity_cancel.php" method="POST">
                                <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($amenity['booking_id']); ?>">
                            </form>
                            <button type="button" class="cancel-btn" onclick="confirmCancel(<?php echo $amenity['booking_id']; ?>)">
                                Cancel Booking
                            </button>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
                <p>No amenities booked.</p>
            <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="useful-info">
        <p>“It looks like you haven’t booked a room yet! Booking a room on campus offers you a personal 
                    space to relax, study, and feel at home. Don’t miss out on the convenience and sense of community 
                    that come with campus life. Head over to the <a href="hall.php">room booking page</a> now to secure your space and make 
                    the most of your campus experience!”</p>
        </div>
    <?php endif; ?>

    </section>

    <?php include 'footer.php'; ?>

    <script>
        let amenityCost = 0; // To store selected amenity cost
        let datePicker = flatpickr("#date_range", {
            mode: "range",
            dateFormat: "Y-m-d",
            minDate: "today", // Disable past dates
            onChange: function(selectedDates) {
                calculateTotalCost(selectedDates); // Calculate total cost on date change
                if (selectedDates.length === 2) {
                    // Format the date range into string
                    const startDate = selectedDates[0];
                    const endDate = selectedDates[1];
                    // Ensure the dates are formatted correctly to YYYY-MM-DD
                    const formattedStartDate = startDate.toLocaleDateString('en-CA');
                    const formattedEndDate = endDate.toLocaleDateString('en-CA');
                    // Set hidden fields for form submission
                    $('#startDate').val(formattedStartDate);
                    $('#endDate').val(formattedEndDate);                
                }
            }
        });

        // Display amenity cost when an amenity is selected
        $('#amenitySelect').on('change', function() {
            const selectedOption = $(this).find(':selected');
            amenityCost = parseFloat(selectedOption.data('cost')) || 0;

            if (amenityCost) {
                $('#amenityCostDisplay').val(amenityCost.toFixed(2));
            } else {
                $('#amenityCostDisplay').html('');
            }

            // Reset date picker and total cost display when a new amenity is selected
            datePicker.clear();
            $('#totalCostDisplay').val('');
        });

    // Calculate total cost based on selected dates and amenity cost
    function calculateTotalCost(selectedDates = []) {
        if (selectedDates.length === 2 && amenityCost > 0) {
            // Normalize both dates to ignore time
            const startDate = selectedDates[0];
            const endDate = selectedDates[1];

            // Set both start and end dates to midnight UTC to ignore time
            startDate.setHours(0, 0, 0, 0);
            endDate.setHours(0, 0, 0, 0);

            // Calculate the number of milliseconds between the dates
            const timeDifference = endDate - startDate;

            // Convert milliseconds to days (1000 * 60 * 60 * 24 = milliseconds in one day)
            const days = timeDifference / (1000 * 60 * 60 * 24) + 1; // Add 1 because both dates are inclusive

            if (days > 0) {
                const totalCost = days * amenityCost;
                $('#totalCostDisplay').val(totalCost.toFixed(2));
            } else {
                $('#totalCostDisplay').val('');
            }
        } else {
            $('#totalCostDisplay').val('');
        }
    }

    // Validate the form before submitting
    function validateAmenitySelection() {
        const selectedAmenity = document.getElementById('amenitySelect').value;
        const selectedDateRange = document.getElementById('date_range').value;
        if (!selectedAmenity) {
            alert("Please select an amenity.");
            return false;
        }
        if (!selectedDateRange) {
            alert("Please select a date range.");
            return false;
        }

        const confirmation = confirm("Are you sure you want to book this amenity?");
        if (!confirmation) {
            return false;
        }

        // Serialize the form and submit via AJAX
        const formData = $('#amenityBookingForm').serialize();

        $.ajax({
            type: 'POST',
            url: 'amenity_booking.php',
            data: formData,
            success: function(response) {
                alert(response);  
                location.reload();
            },
            error: function(xhr, status, error) {
                alert('An error occurred. Please try again.');
            }
        });

        return false;  // Prevent regular form submission
    }

    // Function to confirm and cancel the booking using AJAX
    function confirmCancel(bookingId) {

        if (confirm("Are you sure you want to cancel this booking?")) {
            // Serialize the form data for the specific booking ID
            const formData = $('#cancelForm-' + bookingId).serialize();

            // Use jQuery AJAX to submit the form data to the server
            $.ajax({
                type: 'POST',
                url: 'amenity_cancel.php',
                data: formData,
                success: function(response) {
                    alert(response); 
                    location.reload(); 
                },
                error: function(xhr, status, error) {
                    alert('An error occurred. Please try again.');
                }
            });
        }
    }


    </script>
</body>
</html>
