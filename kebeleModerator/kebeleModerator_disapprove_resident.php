<?php
// Include the database connection file
require_once '../includes/db_connection.php';

// Check if the user is logged in as a kebele moderator
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'kebeleModerator') {
    // Redirect non-moderator users to the login page or a different page
    header('Location: ../login.php');
    exit;
}

// Check if the resident ID is provided
if (isset($_GET['id'])) {
    $resident_id = intval($_GET['id']);

    // Update the status of the resident to 'disapproved'
    $update_query = "UPDATE residents SET status = 'disapproved' WHERE resident_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('i', $resident_id);

    if ($stmt->execute()) {
        // Redirect to the dashboard with a success message
        $_SESSION['message'] = 'Resident request disapproved successfully!';
        header('Location: kebeleModerator_dashboard.php');
        exit;
    } else {
        // Redirect to the dashboard with an error message
        $_SESSION['error'] = 'Failed to disapprove resident request.';
        header('Location: kebeleModerator_dashboard.php');
        exit;
    }
} else {
    // Redirect to the dashboard if no resident ID is provided
    header('Location: kebeleModerator_dashboard.php');
    exit;
}
?>
