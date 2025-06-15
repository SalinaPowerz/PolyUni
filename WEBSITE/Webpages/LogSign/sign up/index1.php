<?php session_start()?>
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
    <div class="SIGNUP">
      <div class="div">
<div style="position: fixed; width: 100%; height: 60px; background-color: #32508F; display: flex; align-items: center; justify-content: space-between; padding: 0 17px; box-sizing: border-box;" id="Navigation_bar">
  <div style="display: flex; align-items: center; z-index: 1000;">
      <img src="../../../Images/new.png" width="50px" alt="Logo" style="vertical-align: middle; margin-right: 10px;" />
    <span style="font-size: 30px; color: #FFFFFF; font-family: Times New Roman; ">POLYCIUM UNIVERSITY</span>
  </div>

  <nav style="display: flex; gap: 12px; font-family: Helvetica; color: #FFFFFF; margin-right: 30px;">
    <a class="navigation" style="font-size: 17px; color: #FFFFFF; text-decoration: none; padding: 4px 10px;" href="#">ABOUT</a>
    <a class="navigation" style="font-size: 17px; color: #FFFFFF; text-decoration: none; padding: 4px 10px;" href="../../Academics/Academics.html">ACADEMICS</a>
    <a class="navigation" style="font-size: 17px; color: #FFFFFF; text-decoration: none; padding: 4px 10px;" href="index1.html">ADMISSION</a>
    <a class="navigation" style="font-size: 17px; color: #FFFFFF; text-decoration: none; padding: 4px 10px;" href="../../StudentLog/StudentLogin.html">STUDENT PORTAL</a>
  </nav>
</div>

<div class="overlap">
  <div class="overlap-group">
    <div class="overlap-group-2">
      <img class="logo-removebg" src="../../../Images/new.png" alt="Logo" />
      <div class="text-wrapper-2">SIGN UP</div>
    </div>

    <form method="POST" action="new_connect.php">
      <input type="email" name="email" placeholder="Email" class="group-2" required />
      <input type="password" name="pass" placeholder="Password" class="img" required />
      <input type="password" name="repeat_pass" placeholder="Confirm Password" class="group" required />

      <a style="font-family: Times New Roman;" href="../log in/index.php" class="back-to-log-in">‹ Back to Log In</a>

      <button type="submit" name="submit_inps" class="yellow">
        <div class="PLACEHOLDER">SIGN UP</div>
      </button>
    </form>
  </div>

  <p class="text-wrapper">Polycium University © 2024 All Rights Reserved.</p>
</div>


      </div>
    </div>
  </body>
</html>
