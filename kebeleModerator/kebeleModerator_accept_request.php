<?php
include '../includes/db_connection.php';
session_start();

// Check if the user is logged in as a kebele moderator
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'kebeleModerator') {
    // Redirect non-moderator users to the login page
    header('Location: ../login.php');
    exit;
}

$kebele_id = $_SESSION['kebele_id'];
$username = $_SESSION['username'];
$kebele_name = $_SESSION['kebele_name'];
$page_title = 'Accept Resident Requests';

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resident_id = $_POST['resident_id'] ?? '';

    if (!empty($resident_id)) {
        // Update the status of the resident to 'pending'
        $update_query = "UPDATE residents SET status = 'pending' WHERE resident_id = ? AND kebele_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ii", $resident_id, $kebele_id);

        if ($stmt->execute()) {
            $success_message = "Resident request accepted successfully.";
        } else {
            $error_message = "Error accepting resident request: " . $conn->error;
        }
    } else {
        $error_message = "Invalid resident ID.";
    }
}

// Fetch requested resident requests from the database
$pending_requests_query = "SELECT * FROM residents WHERE kebele_id = ? AND status = 'requested'";
$stmt = $conn->prepare($pending_requests_query);
$stmt->bind_param("i", $kebele_id);
$stmt->execute();
$pending_requests_result = $stmt->get_result();

include '../includes/header.php';
?>

<div class="container mt-4">
    <h1>Accept Resident Requests</h1>

    <?php if (!empty($error_message)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success_message)) : ?>
        <div class="alert alert-success" role="alert">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Image</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($resident = $pending_requests_result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($resident['resident_id']); ?></td>
                    <td><?php echo htmlspecialchars($resident['username']); ?></td>
                    <td><?php echo htmlspecialchars($resident['full_name']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($resident['image']); ?>" alt="Resident Image" width="50" height="50"></td>
                    <td><?php echo htmlspecialchars($resident['gender']); ?></td>
                    <td><?php echo htmlspecialchars($resident['date_of_birth']); ?></td>
                    <td>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <input type="hidden" name="resident_id" value="<?php echo htmlspecialchars($resident['resident_id']); ?>">
                            <button type="submit" class="btn btn-success btn-sm">Accept</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
