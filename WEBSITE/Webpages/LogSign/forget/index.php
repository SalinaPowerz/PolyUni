<?php
include '../../Exams/db.php';
session_start();

$email_error = "";
$success_message = "";

if(isset($_POST['reset_btn'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    if(empty($email)) {
        $email_error = "Email is required.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Please enter a valid email address.";
    } else {
        $stmt = $conn->prepare("SELECT Account_ID FROM account WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows == 1) {
            $// After verifying the user exists:
$token = bin2hex(random_bytes(32));
$expires = date("Y-m-d H:i:s", time() + 3600); // 1 hour expiration

// Make sure these column names match your database exactly
$update_stmt = $conn->prepare("UPDATE account SET Reset_Token = ?, Reset_Expires = ? WHERE Email = ?");
$update_stmt->bind_param("sss", $token, $expires, $email);

if($update_stmt->execute()) {
    // Success - send email with reset link
} else {
    // Handle error
        }
    }
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Polycium University</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <div class="header">
            <h1>POLYCIUM UNIVERSITY</h1>
        </div>
        
        <div class="form-box">
            <h2>FORGOT PASSWORD</h2>
            
            <?php if(!empty($success_message)): ?>
                <div class="success-message"><?= $success_message ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email" required>
                    <?php if(!empty($email_error)): ?>
                        <div class="error-message"><?= $email_error ?></div>
                    <?php endif; ?>
                </div>
                
                <button type="submit" name="reset_btn">SEND RESET LINK</button>
            </form>
            
            <div class="footer-links">
                <a href="../login/index.php">Back to Login</a>
            </div>
        </div>
        
        <div class="footer">
            Polycium University © 2024 All Rights Reserved.
        </div>
    </div>
</body>
</html>