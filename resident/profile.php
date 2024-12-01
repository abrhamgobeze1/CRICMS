<?php
// Start the session
session_start();

// Include the database connection
require_once '../includes/db_connection.php';

// Check if the user is logged in as an resident
if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "resident") {
    header("Location: ../login.php");
    exit();
}

// Fetch residents details from the database
$resident_id = $_SESSION['user_id'];
$sql = "SELECT * FROM residents WHERE resident_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $resident_id);
$stmt->execute();
$result = $stmt->get_result();
$residents = $result->fetch_assoc();

// Check if the form is submitted for updating profile
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    // Retrieve form data
    $username = $_POST['username'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $marital_status = $_POST['marital_status'];
    $number_of_dependents = $_POST['number_of_dependents'];
    $emergency_contact_name = $_POST['emergency_contact_name'];
    $emergency_contact_phone = $_POST['emergency_contact_phone'];
    $blood_type = $_POST['blood_type'];

    // Check if password is provided
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        // Update residents profile including password
        $update_sql = "UPDATE residents SET username = ?, password = ?, phone_number = ?, email = ?,  marital_status = ?, number_of_dependents = ?, emergency_contact_name = ?, emergency_contact_phone = ?, blood_type = ? WHERE resident_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sssssisssi", $username, $password, $phone_number, $email, $marital_status, $number_of_dependents, $emergency_contact_name, $emergency_contact_phone, $blood_type, $resident_id);
    } else {
        // Update residents profile excluding password
        $update_sql = "UPDATE residents SET username = ?, phone_number = ?, email = ?,  marital_status = ?, number_of_dependents = ?, emergency_contact_name = ?, emergency_contact_phone = ?, blood_type = ? WHERE resident_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssssisssi", $username, $phone_number, $email,  $marital_status, $number_of_dependents, $emergency_contact_name, $emergency_contact_phone, $blood_type, $resident_id);
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
            <?php if (isset($error)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <div class="card">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Profile Details</h5>
                        <img src="<?php echo $residents['image']; ?>" alt="Profile Image" class="img-thumbnail mb-3" style="max-width: 200px;">
                        <h4 class="card-text"><strong>Full Name:</strong> <?php echo $residents['full_name']; ?></h4>
                        <p class="card-text"><strong>Username:</strong> <?php echo $residents['username']; ?></p>
                        <p class="card-text"><strong>Phone Number:</strong> <?php echo $residents['phone_number']; ?></p>
                        <p class="card-text"><strong>Email:</strong> <?php echo $residents['email']; ?></p>
                        <p class="card-text"><strong>Marital Status:</strong> <?php echo $residents['marital_status']; ?></p>
                        <p class="card-text"><strong>Number of Dependents:</strong> <?php echo $residents['number_of_dependents']; ?></p>
                        <p class="card-text"><strong>Emergency Contact Name:</strong> <?php echo $residents['emergency_contact_name']; ?></p>
                        <p class="card-text"><strong>Emergency Contact Phone:</strong> <?php echo $residents['emergency_contact_phone']; ?></p>
                        <p class="card-text"><strong>Blood Type:</strong> <?php echo $residents['blood_type']; ?></p>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editProfileModal">Edit Profile</button>
                    </div>
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
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $residents['username']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">New Password:</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
                    </div>

                    <div class="form-group">
                        <label for="phone_number">Phone Number:</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $residents['phone_number']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $residents['email']; ?>" required>
                    </div>
                
                    <div class="form-group">
                        <label for="marital_status">Marital Status:</label>
                        <select class="form-control" id="marital_status" name="marital_status" required>
                            <option value="single" <?php if ($residents['marital_status'] == 'single') echo 'selected'; ?>>Single</option>
                            <option value="married" <?php if ($residents['marital_status'] == 'married') echo 'selected'; ?>>Married</option>
                            <option value="divorced" <?php if ($residents['marital_status'] == 'divorced') echo 'selected'; ?>>Divorced</option>
                            <option value="widowed" <?php if ($residents['marital_status'] == 'widowed') echo 'selected'; ?>>Widowed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="number_of_dependents">Number of Dependents:</label>
                        <input type="number" class="form-control" id="number_of_dependents" name="number_of_dependents" value="<?php echo $residents['number_of_dependents']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="emergency_contact_name">Emergency Contact Name:</label>
                        <input type="text" class="form-control" id="emergency_contact_name" name="emergency_contact_name" value="<?php echo $residents['emergency_contact_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="emergency_contact_phone">Emergency Contact Phone:</label>
                        <input type="text" class="form-control" id="emergency_contact_phone" name="emergency_contact_phone" value="<?php echo $residents['emergency_contact_phone']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="blood_type">Blood Type:</label>
                        <select class="form-control" id="blood_type" name="blood_type" required>
                            <option value="A+" <?php if ($residents['blood_type'] == 'A+') echo 'selected'; ?>>A+</option>
                            <option value="A-" <?php if ($residents['blood_type'] == 'A-') echo 'selected'; ?>>A-</option>
                            <option value="B+" <?php if ($residents['blood_type'] == 'B+') echo 'selected'; ?>>B+</option>
                            <option value="B-" <?php if ($residents['blood_type'] == 'B-') echo 'selected'; ?>>B-</option>
                            <option value="AB+" <?php if ($residents['blood_type'] == 'AB+') echo 'selected'; ?>>AB+</option>
                            <option value="AB-" <?php if ($residents['blood_type'] == 'AB-') echo 'selected'; ?>>AB-</option>
                            <option value="O+" <?php if ($residents['blood_type'] == 'O+') echo 'selected'; ?>>O+</option>
                            <option value="O-" <?php if ($residents['blood_type'] == 'O-') echo 'selected'; ?>>O-</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" name="update_profile">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>