<?php
// C:\xampp\htdocs\PolyUni\WEBSITE\Webpages\LogSign\forgot password\forgot_password.php
include '../../Exams/db.php';

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../mail_config.php';

session_start();

// Rate limiting
if (!isset($_SESSION['reset_attempts'])) {
    $_SESSION['reset_attempts'] = 0;
    $_SESSION['last_reset_request'] = 0;
}

$email_error = "";
$success_message = "";

if(isset($_POST['reset_btn'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    // Rate limiting check
    $current_time = time();
    if ($_SESSION['reset_attempts'] >= 3 && ($current_time - $_SESSION['last_reset_request']) < 3600) {
        $email_error = "Too many reset attempts. Please try again in 1 hour.";
    } else {
        $_SESSION['reset_attempts']++;
        $_SESSION['last_reset_request'] = $current_time;
        
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
                // Generate reset token and expiration
                $token = bin2hex(random_bytes(32));
                $expires = date("Y-m-d H:i:s", time() + 3600); // 1 hour expiration
                
                $update_stmt = $conn->prepare("UPDATE account SET Reset_Token = ?, Reset_Expires = ? WHERE Email = ?");
                $update_stmt->bind_param("sss", $token, $expires, $email);
                
                if($update_stmt->execute()) {
                    // Generate reset link
                    $reset_link = "http://" . $_SERVER['HTTP_HOST'] . "/PolyUni/WEBSITE/Webpages/LogSign/reset/index.php?token=" . $token;
                    
                    // Send email using PHPMailer
                    $mail = new PHPMailer(true);
                    
                    try {
                        // Server settings
                        $mail->isSMTP();
                        $mail->Host       = SMTP_HOST;
                        $mail->SMTPAuth   = true;
                        $mail->Username   = SMTP_USERNAME;
                        $mail->Password   = SMTP_PASSWORD;
                        $mail->SMTPSecure = SMTP_SECURE;
                        $mail->Port       = SMTP_PORT;
                        
                        // Recipients
                        $mail->setFrom(SMTP_FROM, SMTP_FROM_NAME);
                        $mail->addAddress($email);
                        
                        // Content
                        $mail->isHTML(true);
                        $mail->Subject = 'Password Reset Request - Polycium University';
                        
                        // Email body with HTML formatting
                        $mail->Body = "
                            <!DOCTYPE html>
                            <html>
                            <head>
                                <meta charset='utf-8'>
                                <style>
                                    body { 
                                        font-family: 'Arial', sans-serif; 
                                        line-height: 1.6; 
                                        color: #333; 
                                        margin: 0; 
                                        padding: 0; 
                                    }
                                    .container { 
                                        max-width: 600px; 
                                        margin: 0 auto; 
                                        background: #f9f9f9; 
                                    }
                                    .header { 
                                        background: #32508F; 
                                        color: white; 
                                        padding: 20px; 
                                        text-align: center; 
                                    }
                                    .logo { 
                                        font-size: 24px; 
                                        font-weight: bold; 
                                        margin-bottom: 10px; 
                                    }
                                    .content { 
                                        padding: 30px; 
                                        background: white; 
                                    }
                                    .button { 
                                        background: #32508F; 
                                        color: white; 
                                        padding: 12px 24px; 
                                        text-decoration: none; 
                                        border-radius: 4px; 
                                        display: inline-block; 
                                        margin: 15px 0; 
                                    }
                                    .footer { 
                                        padding: 20px; 
                                        text-align: center; 
                                        font-size: 12px; 
                                        color: #666; 
                                        background: #f5f5f5; 
                                    }
                                    .warning { 
                                        color: #ff0000; 
                                        font-size: 12px; 
                                        margin-top: 10px; 
                                    }
                                </style>
                            </head>
                            <body>
                                <div class='container'>
                                    <div class='header'>
                                        <div class='logo'>POLYCIUM UNIVERSITY</div>
                                        <h2>Password Reset Request</h2>
                                    </div>
                                    <div class='content'>
                                        <p>Hello,</p>
                                        <p>You recently requested to reset your password for your Polycium University account. Click the button below to reset it.</p>
                                        
                                        <p style='text-align: center;'>
                                            <a href='$reset_link' class='button'>Reset Password</a>
                                        </p>
                                        
                                        <p>If you did not request a password reset, please ignore this email or contact support if you have questions.</p>
                                        
                                        <p class='warning'>This password reset link is only valid for the next 60 minutes.</p>
                                        
                                        <p>Thanks,<br>The Polycium University Team</p>
                                    </div>
                                    <div class='footer'>
                                        <p>© 2024 Polycium University. All rights reserved.</p>
                                        <p>This is an automated message, please do not reply to this email.</p>
                                    </div>
                                </div>
                            </body>
                            </html>
                        ";
                        
                        // Plain text version
                        $mail->AltBody = "Password Reset Request - Polycium University\n\n" .
                                         "You have requested to reset your password. Use the following link to reset your password:\n\n" .
                                         "$reset_link\n\n" .
                                         "This link will expire in 1 hour.\n\n" .
                                         "If you didn't request this reset, please ignore this email.\n\n" .
                                         "Best regards,\nPolycium University";
                        
                        $mail->send();
                        
                        // Log successful attempt
                        $log_message = date('Y-m-d H:i:s') . " - Password reset sent to: " . $email . " - IP: " . $_SERVER['REMOTE_ADDR'];
                        file_put_contents('password_reset_log.txt', $log_message . PHP_EOL, FILE_APPEND);
                        
                        $success_message = "Password reset link has been sent to your email. Please check your inbox (and spam folder).";
                    } catch (Exception $e) {
                        $email_error = "Failed to send email. Please try again later or contact support.";
                    }
                } else {
                    $email_error = "Error generating reset token. Please try again.";
                }
            } else {
                $email_error = "No account found with that email address.";
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
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
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
        }
        
        .form-box {
            padding: 30px;
        }
        
        .form-box h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        
        .input-group {
            margin-bottom: 20px;
        }
        
        .input-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        
        .error-message {
            color: #d32f2f;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .success-message {
            background: #4caf50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        button {
            width: 100%;
            padding: 12px;
            background: #32508F;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        button:hover {
            background: #2a4480;
        }
        
        .footer-links {
            text-align: center;
            margin-top: 20px;
        }
        
        .footer-links a {
            color: #32508F;
            text-decoration: none;
        }
        
        .footer {
            background: #f5f5f5;
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #666;
        }
    </style>
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
                <a href="../log in/index.php">Back to Login</a>
            </div>
        </div>
        
        <div class="footer">
            Polycium University © 2024 All Rights Reserved.
        </div>
    </div>
</body>
</html>