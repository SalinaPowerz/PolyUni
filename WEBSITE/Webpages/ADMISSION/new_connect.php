<?php
session_start();
require_once 'connect.php';

if (isset($_POST['submit_inputs'])){    
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $suffix = $_POST['suffix'];
    $dob = date('Y-m-d', strtotime($_POST['dob']));
    $sex = $_POST['sex'];
    $religion = $_POST['religion'];
    $address = $_POST['address'];
    $fathername = $_POST['fathername'];
    $mothername = $_POST['mothername'];
    $guardianname = $_POST['guardianname'];
    $email = $_POST['email'];
    $phoneno = $_POST['phoneno'];
    $contactem = $_POST['contactem'];
    $course = $_POST['course'];


   $conn->query("INSERT INTO admission_form VALUES ('','$firstname','$middlename','$lastname','$suffix',
        '$dob','$sex','$religion','$address','$fathername','$mothername','$guardianname','$email','$phoneno',
        '$contactem','$course')");
        
        header("Location: form.php");
        exit();
}
?>