<!-- Footer -->
<footer class="bg-dark text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <h5>About Us</h5>
                <p>The City Resident ID Card Management System is a comprehensive platform that helps manage the city's
                    resident ID cards. We strive to provide efficient and secure services to the residents of our city.
                </p>
            </div>
            <div class="col-md-4 mb-4 mb-md-0">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="/cricms2/index.php" class="text-white">Home</a></li>
                    <li><a href="/cricms2/about.php" class="text-white">About</a></li>
                    <li><a href="/cricms2/developers.php" class="text-white">Developers</a></li>
                    <li><a href="/cricms2/faq.php" class="text-white">FAQ</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <style>
                    div .list-unstyled img {
                        height: 20px;
                    }
                </style>
                <h5>Contact Us</h5>
                <ul class="list-unstyled">
                    <li><i class="fas fa-map-marker-alt"></i> Wallaga University, Nekemte Ethiopia</li>
                    <li><img src="/cricms2/images/man-talking-on-phone-3021098.png" alt=""></i> +251 923-3650-46</li>
                    <li> </i> ademabdrei0923@gmail.com</li>
                </ul>
                <div class="social-icons">
                    <style>
                        div .social-icons img {
                            height: 20px;
                        }
                    </style>
                    <a href="#" class="text-white mr-3"> <img src="/cricms2/images/facebook.png" alt=""> </a>
                    <a href="#" class="text-white mr-3"> <img src="/cricms2/images/instagram.png" alt=""> </a>
                    <a href="#" class="text-white mr-3"> <img src="/cricms2/images/twitter.png" alt=""> </a>
                    <a href="#" class="text-white mr-3"> <img src="/cricms2/images/pintrest.png" alt=""> </a>
                    <a href="#" class="text-white mr-3"> <img src="/cricms2/images/snapchat.png" alt=""> </a>
                    <a href="#" class="text-white mr-3"> <img src="/cricms2/images/twitter.png" alt=""> </a>
                    <a href="#" class="text-white mr-3"> <img src="" alt=""> </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-darker-dark py-3 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; <span id="date-time"></span> City Resident ID Card Management System All
                        rights reserved.</p>

                    <script>
                        function updateDateTime() {
                            var currentDate = new Date();
                            var dateTimeString = currentDate.getFullYear() + "-" + (currentDate.getMonth() + 1) + "-" + currentDate.getDate() + " " +
                                currentDate.getHours() + ":" + currentDate.getMinutes() + ":" + currentDate.getSeconds();
                            document.getElementById("date-time").innerHTML = dateTimeString;
                        }

                        // Update the date and time every second
                        setInterval(updateDateTime, 1000);
                    </script>
                    <div style="display: flex; align-items:center ; justify-content: space-around">
                        <div class="star">
                            <style>
                                div .star img {
                                    height: 80px;
                                }
                            </style>
                            <img src="/cricms2/images/star.png" alt="">
                        </div>
                        <p class="mb-0">&copy; Adem Abdrei.</p>
                    </div>

                </div>

                <div class="col-md-6 text-md-right">
                    <a href="#" class="text-white mr-3">Privacy Policy</a>
                    <a href="#" class="text-white mr-3">Terms of Service</a>
                    <a href="#" class="text-white">Sitemap</a>
                </div>
            </div>
        </div>
    </div>

</footer>


<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>

<body>


    <script src="/cricms2/js/jquery.min.js"></script>
    <!-- Bootstrap JavaScript dependencies -->
    <script src="/cricms2/js/bootstrap.bundle.min.js"></script>
    <script src="/cricms2/js/jj/boot.js"></script>
    <script src="/cricms2/js/jj/jquery.js"></script>
    <script src="/cricms2/js/jj/proper.js"></script>


    <script src="/cricms2/js/chart.js"></script>
    <!-- Barcode Generator Library -->
    <script src="/cricms2/js/JsBarcode.all.min.js"></script>

    <!-- QR Code Library -->
    <script src="/cricms2/js/qrious.min.js"></script>


    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
</body>

</html>