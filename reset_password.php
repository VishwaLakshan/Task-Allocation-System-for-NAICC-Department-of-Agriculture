<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Reset Password</h1>
        <div class="col-md-6 mx-auto">
            <form id="reset-password-form">
                <!-- Hidden input for the reset token -->
                <input type="hidden" id="reset_token" name="reset_token" value="<?php echo isset($_GET['token']) ? htmlspecialchars($_GET['token']) : ''; ?>">

                <!-- Email input field -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <!-- Password input field -->
                <div class="mb-3">
                    <label for="newPassword" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword" required minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^\w\d\s:])[\S]{8,}">
                    <small class="form-text text-muted">Password must be at least 8 characters long, with a mix of letters, numbers, and special characters.</small>
                </div>

                <!-- Confirm Password input field -->
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>

                <!-- Submit button -->
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </div>
            </form>

            <!-- Response message div -->
            <div id="response-message" class="mt-3"></div>
        </div>
    </div>

    <!-- Bootstrap JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <!-- Custom JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resetPasswordForm = document.getElementById('reset-password-form');
            const responseMessage = document.getElementById('response-message');
            const newPassword = document.getElementById('newPassword');
            const confirmPassword = document.getElementById('confirm_password');

            resetPasswordForm.addEventListener('submit', function(event) {
                event.preventDefault();

                // Check if passwords match
                if (newPassword.value !== confirmPassword.value) {
                    responseMessage.textContent = 'Passwords do not match.';
                    responseMessage.className = 'alert alert-danger';
                    return;
                }

                const formData = new FormData(resetPasswordForm);

                fetch('reset_password_process.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    // Display the response message to the user
                    responseMessage.textContent = data.message;
                    responseMessage.className = data.success ? 'alert alert-success' : 'alert alert-danger';
                })
                .catch(error => {
                    console.error('Error:', error);
                    responseMessage.textContent = 'An error occurred. Please try again later.';
                    responseMessage.className = 'alert alert-danger';
                });
            });
        });
    </script>
</body>
</html>
