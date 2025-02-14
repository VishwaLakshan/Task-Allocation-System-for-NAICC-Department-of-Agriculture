<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TV Programs & Events Time Table</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2> TV PROGRAMS TIME TABLE</h2>
            <button class="btn btn-success" data-toggle="modal" data-target="#addModal">Add Program</button>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Program Name</th>
                    <th>Type of Media</th>
                    <th>Name of Channel</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="timetable-body">
                <!-- Table rows will be inserted here by JavaScript -->
            </tbody>
        </table>
        <nav>
            <ul class="pagination justify-content-center" id="pagination">
                <!-- Pagination controls will be inserted here by JavaScript -->
            </ul>
        </nav>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Program</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add-form">
                        <div class="form-group">
                            <label for="program-name">Program Name</label>
                            <input type="text" class="form-control" id="program-name" required>
                        </div>
                        <div class="form-group">
                            <label for="media-type">Type of Media</label>
                            <input type="text" class="form-control" id="media-type" required>
                        </div>
                        <div class="form-group">
                            <label for="channel-name">Name of Channel</label>
                            <input type="text" class="form-control" id="channel-name" required>
                        </div>
                        <div class="form-group">
                            <label for="program-date">Date</label>
                            <input type="text" class="form-control datepicker" id="program-date" required>
                        </div>
                        <div class="form-group">
                            <label for="program-time">Time</label>
                            <input type="text" class="form-control timepicker" id="program-time" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Program</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit-form">
                        <input type="hidden" id="edit-id">
                        <div class="form-group">
                            <label for="edit-program-name">Program Name</label>
                            <input type="text" class="form-control" id="edit-program-name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-media-type">Type of Media</label>
                            <input type="text" class="form-control" id="edit-media-type" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-channel-name">Name of Channel</label>
                            <input type="text" class="form-control" id="edit-channel-name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-program-date">Date</label>
                            <input type="text" class="form-control datepicker" id="edit-program-date" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-program-time">Time</label>
                            <input type="text" class="form-control timepicker" id="edit-program-time" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/scripts.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize datepicker and timepicker
            $('.datepicker').datepicker();
            $('.timepicker').timepicker();

            // Reset the form when the Add Modal is shown
            $('#addModal').on('shown.bs.modal', function () {
                $('#add-form')[0].reset();
            });
        });
    </script>
</body>
</html>
