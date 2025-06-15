<?php
session_start();
require_once 'connect.php';

if (isset($_POST['submit_inps'])){    
    $email = $_POST['email'];
    $repeat_pass = ($_POST['repeat_pass']);


    $check_em = $conn->query("SELECT Email FROM account WHERE Email = '$email'");
    if($check_em->num_rows > 0){
        $_SESSION['register_error'] = 'Email is already registered!';
        $_SESSION['active_form'] = 'submit_inps';
    } else {
        $conn->query("INSERT INTO account (Account_ID, Email, Password) VALUES ('','$email','$repeat_pass')");
    }   

    header("Location: index1.php");
    exit();
}
?>