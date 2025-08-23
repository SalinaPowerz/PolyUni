<?php
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adid = isset($_POST['adid']) ? intval($_POST['adid']) : 0;
    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';

    // Get applicant info from admission_form
    $stmt = $conn->prepare("SELECT Account_ID, Course_ID FROM admission_form WHERE Ad_ID = ?");
    $stmt->bind_param("i", $adid);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $row = $result->fetch_assoc()) {
        $account_id = $row['Account_ID'];
        $course_id = $row['Course_ID'];
        $date_accepted = date('Y-m-d H:i:s');

        // Insert into accepted_applicants
        $insert = $conn->prepare("INSERT INTO accepted_applicants (Ad_ID, Account_ID, FullName, Course_ID, DateAccepted) VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("iisss", $adid, $account_id, $fullname, $course_id, $date_accepted);
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