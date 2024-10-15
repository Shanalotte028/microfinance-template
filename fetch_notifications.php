<?php
session_start();
require 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    echo "<p>Error: User not logged in.</p>";
    exit();
}

// Get the logged-in user ID from the session
$user_id = $_SESSION['id'];

// // Debugging information
// echo "<p>Debug: User ID from session is $user_id</p>";

// Query to fetch notifications for the current user along with the status, date updated, and message
$query = "
    SELECT images_coe_birthc.status, images_coe_birthc.date_status_updated, images_coe_birthc.message, users.fName
    FROM users
    JOIN images_coe_birthc ON images_coe_birthc.user_id = users.id
    WHERE users.id = ?
";

// Prepare the statement
$stmt = $conn->prepare($query);

if ($stmt === false) {
    echo "<p>Error preparing the query: " . htmlspecialchars($conn->error) . "</p>";
    exit();
}

// Bind the user ID to the query
$stmt->bind_param('i', $user_id);

// Execute the query
if ($stmt->execute()) {
    $result = $stmt->get_result();

    // // Debugging: Output the number of rows found
    // echo "<p>Debug: Number of notifications found: " . $result->num_rows . "</p>";

    // Check if there are notifications
    if ($result->num_rows > 0) {
        // Loop through and display notifications
        while ($row = $result->fetch_assoc()) {
            $message = !empty($row['message']) ? htmlspecialchars($row['message']) : 'No message provided';
            $status = htmlspecialchars($row['status']);
            $fName = htmlspecialchars($row['fName']); // Use 'name' instead of 'fNfame'
            $date_updated = htmlspecialchars($row['date_status_updated']);

            // Assuming $image_path is stored somewhere (e.g., profile pictures)
            $image_path = 'profile_pic/default.jpg'; // Default image path if you don't have user-specific images

            echo "<div class='notification-item mb-3 p-2 border rounded'>";
           
            echo "<p><strong>Name: </strong>$fName</p>";
            echo "<p><strong>Status: </strong>$status</p>";
            echo "<p><strong>Message: </strong>$message</p>";
            echo "<p><small>Date Updated: $date_updated</small></p>";
            echo "</div>";
        }
    } else {
        echo "<p>No new notifications.</p>";
    }
} else {
    echo "<p>Error executing the query: " . htmlspecialchars($stmt->error) . "</p>";
}

// Close the statement
$stmt->close();
?>
