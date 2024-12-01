<?php
// Start the session
session_start();

// Check if the user is logged in as a resident
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'resident') {
    // Redirect non-resident users to the login page or a different page
    header('Location: ../login.php');
    exit;
}

// Include the database connection file
require_once '../includes/db_connection.php';
include '../includes/header.php';
// Fetch resident's details from the database
$resident_id = $_SESSION['user_id']; // Assuming user_id represents the resident's ID
$sql = "SELECT r.*, rg.region_name, z.zone_name, w.woreda_name, c.city_name, k.kebele_name 
        FROM residents r
        LEFT JOIN region rg ON r.region_id = rg.region_id
        LEFT JOIN zone z ON r.zone_id = z.zone_id
        LEFT JOIN woreda w ON r.woreda_id = w.woreda_id
        LEFT JOIN city c ON r.city_id = c.city_id
        LEFT JOIN kebele k ON r.kebele_id = k.kebele_id
        WHERE r.resident_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $resident_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the query was successful and fetch resident's details
if ($result->num_rows > 0) {
    $resident = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="../css/all.min.css">
    <!-- Custom CSS -->
    <style>
        /* Body Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        /* Container Styles */
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Card Styles */
        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            border-radius: 10px 10px 0 0;
            padding: 15px;
            color: #fff;
            text-align: center;
        }

        .card-body {
            padding: 30px;
        }

        /* Resident Details Styles */
        .resident-photo img {
            width: 150px;
            height: 150px;
            border: 5px solid #fff;
            border-radius: 50%;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin: 0 auto 20px;
            display: block;
        }

        .resident-name {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .details-list p {
            font-size: 16px;
            color: #555;
            margin-bottom: 10px;
        }

        .details-list p i {
            margin-right: 10px;
            color: #777;
        }

        .status-label {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9em;
            font-weight: bold;
        }

        .status-label.pending {
            background-color: #ffc107;
            color: #333;
        }

        .status-label.approved {
            background-color: #28a745;
            color: #fff;
        }

        .status-label.requested {
            background-color: #007bff;
            color: #fff;
        }

        .status-label.disapproved {
            background-color: #dc3545;
            color: #fff;
        }

        /* QR Code and Barcode Styles */
        #qrcode,
        #barcode {
            display: block;
            margin: 20px auto;
        }

        #barcode {
            width: 100%;
            /* Ensure barcode fits within its container */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Resident Dashboard</h5>
            </div>
            <div class="card-body">
                <h6 class="card-subtitle mb-3">Welcome, <?php echo $_SESSION['username']; ?>!</h6>
                <!-- ID card section -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="resident-photo">
                            <img src="<?php echo $_SESSION['image']; ?>" alt="Resident Photo" class="img-fluid rounded-circle">
                        </div>
                        <!-- Generate QR Code -->
                        <canvas id="qrcode"></canvas>
                        <!-- Generate Barcode -->
                    </div>
                    <div class="col-md-8">
                        <h5 class="resident-name"><?php echo $resident['full_name']; ?></h5>
                        <div class="details-list">
                            <div style="display: flex; justify-content:space-around">

                                <div>
                                    <p><i class="fas fa-user"></i> <strong>Username:</strong> <?php echo $resident['username']; ?></p>
                                    <p><i class="fas fa-phone"></i> <strong>Phone Number:</strong> <?php echo $resident['phone_number']; ?></p>
                                    <p><i class="fas fa-envelope"></i> <strong>Email:</strong> <?php echo $resident['email']; ?></p>
                                    <p><i class="fas fa-ring"></i> <strong>Marital Status:</strong> <?php echo $resident['marital_status']; ?></p>
                                    <p><i class="fas fa-tint"></i> <strong>Blood Type:</strong> <?php echo $resident['blood_type']; ?></p>
                                    <p><i class="fas fa-users"></i> <strong>Number of Dependents:</strong> <?php echo $resident['number_of_dependents']; ?></p>
                                    <p><i class="fas fa-phone-alt"></i> <strong>Emergency Contact Name:</strong> <?php echo $resident['emergency_contact_name']; ?></p>
                                    <p><i class="fas fa-phone-alt"></i> <strong>Emergency Contact Phone:</strong> <?php echo $resident['emergency_contact_phone']; ?></p>
                                </div>
                                <div>

                                    <p><i class="fas fa-map-marker-alt"></i> <strong>Region:</strong> <?php echo $resident['region_name']; ?></p>
                                    <p><i class="fas fa-globe"></i> <strong>Zone:</strong> <?php echo $resident['zone_name']; ?></p>
                                    <p><i class="fas fa-map"></i> <strong>Woreda:</strong> <?php echo $resident['woreda_name']; ?></p>
                                    <p><i class="fas fa-building"></i> <strong>City:</strong> <?php echo $resident['city_name']; ?></p>
                                    <p><i class="fas fa-home"></i> <strong>Kebele:</strong> <?php echo $resident['kebele_name']; ?></p>
                                    <p>
                                        <i class="fas fa-home"></i>
                                        <strong>Status:</strong>
                                        <span class="status-label <?php echo strtolower($resident['status']); ?>">
                                            <?php echo ucfirst($resident['status']); ?>
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <svg id="barcode"></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once('../includes/footer.php'); ?>


    <script>
        // Generate QR Code
        var qr = new QRious({
            element: document.getElementById('qrcode'),
            value: '<?php echo $resident['username']; ?> , <?php echo $resident['full_name']; ?> ,<?php echo $resident['region_name']; ?>,<?php echo $resident['zone_name']; ?>,<?php echo $resident['woreda_name']; ?>,<?php echo $resident['city_name']; ?>,<?php echo $resident['kebele_name']; ?>'
        });

        // Generate Barcode
        JsBarcode("#barcode", "<?php echo $resident['username']; ?> , <?php echo $resident['full_name']; ?> ,<?php echo $resident['region_name']; ?>,<?php echo $resident['zone_name']; ?>,<?php echo $resident['woreda_name']; ?>,<?php echo $resident['city_name']; ?>,<?php echo $resident['kebele_name']; ?>", {
            format: "CODE128"
        });
    </script>
</body>

</html>