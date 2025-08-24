<?php
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adid = isset($_POST['adid']) ? intval($_POST['adid']) : 0;
    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';

    // Get course ID from admission_form
    $stmt = $conn->prepare("SELECT Course_ID FROM admission_form WHERE Ad_ID = ?");
    $stmt->bind_param("i", $adid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $row = $result->fetch_assoc()) {
        $course_id = $row['Course_ID'];
        
        // Insert into accepted_applicants with additional info
        $insert = $conn->prepare("INSERT INTO accepted_applicants (Ad_ID, FullName, Course_ID) VALUES (?, ?, ?)");
        $insert->bind_param("iss", $adid, $fullname, $course_id);
        
        if ($insert->execute()) {
            echo 'success';
        } else {
            echo 'Failed to insert: ' . $conn->error;
        }
    } else {
        echo 'Applicant not found';
    }
} else {
    echo 'Invalid request';
}
?>