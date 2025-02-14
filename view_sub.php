<?php
include("header.inc");
include('config_db.php'); 

if (isset($_GET['subtask_id'])) {
    $subtask_id = $_GET['subtask_id'];

    // Fetch the subtask details
    $query = $conn->prepare("SELECT * FROM subtasks WHERE subtask_id = ?");
    $query->execute([$subtask_id]);
    $subtask = $query->fetch(PDO::FETCH_ASSOC);

    if ($subtask) {
        ?>
        <div class="content">
            <h2 class="heading">Subtask Details</h2>

            <div class="card">
                <h3 class="task-title"><?= htmlspecialchars($subtask['subtask_name']); ?></h3>
                <p><strong>Subtask Number:</strong> <?= htmlspecialchars($subtask['task_number']); ?></p>
                <p><strong>Description:</strong> <?= htmlspecialchars($subtask['description']); ?></p>
                <p><strong>Priority:</strong> <?= htmlspecialchars($subtask['priority']); ?></p>
                <p><strong>Due Date:</strong> <?= htmlspecialchars($subtask['due_date']); ?></p>                
                <p><strong>Status:</strong> <?= htmlspecialchars($subtask['status']); ?></p>
                <p><strong>Progress:</strong> <?= htmlspecialchars($subtask['progress']); ?>%</p>
                <p><strong>Created At:</strong> <?= htmlspecialchars($subtask['created_at']); ?></p>

                <!-- Assign to Employee Form -->
                <form id="assignSubtaskForm">
                    <div class="form-group">
                        <label for="assign">Assign to Employee (by Name):</label>
                        <input type="text" class="form-control" id="assign" name="assign_name" placeholder="Start typing name..." autocomplete="off" required>
                        <input type="hidden" id="assign_id" name="assign_id"> <!-- Hidden field for employee id -->
                        <div id="employeeSuggestions" class="suggestions-box"></div> <!-- Employee suggestions -->
                    </div>
                    <input type="hidden" name="subtask_id" value="<?= $subtask['id']; ?>">
                    <button type="submit" class="btn btn-primary btn-block">Update Assign</button>
                </form>

                <div id="responseMessage"></div>
            </div>
        </div>
        <?php
    } else {
        echo "<div class='content'><h3 class='error-message'>Subtask not found!</h3></div>";
    }
} else {
    echo "<div class='content'><h3 class='error-message'>No subtask ID provided!</h3></div>";
}
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Handle typing in the assign field for employee search
    $('#assign').on('input', function () {
        let query = $(this).val();

        if (query.length >= 2) {
            $.ajax({
                url: 'search_employees.php', // API to fetch employee suggestions
                method: 'POST',
                data: { query: query },
                success: function (response) {
                    $('#employeeSuggestions').html(response);
                    $('#employeeSuggestions').show();
                }
            });
        } else {
            $('#employeeSuggestions').hide();
        }
    });

    // Handle click on suggestion
    $(document).on('click', '.suggestion-item', function () {
        let employeeName = $(this).text();
        let employeeId = $(this).data('id'); // Get employee ID from suggestion

        $('#assign').val(employeeName);
        $('#assign_id').val(employeeId); // Set employee ID in hidden input field
        $('#employeeSuggestions').hide();
    });

    // Handle form submission to update subtask assignment with AJAX
    $('#assignSubtaskForm').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        $.ajax({
            url: 'update_subtask_assign.php', // API to update subtask assignment
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#responseMessage').html('<div class="alert alert-success">Employee assigned to subtask successfully!</div>');
            },
            error: function() {
                $('#responseMessage').html('<div class="alert alert-danger">Failed to assign employee to subtask.</div>');
            }
        });
    });
</script>

<style>
    .content {
        padding: 30px;
        background-color: #f9f9f9;
        position: relative;
    }

    .heading {
        text-align: center;
        margin-bottom: 20px;
        font-size: 32px;
        font-weight: bold;
        color: #2d3436;
    }

    .card {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 20px auto;
    }

    .task-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        text-align: center;
        color: #2d3436;
    }

    .form-group {
        margin-top: 20px;
    }

    .suggestions-box {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        display: none;
        position: absolute;
        z-index: 9999;
        max-height: 150px;
        overflow-y: auto;
        width: 100%;
    }

    .suggestion-item {
        padding: 8px 12px;
        cursor: pointer;
    }

    .suggestion-item:hover {
        background-color: #00b894;
        color: white;
    }

    #responseMessage {
        margin-top: 20px;
    }
</style>