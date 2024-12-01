<?php
// Start the session
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    // Redirect non-admin users to the login page or a different page
    header('Location: ../login.php');
    exit;
}

// Connect to the database
require_once '../includes/db_connection.php';
include '../includes/header.php';

// Fetch data for the admin dashboard
$total_residents_query = "SELECT COUNT(*) AS total_from_residents FROM residents";
$total_residents_result = $conn->query($total_residents_query);
$total_residents = $total_residents_result->fetch_assoc()['total_from_residents'];

$total_approved_residents_query = "SELECT COUNT(*) AS total_from_residents FROM residents WHERE status = 'approved'";
$total_approved_residents_result = $conn->query($total_approved_residents_query);
$total_approved_residents = $total_approved_residents_result->fetch_assoc()['total_from_residents'];

$total_pending_residents_query = "SELECT COUNT(*) AS total_from_residents FROM residents WHERE status = 'pending'";
$total_pending_residents_result = $conn->query($total_pending_residents_query);
$total_pending_residents = $total_pending_residents_result->fetch_assoc()['total_from_residents'];

$total_disapproved_residents_query = "SELECT COUNT(*) AS total_from_residents FROM residents WHERE status = 'disapproved'";
$total_disapproved_residents_result = $conn->query($total_disapproved_residents_query);
$total_disapproved_residents = $total_disapproved_residents_result->fetch_assoc()['total_from_residents'];

$total_moderators_query = "SELECT COUNT(*) AS total_from_moderator FROM moderator";
$total_moderators_result = $conn->query($total_moderators_query);
$total_moderators = $total_moderators_result->fetch_assoc()['total_from_moderator'];

$total_kebele_moderators_query = "SELECT COUNT(*) AS total_from_kebeleModerator FROM kebeleModerator";
$total_kebele_moderators_result = $conn->query($total_kebele_moderators_query);
$total_kebele_moderators = $total_kebele_moderators_result->fetch_assoc()['total_from_kebeleModerator'];



// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Nekemte City Resident ID</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card bg-primary text-white">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title mb-2">Total Residents</h5>
                        <p class="card-text display-4 mb-0"><?php echo $total_residents; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card bg-success text-white">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title mb-2">Approved Residents</h5>
                        <p class="card-text display-4 mb-0"><?php echo $total_approved_residents; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card bg-warning text-white">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title mb-2">Pending Residents</h5>
                        <p class="card-text display-4 mb-0"><?php echo $total_pending_residents; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card bg-danger text-white">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title mb-2">Disapproved Residents</h5>
                        <p class="card-text display-4 mb-0"><?php echo $total_disapproved_residents; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card bg-info text-white">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title mb-2">Total Moderators</h5>
                        <p class="card-text display-4 mb-0"><?php echo $total_moderators; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card bg-secondary text-white">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title mb-2">Total Kebele Moderators</h5>
                        <p class="card-text display-4 mb-0"><?php echo $total_kebele_moderators; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>