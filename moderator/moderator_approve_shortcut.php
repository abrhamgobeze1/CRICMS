<?php
session_start();
require_once '../includes/db_connection.php'; // Assuming you have a database connection file
include '../includes/header.php';

// Check if the user is logged in as a moderator
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'moderator') {
    // Redirect non-moderator users to the login page or a different page
    header('Location: ../login.php');
    exit;
}

// Check if the resident ID is provided
if (isset($_GET['id'])) {
    $resident_id = intval($_GET['id']);

    // Calculate the expiration date (3 years from now)
    $expiration_date = date('Y-m-d', strtotime('+3 years'));

    // Update the status of the resident to 'approved' and set the expiration date
    $update_query = "UPDATE residents 
                     SET status = 'approved', expiration_date = ?, updated_at = NOW() 
                     WHERE resident_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('si', $expiration_date, $resident_id);

    if ($stmt->execute()) {
        // Redirect to the dashboard with a success message
        $_SESSION['message'] = 'Resident request approved successfully!';
        header('Location: moderator_dashboard.php');
        exit;
    } else {
        // Redirect to the dashboard with an error message
        $_SESSION['error'] = 'Failed to approve resident request.';
        header('Location: moderator_dashboard.php');
        exit;
    }
} else {
    // Redirect to the dashboard if no resident ID is provided
    header('Location: moderator_dashboard.php');
    exit;
}
?>
