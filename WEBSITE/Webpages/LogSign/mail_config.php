<?php
// C:\xampp\htdocs\PolyUni\WEBSITE\Webpages\LogSign\mail_config.php
// Email configuration for PHPMailer

// For Gmail (recommended for testing)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'polyciumuniversity@gmail.com'); // Your Gmail address
define('SMTP_PASSWORD', 'suan axvg mjsz oadv'); // Gmail app password
define('SMTP_FROM', 'your.email@gmail.com');
define('SMTP_FROM_NAME', 'Polycium University');
define('SMTP_SECURE', 'tls');

// Alternative for local testing with XAMPP
/*
define('SMTP_HOST', 'localhost');
define('SMTP_PORT', 25);
define('SMTP_USERNAME', '');
define('SMTP_PASSWORD', '');
define('SMTP_FROM', 'noreply@polycium.edu');
define('SMTP_FROM_NAME', 'Polycium University');
define('SMTP_SECURE', '');
*/
?>