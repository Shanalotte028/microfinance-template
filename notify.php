<?php
session_start();
require 'db.php';
require 'mail.php'; // Make sure this is the correct file for the PHPMailer setup



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the ID is received
    if (!isset($_POST['id'])) {
        echo "No ID received.";
        exit();
    }

    $id = $_POST['id']; // Fetch the ID submitted from the modal
    $message = $_POST['message']; // Get the message from the form
    $action = $_POST['action']; // Approval or decline action

    // Fetch the email from the `images_coe_birthc` table based on the provided ID
    $query = "SELECT email FROM images_coe_birthc WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email']; // Extract the email from the result

        // Generate token and hash it
        $token = bin2hex(random_bytes(16));
        $token_hash = hash("sha256", $token);
        $expiry = date("Y-m-d H:i:s", time() + 60 * 10); // 10-minute expiration

        // Update the reset_token and expiry in the database, as well as the message and status
        $update_query = "UPDATE images_coe_birthc 
                         SET reset_token_hash = ?, reset_token_expires_at = ?, 
                             status = ?, message = ?, date_status_updated = NOW()
                         WHERE id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("ssssi", $token_hash, $expiry, $action, $message, $id);
        $update_stmt->execute();

        if ($conn->affected_rows > 0) {
            // Prepare the email
            $mail->setFrom("mfinance@email.com");
            $mail->addAddress($email);
            $mail->Subject = "Application Status Update";
            $mail->isHTML(true);  // Make sure email content is HTML formatted
            $mail->Body = <<<END
            Your application has been <strong>{$action}</strong>.<br><br>

            Message from the admin: <br><em>{$message}</em><br><br>

            Click <a href="http://localhost/mfinance/view_notification.php?token=$token">here</a> to view the details.
            END;

            // Send the email
            try {
                $mail->send();
                echo "<script>
                    alert('Message sent to the applicant\'s email.');
                    window.location.href = 'index.php'; // Redirect to home page
                </script>";
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Failed to update the database or send the email.";
        }

        $update_stmt->close();
    } else {
        echo "No email found for this ID.";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}
?>


