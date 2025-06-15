<?php
  include '../../Exams/db.php';
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Polycium University</title>
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
    <a class="navigation" style="font-size: 17px; color: #FFFFFF; text-decoration: none; padding: 4px 10px;" href="index.html">ADMISSION</a>
    <a class="navigation" style="font-size: 17px; color: #FFFFFF; text-decoration: none; padding: 4px 10px;" href="../../StudentLog/StudentLogin.html">STUDENT PORTAL</a>
  </nav>
</div>

    <div class="container">
      <div class="login-box">
        <img src="../../../Images/new.png" alt="University Logo" class="logo"/>
        <h2>LOG IN</h2>

        <form id="login-form" action="" method="POST">
    			<input type="email" id="email" name="email" placeholder="Email" required class="input-field" />
    			<input type="password" id="password" name="password" placeholder="Enter your password" required class="input-field" />	
          <button class="login-btn" name="login_btn" type="submit">LOGIN</button>
        </form>
        <?php
          if(isset($_POST['login_btn'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $checkExisting = "SELECT * FROM account WHERE Email = '$email' AND Password = '$password';";
            $checkExistResult = mysqli_query($conn, $checkExisting);
            if(mysqli_num_rows(!$checkExistResult)){
              header("Location: ../log in/index.php");
              exit();
            }
            else{
              $getUserData = "SELECT * FROM account WHERE Email = '$email';";
              $userDataResult = mysqli_query($conn, $getUserData);
              $userDataRow = mysqli_fetch_assoc($userDataResult);
              $_SESSION['acc_id'] = $userDataRow['Account_ID'];
              $_SESSION['email'] = $userDataRow['Email'];
              header("Location: ../../Dashboard/Dash.php");
            }
          }
        
        
        ?>

        <div class="register-link">
          Don’t have an account yet? <br>
		  <a href="../sign up/index1.html">Register Here.</a>
        </div>
      </div>
    </div>

    <div class="footer">
      Polycium University © 2024 All Rights Served .
    </div>
  </body>
</html>
