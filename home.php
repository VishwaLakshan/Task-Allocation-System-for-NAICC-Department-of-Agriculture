<?php
session_start();

// Check if the user is logged in
$is_logged_in = isset($_SESSION['id']);
$is_admin = false;

// Check if the logged-in user is admin
if ($is_logged_in) {
    include('config_db.php'); // Include database connection
    $id = $_SESSION['id'];

    // Fetch user data
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch();
        $email = $user['email'];

        // Check if the user is an admin
        if ($email == 'admin@ad.gov') {
            $is_admin = true;
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Task Allocation System</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navigation.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: sans-serif;
        }

        #nav-bar {
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .navbar {
            background-image: linear-gradient(to right, #9dd53a, #3c8722);
            padding: 0 !important;
        }

        .navbar-brand img {
            height: 40px;
            padding-left: 20px;
        }

        .navbar-nav li {
            padding: 0 10px;
        }

        .navbar-nav li a {
            color: #fff !important;
            font-weight: 600;
            float: right;
            text-align: left;
        }

        .fa-bars {
            color: #fff;
            font-size: 30px !important;
        }

        .navbar-toggler {
            outline: none !important;
        }

        /*--------banner section--------*/

        #banner {
            background-image: linear-gradient(to right, #9dd53a, #3c8722);
            color: #fff;
            padding-top: 5%;
        }

        .promo-title {
            font-size: 40px;
            font-weight: 600;
            margin-top: 100px;
        }

        .bottom-img {
            width: 100%;

        }

        /*----------about us-------*/

        .title::before {
            content: '';
            background: #3c8722;
            height: 5px;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
            display: block;
            transform: translateY(63px);
        }

        .title::after {
            content: '';
            background: #3c8722;
            height: 10px;
            width: 50px;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 40px;
            display: block;
            transform: translateY(8px);
        }

        #about-us {
            background: #f8f9fa;
            padding-bottom: 50px;
            padding-top: 50px;
        }

        .about-title {
            font-size: 40px;
            font-weight: 600;
            margin-top: 8%;
        }

        #about-us ul li {
            margin: 10px 0;
        }

        #about-us ul {
            margin-left: 10px;

        }

        /*---------------*/
        #services {
            padding: 80px 0;
        }

        .service-img {
            width: 100px;
            margin-top: 20px;
        }

        .services {
            padding: 20px;

        }

        .services h4 {
            padding: 5px;
            margin-top: 25px;
            text-transform: uppercase;

        }

        #services .btn-primary {
            box-shadow: none;
            padding: 8px 25px;
            border: none;
            border-radius: 20px;
            background-image: linear-gradient(to right, #9dd53a, #3c8722);
        }

        /*---------Social-media section-------*/

        #social-media {
            background-color: #f8f9fa;
            padding: 100px 0;
        }

        #social-media p {
            font-size: 36px;
            font-weight: 600;
            margin-bottom: 30px;

        }

        .social-icons img {
            width: 60px;
            transition: 0.5s;
        }

        .social-icons a:hover img {
            transform: translateY(-10px);
        }

        /*-----------footer-----------*/

        #footer {
            background-image: linear-gradient(to right, #9dd53a, #3c8722);
            color: #fff;
        }

        .footer-img {
            width: 100%;
        }

        .footer-box {
            padding: 20px;
        }

        .footer-box img {
            width: 120px;
            margin-bottom: 20px;
        }

        .footer-box .fa {
            margin-right: 8px;
            font-size: 25px;
            height: 40px;
            width: 40px;
            text-align: center;
            padding-top: 7px;
            border-radius: 2px;
            background-image: linear-gradient(to right, #9dd53a, #3c8722);

        }

        .footer-box .form-control {
            box-shadow: none !important;
            border: none;
            border-radius: 0;
            margin-top: 25px;
            max-width: 250px;
        }

        .footer-box .btn-primary {
            box-shadow: none;
            border: 0;
            border-radius: 0;
            margin-top: 30px;
            background-image: linear-gradient(to right, #9dd53a, #3c8722);
        }
    </style>
</head>

<body>
    <!-- Navbar Section -->
    <section id="nav-bar">
        <nav class="navbar navbar-expand-lg navbar-light" style="position: sticky; top: 0; z-index: 10; background-image: linear-gradient(to right, #9dd53a, #3c8722); padding: 20 !important;">
            <a class="navbar-brand" href="home.php"><img src="images/logo.png" alt="Logo" style="height: 40px; padding-left: 20px;"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="outline: none !important;">
                <i class="fa fa-bars" style="color: #fff; font-size: 30px !important;"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item" style="padding: 0 10px;">
                        <a class="nav-link" href="home.php" style="color: #fff !important; font-weight: 600;">HOME</a>
                    </li>
                    <li class="nav-item" style="padding: 0 10px;">
                        <a class="nav-link" href="#services" style="color: #fff !important; font-weight: 600;">SERVICES</a>
                    </li>
                    <li class="nav-item" style="padding: 0 10px;">
                        <a class="nav-link" href="#about-us" style="color: #fff !important; font-weight: 600;">ABOUT US</a>
                    </li>
                    <!-- Only show SIGNUP and SIGNIN if the user is NOT logged in -->
                    <?php if (!$is_logged_in): ?>
                        <li class="nav-item" style="padding: 0 10px;">
                            <a class="nav-link" href="signup.php" style="color: #fff !important; font-weight: 600;">SIGNUP</a>
                        </li>
                        <li class="nav-item" style="padding: 0 10px;">
                            <a class="nav-link" href="signin.php" style="color: #fff !important; font-weight: 600;">SIGNIN</a>
                        </li>
                    <?php endif; ?>

                    <!-- Only show PROFILE, LOGOUT if the user is logged in -->
                    <?php if ($is_logged_in): ?>
                        <li class="nav-item" style="padding: 0 10px;">
                            <a class="nav-link" href="profile.php" style="color: #fff !important; font-weight: 600;">PROFILE</a>
                        </li>

                        <!-- Show ADMIN DASHBOARD if the user is an admin -->
                        <?php if ($is_admin): ?>
                            <li class="nav-item" style="padding: 0 10px;">
                                <a class="nav-link" href="admin_dashboard.php" style="color: #fff !important; font-weight: 600;">ADMIN DASHBOARD</a>
                            </li>
                        <?php else: ?>
                            <!-- Otherwise, show EMPLOYEE PAGES -->
                            <li class="nav-item" style="padding: 0 10px;">
                                <a class="nav-link" href="user_notifications.php" style="color: #fff !important; font-weight: 600;">EMPLOYEE NOTIFICATIONS</a>
                            </li>
                            <li class="nav-item" style="padding: 0 10px;">
                                <a class="nav-link" href="user_share_content.php" style="color: #fff !important; font-weight: 600;">SHARE CONTENT</a>
                            </li>
                            <li class="nav-item" style="padding: 0 10px;">
                                <a class="nav-link" href="user_tvprograms.php" style="color: #fff !important; font-weight: 600;">TV PROGRAMS</a>
                            </li>
                            <li class="nav-item" style="padding: 0 10px;">
                                <a class="nav-link" href="user_courses.php" style="color: #fff !important; font-weight: 600;">TRAINEE COURSES</a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item" style="padding: 0 10px;">
                            <a class="nav-link" href="logout.php" style="color: #fff !important; font-weight: 600;">LOGOUT</a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item" style="padding: 0 10px;">
                        <a class="nav-link" href="#footer" style="color: #fff !important; font-weight: 600;">CONTACT</a>
                    </li>
                </ul>
            </div>
        </nav>
    </section>

    <!----------------banner section--------->
    <section id="banner">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="promo-title">Task Allocation System</p>
                    <P>Maximize the productivity with our seamless task allocation system. Assign, track, and complete tasks effortlessly, all in one place</P>
                    <a href="#"><img src=""></a>
                </div>

                <div class="col-md-6 text-center">
                    <img src="images/HRNB.png" class="img-fluid">
                </div>
            </div>
        </div>

        <img src="images/wave1.png" class="bottom-img">
    </section>

    <!-----------------Services------------>
    <section id="services">
        <div class="container text-center">
            <h1 class="title">Services</h1>
            <div class="row text-center">
                <div class="col-md-5 services">
                    <img src="images/admin.webp" class="service-img">
                    <h4>Administrative Division</h4>
                    <p>The backbone of our department, handling all administrative functions, ensuring smooth operations, and providing essential support to our various programs and initiatives. This section manages personnel and day-to-day operations to maintain efficiency and order within the organization.</p>
                </div>

                <div class="col-md-5 services">
                    <img src="images/ICT 02.jfif" class="service-img">
                    <h4>ICT Division</h4>
                    <p>The ICT Section is dedicated to advancing our technological infrastructure, managing our digital resources, and supporting the integration of innovative ICT solutions. This section ensures the smooth operation of our information systems, enhances communication, and drives digital transformation within the department.</p>
                </div>

                <div class="col-md-5 services">
                    <img src="images/vp.jpg" class="service-img">
                    <h4>Video and Photography Division</h4>
                    <p>This section produces educational videos, promotional materials, and photographic records that help in disseminating information and showcasing our achievements to the public.</p>
                </div>

                <div class="col-md-5 services">
                    <img src="images/GT.webp" class="service-img">
                    <h4>Graphic Communication and Training Division</h4>
                    <p>Enhances our communication efforts through compelling graphic design and ensures that our staff and stakeholders receive continuous, high-quality training to stay updated with the latest agricultural practices and technologies.</p>
                </div>
            </div>
            <button type="button" class="btn btn-primary">All services</button>
        </div>
    </section>

    <!----------About Us------>

    <section id="about-us">
        <div class="container">
            <h1 class="title text-center">About Us?</h1>
            <div class="row">
                <div class="col-md-6 about-us">
                    <p class="about-title">What We Are Enabling</p>
                    <ul>
                        <li>Efficiently Assign Tasks: Ensure that tasks are allocated to the right personnel based on their expertise and availability, optimizing our resource utilization.</li>
                        <li>Track Progress: Monitor the progress of various projects and initiatives in real-time, ensuring timely completion and addressing any bottlenecks swiftly.</li>
                        <li>Enhance Collaboration: Foster better collaboration among our teams and institutions, allowing for the seamless sharing of information and resources.</li>
                        <li>Improve Transparency: Provide a transparent view of task assignments and project statuses to all stakeholders, promoting accountability and clarity.</li>
                    </ul>
                </div>

                <div class="col-md-6">
                    <img src="images/NAICC.jpg" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-----------Contact us------>

    <section id="social-media">
        <div class="container text-center">
            <p>FIND US ON SOCIAL MEDIA</p>
            <div class="social-icons">
                <a href="#"><img src="images/facebook-icon.png"></a>
                <a href="#"><img src="images/instagram-icon.png"></a>
                <a href="#"><img src="images/twitter-icon.png"></a>
                <a href="#"><img src="images/linkedin-icon.png"></a>
                <a href="#"><img src="images/whatsapp-icon.png"></a>
            </div>
        </div>
    </section>

    <!---------footer section------>

    <section id="footer">
        <img src="images/wave2.png" class="footer-img">
        <div class="container">
            <div class="row">
                <div class="col-md-4 footer-box">
                    <p>Empowering efficient task management for the agricultural department, our system streamlines operations, enhances productivity, and promotes sustainable practices.</p>
                </div>

                <div class="col-md-4 footer-box">
                    <p>CONTACT US</p>
                    <p><i class="fa fa-map-marker"></i> National Agriculture Information and Communication Centre, Gannoruwa, Peradeniya, Sri Lanka</p>
                    <p><i class="fa fa-phone"></i> +94 812 030040/41/42/43</p>
                    <p><i class="fa fa-envelope"></i> director.naicc@doa.gov.lk</p>
                </div>

                <div class="col-md-4 footer-box">
                    <p>SUBSCRIBE NEWSLETTER</p>
                    <input type="email" class="form-control" placeholder="Your Email">
                    <button type="button" class="btn btn-primary">Subscribe</button>
                </div>
            </div>
        </div>
    </section>

    <!------smooth scroll------->
    <script src="smooth-scroll.js"></script>
    <script>
        var scroll = new SmoothScroll('a[href*="#"]');
    </script>
</body>

</html>