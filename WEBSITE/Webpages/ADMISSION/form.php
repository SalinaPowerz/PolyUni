<?php 
session_start();
require_once 'connect.php'; // Include database connection

// Get the current Account_ID from the session
$account_id = $_SESSION['acc_id'] ?? null;

// Redirect if Account_ID is not set
if (!$account_id) {
    header("Location: ../../LogSign/log in/index.php");
    exit();
}

// Check if form exists to determine if this is a new profile or update
$query = "SELECT * FROM admission_form WHERE Account_ID = '$account_id'";
$result = $conn->query($query);
$is_existing_profile = ($result && $result->num_rows > 0);

if ($is_existing_profile) {
    $form_data = $result->fetch_assoc();
} else {
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
    .required-field::after {
      content: " *";
      color: red;
    }
    .current-file {
      color: #666;
      font-style: italic;
      margin-top: 5px;
    }
    .file-error {
      color: red;
      font-size: 0.9em;
      margin-top: 5px;
    }
    /* Style for uppercase text */
    .uppercase-input {
      text-transform: uppercase;
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

  <main>
    <div class="form-container">
      <div class="form-logo">
        <img src="../../Images/new.png" alt="Admission Logo" />
      </div>

      <h2>Admission Profile</h2>
      <p>Kindly fill out this profile</p>

      <form id="admissionForm" method="POST" action="new_connect.php" enctype="multipart/form-data" autocomplete="off">
        <!-- Personal Information -->
        <div class="form-row">
          <label class="required-field">First Name</label>
          <label>Middle Name</label>
        </div>
        <div class="form-row">
          <input type="text" name="firstname" placeholder="First Name" value="<?= $form_data['FirstName'] ?? '' ?>" class="uppercase-input" required />
          <input type="text" name="middlename" placeholder="Middle Name" value="<?= $form_data['MiddleName'] ?? '' ?>" class="uppercase-input" />
        </div>
        
        <div class="form-row">
          <label class="required-field">Last Name</label>
          <label>Suffix</label>
        </div>
        <div class="form-row">
          <input type="text" name="lastname" placeholder="Last Name" value="<?= $form_data['LastName'] ?? '' ?>" class="uppercase-input" required />
          <input type="text" name="suffix" placeholder="Suffix" value="<?= $form_data['Suffix'] ?? '' ?>" class="uppercase-input" />
        </div>
        
        <div class="form-row">
          <label class="required-field">Date of Birth</label>
          <label class="required-field">Gender</label>
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
          <label class="required-field">Block/Lot</label>
          <label class="required-field">Street</label>
        </div>
        <div class="form-row">
          <input type="text" name="blocklot" placeholder="Block/Lot" value="<?= $form_data['BlockLot'] ?? '' ?>" class="uppercase-input" required />
          <input type="text" name="street" placeholder="Street" value="<?= $form_data['Street'] ?? '' ?>" class="uppercase-input" required />
        </div>
        
        <div class="form-row">
          <label class="required-field">Barangay</label>
          <label class="required-field">City</label>
        </div>
        <div class="form-row">
          <input type="text" name="barangay" placeholder="Barangay" value="<?= $form_data['Barangay'] ?? '' ?>" class="uppercase-input" required />
          <input type="text" name="city" placeholder="City" value="<?= $form_data['City'] ?? '' ?>" class="uppercase-input" required />
        </div>
        
        <div class="form-row">
          <label class="required-field">Province</label>
        </div>
        <div class="form-row">
          <input type="text" name="province" placeholder="Province" value="<?= $form_data['Province'] ?? '' ?>" class="uppercase-input" required />
        </div>

        <!-- Family Information -->
        <div class="form-row">
          <label class="required-field">Father's Name</label>
          <label class="required-field">Mother's Maiden Name</label>
        </div>
        <div class="form-row">
          <input type="text" name="fathername" placeholder="Father's Name" value="<?= $form_data['Fathers_Name'] ?? '' ?>" class="uppercase-input" required />
          <input type="text" name="mothername" placeholder="Mother's Maiden Name" value="<?= $form_data['Mothers_Name'] ?? '' ?>" class="uppercase-input" required />
        </div>
        
        <div class="form-row">
          <label class="required-field">Guardian's Name</label>
          <label class="required-field">Email</label>
        </div>
        <div class="form-row">
          <input type="text" name="guardianname" placeholder="Guardian's Name" value="<?= $form_data['Guardian'] ?? '' ?>" class="uppercase-input" required />
          <input type="email" id="email" name="email" placeholder="Email" value="<?= $form_data['Email'] ?? '' ?>" required />
        </div>

        <!-- Religion -->
        <div class="form-row">
          <label class="required-field">Religion</label>
        </div>
        <div class="form-row">
          <input type="text" name="religion" placeholder="Religion" value="<?= $form_data['Religion'] ?? '' ?>" class="uppercase-input" required />
        </div>

        <!-- Contact Information -->
        <div class="form-row">
          <label class="required-field">Phone Number</label>
          <label class="required-field">Emergency Contact</label>
        </div>
        <div class="form-row">
          <input type="text" id="phoneno" name="phoneno" placeholder="Phone Number" maxlength="11" value="<?= $form_data['Phone_num'] ?? '' ?>" required />
          <input type="text" id="contactem" name="contactem" placeholder="Contact in case of Emergency" maxlength="11" value="<?= $form_data['Contact_num'] ?? '' ?>" required />
        </div>

        <!-- Course Selection -->
        <div class="form-row">
          <label class="required-field">Course</label>
        </div>
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
          <label class="required-field">Upload Report Card (Image)</label>
          <input type="file" id="report_card" name="report_card" accept="image/*" <?= !$is_existing_profile ? 'required' : '' ?> />
          <?php if (!empty($form_data['ReportCard'])): ?>
            <p class="current-file">Current File: <?= getOriginalFileName($form_data['ReportCard']) ?></p>
            <input type="hidden" name="existing_report_card" value="<?= $form_data['ReportCard'] ?>" />
          <?php endif; ?>
          <div id="report_card_error" class="file-error"></div>
        </div>
        
        <div class="file-upload">
          <label class="required-field">Upload Form 137 (Image)</label>
          <input type="file" id="form_137" name="form_137" accept="image/*" <?= !$is_existing_profile ? 'required' : '' ?> />
          <?php if (!empty($form_data['Form137'])): ?>
            <p class="current-file">Current File: <?= getOriginalFileName($form_data['Form137']) ?></p>
            <input type="hidden" name="existing_form_137" value="<?= $form_data['Form137'] ?>" />
          <?php endif; ?>
          <div id="form_137_error" class="file-error"></div>
        </div>
        
        <div class="file-upload">
          <label class="required-field">Upload Health Records (Image)</label>
          <input type="file" id="health_records" name="health_records" accept="image/*" <?= !$is_existing_profile ? 'required' : '' ?> />
          <?php if (!empty($form_data['HealthRecords'])): ?>
            <p class="current-file">Current File: <?= getOriginalFileName($form_data['HealthRecords']) ?></p>
            <input type="hidden" name="existing_health_records" value="<?= $form_data['HealthRecords'] ?>" />
          <?php endif; ?>
          <div id="health_records_error" class="file-error"></div>
        </div>

        <!-- Submit -->
        <div class="submit-row">
          <button name="submit_inputs" type="submit">Save</button>
        </div>
      </form>
    </div>
  </main>

<script>
  // Function to convert input to uppercase
  function convertToUppercase(event) {
    event.target.value = event.target.value.toUpperCase();
  }

  // Add event listeners to all text inputs that should be uppercase
  document.querySelectorAll('.uppercase-input').forEach(input => {
    input.addEventListener('input', convertToUppercase);
    input.addEventListener('blur', convertToUppercase);
  });

  // Restrict phone number and emergency contact to numbers only
  document.getElementById('phoneno').addEventListener('input', function (e) {
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  document.getElementById('contactem').addEventListener('input', function (e) {
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  // Function to check for duplicate file names
  function checkDuplicateFiles() {
    const files = {
      report_card: document.getElementById('report_card').files[0],
      form_137: document.getElementById('form_137').files[0],
      health_records: document.getElementById('health_records').files[0]
    };
    
    const fileNames = {};
    let hasDuplicates = false;
    
    // Clear previous error messages
    document.querySelectorAll('.file-error').forEach(el => el.textContent = '');
    
    // Check for duplicates among newly uploaded files
    for (const [field, file] of Object.entries(files)) {
      if (file) {
        if (fileNames[file.name]) {
          document.getElementById(`${field}_error`).textContent = 
            `This file has the same name as ${fileNames[file.name]}`;
          hasDuplicates = true;
        } else {
          fileNames[file.name] = field.replace('_', ' ');
        }
      }
    }
    
    return !hasDuplicates;
  }

  // Form submission validation
  document.getElementById('admissionForm').addEventListener('submit', function(event) {
    let isValid = true;
    
    // Check for duplicate files
    if (!checkDuplicateFiles()) {
      isValid = false;
    }
    
    // Validate date of birth (must be at least 16 years old)
    const dobInput = document.getElementById('dob');
    const dob = new Date(dobInput.value);
    const today = new Date();

    if (isNaN(dob.getTime())) {
      alert('Please enter a valid date of birth.');
      dobInput.classList.add('error-border');
      isValid = false;
    } else {
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
        isValid = false;
      } else {
        dobInput.classList.remove('error-border');
      }
    }
    
    // For new profiles, check if at least one file is uploaded
    const isNewProfile = <?= $is_existing_profile ? 'false' : 'true' ?>;
    if (isNewProfile) {
      const reportCard = document.getElementById('report_card').files.length;
      const form137 = document.getElementById('form_137').files.length;
      const healthRecords = document.getElementById('health_records').files.length;
      
      if (!reportCard && !form137 && !healthRecords) {
        alert('Please upload all required documents for new profile submission.');
        isValid = false;
      }
    }
    
    if (!isValid) {
      event.preventDefault();
    }
  });

  // Real-time file name checking
  document.querySelectorAll('input[type="file"]').forEach(input => {
    input.addEventListener('change', function() {
      checkDuplicateFiles();
    });
  });
</script>

</body>
</html>