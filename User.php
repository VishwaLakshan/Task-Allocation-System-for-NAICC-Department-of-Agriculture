<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

class User {
    private $id;
    private $name;
    private $email;
    private $password;
    private $verification_code;
    private $verified;
    private $user_type;
    private $position;
    private $phone;
    private $location;
    private $division;
    private $reset_token;
    

    // Constructor (if needed)
    // public function __construct() {}

    // Getters and setters
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;
    }

    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }
    public function setPassword($password) {
        $this->password = $password;
    }

    public function getVerificationCode() {
        return $this->verification_code;
    }
    public function setVerificationCode($verification_code) {
        $this->verification_code = $verification_code;
    }

    public function getVerified() {
        return $this->verified;
    }
    public function setVerified($verified) {
        $this->verified = $verified;
    }

    public function getUserType() {
        return $this->user_type;
    }
    public function setUserType($user_type) {
        $this->user_type = $user_type;
    }

    public function getPosition() {
        return $this->position;
    }
    public function setPosition($position) {
        $this->position = $position;
    }

    public function getPhone() {
        return $this->phone;
    }
    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function getLocation() {
        return $this->location;
    }
    public function setLocation($location) {
        $this->location = $location;
    }

    public function getDivision() {
        return $this->division;
    }
    public function setDivision($division) {
        $this->division = $division;
    }

    public function getResetToken() {
        return $this->reset_token;
    }
    public function setResetToken($reset_token) {
        $this->id = $reset_token;
    }
   

    // Load user by ID
    public function loadById($id) {
        global $conn;
        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $this->id = $user['id'];
                $this->email = $user['email'];
                $this->password = $user['password'];
                $this->verification_code = $user['verification_code'];
                $this->verified = $user['verified'];
                $this->user_type = $user['user_type'];
                $this->reset_token = $user['reset_token'];
               

                return true;
            }
        } catch (Exception $e) {
            error_log("Error loading user by ID: " . $e->getMessage());
        }

        return false;
    }

    // Load user by email
    public function loadByEmail($email) {
        global $conn;
        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $this->id = $user['id'];
                $this->email = $user['email'];
                $this->password = $user['password'];
                $this->verification_code = $user['verification_code'];
                $this->verified = $user['verified'];
                $this->user_type = $user['user_type'];
                $this->reset_token = $user['reset_token'];
               

                return true;
            }
        } catch (Exception $e) {
            error_log("Error loading user by email: " . $e->getMessage());
        }

        return false;
    }




    // Sign up user
    public function signUp() {
        global $conn;
        try {
            $verification_code = $this->generateVerificationCode(); // Generate verification code

            $stmt = $conn->prepare("INSERT INTO users (email, password, verification_code, verified, user_type) VALUES (?, ?, ?, 0, ?)");
            $stmt->execute([$this->email, $this->password, $verification_code, $this->user_type]);
            $this->id = $conn->lastInsertId();
            $this->verification_code = $verification_code; // Store verification code in the object
            return true;
        } catch (Exception $e) {
            error_log("Error in signUp: " . $e->getMessage());
            return false;
        }
    }

    // Generate verification code
    private function generateVerificationCode() {
        return bin2hex(random_bytes(6)); // 
    }

    // Send verification code to user's email
    public function sendVerificationCode() {
        $verificationCode = $this->getVerificationCode();

        if (!$verificationCode) {
            $verificationCode = $this->generateVerificationCode();
            $this->setVerificationCode($verificationCode);
        }

        global $conn;
            $stmt = $conn->prepare("UPDATE users SET verification_code = ? WHERE id = ?");
            $stmt->execute([$this->verification_code, $this->id]);

            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_OFF;                      // Disable verbose debug output
                $mail->isSMTP();                                        // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                   // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                               // Enable SMTP authentication
                $mail->Username   = 'rifanayaseen1999@gmail.com';       // SMTP username
                $mail->Password   = 'vigaaesnphypbkhh';                 // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     // Enable implicit TLS encryption
                $mail->Port       = 587;                                // TCP port to connect to

                //Recipients
                $mail->setFrom('rifanayaseen1999@gmail.com', 'Rifanayaseen');
                $mail->addAddress($this->email);                        // Add a recipient
                $mail->addReplyTo('rifanayaseen1999@gmail.com');

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Email Verification Code';
            $mail->Body = "<html><body><h1>Verification Code: $verificationCode</h1></body></html>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Error sending verification email: " . $e->getMessage());
            return false;
        }
    }
    
    // Update user details
    public function update() {
        global $conn;
        try {
            $stmt = $conn->prepare("UPDATE users SET email = ?, password = ?, verification_code = ?, verified = ?, user_type = ? WHERE id = ?");
            $stmt->execute([$this->email, $this->password, $this->verification_code, $this->verified, $this->user_type, $this->id]);
            return true;
        } catch (Exception $e) {
            error_log("Error updating user: " . $e->getMessage());
            return false;
        }
    }

    // Verify user
    public function Verified() {
        global $conn;
        try {
            $stmt = $conn->prepare("UPDATE users SET verified = 1 WHERE id = ?");
            $stmt->execute([$this->id]);
            $rowsUpdated = $stmt->rowCount();
            
            if ($rowsUpdated > 0) {
                $this->verified = 1; // Update the object property
                return true;
            } else {
                return false; // Failed to update
            }
        } catch (Exception $e) {
            error_log("Error in Verified(): " . $e->getMessage());
            return false;
        }
    }
    
    public function signIn() {
    }


    public function sendResetToken() {
        // Generate a unique token
        $reset_token = bin2hex(random_bytes(32));
        $this->setResetToken($reset_token); // Assuming this method sets the token property
    
        global $conn;
        // Update the reset token in the database for the current user
        $stmt = $conn->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
        $stmt->execute([$reset_token, $this->id]);
    
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);
    
        try {
            // Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      // Disable verbose debug output
            $mail->isSMTP();                                        // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                   // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                               // Enable SMTP authentication
            $mail->Username   = 'rifanayaseen1999@gmail.com';       // SMTP username
            $mail->Password   = 'vigaaesnphypbkhh';                 // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     // Enable implicit TLS encryption
            $mail->Port       = 587;                                // TCP port to connect to
    
            // Recipients
            $mail->setFrom('rifanayaseen1999@gmail.com', 'Rifanayaseen');
            $mail->addAddress($this->getEmail());                        // Add a recipient
            $mail->addReplyTo('rifanayaseen1999@gmail.com');  // Add a reply-to address
    
            // Content settings
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = " Password Reset";
    
            // Email body
            $mail->Body = "
                <html>
                <head>
                    <style>
                        body {
                            font-family: 'Arial', sans-serif;
                            line-height: 1.6;
                        }
                        .container {
                            max-width: 600px;
                            margin: 0 auto;
                        }
                        .header {
                            background-color: #f0f0f0;
                            padding: 20px;
                            text-align: center;
                        }
                        .content {
                            padding: 20px;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h1>Welcome</h1>
                        </div>
                        <div class='content'>
                            <p>Hi,</p>
                            <p>We received a request to reset your password for the account associated with your email address: <strong>" . htmlspecialchars($this->getEmail()) . "</strong>.</p>
                            <p>Click on this link to reset your password: <strong><a href='http://localhost:3000/reset_password.php?email=" . urlencode($this->getEmail()) . "&token=" . $reset_token . "'>Reset Password</a></strong></p>
                        </div>
                    </div>
                </body>
                </html>
            ";
    
            // Send the email
            $mail->send(); // Attempt to send the email
            return true; // Return true if the email was sent successfully
    
        } catch (Exception $e) {
            // Log error message or handle the error as needed
            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            return false; // Return false if there was an error sending the email
        }
    }
    
    
}
?>
