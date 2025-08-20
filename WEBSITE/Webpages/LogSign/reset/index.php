<?php
include '../../Exams/db.php';
session_start();

$token = $_GET['token'] ?? '';
$password_error = "";
$success_message = "";

if(empty($token)) {
    header("Location: ../login/index.php");
    exit();
}

$stmt = $conn->prepare("SELECT Account_ID FROM account WHERE Reset_Token = ? AND Reset_Expires > NOW()");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0) {
    header("Location: ../login/index.php?error=invalid_token");
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
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_stmt = $conn->prepare("UPDATE account SET Password = ?, Reset_Token = NULL, Reset_Expires = NULL WHERE Reset_Token = ?");
        $update_stmt->bind_param("ss", $hashed_password, $token);
        
        if($update_stmt->execute()) {
            $success_message = "Your password has been reset successfully.";
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
    <link rel="stylesheet" href="style.css">
    <style>
        .password-container {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #7f8c8d;
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
                    <a href="../login/index.php">Login with your new password</a>
                </div>
            <?php else: ?>
                <?php if(!empty($password_error)): ?>
                    <div class="error-message"><?= $password_error ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="input-group password-container">
                        <input type="password" id="password" name="password" placeholder="New Password" required>
                        <span class="toggle-password" onclick="togglePassword()">👁️</span>
                    </div>
                    
                    <div class="input-group">
                        <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
                    </div>
                    
                    <button type="submit" name="reset_btn">RESET PASSWORD</button>
                </form>
                
                <div class="footer-links">
                    <a href="../login/index.php">Back to Login</a>
                </div>
                
                <script>
                    function togglePassword() {
                        const passwordField = document.getElementById('password');
                        if (passwordField.type === 'password') {
                            passwordField.type = 'text';
                        } else {
                            passwordField.type = 'password';
                        }
                    }
                </script>
            <?php endif; ?>
        </div>
        
        <div class="footer">
            Polycium University © 2024 All Rights Reserved.
        </div>
    </div>
</body>
</html>