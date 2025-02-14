<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainee Courses Time Table</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navigation.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
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
                                    <h2>TRAINEE COURSES TIME TABLE</h2>
                                    <button class="btn btn-success" data-toggle="modal" data-target="#addModal">Add Course Schedule</button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Course Name</th>
                                                <th>Date</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Action</th>
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

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Shedule Course</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add-form">
                        <div class="form-group">
                            <label for="course-name">Course Name</label>
                            <input type="text" class="form-control" id="course-name" required>
                        </div>
                        <div class="form-group">
                            <label for="course-date">Date</label>
                            <input type="text" class="form-control datepicker" id="course-date" required>
                        </div>
                        <div class="form-group">
                            <label for="start-time">Start Time</label>
                            <input type="text" class="form-control timepicker" id="start-time" required>
                        </div>
                        <div class="form-group">
                            <label for="end-time">End Time</label>
                            <input type="text" class="form-control timepicker" id="end-time" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Course Modal -->
    <div class="modal fade" id="editCourseModal" tabindex="-1" role="dialog" aria-labelledby="editCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editCourseForm">
                        <input type="hidden" id="courseId" name="courseId">
                        <div class="form-group">
                            <label for="course_name">Course Name</label>
                            <input type="text" class="form-control" id="course_name" name="course_name" required>
                        </div>
                        <div class="form-group">
                            <label for="course_date">Course Date</label>
                            <input type="date" class="form-control" id="course_date" name="course_date" required>
                        </div>
                        <div class="form-group">
                            <label for="start_time">Start Time</label>
                            <input type="time" class="form-control" id="start_time" name="start_time" required>
                        </div>
                        <div class="form-group">
                            <label for="end_time">End Time</label>
                            <input type="time" class="form-control" id="end_time" name="end_time" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- [ Scripts ] -->
    <script src="js/vendor-all.min.js"></script>
    <script src="js/plugins/bootstrap.min.js"></script>
    <script src="js/ripple.js"></script>
    <script src="js/pcoded.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/courses-script.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize datepicker and timepicker
            $('.datepicker').datepicker();
            $('.timepicker').timepicker();

            // Reset the form when the Add Modal is shown
            $('#addModal').on('shown.bs.modal', function() {
                $('#add-form')[0].reset();
            });
        });
    </script>
</body>

</html>