<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Email Verification</title>
    <style>
         body {
         
         background: linear-gradient(to right, #9dd53a, #3c8722);
        }
        </style>
</head>
<body>
    <div class="container mt-5 text-center">
        <?php
        require_once('config_db.php');
        require_once('User.php');

        if (isset($_GET['id'])) {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            $user = new User();
            if ($user->loadById($id)) {
                $user->sendVerificationCode();
            } else {
                echo "User not found.";
            }
        }
        ?>
        <h1 class="text-center">Verify Your Email Address</h1>
        <hr>
        <br>
        <div>Please check your inbox and enter the verification code below to verify your email address.</div>
        <br>
        <div class="col-md-4 mx-auto">
            <form id="verification-form" action="verify_email.php" method="post">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                <div class="mb-3">
                    <label for="verification_code" class="form-label">Verification Code</label>
                    <input type="text" class="form-control text-center" id="verification_code" name="verification_code" required>
                </div>
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary">Verify</button>
                </div>
            </form>
            
            <div id="response-message" class="mt-3 text-center"></div>
        </div>
    </div>

    <script>
    document.getElementById('verification-form').addEventListener('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(document.getElementById('verification-form'));

        fetch('verify_email.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            var responseMessageDiv = document.getElementById('response-message');
            responseMessageDiv.innerHTML = '<div class="alert ' + (data.success ? 'alert-success' : 'alert-danger') + '" role="alert">' + data.message + '</div>';

            if (data.success) {
                setTimeout(() => {
                    window.location.href = 'signin.php'; // Redirect to signin page on success
                }, 2000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            var responseMessageDiv = document.getElementById('response-message');
            responseMessageDiv.innerHTML = '<div class="alert alert-danger" role="alert">An error occurred. Please try again.</div>';
        });
    });
</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
