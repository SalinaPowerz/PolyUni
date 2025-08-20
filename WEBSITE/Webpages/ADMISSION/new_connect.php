<?php
session_start();
require_once 'connect.php';

// Check if Account_ID is set
if (!isset($_SESSION['acc_id'])) {
    echo "<script>alert('No Account_ID found in session.'); window.location.href = 'form.php';</script>";
    exit();
}

$account_id = $_SESSION['acc_id'];

if (isset($_POST['submit_inputs'])) {
    // Save form data
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $suffix = $_POST['suffix'];
    $dob = date('Y-m-d', strtotime($_POST['dob']));
    $sex = $_POST['sex'];
    $religion = $_POST['religion'];
    $blocklot = $_POST['blocklot'];
    $street = $_POST['street'];
    $barangay = $_POST['barangay'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $fathername = $_POST['fathername'];
    $mothername = $_POST['mothername'];
    $guardianname = $_POST['guardianname'];
    $email = $_POST['email'];
    $phoneno = $_POST['phoneno'];
    $contactem = $_POST['contactem'];
    $course = $_POST['course'];

    // Handle file uploads
    $uploadDir = 'uploads/';
    $reportCardPath = $_POST['existing_report_card'] ?? '';
    $form137Path = $_POST['existing_form_137'] ?? '';
    $healthRecordsPath = $_POST['existing_health_records'] ?? '';

    // Ensure the uploads directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Save Report Card
    if (isset($_FILES['report_card']) && $_FILES['report_card']['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($_FILES['report_card']['name']);
        if (file_exists($uploadDir . $fileName)) {
            echo "<script>alert('Error: File \"$fileName\" already exists. Please rename the file and try again.'); window.location.href = 'form.php';</script>";
            exit();
        }
        $uniqueName = uniqid() . '_' . $fileName;
        $reportCardPath = $uploadDir . $uniqueName;
        move_uploaded_file($_FILES['report_card']['tmp_name'], $reportCardPath);
    }

    // Save Form 137
    if (isset($_FILES['form_137']) && $_FILES['form_137']['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($_FILES['form_137']['name']);
        if (file_exists($uploadDir . $fileName)) {
            echo "<script>alert('Error: File \"$fileName\" already exists. Please rename the file and try again.'); window.location.href = 'form.php';</script>";
            exit();
        }
        $uniqueName = uniqid() . '_' . $fileName;
        $form137Path = $uploadDir . $uniqueName;
        move_uploaded_file($_FILES['form_137']['tmp_name'], $form137Path);
    }

    // Save Health Records
    if (isset($_FILES['health_records']) && $_FILES['health_records']['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($_FILES['health_records']['name']);
        if (file_exists($uploadDir . $fileName)) {
            echo "<script>alert('Error: File \"$fileName\" already exists. Please rename the file and try again.'); window.location.href = 'form.php';</script>";
            exit();
        }
        $uniqueName = uniqid() . '_' . $fileName;
        $healthRecordsPath = $uploadDir . $uniqueName;
        move_uploaded_file($_FILES['health_records']['tmp_name'], $healthRecordsPath);
    }

    // Check if the user already has a record
    $checkQuery = "SELECT * FROM admission_form WHERE Account_ID = '$account_id'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        // Update existing record
        $updateQuery = "UPDATE admission_form SET 
            FirstName = '$firstname', 
            MiddleName = '$middlename', 
            LastName = '$lastname', 
            Suffix = '$suffix', 
            BirthDate = '$dob', 
            Sex = '$sex', 
            Religion = '$religion', 
            BlockLot = '$blocklot', 
            Street = '$street', 
            Barangay = '$barangay', 
            City = '$city', 
            Province = '$province', 
            Fathers_Name = '$fathername', 
            Mothers_Name = '$mothername', 
            Guardian = '$guardianname', 
            Email = '$email', 
            Phone_num = '$phoneno', 
            Contact_num = '$contactem', 
            Course_ID = '$course', 
            ReportCard = '$reportCardPath', 
            Form137 = '$form137Path', 
            HealthRecords = '$healthRecordsPath' 
            WHERE Account_ID = '$account_id'";
        if ($conn->query($updateQuery)) {
            echo "<script>alert('Profile updated successfully.'); window.location.href = '../Dashboard/Dash.php';</script>";
        } else {
            echo "<script>alert('Error updating profile: " . $conn->error . "'); window.location.href = 'form.php';</script>";
        }
    } else {
        // Insert new record
        $insertQuery = "INSERT INTO admission_form 
            (FirstName, MiddleName, LastName, Suffix, BirthDate, Sex, Religion, BlockLot, Street, Barangay, City, Province, Fathers_Name, Mothers_Name, Guardian, Email, Phone_num, Contact_num, Course_ID, ReportCard, Form137, HealthRecords, Account_ID) 
            VALUES 
            ('$firstname', '$middlename', '$lastname', '$suffix', '$dob', '$sex', '$religion', '$blocklot', '$street', '$barangay', '$city', '$province', '$fathername', '$mothername', '$guardianname', '$email', '$phoneno', '$contactem', '$course', '$reportCardPath', '$form137Path', '$healthRecordsPath', '$account_id')";
        if ($conn->query($insertQuery)) {
            echo "<script>alert('Profile created successfully.'); window.location.href = '../Dashboard/Dash.php';</script>";
        } else {
            echo "<script>alert('Error creating profile: " . $conn->error . "'); window.location.href = 'form.php';</script>";
        }
    }
}
?>