<?php
include("header.inc");
?>

<div class="content">
    <h2 class="heading">Add New Sub-Task</h2>

    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="alert alert-success" role="alert">
            Sub-task added successfully!
        </div>
    <?php endif; ?>

    <div class="card">
        <form method="POST" action="subtask_process.php">
        <div class="form-group">
                <label for="main_task_name">Main Task Name</label>
                <input type="text" class="form-control" id="main_task_name" name="main_task_name" placeholder="Enter main_task_name" required>
            </div>


            <div class="form-group">
                <label for="subtask_name">Sub-task Name</label>
                <input type="text" class="form-control" id="subtask_name" name="subtask_name" placeholder="Enter sub-task name" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter sub-task description" required></textarea>
            </div>

            <div class="form-group">
                <label for="due_date">Due Date</label>
                <input type="date" class="form-control" id="due_date" name="due_date" required>
            </div>

            <div class="form-group">
                <label for="priority">Priority</label>
                <select class="form-control" id="priority" name="priority" required>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                </select>
            </div>
            <br>
            <button type="submit" class="btn btn-primary btn-block">Add Sub-task</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#main_task_name').on('input', function () {
        let taskName = $(this).val();

        if (taskName.length >= 2) {
            $.ajax({
                url: 'task_suggestions.php', 
                method: 'POST',
                data: { query: taskName },
                success: function (response) {
                    $('#taskSuggestions').html(response);
                    $('#taskSuggestions').show();
                }
            });
        } else {
            $('#taskSuggestions').hide();
        }
    });

    $(document).on('click', '.suggestion-item', function () {
        let taskName = $(this).text();
        $('#main_task_name').val(taskName);
        $('#taskSuggestions').hide();
    });
</script>

<style>
    .suggestions-box {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        display: none;
        position: absolute; /* This ensures it appears directly below the input */
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

</body>
</html>
