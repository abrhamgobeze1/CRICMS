<?php
include '../includes/db_connection.php';
session_start();

// Check if the user is logged in as a kebele moderator
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'kebeleModerator') {
    // Redirect non-moderator users to the login page or a different page
    header('Location: ../login.php');
    exit;
}

// Check if the resident ID is provided in the query string
if (isset($_GET['id'])) {
    $residentId = $_GET['id'];

    // Update the expiration date and the updated_at timestamp
    $newExpirationDate = date('Y-m-d', strtotime('+3 years', strtotime(date('Y-m-d'))));
    $sql = "UPDATE residents SET expiration_date = '$newExpirationDate', updated_at = NOW() WHERE resident_id = $residentId";

    if ($conn->query($sql) === TRUE) {
        // Redirect the user back to the main page or display a success message
        header('Location: kebeleModerator_dashboard.php');
        exit;
    } else {
        // Display an error message
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // Redirect the user back to the main page or display an error message
    header('Location: kebeleModerator_dashboard.php');
    exit;
}

// Close the database conn
$conn->close();