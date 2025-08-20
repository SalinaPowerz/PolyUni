<?php
session_start();
$register_error = '';
$register_success = ''; // Add this line for success messages

if (isset($_SESSION['register_error'])) {
    $register_error = $_SESSION['register_error'];
    unset($_SESSION['register_error']);
}

// Add this block for success messages
if (isset($_SESSION['register_success'])) {
    $register_success = $_SESSION['register_success'];
    unset($_SESSION['register_success']);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Polycium University</title>
    <link rel="stylesheet" href="global.css" />
    <link rel="stylesheet" href="style.css" />	
  </head>
  <body>
    <?php if (!empty($register_error)): ?>
    <script>
    window.onload = function() {
        alert("<?php echo addslashes($register_error); ?>");
    };
    </script>
    <?php endif; ?>
    
    <!-- Add this block for success messages -->
    <?php if (!empty($register_success)): ?>
    <script>
    window.onload = function() {
        alert("<?php echo addslashes($register_success); ?>");
        // Redirect to login page after showing success message
        setTimeout(function() {
            window.location.href = "../log in/index.php";
        }, 2000);
    };
    </script>
    <?php endif; ?>
    
    <div class="SIGNUP">
      <div class="div">
<div style="position: fixed; width: 100%; height: 60px; background-color: #32508F; display: flex; align-items: center; justify-content: space-between; padding: 0 17px; box-sizing: border-box;" id="Navigation_bar">
  <div style="display: flex; align-items: center; z-index: 1000;">
      <img src="../../../Images/new.png" width="50px" alt="Logo" style="vertical-align: middle; margin-right: 10px;" />
    <span style="font-size: 30px; color: #FFFFFF; font-family: Times New Roman; ">POLYCIUM UNIVERSITY</span>
  </div>

  <nav style="display: flex; gap: 12px; font-family: Helvetica; color: #FFFFFF; margin-right: 30px;">
    <a class="navigation" style="font-size: 17px; color: #FFFFFF; text-decoration: none; padding: 4px 10px;" href="../../HomePage/main.html">ABOUT</a>
    <a class="navigation" style="font-size: 17px; color: #FFFFFF; text-decoration: none; padding: 4px 10px;" href="../../Academics/Academics.html">ACADEMICS</a>
    <a class="navigation" style="font-size: 17px; color: #FFFFFF; text-decoration: none; padding: 4px 10px;" href="index1.php">ADMISSION</a>
    <a class="navigation" style="font-size: 17px; color: #FFFFFF; text-decoration: none; padding: 4px 10px;" href="../../StudentLog/StudentLogin.html">STUDENT PORTAL</a>
  </nav>
</div>

<div class="overlap">
  <div class="overlap-group">
    <div class="overlap-group-2">
      <img class="logo-removebg" src="../../../Images/new.png" alt="Logo" />
      <div class="text-wrapper-2">SIGN UP</div>
    </div>

<form method="POST" action="new_connect.php" id="signup-form" autocomplete="off">
  <div class="form-group email-group">
    <input type="text" name="email" placeholder="Email" class="group-2" required autocomplete="off" />
    <span id="email-error" style="color: red; font-size: 14px; display: block; margin-bottom: 4px; margin-left: 35px;"></span>
  </div>
  <div class="form-group password-group" style="position: relative;">
  <input type="password" id="pass" name="pass" placeholder="Password" class="img" required autocomplete="off" style="padding-right:40px;" />

  <!-- Eye icon moved here -->
  <button type="button" class="eye-btn" id="toggleEye" aria-label="Toggle password visibility"
    style="position:absolute; top:8px; right:35px; background:none; border:none; cursor:pointer;">
    <!-- open-eye svg -->
    <svg id="eyeOpen" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"
      stroke-linecap="round" stroke-linejoin="round" width="24" height="24">
      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"></path>
      <circle cx="12" cy="12" r="3"></circle>
    </svg>
    <!-- closed eye hidden by default -->
    <svg id="eyeClosed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"
      stroke-linecap="round" stroke-linejoin="round" width="24" height="24" style="display:none">
      <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a20.6 20.6 0 0 1 5.06-6.14"></path>
      <path d="M1 1l22 22"></path>
    </svg>
  </button>
</div>

<!-- Confirm Password stays as-is -->
<div class="form-group confirm-group">
  <input type="password" id="repeat_pass" name="repeat_pass" placeholder="Confirm Password" class="group" required autocomplete="off" style="padding-right:40px; margin-top:8px;" />
</div>
  <div class="form-group error-group">
    <span id="error-message" style="color: red; font-size: 14px; display: block; margin-bottom: 4px; margin-left: 35px;"></span>
  </div>
  <div class="form-group back-group">
    <a style="font-family: Times New Roman;" href="../log in/index.php" class="back-to-log-in">‹ Back to Log In</a>
  </div>
  <div class="form-group signup-group">
    <button type="submit" name="submit_inps" class="yellow">
      <div class="PLACEHOLDER">SIGN UP</div>
    </button>
  </div>
</form>
<script>
document.getElementById('signup-form').onsubmit = function(event) {
  var emailInput = document.querySelector('input[name="email"]');
  var passInput = document.getElementById('pass');
  var repeatPassInput = document.getElementById('repeat_pass');
  var email = emailInput.value;
  var pass = passInput.value;
  var repeatPass = repeatPassInput.value;
  var errorMsg = document.getElementById('error-message');
  var emailError = document.getElementById('email-error');

  // Reset borders and error messages
  emailInput.style.border = '';
  passInput.style.border = '';
  repeatPassInput.style.border = '';
  emailError.textContent = '';
  errorMsg.textContent = '';

  // Email validation
  if (!email.includes('@')) {
    emailError.textContent = "Invalid email address.";
    emailInput.style.border = '2px solid red';
    event.preventDefault();
    return false;
  }

  // Password length validation
  if (pass.length < 10) {
    errorMsg.textContent = "Password must be at least 10 characters long.";
    passInput.style.border = '2px solid red';
    event.preventDefault();
    return false;
  }

  // Password match validation
  if (pass !== repeatPass) {
    errorMsg.textContent = "Passwords do not match.";
    passInput.style.border = '2px solid red';
    repeatPassInput.style.border = '2px solid red';
    event.preventDefault();
    return false;
  }

  // If all is good, clear error
  errorMsg.textContent = "";
  return true;
};

// Show/Hide Passwords with SVG toggle
document.getElementById('toggleEye').addEventListener('click', function() {
  var passInput = document.getElementById('pass');
  var repeatPassInput = document.getElementById('repeat_pass');
  var eyeOpen = document.getElementById('eyeOpen');
  var eyeClosed = document.getElementById('eyeClosed');
  var isHidden = passInput.type === 'password';

  passInput.type = isHidden ? 'text' : 'password';
  repeatPassInput.type = isHidden ? 'text' : 'password';
  eyeOpen.style.display = isHidden ? 'none' : '';
  eyeClosed.style.display = isHidden ? '' : 'none';
});
</script>
  </div>
  </div>
  <footer>
    Polycium University © 2024 All Rights Reserved.
  </footer>
</body>
</html>