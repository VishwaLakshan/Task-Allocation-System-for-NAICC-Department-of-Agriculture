<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Share Content</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navigation.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .modal-footer {
            border-top: none;
        }

        .table thead th {
            background-color: #3c8722;
            color: white;
        }

        .table td {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        #user-list {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <!-- Include Navigation Bar -->
    <?php include 'nav_bar.php'; ?>

    <!-- Include Sidebar Navigation -->
    <?php include 'sidebar_nav.php'; ?>

    <!-- Main Content -->
    <main class="pcoded-main-container">
        <div class="pcoded-wrapper container mt-5">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="page-wrapper">
                        <div class="page-header">
                            <div class="page-block">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h2>SHARE CONTENT</h2>
                                </div>
                                <div class="editor-container">
                                    <input type="hidden" id="senderId" value="<?php echo $_SESSION['id']; ?>">
                                    <div id="toolbar"></div>
                                    <div id="editor"></div>
                                    <button id="save-btn" class="btn btn-success mt-3">Send</button>
                                </div>
                            </div>
                        </div>
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
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/scripts.js"></script>
    <script src="js/vendor-all.min.js"></script>
    <script src="js/plugins/bootstrap.min.js"></script>
    <script src="js/ripple.js"></script>
    <script src="js/pcoded.min.js"></script>
</body>

</html>