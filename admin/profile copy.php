<?php
// Start the session
session_start();

// Include the database connection
require_once '../includes/db_connection.php';

// Check if the user is logged in as an admin
if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "admin") {
    header("Location: ../login.php");
    exit();
}

// Fetch admin details from the database
$admin_id = $_SESSION['user_id'];
$sql = "SELECT * FROM admin WHERE admin_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

// Check if the form is submitted for updating profile
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    // Retrieve form data
    $username = $_POST['username'];
    $full_name = $_POST['full_name'];
    


    // Check if password is provided
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        // Update admin profile including password
        $update_sql = "UPDATE admin SET  username = ?, password = ?, full_name =?  WHERE admin_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sssi",  $username,$full_name, $password, $admin_id);
    } else {
        // Update admin profile excluding password
        $update_sql = "UPDATE admin SET  username = ?, full_name = ? WHERE admin_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssi", $username, $full_name, $admin_id);
    }
    
    if ($update_stmt->execute()) {
        // Profile updated successfully, redirect to profile page
        header('Location: profile.php');
        exit;
    } else {
        // Error occurred during profile update
        $error = "Error: Unable to update profile. Please try again.";
    }
}

?>

<?php require_once '../includes/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Admin Profile</h2>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Profile Details</h5>
                    <h4 class="card-text"><strong>Full Name:</strong> <?php echo $admin['full_name']; ?></h4>
                    <p class="card-text"><strong>Username:</strong> <?php echo $admin['username']; ?></p>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editProfileModal">Edit Profile</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
                 
                    <div class="form-group">
                        <label for="username">Full Name:</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo $admin['full_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $admin['username']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">New Password:</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
                    </div>
                    <button type="submit" class="btn btn-primary" name="update_profile">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
