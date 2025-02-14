<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<style>
     #nav-bar
{
    position: sticky;
    top: 0;
    z-index: 10;
}
.navbar
{
    background-image: linear-gradient(to right, #9dd53a, #3c8722);
    padding: 0 !important;
}
.navbar-brand img
{
height:40px;
padding-left:20px;
}
.navbar-nav li
{
    padding: 0 10px;
}
.navbar-nav li a
{
    color: #fff !important;
    font-weight: 600;
    float: right;
    text-align: left;
}
.fa-bars
{
    color: #fff;
    font-size: 30px !important;
}
.navbar-toggler
{
    outline:none !important;
}

.btn-custom {
            background-color: #28a745;
            color: #fff;
        }
        .btn-custom:hover {
            background-color: #218838;
        }
</style>

</head>
<body>

<section id="nav-bar">
        <nav class="navbar navbar-expand-lg navbar-light" style="position: sticky; top: 0; z-index: 10; background-image: linear-gradient(to right, #9dd53a, #3c8722); padding: 0 !important;">
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
                        <a class="nav-link" href="logout.php" style="color: #fff !important; font-weight: 600;">LOGOUT</a>
                    </li>
                  
                </ul>
            </div>
        </nav>
    </section>

    <div class="container mt-5">
        <h1 class="text-center">Forgot Password</h1>
        <div class="col-md-6 mx-auto">
            <form id="forgot-password-form">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-custom">Send Reset Link</button>
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
            const forgotPasswordForm = document.getElementById('forgot-password-form');
            const responseMessage = document.getElementById('response-message');

            forgotPasswordForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(forgotPasswordForm);

                fetch('forgot_password_process.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) { // Check if the response is okay
                            throw new Error('Network response was not okay');
                        }
                        return response.json();
                    })
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
