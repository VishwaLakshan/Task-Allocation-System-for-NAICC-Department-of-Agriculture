<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Content Sharing</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navigation.css">
    <style>
        @import 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css';

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #9dd53a, #3c8722);
            color: #333;
            margin: 0;
        }

        #nav-bar {
            position: sticky;
            top: 0;
            z-index: 10;
        }

        /* Editor Container */
        .editor-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
            /* Centers the editor */
            position: relative;
        }

        #editor {
            height: 300px;
            margin-bottom: 10px;
        }

        #save-btn {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 10px;
            border: none;
            color: #fff;
            background-color: #2b6e1e;
            transition: background-color 0.3s ease;
        }

        #save-btn:hover {
            background-color: #3c8722;
        }

        .ql-discard {
            background: none;
            border: none;
            color: #333;
            cursor: pointer;
            margin-left: 5px;
            font-size: 14px;
        }

        .ql-discard:hover {
            color: #9dd53a;
        }

        .swal2-popup {
            border: none;
        }

        .swal2-styled.swal2-confirm,
        .swal2-styled.swal2-cancel {
            border: none;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .modal-body {
            padding: 20px;
        }

        #user-list {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <!-- Navbar Section -->
    <section id="nav-bar">
        <nav class="navbar navbar-expand-lg navbar-light" style="background-image: linear-gradient(to right, #9dd53a, #3c8722);">
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

    <!-- Text Editor Section -->
    <div class="editor-container">
        <input type="hidden" id="senderId" value="<?php echo $_SESSION['id']; ?>">
        <div id="toolbar"></div>
        <div id="editor"></div>
        <button id="save-btn">Send</button>
    </div>

    <!-- User Selection Modal -->
    <div class="modal fade" id="userSelectionModal" tabindex="-1" aria-labelledby="userSelectionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userSelectionModalLabel">Select Users</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span> <!-- Add close icon -->
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Position</th>
                            </tr>
                        </thead>
                        <tbody id="user-list">
                            <!-- User list will be populated here -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" id="confirm-selection" class="btn btn-success">Confirm Selection</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="js/users-script.js"></script>
</body>

</html>