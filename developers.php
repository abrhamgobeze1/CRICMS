<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nekemte City Resident ID Card</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="/project_directory/images/nekemte-logo.jpg" type="image/x-icon">

    <style>
        /* Hero Section */
        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #f5f5f5;
            padding: 4rem 0;
        }

        .hero-content {
            flex: 1;
            padding-right: 2rem;
        }

        .hero-content h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .hero-content p {
            font-size: 1.25rem;
            color: #666;
        }

        .hero-image {
            flex: 1;
        }

        .hero-image img {
            max-width: 100%;
            height: auto;
        }

        /* Developers Grid */
        .developers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            grid-gap: 2rem;
        }

        .card {
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card .card-body {
            padding: 1.5rem;
        }

        .card .social-links {
            display: flex;
            justify-content: center;
            margin-top: 1rem;
        }

        .card .social-links a {
            color: #333;
            transition: color 0.3s ease-in-out;
        }

        .card .social-links a:hover {
            color: #007bff;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
        }

        /* Responsive Styles */
        @media (max-width: 767px) {
            .hero {
                flex-direction: column;
                padding: 2rem 0;
            }

            .hero-content {
                padding-right: 0;
                text-align: center;
                margin-bottom: 2rem;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-content p {
                font-size: 1rem;
            }

            .developers-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }
    </style>
</head>

<body>
    <?php include 'includes/header.php' ?>

    <section class="hero">
        <div class="hero-content">
            <h1>Meet Our Talented Developers</h1>
            <p>The team behind theNekemte City Resident ID Card Management System</p>
        </div>
        <div class="hero-image">
            <img src="images/slider/Nekemte_city_01.jpg" alt="Hero Image">
        </div>
    </section>

    <div class="container my-5">
        <h2 class="section-title mb-4">Our Talented Developers</h2>
        <div class="row developers-grid">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="images/developers/Rebuma.png" class="card-img-top" alt="Developer 1">
                    <div class="card-body">
                    <h5 class="card-title">Adem Abdrei</h5>
                    <p class="card-text">ID Card: 1303414</p>
                        <div class="social-links">
                            <a href="#" class="btn mx-2">
                                <img src="images/social/facebook.png" alt="Facebook" width="20" height="20">
                            </a>
                            <a href="#" class="btn mx-2">
                                <img src="images/social/twitter.png" alt="Twitter" width="20" height="20">
                            </a>
                            <a href="#" class="btn  mx-2">
                                <img src="images/social/instagram.png" alt="Instagram" width="20" height="20">
                            </a>
                            <a href="#" class="btn mx-2">
                                <img src="images/social/telegram.png" alt="Telegram" width="20" height="20">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="images/developers/Nanati.png" class="card-img-top" alt="Developer 2">
                    <div class="card-body">
                    <h5 class="card-title">Abrham Gobeze</h5>
                    <p class="card-text">ID Card: 1303383</p>
                        <div class="social-links">
                            <a href="#" class="btn mx-2">
                                <img src="images/social/facebook.png" alt="Facebook" width="20" height="20">
                            </a>
                            <a href="#" class="btn mx-2">
                                <img src="images/social/twitter.png" alt="Twitter" width="20" height="20">
                            </a>
                            <a href="#" class="btn  mx-2">
                                <img src="images/social/instagram.png" alt="Instagram" width="20" height="20">
                            </a>
                            <a href="#" class="btn mx-2">
                                <img src="images/social/telegram.png" alt="Telegram" width="20" height="20">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="images/developers/Ayantu.png" class="card-img-top" alt="Developer 2">
                    <div class="card-body">
                    <h5 class="card-title">Adugna Misgana</h5>
                    <p class="card-text">ID Card: 1303424</p>
                        <div class="social-links">
                            <a href="#" class="btn mx-2">
                                <img src="images/social/facebook.png" alt="Facebook" width="20" height="20">
                            </a>
                            <a href="#" class="btn mx-2">
                                <img src="images/social/twitter.png" alt="Twitter" width="20" height="20">
                            </a>
                            <a href="#" class="btn  mx-2">
                                <img src="images/social/instagram.png" alt="Instagram" width="20" height="20">
                            </a>
                            <a href="#" class="btn mx-2">
                                <img src="images/social/telegram.png" alt="Telegram" width="20" height="20">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="images/developers/Yohannis.png" class="card-img-top" alt="Developer 2">
                    <div class="card-body">
                        <h5 class="card-title">Dugasa Olana</h5>
                        <p class="card-text">ID Card: WU-1206228</p>
                        <div class="social-links">
                            <a href="#" class="btn mx-2">
                                <img src="images/social/facebook.png" alt="Facebook" width="20" height="20">
                            </a>
                            <a href="#" class="btn mx-2">
                                <img src="images/social/twitter.png" alt="Twitter" width="20" height="20">
                            </a>
                            <a href="#" class="btn  mx-2">
                                <img src="images/social/instagram.png" alt="Instagram" width="20" height="20">
                            </a>
                            <a href="#" class="btn mx-2">
                                <img src="images/social/telegram.png" alt="Telegram" width="20" height="20">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="images/developers/Yohannis.png" class="card-img-top" alt="Developer 2">
                    <div class="card-body">
                        <h5 class="card-title"> Hundesa Nemera </h5>
                        <p class="card-text">ID Card: WU-1305966</p>
                        <div class="social-links">
                            <a href="#" class="btn mx-2">
                                <img src="images/social/facebook.png" alt="Facebook" width="20" height="20">
                            </a>
                            <a href="#" class="btn mx-2">
                                <img src="images/social/twitter.png" alt="Twitter" width="20" height="20">
                            </a>
                            <a href="#" class="btn  mx-2">
                                <img src="images/social/instagram.png" alt="Instagram" width="20" height="20">
                            </a>
                            <a href="#" class="btn mx-2">
                                <img src="images/social/telegram.png" alt="Telegram" width="20" height="20">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php' ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add your custom JavaScript code here
    </script>
</body>

</html>