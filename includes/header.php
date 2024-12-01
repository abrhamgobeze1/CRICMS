<?php
// Start the session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once 'db_connection.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nekemte City Resident ID</title>
    <link rel="shortcut icon" href="/CRICMS2/images/nekemte.jpg" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/cricms2/css/bootstrap.min.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="/cricms2/index.php">Nekemte City Resident ID</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/cricms2/index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/cricms2/about.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/cricms2/developers.php">Developers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/cricms2/faq.php">FAQ</a>
                        </li>
                    
                        <?php if (isset($_SESSION["user_type"])) { ?>
                            <li class="nav-item dropdown">

                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="badge badge-pill badge-info"><?php echo ucfirst($_SESSION["user_type"]); ?></span>
                                    <?php if (!empty($_SESSION["image"]) && file_exists($_SESSION["image"])) : ?>
                                        <img src="<?php echo $_SESSION["image"]; ?>" alt="" style="width: 30px; height: 30px; border-radius: 50%; border: 3px solid black;">
                                    <?php else : ?>
                                        <img src="/odps/images/favicon/favicon.jpg" alt="" style="width: 30px; height: 30px; border-radius: 50%;border: 3px solid black;">
                                    <?php endif; ?>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <?php if ($_SESSION["user_type"] == "admin") { ?>
                                        <a class="dropdown-item" href="/cricms2/admin/admin_dashboard.php">Dashboard</a>
                                        <a class="dropdown-item" href="/cricms2/admin/admin_manage_moderators.php">Manage Moderators</a>
                                        <a class="dropdown-item" href="/cricms2/admin/admin_manage_kebele_moderators.php">Manage kebeleModerator</a>
                                        <a class="dropdown-item" href="/cricms2/admin/admin_manage_components.php">Manage Components</a>
                                        <a class="dropdown-item" href="/cricms2/admin/profile.php">Profile</a>
                                        <a class="dropdown-item" href="/cricms2/logout.php">Logout</a>
                                    <?php } elseif ($_SESSION["user_type"] == "moderator") { ?>
                                        <a class="dropdown-item" href="/cricms2/moderator/moderator_dashboard.php">Dashboard</a>
                                        <a class="dropdown-item" href="/cricms2/moderator/moderator_approve_resident.php">Approve Residents</a>
                                        <a class="dropdown-item" href="/cricms2/moderator/moderator_manage_kebele_moderators.php">Manage Kebele Moderators</a>
                                        <a class="dropdown-item" href="/cricms2/moderator/moderator_manage_kebele.php">Manage Kebele</a>
                                        <a class="dropdown-item" href="/cricms2/moderator/profile.php">Profile</a>
                                        <a class="dropdown-item" href="/cricms2/logout.php">Logout</a>
                                    <?php } elseif ($_SESSION["user_type"] == "kebeleModerator") { ?>
                                        <a class="dropdown-item" href="/cricms2/kebeleModerator/kebeleModerator_dashboard.php">Dashboard</a>
                                        <a class="dropdown-item" href="/cricms2/kebeleModerator/kebeleModerator_accept_request.php">Accept Registeration Request</a>
                                        <a class="dropdown-item" href="/cricms2/kebeleModerator/kebeleModerator_manage_residents.php">Manage Residents</a>
                                        <a class="dropdown-item" href="/cricms2/kebeleModerator/profile.php">Profile</a>
                                        <a class="dropdown-item" href="/cricms2/logout.php">Logout</a>
                                    <?php } elseif ($_SESSION["user_type"] == "resident") { ?>
                                        <a class="dropdown-item" href="/cricms2/resident/resident_dashboard.php">Dashboard</a>
                                        <a class="dropdown-item" href="/cricms2/resident/resident_view_id_card.php">View ID Card</a>
                                        <a class="dropdown-item" href="/cricms2/resident/profile.php">Profile</a>
                                        <a class="dropdown-item" href="/cricms2/logout.php">Logout</a>
                                    <?php } ?>
                                </div>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/cricms2/login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/cricms2/resident/resident_register.php">Register</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>