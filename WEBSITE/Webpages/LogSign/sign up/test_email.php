<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'your.email@gmail.com';
    $mail->Password = 'your-app-password';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->SMTPDebug = 2; // Enable verbose output
    
    $mail->setFrom('noreply@polycium.edu', 'Test');
    $mail->addAddress('your.test.email@gmail.com');
    $mail->Subject = 'Test Email from PHPMailer';
    $mail->Body = 'This is a test email!';
    
    if ($mail->send()) {
        echo "✅ Email sent successfully!";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>