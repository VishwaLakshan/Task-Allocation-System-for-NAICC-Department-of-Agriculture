<?php
include("header.inc");
include('config_db.php'); 

if (isset($_GET['main_task_id'])) {
    $task_id = $_GET['main_task_id']; // Get the task ID from the URL

    // Prepare and execute the query to fetch task details
    $query = $conn->prepare("SELECT * FROM main_task WHERE main_task_id = ?");
    $query->execute([$task_id]);
    $task = $query->fetch(PDO::FETCH_ASSOC); // Fetch the task details

    if ($task) {
        // Fetch the subtasks associated with this main task
        $stmt = $conn->prepare("SELECT * FROM subtasks WHERE main_task_id = ?");
        $stmt->execute([$task_id]);
        $subtasks = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all subtasks
        ?>
        <div class="content">
            <h2 class="heading">Task Details</h2>

            <div class="card">
                <h3 class="task-title"><?= htmlspecialchars($task['main_task_name']); ?></h3>
                
                <p><strong>Description:</strong> <?= htmlspecialchars($task['description']); ?></p>
                <p><strong>Authority:</strong> <?= htmlspecialchars($task['authority']); ?></p>
                <p><strong>Priority:</strong> <?= htmlspecialchars($task['priority']); ?></p>
                <p><strong>Due Date:</strong> <?= htmlspecialchars($task['due_date']); ?></p>
                <p><strong>Actual Due Date:</strong> <?= htmlspecialchars($task['actual_due_date']); ?></p>
                <p><strong>Status:</strong> <?= htmlspecialchars($task['status']); ?></p>
                <p><strong>Progress:</strong> <?= htmlspecialchars($task['progress']); ?>%</p>
                <p><strong>Created At:</strong> <?= htmlspecialchars($task['created_at']); ?></p>

                <!-- Subtasks Section -->
                <h3 class="heading mt-4">Subtasks</h3>
                <div href="view_sub.php" class="subtask-cards">
                    <?php if ($subtasks): ?>
                        <?php foreach ($subtasks as $subtask): ?>
                            <!-- Corrected: Reference $subtask['subtask_id'] -->
                            <a href="view_sub.php?subtask_id=<?= htmlspecialchars($subtask_id['subtask_id']); ?>" class="subtask-card">
                                <h4 class="subtask-title"><?= htmlspecialchars($subtask['subtask_name']); ?></h4>
                                <p>Due Date: <?= htmlspecialchars($subtask['due_date']); ?></p>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No subtasks found for this task.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo "<div class='content'><h3 class='error-message'>Task not found!</h3></div>";
    }
} else {
    echo "<div class='content'><h3 class='error-message'>No task ID provided!</h3></div>";
}
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Handle typing in the assign field
    $('#assign').on('input', function () {
        let query = $(this).val();

        if (query.length >= 2) {
            $.ajax({
                url: 'search_employees.php', // Path to your PHP file to fetch employee suggestions
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
        let employeeId = $(this).data('id'); // Assuming data-id contains employee ID

        $('#assign').val(employeeName);
        $('#assign_id').val(employeeId); // Set employee ID in hidden input field
        $('#employeeSuggestions').hide();
    });

    // Handle form submission with AJAX
    $('#assignForm').on('submit', function(e) {
        e.preventDefault(); // Prevent form submission

        $.ajax({
            url: 'update_assign.php', // API to update task assignment
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#responseMessage').html('<div class="alert alert-success">Employee assigned successfully!</div>');
            },
            error: function() {
                $('#responseMessage').html('<div class="alert alert-danger">Failed to assign employee.</div>');
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

    .task-title, .subtask-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        text-align: center;
        color: #2d3436;
    }

    .subtask-cards {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 20px;
    }

    .subtask-card {
        background-color: #e0f7fa;
        padding: 20px;
        border-radius: 8px;
        width: 250px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        text-decoration: none;
        color: #2d3436;
    }

    .subtask-card:hover {
        transform: scale(1.05);
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
</style>
