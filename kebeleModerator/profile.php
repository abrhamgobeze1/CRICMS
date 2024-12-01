<?php
// Start the session
session_start();

// Include the database connection
require_once '../includes/db_connection.php';

// Check if the user is logged in as an kebeleModerator
if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "kebeleModerator") {
    header("Location: ../login.php");
    exit();
}

// Fetch kebeleModerator details from the database
$kebeleModerator_id = $_SESSION['user_id'];
$sql = "SELECT * FROM kebeleModerator WHERE kebeleModerator_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $kebeleModerator_id);
$stmt->execute();
$result = $stmt->get_result();
$kebeleModerator = $result->fetch_assoc();

// Check if the form is submitted for updating profile
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    // Retrieve form data
    $username = $_POST['username'];
    $full_name = $_POST['full_name'];

    // Handle image upload
    $image = NULL;
    if ($_FILES['image']['size'] > 0) {
        $image_dir = '../images/profile/kebeleModerator';
        $image_name = basename($_FILES['image']['name']);
        $image_path = $image_dir . $image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            $image = $image_name;
        } else {
            $error = "Error uploading the image. Please try again.";
        }
    }

    // Check if password is provided
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        // Update kebeleModerator profile including password and image
        $update_sql = "UPDATE kebeleModerator SET username = ?, password = ?, full_name = ?, image = ? WHERE kebeleModerator_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssssi", $username, $password, $full_name, $image, $kebeleModerator_id);
    } else {
        // Update kebeleModerator profile excluding password, but including image
        $update_sql = "UPDATE kebeleModerator SET username = ?, full_name = ?, image = ? WHERE kebeleModerator_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sssi", $username, $full_name, $image, $kebeleModerator_id);
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
                    <img src="../images/profile/kebeleModerator/<?php echo $kebeleModerator['image']; ?>" alt="Profile Image" class="img-thumbnail mb-3" style="max-width: 200px;">
                    <h4 class="card-text"><strong>Full Name:</strong> <?php echo $kebeleModerator['full_name']; ?></h4>
                    <p class="card-text"><strong>Username:</strong> <?php echo $kebeleModerator['username']; ?></p>
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
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="full_name">Full Name:</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo $kebeleModerator['full_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $kebeleModerator['username']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">New Password:</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
                    </div>
                    <div class="form-group">
                        <label for="image">Profile Image:</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                    </div>
                    <button type="submit" class="btn btn-primary" name="update_profile">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>