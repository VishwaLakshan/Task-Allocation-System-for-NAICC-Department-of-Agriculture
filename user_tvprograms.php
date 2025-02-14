<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TV Programs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
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
                    <li class="nav-item" style="padding: 0 10px;">
                        <a class="nav-link" href="profile.php" style="color: #fff !important; font-weight: 600;">PROFILE</a>
                    </li>
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

                    <li class="nav-item" style="padding: 0 10px;">
                        <a class="nav-link" href="logout.php" style="color: #fff !important; font-weight: 600;">LOGOUT</a>
                    </li>
                </ul>
            </div>
        </nav>
    </section>

    <!-- Main Content -->
    <main class="pcoded-main-container">
        <div class="pcoded-wrapper container mt-5">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="page-wrapper">
                        <div class="page-header">
                            <div class="page-block">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h2>TV PROGRAMS TIME TABLE</h2>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Program Name</th>
                                                <th>Type of Media</th>
                                                <th>Name of Channel</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                            </tr>
                                        </thead>
                                        <tbody id="timetable-body">
                                            <!-- Table rows will be dynamically inserted by JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                                <nav>
                                    <ul class="pagination justify-content-center" id="pagination">
                                        <!-- Pagination controls will be dynamically inserted by JavaScript -->
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/user-tvprograms.js"></script>
</body>

</html>