<?php
include '../includes/db_connection.php';
session_start();

// Check if the user is logged in as a kebele moderator
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'kebeleModerator') {
    // Redirect non-moderator users to the login page or a different page
    header('Location: ../login.php');
    exit;
}
$kebele_id = $_SESSION['kebele_id'];
$username = $_SESSION['username'];
$kebele_name = $_SESSION['kebele_name'];
$page_title = 'Manage Residents';

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {


        case 'add_resident':
            // Input validation and handling
            $username = $_POST['username'] ?? '';
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $full_name = $_POST['full_name'] ?? '';
            $gender = $_POST['gender'] ?? '';
            $date_of_birth = $_POST['date_of_birth'] ?? '';

            // Calculate expiration date (3 years from current date)
            $expiration_date = date('Y-m-d', strtotime('+3 years'));

            // Handle file upload
            $target_dir = "../images/profile/resident";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Retrieve region, zone, woreda, city, and kebele IDs from session
            $region_id = $_SESSION['region_id'] ?? '';
            $zone_id = $_SESSION['zone_id'] ?? '';
            $woreda_id = $_SESSION['woreda_id'] ?? '';
            $city_id = $_SESSION['city_id'] ?? '';
            $kebele_id = $_SESSION['kebele_id'] ?? '';

            if (!empty($username) && !empty($password) && !empty($full_name) && !empty($gender) && !empty($date_of_birth) && !empty($region_id) && !empty($zone_id) && !empty($woreda_id) && !empty($city_id) && !empty($kebele_id)) {
                // Check if the resident with the same username already exists
                $checkUsernameQuery = "SELECT * FROM residents WHERE username = ?";
                $checkUsernameStmt = $conn->prepare($checkUsernameQuery);
                $checkUsernameStmt->bind_param('s', $username);
                $checkUsernameStmt->execute();
                $existingResident = $checkUsernameStmt->get_result()->fetch_assoc();

                if (!$existingResident) {
                    // Generate unique national ID
                    $lastResidentQuery = "SELECT MAX(resident_id) AS last_resident_id FROM residents";
                    $lastResidentStmt = $conn->prepare($lastResidentQuery);
                    $lastResidentStmt->execute();
                    $lastResidentResult = $lastResidentStmt->get_result()->fetch_assoc();
                    $lastResidentId = $lastResidentResult['last_resident_id'] ?? 0;
                    $nationalId = 'NEKEMTE' .  $region_id . $zone_id . $woreda_id . $city_id . $kebele_id . ($lastResidentId + 1);

                    // Check if image file is a actual image or fake image
                    $check = getimagesize($_FILES["image"]["tmp_name"]);
                    if ($check === false) {
                        $error_message = "File is not an image.";
                    } else {
                        // Check file size (limit to 2MB)
                        if ($_FILES["image"]["size"] > 2000000) {
                            $error_message = "Sorry, your file is too large.";
                        } else {
                            // Allow certain file formats
                            $allowed_formats = ['jpg', 'jpeg', 'png', 'gif'];
                            if (!in_array($imageFileType, $allowed_formats)) {
                                $error_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            } else {
                                // Check if $error_message is empty
                                if (empty($error_message)) {
                                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                                        // Save the resident to the database
                                        $insertResidentQuery = "INSERT INTO residents (username, password, full_name, image, national_id, gender, date_of_birth, expiration_date, region_id, zone_id, woreda_id, city_id, kebele_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                                        $insertResidentStmt = $conn->prepare($insertResidentQuery);
                                        $insertResidentStmt->bind_param('ssssssssiiiii', $username, $password, $full_name, $target_file, $nationalId, $gender, $date_of_birth, $expiration_date, $region_id, $zone_id, $woreda_id, $city_id, $kebele_id);
                                        if ($insertResidentStmt->execute()) {
                                            $success_message = "Resident added successfully.";
                                            header('Location: kebeleModerator_manage_residents.php');
                                            exit;
                                        } else {
                                            // Handle database insertion error
                                            $error_message = "Failed to add resident. Please try again later.";
                                        }
                                    } else {
                                        $error_message = "Sorry, there was an error uploading your file.";
                                    }
                                }
                            }
                        }
                    }
                } else {
                    // Handle existing username error
                    $error_message = "Username already exists. Please choose a different username.";
                }
            } else {
                // Handle invalid input
                $error_message = "Please fill out all the required fields.";
            }
            break;
        case 'edit_resident':
            $resident_id = $_POST['resident_id'];
            $username = $_POST['username'];
            $password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
            $full_name = $_POST['full_name'];
            $gender = $_POST['gender'];
            $date_of_birth = $_POST['date_of_birth'];
            $expiration_date = date('Y-m-d', strtotime('+3 years'));

            // Retrieve region, zone, woreda, city, and kebele IDs from session
            $region_id = $_SESSION['region_id'] ?? '';
            $zone_id = $_SESSION['zone_id'] ?? '';
            $woreda_id = $_SESSION['woreda_id'] ?? '';
            $city_id = $_SESSION['city_id'] ?? '';
            $kebele_id = $_SESSION['kebele_id'] ?? '';

            // Handle file upload
            $image_path = null;
            if (!empty($_FILES["image"]["name"])) {
                $target_dir = "../images/profile/resident";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if ($check !== false) {
                    if ($_FILES["image"]["size"] <= 2000000) {
                        if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                                $image_path = $target_file;
                            }
                        }
                    }
                }
            }

            // Update resident in the database
            $update_query = "UPDATE residents SET username = ?, full_name = ?, gender = ?, date_of_birth = ?,expiration_date = ?,  region_id = ?" .
                ($password ? ", password = ?" : "") .
                ($image_path ? ", image = ?" : "") .
                " WHERE resident_id = ?";
            $stmt = $conn->prepare($update_query);

            $bindParams = array($username, $full_name, $gender, $date_of_birth, $expiration_date,  $region_id);
            if ($password) {
                $bindParams[] = $password;
            }
            if ($image_path) {
                $bindParams[] = $image_path;
            }
            $bindParams[] = $resident_id;

            $stmt->bind_param(str_repeat("s", count($bindParams)), ...$bindParams);

            if ($stmt->execute()) {
                $success_message = "Resident updated successfully.";
            } else {
                $error_message = "Error updating resident: " . $conn->error;
            }
            break;

        case 'delete_resident':
            $resident_id = $_POST['resident_id'];

            // Delete resident from the database
            $delete_query = "DELETE FROM residents WHERE resident_id = ?";
            $stmt = $conn->prepare($delete_query);
            $stmt->bind_param("i", $resident_id);

            if ($stmt->execute()) {
                $success_message = "Resident deleted successfully.";
            } else {
                $error_message = "Error deleting resident: " . $conn->error;
            }
            break;

        default:
            $error_message = "Invalid action.";
            break;
    }
}

// Fetch residents from the database
$residents_query = "SELECT * FROM residents WHERE kebele_id = ?";
$stmt = $conn->prepare($residents_query);
$stmt->bind_param("i", $kebele_id);
$stmt->execute();
$residents_result = $stmt->get_result();

include '../includes/header.php';
?>

<div class="container mt-4">
    <h1>Manage Residents</h1>

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

    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addResidentModal">Add Resident</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Image</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Expiration Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($resident = $residents_result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $resident['resident_id']; ?></td>
                    <td><?php echo htmlspecialchars($resident['username']); ?></td>
                    <td><?php echo htmlspecialchars($resident['full_name']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($resident['image']); ?>" alt="Resident Image" width="50" height="50"></td>
                    <td><?php echo htmlspecialchars($resident['gender']); ?></td>
                    <td><?php echo htmlspecialchars($resident['date_of_birth']); ?></td>
                    <td><?php echo htmlspecialchars($resident['expiration_date']); ?></td>
                    <td><?php echo htmlspecialchars($resident['status']); ?></td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editResidentModal<?php echo $resident['resident_id']; ?>">Edit</button>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteResidentModal<?php echo $resident['resident_id']; ?>">Delete</button>
                    </td>
                </tr>
                <!-- Edit Resident Modal -->
                <div class="modal fade" id="editResidentModal<?php echo $resident['resident_id']; ?>" tabindex="-1" aria-labelledby="editResidentModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editResidentModalLabel">Edit Resident</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="action" value="edit_resident">
                                    <input type="hidden" name="resident_id" value="<?php echo $resident['resident_id']; ?>">
                                    <div class="form-group">
                                        <label for="edit_username">Username</label>
                                        <input type="text" class="form-control" id="edit_username" name="username" value="<?php echo htmlspecialchars($resident['username']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_password">Password</label>
                                        <input type="password" class="form-control" id="edit_password" name="password">
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_full_name">Full Name</label>
                                        <input type="text" class="form-control" id="edit_full_name" name="full_name" value="<?php echo htmlspecialchars($resident['full_name']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_gender">Gender</label>
                                        <select class="form-control" id="edit_gender" name="gender" required>
                                            <option value="">Select Gender</option>
                                            <option value="male" <?php echo $resident['gender'] == 'male' ? 'selected' : ''; ?>>Male</option>
                                            <option value="female" <?php echo $resident['gender'] == 'female' ? 'selected' : ''; ?>>Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_date_of_birth">Date of Birth</label>
                                        <input type="date" class="form-control" id="edit_date_of_birth" name="date_of_birth" value="<?php echo $resident['date_of_birth']; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="edit_image">Image</label>
                                        <input type="file" class="form-control-file" id="edit_image" name="image">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Resident Modal -->
                <div class="modal fade" id="deleteResidentModal<?php echo $resident['resident_id']; ?>" tabindex="-1" aria-labelledby="deleteResidentModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteResidentModalLabel">Delete Resident</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this resident?</p>
                            </div>
                            <div class="modal-footer">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <input type="hidden" name="action" value="delete_resident">
                                    <input type="hidden" name="resident_id" value="<?php echo $resident['resident_id']; ?>">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<!-- Add Resident Modal -->
<div class="modal fade" id="addResidentModal" tabindex="-1" aria-labelledby="addResidentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addResidentModalLabel">Add Resident</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="add_resident">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control-file" id="image" name="image" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Resident</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>