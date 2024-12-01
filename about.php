<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nekemte City Resident ID Card</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="/project_directory/images/nekemte-logo.jpg" type="image/x-icon">
    <style>
        :root {
            --primary-color: #0072C6;
            /* Blue */
            --secondary-color: #00A0E3;
            /* Light Blue */
            --tertiary-color: #00DF9F;
            /* Teal */
        }

        body {
            font-family: Arial, sans-serif;
            color: #333;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: var(--primary-color);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: #fff;
        }

        .navbar-dark .navbar-nav .nav-link {
            color: var(--tertiary-color);
        }

        .navbar-dark .navbar-nav .nav-link:hover {
            color: var(--primary-color);
        }

        .footer {
            background-color: var(--primary-color);
            color: #fff;
        }

        .footer a {
            color: var(--tertiary-color);
        }

        .footer a:hover {
            color: #fff;
        }
    </style>
</head>

<body> <?php include 'includes/header.php' ?> <div class="container mt-5">
        <h1>Nekemte City Resident ID Card</h1>
        <div class="row">
            <div class="col-md-12">
                <h2>Card Information</h2>
                <p>The Nekemte City Resident ID Card is an official document that verifies the identity and residency status of individuals living within the city limits of Nekemte, Ethiopia.</p>
                <p>The card contains the following information:</p>
                <ul>
                    <li>Full Name</li>
                    <li>Photograph</li>
                    <li>Unique ID Number</li>
                    <li>Date of Birth</li>
                    <li>Address within Nekemte City</li>
                    <li>Date of Issue and Expiration</li>
                </ul>
                <img src="/cricms2/images/sample.jpg" alt="">
                <p>The Nekemte City Resident ID Card provides access to various municipal services and benefits, such as healthcare, education, and public transportation. It also serves as a valid form of identification for various administrative and legal purposes within the city.</p>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <h2>Application Process</h2>
                <p>To apply for a Nekemte City Resident ID Card, residents must provide the following documentation:</p>
                <ul>
                    <li>Completed application form</li>
                    <li>Proof of Nekemte City residency (e.g., utility bill, rental agreement, or property deed)</li>
                    <li>Valid government-issued ID (e.g., national ID, passport, or driver's license)</li>
                    <li>Passport-sized photograph</li>
                    <li>Application fee (to be determined by the local government)</li>
                </ul>
                <p>The application process can be completed at the Nekemte City Hall or designated municipal offices. Residents can also submit their applications online through the city's official website. Upon successful processing, the Nekemte City Resident ID Card will be issued and delivered to the applicant's registered address.</p>
            </div>
        </div>
    </div><?php include 'includes/footer.php' ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add your custom JavaScript code here
    </script>
</body>

</html>