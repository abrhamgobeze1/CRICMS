<?php
// Start the session
session_start();

// Include the database connection
require_once '../includes/db_connection.php';

// Check if the user is logged in as a resident
if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "resident") {
    header("Location: ../login.php");
    exit();
}

// Get the resident's information from the database
$resident_id = $_SESSION["user_id"];
$query = "
    SELECT r.*, rg.region_name, z.zone_name, w.woreda_name, c.city_name, k.kebele_name
    FROM residents r
    LEFT JOIN region rg ON r.region_id = rg.region_id
    LEFT JOIN zone z ON r.zone_id = z.zone_id
    LEFT JOIN woreda w ON r.woreda_id = w.woreda_id
    LEFT JOIN city c ON r.city_id = c.city_id
    LEFT JOIN kebele k ON r.kebele_id = k.kebele_id
    WHERE r.resident_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $resident_id);
$stmt->execute();
$result = $stmt->get_result();
$resident = $result->fetch_assoc();

if (!$resident) {
    echo "No resident found with ID: $resident_id";
    exit();
}

$conn->close(); // Close the database connection
?>

<?php require_once '../includes/header.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <title>Resident ID Card</title>
    <style>
        /* Styles remain the same as provided */
        .id-card {
            width: 600px;
            margin: 0 auto;
            background-color: #f5f5f5;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .id-card-header {
            width: 600px;
            background-color: #007bff;
            padding: 20px;
            text-align: center;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .id-card-header h1 {
            font-size: 20px;
            margin: 0;
        }

        .person-esential {
            width: 600px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .id-number {
            font-size: 10px;
            font-weight: bold;
            color: #fff;
            padding: 4px 8px;
            border-radius: 4px;
            display: inline-block;
            margin-right: 10px;
        }

        .id-number i {
            margin-right: 4px;
        }


        .person-esential {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #f5f5f5;
    padding: 10px 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.name {
    font-size: 24px;
    font-weight: bold;
    color: #333;
}

.id-number {
    font-size: 16px;
    font-weight: bold;
    color: #fff;
    padding: 5px 10px;
    border-radius: 3px;
}

        .flag-logos {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 80px;
        }

        .flag-logo {
            height: 40px;
            width: 80px;
            border: transparent 4px dashed;
            border-radius: 6px;
        }

        .id-card-content {
            width: 600px;
            display: flex;
            justify-content: space-around;
            padding: 20px;
            gap: 0px;
        }

        .id-card-image {
            width: 150px;
            height: 200px;
            border-radius: 6px;
            object-fit: cover;
            object-position: center;
            margin-right: 20px;
        }

        .id-card-details {
            flex-grow: 1;
        }

        .id-card-details p {
            margin: 10px 0;
            font-size: 8px;
            color: #333;
        }

        .id-card-details .label {
            font-weight: bold;
            margin-right: 5px;
        }

        .barcode-qr-container {
            width: 600px;
            display: flex;
            justify-content: space-around;
            margin-top: 0px;
        }

        .barcode-container,
        .qr-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0 20px;
        }

        /* Print styles */
        @media print {
            body * {
                visibility: hidden;
            }

            .id-card,
            .id-card * {
                visibility: visible;
            }

            .id-card {
                background-color: #fff;
                /* Set the background color to white */
                color: #000;
                /* Set the text color to black */
                -webkit-print-color-adjust: exact;
                /* Safari */
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                /* Chrome, Firefox */
                -ms-print-color-adjust: exact;
                /* Internet Explorer */
                -o-print-color-adjust: exact;
                /* Opera */
                print-color-adjust: exact;
                /* Standard */
                -moz-print-color-adjust: exact;
                /* Firefox (Old) */
                -webkit-color-adjust: exact;
                /* Safari (Old) */
                -epub-color-adjust: exact;
                /* EPUB */
                -prince-color-adjust: exact;
                /* Prince */
                -wkhtmltopdf-print-color-adjust: exact;
                /* wkhtmltopdf */
                -weasyprint-print-color-adjust: exact;
                /* Weasyprint */
            }

            .id-card {
                background-color: #fff;
                /* Set the background color to white */
                color: #000;
                /* Set the text color to black */
            }

            .id-card-header {
                background-color: #007bff;
                /* Set the header background color */
                color: #fff;
                /* Set the header text color to white */
            }

            .id-number {
                background-color: #007bff;
                /* Set the ID number background color */
                color: #fff;
                /* Set the ID number text color to white */
            }

            .id-card {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .print-button {
                display: none;
            }
        }
    </style>
    <script src="bar.js"></script>
    <script src="qrious.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>Resident ID Card</h1>
        <div class="container my-4">
            <?php if ($resident) { ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Resident Status</h5>
                        <p class="card-text">Status: <span class="badge <?php echo $resident['status'] === 'approved' ? 'bg-success' : 'bg-secondary'; ?>"><?php echo $resident['status']; ?></span></p>
                        <?php if ($resident['status'] === 'approved') { ?>
                            <button class="btn btn-primary print-button" onclick="window.print()">Print ID Card</button>
                        <?php } else { ?>
                            <p class="text-muted">You cannot print your ID card until your account is approved.</p>
                        <?php } ?>
                    </div>
                </div>
            <?php } else { ?>
                <p class="text-muted">No resident data available.</p>
            <?php } ?>
        </div>
        <div class="id-card">
            <div class="id-card-header">
                <div class="flag-logos">
                    <img src="../images/flags/ethiopia.png" alt="Flag Logo" class="flag-logo">
                    <h6><?php echo htmlspecialchars($resident["region_name"]); ?> regional state <?php echo htmlspecialchars($resident["zone_name"]); ?> Zone <?php echo htmlspecialchars($resident["woreda_name"]); ?> warrada <?php echo htmlspecialchars($resident["city_name"]); ?> City Resident ID Card</h6>
                    <img src="../images/flags/oromia.jpg" alt="Flag Logo" class="flag-logo">
                </div>
            </div>
            <h3 class="person-esential">
                <span class="name"><?php echo ucwords($resident["full_name"]); ?></span>
                <span class="id-number bg-success">ID: <?php echo $resident["national_id"]; ?></span>
            </h3>
            <div class="id-card-content">
                <?php if (!empty($resident["image"])) { ?>
                    <img src="../uploads/<?php echo htmlspecialchars($resident["image"]); ?>" alt="Resident Image" class="id-card-image">
                <?php } ?>
                <div class="id-card-details">
                    <p><span class="label">Phone:</span> <span class="value"><?php echo htmlspecialchars($resident["phone_number"]); ?></span></p>
                    <p><span class="label">Email:</span> <span class="value"><?php echo htmlspecialchars($resident["email"]); ?></span></p>
                    <p><span class="label">Marital Status:</span> <span class="value"><?php echo htmlspecialchars($resident["marital_status"]); ?></span></p>
                    <p><span class="label">Number of Dependents:</span> <span class="value"><?php echo htmlspecialchars($resident["number_of_dependents"]); ?></span></p>
                    <p><span class="label">Ec Name:</span> <span class="value"><?php echo htmlspecialchars($resident["emergency_contact_name"]); ?></span></p>
                    <p><span class="label">Ec Phone:</span> <span class="value"><?php echo htmlspecialchars($resident["emergency_contact_phone"]); ?></span></p>
                    <p><span class="label">Blood Type:</span> <span class="value"><?php echo htmlspecialchars($resident["blood_type"]); ?></span></p>
                    <?php
                    // Calculate the age from the date of birth
                    $dob = new DateTime($resident["date_of_birth"]);
                    $now = new DateTime();
                    $age = $now->diff($dob)->y;

                    // Subtract 8 years from the age
                    $age_minus_8 = $age - 8;
                    ?>

                    <p><span class="label"> Age:</span> <span class="value"><?php echo $age_minus_8; ?></span></p>
                </div>
                <div class="id-card-details">
                    <p><span class="label">Region:</span> <span class="value"><?php echo htmlspecialchars($resident["region_name"]); ?></span></p>
                    <p><span class="label">Zone:</span> <span class="value"><?php echo htmlspecialchars($resident["zone_name"]); ?></span></p>
                    <p><span class="label">Woreda:</span> <span class="value"><?php echo htmlspecialchars($resident["woreda_name"]); ?></span></p>
                    <p><span class="label">City:</span> <span class="value"><?php echo htmlspecialchars($resident["city_name"]); ?></span></p>
                    <p><span class="label">Kebele:</span> <span class="value"><?php echo htmlspecialchars($resident["kebele_name"]); ?></span></p>
                    <p><span class="label">Gender:</span> <span class="value"><?php echo htmlspecialchars($resident["gender"]); ?></span></p>
                    <p><span class="label">DoB:</span> <span class="value"><?php echo htmlspecialchars($resident["date_of_birth"]); ?></span></p>
                </div>

            </div>
            <div class="barcode-qr-container">
                <div class="barcode-container">
                    <svg id="barcode"></svg>
                </div>
                <div>
                    <p class="bg-danger"><span class="label">Expire Date:</span> <span class="value"><?php echo htmlspecialchars($resident["expiration_date"]); ?></span></p>
                </div>
                <div class="qr-container">
                    <canvas id="qr-code"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Generate Barcode
        JsBarcode("#barcode", "<?php echo htmlspecialchars($resident['national_id']); ?>", {
            format: "CODE128",
            width: 1,
            height: 20,
            displayValue: false
        });

        // Generate QR Code
        var qrCode = new QRious({
            element: document.getElementById('qr-code'),
            value: "<?php echo htmlspecialchars($resident['full_name']); ?>, <?php echo htmlspecialchars($resident['region_name']); ?>, <?php echo htmlspecialchars($resident['zone_name']); ?>, <?php echo htmlspecialchars($resident['woreda_name']); ?>, <?php echo htmlspecialchars($resident['city_name']); ?>, <?php echo htmlspecialchars($resident['kebele_name']); ?>",
            size: 70
        });
    </script>
</body>

</html>

<?php require_once '../includes/footer.php'; ?>