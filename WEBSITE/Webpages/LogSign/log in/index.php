<?php
include '../../Exams/db.php';
session_start();

$email_error = "";
$password_error = "";
$email = "";

if(isset($_POST['login_btn'])){
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['pass'];

    $has_error = false;
    if (empty($email)) {
        $email_error = "Email is required.";
        $has_error = true;
    }
    if (empty($password)) {
        $password_error = "Password is required.";
        $has_error = true;
    }

    if (!$has_error) {
        $stmt = $conn->prepare("SELECT Account_ID, Password FROM account WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $hashed_password = $user['Password'];

            if (password_verify($password, $hashed_password)) {
                $_SESSION['acc_id'] = $user['Account_ID'];
                $_SESSION['email'] = $user['Email'];
                header("Location: ../../Admission/Form.php");
                exit();
            } else {
                $password_error = "Incorrect Password";
            }
        } else {
            $email_error = "Invalid Email";
        }
        
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Polycium University</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="globals.css" />
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>

<div style="position: fixed; width: 100%; height: 60px; background-color: #32508F; display: flex; align-items: center; justify-content: space-between; padding: 0 17px; box-sizing: border-box;" id="Navigation_bar">
  <div style="display: flex; align-items: center;">
      <img src="../../../Images/new.png" width="50px" alt="Logo" style="vertical-align: middle; margin-right: 10px;" />
    <span style="font-size: 30px; color: #FFFFFF; ">POLYCIUM UNIVERSITY</span>
  </div>

  <nav style="display: flex; gap: 12px; font-family: Helvetica; color: #FFFFFF; margin-right: 30px;">
    <a class="navigation" style="font-size: 17px; color: #FFFFFF; text-decoration: none; padding: 4px 10px;" href="../../HomePage/main.html">ABOUT</a>
    <a class="navigation" style="font-size: 17px; color: #FFFFFF; text-decoration: none; padding: 4px 10px;" href="../../Academics/Academics.html">ACADEMICS</a>
    <a class="navigation" style="font-size: 17px; color: #FFFFFF; text-decoration: none; padding: 4px 10px;" href="index.php">ADMISSION</a>
    <a class="navigation" style="font-size: 17px; color: #FFFFFF; text-decoration: none; padding: 4px 10px;" href="../../StudentLog/StudentLogin.html">STUDENT PORTAL</a>
  </nav>
</div>

    <div class="container">
      <div class="login-box">
        <img src="../../../Images/new.png" alt="University Logo" class="logo"/>
        <h2>LOG IN</h2>
        

        <form id="login-form" action="" method="POST">
            <div class="form-group">
                <input type="email" id="email" name="email" placeholder="Email" value="<?= htmlspecialchars($email); ?>" required class="input-field" />
                <div class="error-text" id="emailError"><?= htmlspecialchars($email_error) ?></div>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="pass" placeholder="Enter your password" required class="input-field" /> 
                <i class="fa-solid fa-eye eye-icon" id="togglePassword"></i>
                <div class="error-text" id="passwordError"><?= htmlspecialchars($password_error) ?></div>
            </div>
            <div class="forgot-password-link">
                <a href="../forget/index.php">Forgot Password?</a>
            </div>
            <button class="login-btn" name="login_btn" type="submit">LOGIN</button>
        </form>

        <div class="register-link">
          Don’t have an account yet? <br>
          <a href="../sign up/index1.php">Register Here.</a>
        </div>
      </div>
    </div>

    <div class="footer">
      Polycium University © 2024 All Rights Reserved.
    </div>

    <script>
      const togglePassword = document.getElementById('togglePassword');
      const passwordField = document.getElementById('password');

      if(togglePassword) {
          togglePassword.addEventListener('click', function () {
              const type = passwordField.type === 'password' ? 'text' : 'password';
              passwordField.type = type;
              this.classList.toggle('fa-eye');
              this.classList.toggle('fa-eye-slash');
          });
      }

      document.getElementById('login-form').addEventListener('submit', function(e) {
          let valid = true;
          const emailInput = document.getElementById('email');
          const passwordInput = document.getElementById('password');
          const emailError = document.getElementById('emailError');
          const passwordError = document.getElementById('passwordError');

          emailError.textContent = "";
          passwordError.textContent = "";
          emailInput.classList.remove('error-border');
          passwordInput.classList.remove('error-border');

          const email = emailInput.value.trim();
          const password = passwordInput.value.trim();
          
          const emailPattern = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;
          if (email === "") {
              emailError.textContent = "Email is required.";
              emailInput.classList.add('error-border');
              valid = false;
          } else if (!emailPattern.test(email)) {
              emailError.textContent = "Please enter a valid email address.";
              emailInput.classList.add('error-border');
              valid = false;
          }

          if (password === "") {
              passwordError.textContent = "Password is required.";
              passwordInput.classList.add('error-border');
              valid = false;
          } else if (password.length < 4) {
              passwordError.textContent = "Password must be at least 4 characters.";
              passwordInput.classList.add('error-border');
              valid = false;
          }

          if (!valid) {
              e.preventDefault();
          }
      });
    </script>
</body>
</html>