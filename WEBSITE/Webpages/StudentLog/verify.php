<?php
$conn = new mysqli('localhost', 'root', '', 'polyciumuniversity');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student_number = trim($_POST['StuNum']);
$password = trim($_POST['Pass']);

$stmt = $conn->prepare("SELECT * FROM school WHERE Student_ID = ? AND Password = ?");
$stmt->bind_param("ss", $student_number, $password);

if (!$stmt->execute()) {
    die("Error executing query: " . $stmt->error);
}

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    session_start();
    $_SESSION['student_id'] = $student_number;
    header("Location: welcome.php");
    exit();
} else {
    echo "<script>alert('Invalid Student ID or Password.'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
