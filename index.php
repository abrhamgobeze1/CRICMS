<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nekemte City Resident ID</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="shortcut icon" href="/odps/images/favicon/favicon.jpg" type="image/x-icon">
  <!-- Custom CSS -->
  <style>
    body {
      background-color: #f8f9fa;
      font-family: Arial, sans-serif;
    }

    .hero-section {
      background-image: url('images/slider/Nekemte.jpg');
      background-size: cover;
      color: #fff;
      text-align: center;
      padding: 100px 0;
    }
    .container-color {
  color: #0077b6; /* slightly darker blue */
  background-color: #f7f7f7; /* light gray */
  font-weight: 500; /* medium weight */
  padding: 1.25rem;
  border-radius: 0.375rem; /* slightly rounded corners */
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.1);
}

    .hero-section h1 {
      font-size: 3.5rem;
      margin-bottom: 20px;
    }

    .hero-section p {
      font-size: 1.2rem;
      margin-bottom: 40px;
    }

    .features-section {
      padding: 80px 0;
      background-color: #fff;
      text-align: center;
    }

    .features-section h2 {
      font-size: 2.5rem;
      margin-bottom: 50px;
    }

    .feature {
      margin-bottom: 30px;
    }

    .feature h3 {
      font-size: 1.8rem;
      margin-bottom: 10px;
    }

    .testimonial-section {
      padding: 80px 0;
      background-color: #f8f9fa;
      text-align: center;
    }

    .testimonial {
      margin-bottom: 50px;
    }

    .testimonial img {
      width: 100px;
      border-radius: 50%;
      margin-bottom: 20px;
    }

    .testimonial p {
      font-size: 1.2rem;
      margin-bottom: 10px;
    }

    .testimonial span {
      font-weight: bold;
      font-style: italic;
    }

    .carousel-item img {
      max-height: 400px;
      object-fit: cover;
    }
    .hero {
  background-image: linear-gradient(to right, #1d4ed8, #1e40af);
  padding: 4rem 2rem;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 50vh;
}

.hero-content {
  text-align: center;
  color: #fff;
  max-width: 600px;
}

.hero-title {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 1rem;
}

.hero-description {
  font-size: 1.25rem;
  margin-bottom: 2rem;
}

.hero-actions .btn {
  margin: 0 0.5rem;
}

.btn {
  display: inline-block;
  padding: 0.75rem 1.5rem;
  border-radius: 0.375rem;
  font-size: 1rem;
  font-weight: 500;
  text-decoration: none;
  transition: background-color 0.3s ease;
}

.btn-primary {
  background-color: #fff;
  color: #1d4ed8;
}

.btn-primary:hover {
  background-color: #e5e7eb;
}

.btn-secondary {
  background-color: transparent;
  color: #fff;
  border: 1px solid #fff;
}

.btn-secondary:hover {
  background-color: rgba(255, 255, 255, 0.1);
}
  </style>
</head>

<body>
  <?php include 'includes/header.php'; ?>

  <section class="hero">
  <div class="hero-content">
    <h1 class="hero-title">Nekemte City Resident ID</h1>
    <p class="hero-description">Manage your city resident ID cards with ease</p>
    <div class="hero-actions">
      <a href="resident/resident_register.php" class="btn btn-primary">Register for ID Card</a>
      <a href="login.php" class="btn btn-secondary">Login</a>
    </div>
  </div>
</section>

  <section class="features-section">
    <div class="container">
      <h2>Key Features</h2>
      <div class="row">
        <div class="col-md-4">
          <div class="feature">
            <h3>Easy Registration</h3>
            <p>Quick and easy registration process for city residents.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature">
            <h3>Secure ID Management</h3>
            <p>Manage and update your city ID card securely.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature">
            <h3>Application Tracking</h3>
            <p>Monitor the status of your ID card application.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Slider -->
  <section>
    <div class="container">
      <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <ol class="carousel-indicators">
          <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
          <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
          <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
          <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"></li>
          <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="images/slider/Nekemte.jpg" class="d-block w-100" alt="Slide 1">
          </div>
          <div class="carousel-item">
            <img src="images/slider/Nekemte_city.jpg" class="d-block w-100" alt="Slide 2">
          </div>
          <div class="carousel-item">
            <img src="images/slider/Nekemte_city_01.jpg" class="d-block w-100" alt="Slide 3">
          </div>
          <div class="carousel-item">
            <img src="images/slider/Nekemte school.jpg" class="d-block w-100" alt="Slide 4">
          </div>
          <div class="carousel-item">
            <img src="images/slider/002 Nekemte.jpg" class="d-block w-100" alt="Slide 5">
          </div>
          <div class="carousel-item">
            <img src="images/slider/Nekemte agip.jpg" class="d-block w-100" alt="Slide 6">
          </div>
          <div class="carousel-item">
            <img src="images/slider/Nekemte-_-OLF-S-hane-_Ethiopia.jpg" class="d-block w-100" alt="Slide 7">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </section>

  <section class="testimonial-section">
  <div class="container">
    <h2>What Our Users Are Saying</h2>
    <div class="row">
      <div class="col-md-4">
        <div class="testimonial">
          <img src="images/testimonials/AVATARZ 1.png" alt="Testimonial 1">
          <p>"The online registration for my city ID was quick and easy. Excellent service!"</p>
          <span>- Meron Kebede, Resident</span>
        </div>
      </div>
      <div class="col-md-4">
        <div class="testimonial">
          <img src="images/testimonials/AVATARZ 2.png" alt="Testimonial 2">
          <p>"I love how secure and efficient the ID management system is. It's a game-changer!"</p>
          <span>- Hanna Yohannes, Resident</span>
        </div>
      </div>
      <div class="col-md-4">
        <div class="testimonial">
          <img src="images/testimonials/AVATARZ 3.png" alt="Testimonial 3">
          <p>"Tracking my application status was so convenient. I'm impressed with the service!"</p>
          <span>- Elias Seyoum, Resident</span>
        </div>
      </div>
      <div class="col-md-4">
        <div class="testimonial">
          <img src="images/testimonials/AVATARZ 4.png" alt="Testimonial 4">
          <p>"The system is user-friendly and efficient. It made the entire process hassle-free."</p>
          <span>- Selam Getachew, Resident</span>
        </div>
      </div>
      <div class="col-md-4">
        <div class="testimonial">
          <img src="images/testimonials/AVATARZ - Tomas.png" alt="Testimonial 5">
          <p>"I'm really impressed with how easy it was to manage my ID card online. Excellent job!"</p>
          <span>- Bemnet Asfaw, Resident</span>
        </div>
      </div>
      <div class="col-md-4">
        <div class="testimonial">
          <img src="images/testimonials/AVATARZ - Sheik.png" alt="Testimonial 6">
          <p>"A seamless process from start to finish. I highly recommend the online system to everyone."</p>
          <span>- Feyisa Lelisa, Resident</span>
        </div>
      </div>
    </div>
  </div>
</section>

  <?php include 'includes/footer.php'; ?>

  <!-- jQuery and Bootstrap JS -->
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery-3.6.0.min.js"></script>
</body>

</html>