<?php
session_start();
require_once 'connect.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Simple email function using built-in mail()
function sendWelcomeEmail($email) {
    $subject = "Welcome to Polycium University!";
    $message = "
    Welcome to Polycium University!
    
    Your account has been successfully created.
    You can now access all university services.
    
    Best regards,
    Polycium University Team
    ";
    
    $headers = "From: noreply@polycium.edu\r\n";
    $headers .= "Reply-To: support@polycium.edu\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    return mail($email, $subject, $message, $headers);
}

if (isset($_POST['submit_inps'])) {
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $repeat_pass = $_POST['repeat_pass'];

    // Validate passwords match
    if ($password !== $repeat_pass) {
        $_SESSION['register_error'] = 'Passwords do not match!';
        header("Location: index1.php");
        exit();
    }

    // Validate password length
    if (strlen($password) < 8) {
        $_SESSION['register_error'] = 'Password must be at least 8 characters long!';
        header("Location: index1.php");
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['register_error'] = 'Invalid email format!';
        header("Location: index1.php");
        exit();
    }

    // Check if email exists
    $stmt = $conn->prepare("SELECT Email FROM account WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $email_exists = $stmt->num_rows > 0;
    $stmt->close();

    if ($email_exists) {
        $_SESSION['register_error'] = 'Email is already registered!';
        header("Location: index1.php");
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO account (Email, Password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $hashedPassword);
    
    if ($stmt->execute()) {
        // Registration successful - send welcome email
        $emailSent = sendWelcomeEmail($email);
        
        if ($emailSent) {
            $_SESSION['register_success'] = "Account created successfully! Welcome email sent to " . htmlspecialchars($email);
        } else {
            $_SESSION['register_success'] = "Account created successfully!";
        }
        
        header("Location: index1.php");
        exit();
        
    } else {
        $_SESSION['register_error'] = "Error creating account. Please try again.";
        header("Location: index1.php");
        exit();
    }
    
    $stmt->close();
}

header("Location: index1.php");
exit();
?>