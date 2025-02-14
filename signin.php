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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">    
    <style>
        body {
            background: linear-gradient(to right, #9dd53a, #3c8722);
        }

        .container {
            margin-top: 80px;
        }

        .card {
            margin-top: 10px;
        }

        .fa-bars {
            color: #fff;
            font-size: 30px !important;
        }

        /* Custom green button */
        .btn-custom {
            background-color: #28a745;
            /* Green color */
            border-color: #28a745;
            /* Green border color */
            color: #fff;
            /* White text color */
        }

        .btn-custom:hover {
            background-color: #218838;
            /* Darker green on hover */
            border-color: #1e7e34;
            /* Darker green border on hover */
        }
    </style>
</head>

<body>
    <!-- Navbar Section -->
    <section id="nav-bar">
        <nav class="navbar navbar-expand-lg navbar-light" style="position: sticky; top: 0; z-index: 10; background-image: linear-gradient(to right, #9dd53a, #3c8722); padding: 0 !important;">
            <a class="navbar-brand" href="home.php"><img src="images/logo.png" alt="Logo" style="height: 40px; padding-left: 20px;"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="outline: none !important;">
                <i class="fa fa-bars" style="color: #fff; font-size: 30px !important;"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item" style="padding: 0 10px;">
                        <a class="nav-link" href="home.php" style="color: #fff !important; font-weight: 600;">HOME</a>
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
                            <!-- Otherwise, show EMPLOYEE NOTIFICATIONS and SHARE CONTENT -->
                            <li class="nav-item" style="padding: 0 10px;">
                                <a class="nav-link" href="user_notifications.php" style="color: #fff !important; font-weight: 600;">EMPLOYEE NOTIFICATIONS</a>
                            </li>
                            <li class="nav-item" style="padding: 0 10px;">
                                <a class="nav-link" href="user_share_content.php" style="color: #fff !important; font-weight: 600;">SHARE CONTENT</a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item" style="padding: 0 10px;">
                            <a class="nav-link" href="logout.php" style="color: #fff !important; font-weight: 600;">LOGOUT</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </section>

    <div class="container">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header text-center">
                    <h1>Sign In</h1>
                </div>
                <div class="card-body">
                    <form id="signin-form">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
                            <label class="form-check-label" for="rememberMe">Remember Me</label>
                        </div>
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-custom">Sign In</button>
                        </div>
                    </form>
                    <div class="text-center">
                        <p>Don't have an account? <a href="signup.php" style="color: #28a745; text-decoration: none;">Sign Up</a></p>
                        <a href="forgot_password.php" style="color: #28a745; text-decoration: none;">Forgot your password?</a>
                    </div>
                    <!-- Response message div -->
                    <div id="response-message" class="col-md-6 mx-auto text-center mt-3"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const signinForm = document.getElementById('signin-form');
            const responseMessage = document.getElementById('response-message');

            signinForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(signinForm);

                fetch('signin_process.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Response:', data);
                        responseMessage.textContent = data.message;
                        if (data.success) {
                            responseMessage.className = 'alert alert-success';
                            setTimeout(() => {
                                window.location.href = 'home.php';
                            }, 2000); // Redirect after a short delay
                        } else {
                            responseMessage.className = 'alert alert-danger';
                            if (data.message === "Email not verified.") {
                                setTimeout(() => {
                                    window.location.href = 'verify.php?id=' + data.id;
                                }, 2000);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        responseMessage.textContent = 'An error occurred. Please try again.';
                        responseMessage.className = 'alert alert-danger';
                    });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>