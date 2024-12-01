<?php


// Include the database connection file
require_once '../includes/db_connection.php';

$errors = [];
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $full_name = trim($_POST['full_name']);
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];
    $region_id = $_POST['region_id'];
    $zone_id = $_POST['zone_id'];
    $woreda_id = $_POST['woreda_id'];
    $city_id = $_POST['city_id'];
    $kebele_id = $_POST['kebele_id'];
    $errors = [];

    // Generate unique national ID
    $lastResidentQuery = "SELECT MAX(resident_id) AS last_resident_id FROM residents";
    $lastResidentStmt = $conn->prepare($lastResidentQuery);
    $lastResidentStmt->execute();
    $lastResidentResult = $lastResidentStmt->get_result()->fetch_assoc();
    $lastResidentId = $lastResidentResult['last_resident_id'] ?? 0;
    $nationalId = 'NEKEMTE' . sprintf('%04d', $region_id) . sprintf('%01d', $zone_id) . sprintf('%01d', $woreda_id) . sprintf('%01d', $city_id) . sprintf('%01d', $kebele_id) . sprintf('%01d', $lastResidentId + 1);

    // Validate inputs
    if (empty($username) || empty($password) || empty($full_name) || empty($gender) || empty($date_of_birth) || empty($region_id) || empty($zone_id) || empty($woreda_id) || empty($city_id) || empty($kebele_id)) {
        $errors[] = 'Please fill in all required fields.';
    }

    // Image upload
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../images/profile/resident";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file type
        $allowed_types = ['jpg', 'png', 'jpeg', 'gif'];
        if (!in_array($imageFileType, $allowed_types)) {
            $errors[] = 'Only JPG, JPEG, PNG & GIF files are allowed.';
        }

        // Check file size (limit: 2MB)
        if ($_FILES["image"]["size"] > 2000000) {
            $errors[] = 'File size should not exceed 2MB.';
        }

        if (empty($errors)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = basename($_FILES["image"]["name"]);
            } else {
                $errors[] = 'There was an error uploading your file.';
            }
        }
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // If no errors, insert into the database
    if (empty($errors)) {
        $query = "
            INSERT INTO residents (national_id, username, password, full_name, image, gender, date_of_birth, region_id, zone_id, woreda_id, city_id, kebele_id, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'requested')
        ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssssssiiiii', $nationalId, $username, $hashed_password, $full_name, $target_file, $gender, $date_of_birth, $region_id, $zone_id, $woreda_id, $city_id, $kebele_id);

        if ($stmt->execute()) {
            $success = 'Registration request submitted successfully!';
            header('Location: ../login.php');
            exit; // Ensure that code execution stops after the redirect
        } else {
            $errors[] = 'Error: ' . $stmt->error;
        }
    }
}

// Fetch region, zone, woreda, city, and kebele data
$regions = $conn->query("SELECT region_id, region_name FROM region");
$zones = $conn->query("SELECT zone_id, zone_name, region_id FROM zone");
$woredas = $conn->query("SELECT woreda_id, woreda_name, zone_id FROM woreda");
$cities = $conn->query("SELECT city_id, city_name, woreda_id FROM city");
$kebeles = $conn->query("SELECT kebele_id, kebele_name, city_id FROM kebele");

include '../includes/header.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Resident ID Card Registration</title>
    <style>
        .error {
            color: red;
        }

        .success {
            color: green;
        }

        .form-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>

<body>

    <div class="container mt-5">

        <?php if (!empty($errors)) : ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error) : ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($success) : ?>
            <div class="alert alert-success">
                <p><?php echo htmlspecialchars($success); ?></p>
            </div>
        <?php endif; ?>

        <form action="resident_register.php" method="POST" enctype="multipart/form-data">
            <div class="form-container">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="full_name">Full Name:</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" required>
                </div>
                <div class="form-group">
                    <label for="image">Profile Image:</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                </div>
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select class="form-control" id="gender" name="gender" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date_of_birth">Date of Birth:</label>
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                </div>
                <div class="form-group">
                    <label for="region_id">Region:</label>
                    <select class="form-control" id="region_id" name="region_id" required>
                        <option value="">Select Region</option>
                        <?php while ($region = $regions->fetch_assoc()) : ?>
                            <option value="<?php echo $region['region_id']; ?>"><?php echo htmlspecialchars($region['region_name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="zone_id">Zone:</label>
                    <select class="form-control" id="zone_id" name="zone_id" required>
                        <option value="">Select Zone</option>
                        <?php while ($zone = $zones->fetch_assoc()) : ?>
                            <option value="<?php echo $zone['zone_id']; ?>" data-region="<?php echo $zone['region_id']; ?>"><?php echo htmlspecialchars($zone['zone_name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="woreda_id">Woreda:</label>
                    <select class="form-control" id="woreda_id" name="woreda_id" required>
                        <option value="">Select Woreda</option>
                        <?php while ($woreda = $woredas->fetch_assoc()) : ?>
                            <option value="<?php echo $woreda['woreda_id']; ?>" data-zone="<?php echo $woreda['zone_id']; ?>"><?php echo htmlspecialchars($woreda['woreda_name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="city_id">City:</label>
                    <select class="form-control" id="city_id" name="city_id" required>
                        <option value="">Select City</option>
                        <?php while ($city = $cities->fetch_assoc()) : ?>
                            <option value="<?php echo $city['city_id']; ?>" data-woreda="<?php echo $city['woreda_id']; ?>"><?php echo htmlspecialchars($city['city_name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="kebele_id">Kebele:</label>
                    <select class="form-control" id="kebele_id" name="kebele_id" required>
                        <option value="">Select Kebele</option>
                        <?php while ($kebele = $kebeles->fetch_assoc()) : ?>
                            <option value="<?php echo $kebele['kebele_id']; ?>" data-city="<?php echo $kebele['city_id']; ?>"><?php echo htmlspecialchars($kebele['kebele_name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit Registration Request</button>
                </div>
            </div>
        </form>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const regionSelect = document.getElementById('region_id');
            const zoneSelect = document.getElementById('zone_id');
            const woredaSelect = document.getElementById('woreda_id');
            const citySelect = document.getElementById('city_id');
            const kebeleSelect = document.getElementById('kebele_id');

            function filterOptions(selectElement, attribute, value) {
                const options = selectElement.querySelectorAll('option');
                options.forEach(option => {
                    if (option.getAttribute(attribute) === value || option.value === '') {
                        option.style.display = '';
                    } else {
                        option.style.display = 'none';
                    }
                });
            }

            regionSelect.addEventListener('change', function() {
                const regionId = regionSelect.value;
                filterOptions(zoneSelect, 'data-region', regionId);
                zoneSelect.value = '';
                woredaSelect.value = '';
                citySelect.value = '';
                kebeleSelect.value = '';
            });

            zoneSelect.addEventListener('change', function() {
                const zoneId = zoneSelect.value;
                filterOptions(woredaSelect, 'data-zone', zoneId);
                woredaSelect.value = '';
                citySelect.value = '';
                kebeleSelect.value = '';
            });

            woredaSelect.addEventListener('change', function() {
                const woredaId = woredaSelect.value;
                filterOptions(citySelect, 'data-woreda', woredaId);
                citySelect.value = '';
                kebeleSelect.value = '';
            });

            citySelect.addEventListener('change', function() {
                const cityId = citySelect.value;
                filterOptions(kebeleSelect, 'data-city', cityId);
                kebeleSelect.value = '';
            });
        });
    </script>
</body>

</html>

<?php include '../includes/footer.php'; ?>