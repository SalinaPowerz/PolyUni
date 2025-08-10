<?php
session_start();
require_once 'connect.php';

if (isset($_POST['submit_inps'])) {
    $email = $_POST['email'];
    $password = $_POST['pass'];

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
    $stmt->execute();
    $stmt->close();

    // Redirect to login page after successful signup
    header("Location: ../log in/index.php");
    exit();
}
?>