<?php
// Include the database connection file
require_once '../includes/db_connection.php';

// Initialize variables
$recent_activities = []; // Assuming this data will be fetched later
$events = []; // Assuming this data will be fetched later
$notifications = []; // Assuming this data will be fetched later

// Check if the user is logged in as a kebele moderator
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'kebeleModerator') {
    // Redirect non-moderator users to the login page or a different page
    header('Location: ../login.php');
    exit;
}

// Fetch kebele moderator information
$moderator_id = $_SESSION['user_id']; // Assuming moderator_id is stored in the session
$kebele_id = $_SESSION['kebele_id']; // Assuming kebele_id is also stored in the session
$username = $_SESSION['username']; // Assuming username is stored in the session
$kebele_name = $_SESSION['kebele_name']; // Assuming kebele_name is stored in the session

// Welcome Message
$welcome_message = "Welcome, $username! You are assigned to Kebele: $kebele_name";

// Query to get counts for Quick Stats
$sql = "SELECT 
            COUNT(*) AS total_residents,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS pending_registrations,
            SUM(CASE WHEN status = 'requested' THEN 1 ELSE 0 END) AS requested_registrations,
            SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) AS approved_registrations,
            SUM(CASE WHEN status = 'disapproved' THEN 1 ELSE 0 END) AS disapproved_registrations,
            SUM(CASE WHEN expiration_date < CURDATE() THEN 1 ELSE 0 END) AS expired_registrations

        FROM residents
        WHERE kebele_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $kebele_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_residents = $row['total_residents'];
    $pending_registrations = $row['pending_registrations'];
    $requested_registrations = $row['requested_registrations'];
    $approved_registrations = $row['approved_registrations'];
    $disapproved_registrations = $row['disapproved_registrations'];
    $expired_registrations = $row['expired_registrations'];
}

// Fetch pending registrations for the assigned kebele
$pending_registrations_query = "SELECT r.resident_id, r.username, r.full_name, r.status, k.kebele_name, c.city_name 
                                FROM residents r
                                JOIN kebele k ON r.kebele_id = k.kebele_id
                                JOIN city c ON r.city_id = c.city_id
                                WHERE r.status = 'pending' AND r.kebele_id = ?";
$pending_stmt = $conn->prepare($pending_registrations_query);
$pending_stmt->bind_param("i", $kebele_id);
$pending_stmt->execute();
$pending_registrations_result = $pending_stmt->get_result();

// Fetch requested registrations for the assigned kebele
$requested_registrations_query = "SELECT r.resident_id, r.username, r.full_name, r.status, k.kebele_name, c.city_name 
                                  FROM residents r
                                  JOIN kebele k ON r.kebele_id = k.kebele_id
                                  JOIN city c ON r.city_id = c.city_id
                                  WHERE r.status = 'requested' AND r.kebele_id = ?";
$requested_stmt = $conn->prepare($requested_registrations_query);
$requested_stmt->bind_param("i", $kebele_id);
$requested_stmt->execute();
$requested_registrations_result = $requested_stmt->get_result();

// Fetch approved registrations for the assigned kebele
$approved_registrations_query = "SELECT r.resident_id, r.username, r.full_name, r.status, k.kebele_name, c.city_name 
                                 FROM residents r
                                 JOIN kebele k ON r.kebele_id = k.kebele_id
                                 JOIN city c ON r.city_id = c.city_id
                                 WHERE r.status = 'approved' AND r.kebele_id = ?";
$approved_stmt = $conn->prepare($approved_registrations_query);
$approved_stmt->bind_param("i", $kebele_id);
$approved_stmt->execute();
$approved_registrations_result = $approved_stmt->get_result();

// Fetch disapproved registrations for the assigned kebele
$disapproved_registrations_query = "SELECT r.resident_id, r.username, r.full_name, r.status, k.kebele_name, c.city_name 
                                    FROM residents r
                                    JOIN kebele k ON r.kebele_id = k.kebele_id
                                    JOIN city c ON r.city_id = c.city_id
                                    WHERE r.status = 'disapproved' AND r.kebele_id = ?";
$disapproved_stmt = $conn->prepare($disapproved_registrations_query);
$disapproved_stmt->bind_param("i", $kebele_id);
$disapproved_stmt->execute();
$disapproved_registrations_result = $disapproved_stmt->get_result();


// Fetch expired registrations for the assigned kebele
$expired_registrations_query = "SELECT r.resident_id, r.username,r.expiration_date, r.full_name, r.status, k.kebele_name, c.city_name 
                                FROM residents r
                                JOIN kebele k ON r.kebele_id = k.kebele_id
                                JOIN city c ON r.city_id = c.city_id
                                WHERE r.expiration_date < CURDATE() AND r.kebele_id = ?";
$expired_stmt = $conn->prepare($expired_registrations_query);
$expired_stmt->bind_param("i", $kebele_id);
$expired_stmt->execute();
$expired_registrations_result = $expired_stmt->get_result();

// Include the header file
include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebele Moderator Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="../css/all.min.css">
    <script src="../js/chart.js"></script>

    <!-- Custom CSS -->
    <style>
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h5 {
            margin-bottom: 0;
        }

        .card-body {
            max-height: 400px;
            overflow-y: auto;
        }

        .status-pill {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1;
            border-radius: 0.25rem;
        }

        .status-pill.pending {
            background-color: #ffc107;
            color: #333;
        }

        .status-pill.approved {
            background-color: #28a745;
            color: #fff;
        }

        .status-pill.disapproved {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container-fluid py-4">
        <!-- Welcome Message -->
        <div class="alert alert-primary" role="alert">
            <?php echo $welcome_message; ?>
        </div>


        <!-- Action Buttons -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <a href="kebeleModerator_manage_residents.php" class="btn btn-primary btn-lg btn-block">Manage Residents</a>
            </div>



            <div class="col-md-4 mb-4">
                <div class="card-body">
                    <h5 class="card-title">Quick Stats</h5>
                    <!-- Use canvas element for the chart -->
                    <canvas id="quickStatsChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Registrations Sections -->
        <div class="row">
            <!-- Pending Registrations -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Pending Registrations</h5>
                        <span class="badge bg-warning"><?php echo $pending_registrations; ?></span>
                    </div>
                    <div class="card-body">
                        <?php while ($row = $pending_registrations_result->fetch_assoc()) : ?>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6><?php echo $row['username']; ?></h6>
                                    <p class="mb-0"><?php echo $row['full_name']; ?></p>
                                    <p class="mb-0"><?php echo $row['kebele_name']; ?>, <?php echo $row['city_name']; ?></p>
                                </div>
                                <div>
                                    <span class="status-pill approved">Pending</span>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>



            <!-- Requested Registrations -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Requested Registrations</h5>
                        <span class="badge bg-warning"><?php echo $requested_registrations; ?></span>
                    </div>
                    <div class="card-body">
                        <?php while ($row = $requested_registrations_result->fetch_assoc()) : ?>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6><?php echo $row['username']; ?></h6>
                                    <p class="mb-0"><?php echo $row['full_name']; ?></p>
                                    <p class="mb-0"><?php echo $row['kebele_name']; ?>, <?php echo $row['city_name']; ?></p>
                                </div>
                                <div>
                                    <a href="kebeleModerator_accept_to_pending.php?id=<?php echo $row['resident_id']; ?>" class="btn btn-success btn-sm mr-2">Accept</a>
                                    <a href="kebeleModerator_disapprove_resident.php?id=<?php echo $row['resident_id']; ?>" class="btn btn-danger btn-sm">Disapprove</a>
                                </div>
                                <div>
                                    <span class="status-pill approved">Requested</span>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
            <!-- Approved Registrations -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Approved Registrations</h5>
                        <span class="badge bg-success"><?php echo $approved_registrations; ?></span>
                    </div>
                    <div class="card-body">
                        <?php while ($row = $approved_registrations_result->fetch_assoc()) : ?>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6><?php echo $row['username']; ?></h6>
                                    <p class="mb-0"><?php echo $row['full_name']; ?></p>
                                    <p class="mb-0"><?php echo $row['kebele_name']; ?>, <?php echo $row['city_name']; ?></p>
                                </div>
                                <div>
                                    <span class="status-pill approved">Approved</span>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>

            <!-- Disapproved Registrations -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Disapproved Registrations</h5>
                        <span class="badge bg-danger"><?php echo $disapproved_registrations; ?></span>
                    </div>
                    <div class="card-body">
                        <?php while ($row = $disapproved_registrations_result->fetch_assoc()) : ?>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6><?php echo $row['username']; ?></h6>
                                    <p class="mb-0"><?php echo $row['full_name']; ?></p>
                                    <p class="mb-0"><?php echo $row['kebele_name']; ?>, <?php echo $row['city_name']; ?></p>
                                </div>
                                <div>
                                <a href="kebeleModerator_accept_to_pending.php?id=<?php echo $row['resident_id']; ?>" class="btn btn-success btn-sm mr-2">Accept</a>
                                <a href="kebeleModerator_delete_from_system.php?id=<?php echo $row['resident_id']; ?>" class="btn btn-danger btn-sm mr-2">Remove</a>
                                </div>
                                <div>
                                    <span class="status-pill disapproved">Disapproved</span>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>


            <!-- Expired Registrations -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Expired Registrations</h5>
                        <span class="badge bg-danger"><?php echo $expired_registrations; ?></span>
                    </div>
                    <div class="card-body">
                        <?php while ($row = $expired_registrations_result->fetch_assoc()) : ?>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6><?php echo $row['username']; ?></h6>
                                    <p class="mb-0"><?php echo $row['full_name']; ?></p>
                                    <p class="mb-0"><?php echo $row['kebele_name']; ?>, <?php echo $row['city_name']; ?></p>
                                    <p class="mb-0"><?php echo $row['expiration_date']; ?></p>

                                </div>
                                <div>
                                    <div>
                                    </div>
                                    <a href="kebeleModerator_delete_from_system.php?id=<?php echo $row['resident_id']; ?>" class="btn btn-danger btn-sm mr-2">Remove</a>

                                    <a href="extend_expiration_registrations.php?id=<?php echo $row['resident_id']; ?>" class="btn btn-success btn-sm mr-2">Extend Expiration</a>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>


        </div>


    </div>

    <!-- Include footer -->
    <?php include '../includes/footer.php'; ?>

    <script>
        // Quick Stats Chart
        var ctx = document.getElementById('quickStatsChart').getContext('2d');
        var quickStatsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Residents', 'Pending Registrations', 'Approved Registrations', 'Disapproved Registrations'],
                datasets: [{
                    label: 'Counts',
                    data: [<?php echo $total_residents; ?>, <?php echo $pending_registrations; ?>, <?php echo $approved_registrations; ?>, <?php echo $disapproved_registrations; ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>