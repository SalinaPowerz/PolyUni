<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="style.css" />
    <title>Student Portal</title>
  </head>
  
  <body>
    <div class="LOGIN-STUDENT-PORTAL">
      <div class="overlap-wrapper">
        <div class="overlap">
          <div class="rectangle"></div>
          <div class="div"></div>
          <div class="text-wrapper">Dashboard</div>
			<div class="text-wrapper-2">
			  <?php
				if (isset($_SESSION['Full_Name'])) {
				  echo htmlspecialchars($_SESSION['Full_Name']);
				} else {
				  echo "Name not found.";
				}
			  ?>
			</div>
          <div class="rectangle-2"></div>
          <div class="rectangle-3"></div>
          <div class="rectangle-4"></div>
          <div class="rectangle-5"></div>
		  <div class="rectangle-6">
		  <div class="text-wrapper-6">Temporary Password</div>
		  <input type="password" class="text-wrapper-11 password-input" id="tempPassword" value="SP_121ssd" readonly />
		  <label class="show-password">
		  <input type="checkbox" id="showPassword" onchange="togglePassword()" />
		  </label>
		  </div>
          <div class="rectangle-7"></div>
          <div class="text-wrapper-3">Current Academic Year</div>
          <div class="text-wrapper-4">Student Number</div>
          <div class="text-wrapper-5">School Email</div>
          <div class="text-wrapper-6">Temporary Password</div>
          <div class="text-wrapper-7">Current Status</div>
          <div class="text-wrapper-8">2025 - 2026</div>
          <div class="text-wrapper-9">
			  <?php
			  if (isset($_SESSION['student_id'])) {
				echo $_SESSION['student_id'];
			  } else {
				echo "Student ID not found.";
			  }
			  ?>
			</div>
			
          <div class="text-wrapper-10">
		  <?php
			if (isset($_SESSION['Email'])) {
			  echo htmlspecialchars($_SESSION['Email']);
			} else {
			  echo "Email not found.";
			}
		  ?>
		  </div>
          <div class="text-wrapper-12">Enrolled</div>

		  <div class="rectangle-3 copy-rect-3"></div>
		  <div class="rectangle-7 copy-rect-7"></div>
		  <div class="text-wrapper-3 copy-label-3">Current Academic Year</div>
		  <div class="text-wrapper-8 copy-value-8">2025 - 2026</div>
		  <div class="text-wrapper-7 copy-label-7">Current Status</div>
		  <div class="text-wrapper-12 copy-value-12">Enrolled</div>
			<div class="sidebar-nav">
			<img class="full" src="../../../Images/new.png" alt="Logo" />
			  <a href="#" class="nav-link">Dashboard</a>
			  <a href="#" class="nav-link">My Profile</a>
			  <a href="#" class="nav-link">Subjects</a>
			  <a href="#" class="nav-link">Enrollment</a>
			  <a href="#" class="nav-link">Account Settings</a>
			  
		  <div class="yellow">
          <a href="logout.php">  <button class="logout-button">Logout</button></a>
          </div>
			</div>
        </div>
      </div>
    </div>
	<script>
	  function togglePassword() {
		const input = document.getElementById("tempPassword");
		const checkbox = document.getElementById("showPassword");
		input.type = checkbox.checked ? "text" : "password";
	  }
	</script>


  </body>
</html>
