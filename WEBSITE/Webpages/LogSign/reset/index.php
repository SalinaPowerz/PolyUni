<?php
// C:\xampp\htdocs\PolyUni\WEBSITE\Webpages\LogSign\reset\reset.php
include '../../Exams/db.php';
session_start();

$token = $_GET['token'] ?? '';
$password_error = "";
$success_message = "";

// Validate token format
if(empty($token) || strlen($token) !== 64) {
    header("Location: ../log in/index.php?error=invalid_token");
    exit();
}

// Check if token is valid and not expired
$stmt = $conn->prepare("SELECT Account_ID FROM account WHERE Reset_Token = ? AND Reset_Expires > NOW()");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0) {
    // Clear any expired tokens
    $conn->query("UPDATE account SET Reset_Token = NULL, Reset_Expires = NULL WHERE Reset_Expires <= NOW()");
    
    header("Location: ../log in/index.php?error=invalid_or_expired_token");
    exit();
}

if(isset($_POST['reset_btn'])) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if(empty($password) || empty($confirm_password)) {
        $password_error = "Both password fields are required.";
    } elseif($password != $confirm_password) {
        $password_error = "Passwords do not match.";
    } elseif(strlen($password) < 8) {
        $password_error = "Password must be at least 8 characters long.";
    } elseif(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        $password_error = "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&).";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_stmt = $conn->prepare("UPDATE account SET Password = ?, Reset_Token = NULL, Reset_Expires = NULL WHERE Reset_Token = ?");
        $update_stmt->bind_param("ss", $hashed_password, $token);
        
        if($update_stmt->execute()) {
            $success_message = "Your password has been reset successfully.";
            
            // Log successful password reset
            $log_message = date('Y-m-d H:i:s') . " - Password reset successful for token: " . $token . " - IP: " . $_SERVER['REMOTE_ADDR'];
            file_put_contents('password_reset_log.txt', $log_message . PHP_EOL, FILE_APPEND);
        } else {
            $password_error = "An error occurred. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Polycium University</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .login-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            overflow: hidden;
        }
        
        .header {
            background: #32508F;
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 500;
        }
        
        .form-box {
            padding: 30px;
        }
        
        .form-box h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
            font-weight: 500;
            font-size: 22px;
        }
        
        .input-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        .input-group input {
            width: 100%;
            padding: 12px 40px 12px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .input-group input:focus {
            outline: none;
            border-color: #32508F;
            box-shadow: 0 0 0 2px rgba(50, 80, 143, 0.2);
        }
        
        .error-message {
            color: #d32f2f;
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }
        
        .success-message {
            background: #4caf50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }
        
        .success-message a {
            color: white;
            text-decoration: underline;
            font-weight: 500;
        }
        
        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background: #32508F;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
            font-weight: 500;
            margin-top: 10px;
        }
        
        button[type="submit"]:hover {
            background: #2a4480;
        }
        
        .footer-links {
            text-align: center;
            margin-top: 20px;
        }
        
        .footer-links a {
            color: #32508F;
            text-decoration: none;
            font-size: 14px;
        }
        
        .footer-links a:hover {
            text-decoration: underline;
        }
        
        .footer {
            background: #f5f5f5;
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #666;
        }
        
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 70%;
            transform: translateY(-50%);
            cursor: pointer;
            background: none;
            border: none;
            font-size: 16px;
            color: #7f8c8d;
            padding: 0;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .password-requirements {
            font-size: 12px;
            color: #666;
            margin: 15px 0;
            line-height: 1.4;
            background: #f9f9f9;
            padding: 10px;
            border-radius: 4px;
            border-left: 3px solid #32508F;
        }
        
        .input-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        
        /* Responsive adjustments */
        @media (max-width: 480px) {
            .form-box {
                padding: 20px;
            }
            
            .header {
                padding: 15px;
            }
            
            .header h1 {
                font-size: 20px;
            }
            
            .form-box h2 {
                font-size: 18px;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="header">
            <h1>POLYCIUM UNIVERSITY</h1>
        </div>
        
        <div class="form-box">
            <h2>RESET PASSWORD</h2>
            
            <?php if(!empty($success_message)): ?>
                <div class="success-message">
                    <?= $success_message ?><br>
                    <a href="../log in/index.php">Login with your new password</a>
                </div>
            <?php else: ?>
                <?php if(!empty($password_error)): ?>
                    <div class="error-message"><?= $password_error ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="input-group">
                        <label class="input-label">New Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter new password" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('password')">
                            <span>👁️</span>
                        </button>
                    </div>
                    
                    <div class="input-group">
                        <label class="input-label">Confirm New Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('confirm_password')">
                            <span>👁️</span>
                        </button>
                    </div>
                    
                    <div class="password-requirements">
                        <strong>Password Requirements:</strong>
                        <ul style="margin-top: 8px; margin-left: 20px;">
                            <li>At least 8 characters</li>
                            <li>One uppercase letter (A-Z)</li>
                            <li>One lowercase letter (a-z)</li>
                            <li>One number (0-9)</li>
                            <li>One special character (@$!%*?&)</li>
                        </ul>
                    </div>
                    
                    <button type="submit" name="reset_btn">RESET PASSWORD</button>
                </form>
                
                <div class="footer-links">
                    <a href="../log in/index.php">Back to Login</a>
                </div>
                
                <script>
                    function togglePassword(fieldId) {
                        const passwordField = document.getElementById(fieldId);
                        const toggleButton = passwordField.nextElementSibling;
                        const eyeIcon = toggleButton.querySelector('span');
                        
                        if (passwordField.type === 'password') {
                            passwordField.type = 'text';
                            eyeIcon.textContent = '🔒';
                        } else {
                            passwordField.type = 'password';
                            eyeIcon.textContent = '👁️';
                        }
                    }
                    
                    // Add real-time password validation
                    document.getElementById('password').addEventListener('input', function() {
                        validatePassword();
                    });
                    
                    document.getElementById('confirm_password').addEventListener('input', function() {
                        validatePassword();
                    });
                    
                    function validatePassword() {
                        const password = document.getElementById('password').value;
                        const confirmPassword = document.getElementById('confirm_password').value;
                        const submitButton = document.querySelector('button[type="submit"]');
                        
                        // Basic validation to enable/disable button
                        if (password.length >= 8 && confirmPassword === password) {
                            submitButton.disabled = false;
                            submitButton.style.opacity = '1';
                            submitButton.style.cursor = 'pointer';
                        } else {
                            submitButton.disabled = true;
                            submitButton.style.opacity = '0.7';
                            submitButton.style.cursor = 'not-allowed';
                        }
                    }
                    
                    // Initial validation
                    validatePassword();
                </script>
            <?php endif; ?>
        </div>
        
        <div class="footer">
            Polycium University © 2024 All Rights Reserved.
        </div>
    </div>
</body>
</html>