<?php 
session_start();
require_once 'connect.php'; // Include database connection

// Allow changing the Account_ID in the session
if (isset($_POST['change_account_id'])) {
    $_SESSION['acc_id'] = $_POST['new_account_id']; // Use 'acc_id' to match the session variable in index.php
    header("Location: form.php"); // Refresh the page to load the new Account_ID's data
    exit();
}

// Get the current Account_ID from the session
$account_id = $_SESSION['acc_id'] ?? null; // Use 'acc_id' here as well

// Debug: Check if Account_ID is set
if (!$account_id) {
    echo "No Account_ID found in session.<br>";
    // Show the Account_ID change form so you can set it manually
    ?>
    <div style="margin: 20px;">
      <form method="POST" action="">
        <label for="new_account_id">Change Account_ID:</label>
        <input type="text" id="new_account_id" name="new_account_id" placeholder="Enter new Account_ID" required />
        <button type="submit" name="change_account_id">Change</button>
      </form>
    </div>
    <?php
    exit();
} else {
    echo "Account_ID: " . $account_id . "<br>";
}

// Retrieve saved form data from the database
$query = "SELECT * FROM admission_form WHERE Account_ID = '$account_id'";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $form_data = $result->fetch_assoc();
} else {
    // If no data exists for the current user, reset the form
    $form_data = [];
}

// Function to extract the original file name (remove unique identifier)
function getOriginalFileName($filePath) {
    return preg_replace('/^[a-z0-9]+_/', '', basename($filePath));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Polycium University Admission Profile</title>
  <link rel="stylesheet" href="form.css" />
  <style>
    .error-border {
      border: 2px solid red;
    }
    .form-row, .form-row1 {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 15px;
    }
    .form-row input, .form-row select, .form-row label {
      flex: 1;
      min-width: 200px;
    }
    .form-row label {
      font-weight: bold;
    }
    .file-upload {
      display: flex;
      flex-direction: column;
      gap: 5px;
    }
  </style>
</head>
<body>
  <div style="width: 100%; height: 60px; background-color: #32508F; display: flex; align-items: center; justify-content: space-between; padding: 0 17px; box-sizing: border-box;" id="Navigation_bar">
    <div style="display: flex; align-items: center;">
      <img src="../../Images/new.png" width="50px" alt="Logo" style="vertical-align: middle; margin-right: 10px;" />
      <span style="font-size: 30px; color: #FFFFFF; font-family: s; ">POLYCIUM UNIVERSITY</span>
    </div>
  </div>

  <!-- Form to Change Account_ID -->
  <div style="margin: 20px;">
    <form method="POST" action="">
      <label for="new_account_id">Change Account_ID:</label>
      <input type="text" id="new_account_id" name="new_account_id" placeholder="Enter new Account_ID" required />
      <button type="submit" name="change_account_id">Change</button>
    </form>
  </div>

  <main>
    <div class="form-container">
      <div class="form-logo">
        <img src="../../Images/new.png" alt="Admission Logo" />
      </div>

      <h2>Admission Profile</h2>
      <p>Kindly fill out this profile</p>

      <form id="admissionForm" method="POST" action="new_connect.php" enctype="multipart/form-data">
        <!-- Personal Information -->
        <div class="form-row">
          <input type="text" name="firstname" placeholder="First Name" value="<?= $form_data['FirstName'] ?? '' ?>" required />
          <input type="text" name="middlename" placeholder="Middle Name" value="<?= $form_data['MiddleName'] ?? '' ?>" required />
        </div>
        <div class="form-row">
          <input type="text" name="lastname" placeholder="Last Name" value="<?= $form_data['LastName'] ?? '' ?>" required />
          <input type="text" name="suffix" placeholder="Suffix" value="<?= $form_data['Suffix'] ?? '' ?>" />
        </div>
        <div class="form-row">
          <input type="date" id="dob" name="dob" placeholder="Date of Birth" value="<?= $form_data['BirthDate'] ?? '' ?>" required />
          <select name="sex" required>
            <option class="sex" disabled <?= empty($form_data['Sex']) ? 'selected' : '' ?> value="">--- Select Gender ---</option>
            <option value="Male" <?= ($form_data['Sex'] ?? '') === 'Male' ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= ($form_data['Sex'] ?? '') === 'Female' ? 'selected' : '' ?>>Female</option>
          </select>
        </div>

        <!-- Address -->
        <div class="form-row">
          <input type="text" name="blocklot" placeholder="Block/Lot" value="<?= $form_data['BlockLot'] ?? '' ?>" required />
          <input type="text" name="street" placeholder="Street" value="<?= $form_data['Street'] ?? '' ?>" required />
        </div>
        <div class="form-row">
          <input type="text" name="barangay" placeholder="Barangay" value="<?= $form_data['Barangay'] ?? '' ?>" required />
          <input type="text" name="city" placeholder="City" value="<?= $form_data['City'] ?? '' ?>" required />
        </div>
        <div class="form-row">
          <input type="text" name="province" placeholder="Province" value="<?= $form_data['Province'] ?? '' ?>" required />
        </div>

        <!-- Family Information -->
        <div class="form-row">
          <input type="text" name="fathername" placeholder="Father’s Name" value="<?= $form_data['Fathers_Name'] ?? '' ?>" required />
          <input type="text" name="mothername" placeholder="Mother’s Maiden Name" value="<?= $form_data['Mothers_Name'] ?? '' ?>" required />
        </div>
        <div class="form-row">
          <input type="text" name="guardianname" placeholder="Guardian’s Name" value="<?= $form_data['Guardian'] ?? '' ?>" required />
          <input type="email" id="email" name="email" placeholder="Email" value="<?= $form_data['Email'] ?? '' ?>" required />
        </div>

        <!-- Religion -->
        <div class="form-row">
          <input type="text" name="religion" placeholder="Religion" value="<?= $form_data['Religion'] ?? '' ?>" required />
        </div>

        <!-- Contact Information -->
        <div class="form-row">
          <input type="text" id="phoneno" name="phoneno" placeholder="Phone Number" maxlength="11" value="<?= $form_data['Phone_num'] ?? '' ?>" required />
          <input type="text" id="contactem" name="contactem" placeholder="Contact in case of Emergency" maxlength="11" value="<?= $form_data['Contact_num'] ?? '' ?>" required />
        </div>

        <!-- Course Selection -->
        <div class="form-row">
          <select name="course" required>
            <option disabled <?= empty($form_data['Course_ID']) ? 'selected' : '' ?> value="">--- Select Course ---</option>
            <option value="BSIT" <?= ($form_data['Course_ID'] ?? '') === 'BSIT' ? 'selected' : '' ?>>Bachelor of Science in Information Technology</option>
            <option value="BSCS" <?= ($form_data['Course_ID'] ?? '') === 'BSCS' ? 'selected' : '' ?>>Bachelor of Science in Computer Science</option>
            <option value="BSHM" <?= ($form_data['Course_ID'] ?? '') === 'BSHM' ? 'selected' : '' ?>>Bachelor of Science in Hospitality Management</option>
            <option value="BSEd" <?= ($form_data['Course_ID'] ?? '') === 'BSEd' ? 'selected' : '' ?>>Bachelor of Secondary Education Major in English</option>
            <option value="BMMA" <?= ($form_data['Course_ID'] ?? '') === 'BMMA' ? 'selected' : '' ?>>Bachelor of Science in Multimedia Arts</option>
          </select>
        </div>

        <!-- File Uploads -->
        <div class="file-upload">
          <label>Upload Report Card (Image):</label>
          <input type="file" id="report_card" name="report_card" accept="image/*" />
          <?php if (!empty($form_data['ReportCard'])): ?>
            <p>Current File: <?= getOriginalFileName($form_data['ReportCard']) ?></p>
            <input type="hidden" name="existing_report_card" value="<?= $form_data['ReportCard'] ?>" />
          <?php endif; ?>
        </div>
        <div class="file-upload">
          <label>Upload Form 137 (Image):</label>
          <input type="file" id="form_137" name="form_137" accept="image/*" />
          <?php if (!empty($form_data['Form137'])): ?>
            <p>Current File: <?= getOriginalFileName($form_data['Form137']) ?></p>
            <input type="hidden" name="existing_form_137" value="<?= $form_data['Form137'] ?>" />
          <?php endif; ?>
        </div>
        <div class="file-upload">
          <label>Upload Health Records (Image):</label>
          <input type="file" id="health_records" name="health_records" accept="image/*" />
          <?php if (!empty($form_data['HealthRecords'])): ?>
            <p>Current File: <?= getOriginalFileName($form_data['HealthRecords']) ?></p>
            <input type="hidden" name="existing_health_records" value="<?= $form_data['HealthRecords'] ?>" />
          <?php endif; ?>
        </div>

        <!-- Submit -->
        <div class="submit-row">
          <button name="submit_inputs" type="submit">Save</button>
        </div>
      </form>
    </div>
  </main>

<script>
  // Restrict phone number and emergency contact to numbers only
  document.getElementById('phoneno').addEventListener('input', function (e) {
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  document.getElementById('contactem').addEventListener('input', function (e) {
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  // Form submission validation
  document.getElementById('admissionForm').addEventListener('submit', function(event) {
    const reportCard = document.getElementById('report_card').value;
    const form137 = document.getElementById('form_137').value;
    const healthRecords = document.getElementById('health_records').value;

    // Check for duplicate file uploads
    if (
      (reportCard && form137 && reportCard === form137) ||
      (reportCard && healthRecords && reportCard === healthRecords) ||
      (form137 && healthRecords && form137 === healthRecords)
    ) {
      alert('Duplicate file detected! Please upload unique files for each field.');
      event.preventDefault();
      return;
    }

    // Validate date of birth (must be at least 16 years old)
    const dobInput = document.getElementById('dob');
    const dob = new Date(dobInput.value);
    const today = new Date();

    if (isNaN(dob)) {
      alert('Please enter a valid date of birth.');
      dobInput.classList.add('error-border');
      event.preventDefault();
      return;
    }

    let age = today.getFullYear() - dob.getFullYear();
    const monthDiff = today.getMonth() - dob.getMonth();
    const dayDiff = today.getDate() - dob.getDate();

    // Adjust age if current date is before the birthday
    if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
      age--;
    }

    if (age < 16) {
      alert('You must be at least 16 years old to submit this form.');
      dobInput.classList.add('error-border');
      event.preventDefault();
      return;
    } else {
      dobInput.classList.remove('error-border');
    }
  });
</script>

</body>
</html>
