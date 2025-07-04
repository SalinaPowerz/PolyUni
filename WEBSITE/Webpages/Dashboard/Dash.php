<?php
  include '../Exams/db.php';
  session_start();
?>

<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="globals.css" />
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div style="width: 100%; height: 60px; background-color: #32508F; display: flex; align-items: center; justify-content: space-between; padding: 0 17px; box-sizing: border-box;" id="Navigation_bar">
      <div style="display: flex; align-items: center;">
        <img src="../../Images/new.png" width="50px" alt="Logo" style="vertical-align: middle; margin-right: 10px;" />
        <span style="font-size: 30px; color: #FFFFFF;">POLYCIUM UNIVERSITY</span>
      </div>
    </div>

    <div class="ADMISSIONGOOD">
      <div class="div">
        <div class="overlap">
          <img class="element" src="../../Images/Bg2.png" />
          <div class="rectangle"></div>
          <div class="rectangle-2"></div>
          <div class="text-wrapper">School Year:</div>
          <div class="rectangle-3"></div>
          <a href="../Admission/form.html"><div class="nav"><div class="about highlight">Profile</div></div></a>
          <a href="../Exams/ExamStart/ExamStart.php"><div class="about-wrapper"><div class="about highlight">Exams</div></div></a>
          <a href="Dash.php"><div class="div-wrapper"><div class="about highlight">Dashboard</div></div></a>
          <a href="../LogSign/log in/index.php"><div class="logout-wrapper"><div class="about highlight logout">Logout</div></div></a>
          <div class="text-wrapper-2">2025 - 2026</div>
          <div class="text-wrapper-4">Results:</div>
          <div class="rectangle-4"></div>
        </div>
      </div>
    </div>
    <script>
      document.querySelector('.logout').addEventListener('click', function () {
        alert('Logging out...');
        window.location.href = '/login';
      });
    </script>
  </body>
</html>
