<?php
include("header.inc");
?>
<div class="content">
    <h2 class="heading">Add New Task</h2>

    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="alert alert-success" role="alert">
            Task added successfully!
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <form method="POST" action="main_task_process.php">
            <div class="form-group">
                <label for="main_task_name">Main Task Name</label>
                <input type="text" class="form-control" id="main_task_name" name="main_task_name" placeholder="Enter task name" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter task description" required></textarea>
            </div>

            <div class="form-group">
                <label for="authority">Authority</label>
                <input type="text" class="form-control" id="authority" name="authority" placeholder="Enter authority" required>
            </div>

            <div class="form-group">
                <label for="due_date">Due Date</label>
                <input type="date" class="form-control" id="due_date" name="due_date" required>
            </div>

            <div class="form-group">
                <label for="actual_due_date">Actual Due Date</label>
                <input type="date" class="form-control" id="actual_due_date" name="actual_due_date" required>
            </div>

            <div class="form-group">
                <label for="remaining_days">Days Remaining</label>
                <input type="text" class="form-control" id="remaining_days" readonly>
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
            <button type="submit" class="btn btn-primary btn-block">Add</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('actual_due_date').addEventListener('change', function() {
        const dueDate = new Date(document.getElementById('due_date').value);
        const actualDueDate = new Date(document.getElementById('actual_due_date').value);
        const remainingDaysInput = document.getElementById('remaining_days');

        if (!isNaN(dueDate.getTime()) && !isNaN(actualDueDate.getTime())) {
            const timeDifference = actualDueDate.getTime() - dueDate.getTime();
            const dayDifference = Math.ceil(timeDifference / (1000 * 3600 * 24)); // Convert milliseconds to days
            
            if (dayDifference >= 0) {
                remainingDaysInput.value = dayDifference + ' days remaining';
            } else {
                remainingDaysInput.value = 'Overdue by ' + Math.abs(dayDifference) + ' days';
            }
        } else {
            remainingDaysInput.value = '';
        }
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
