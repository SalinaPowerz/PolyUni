<?php
	include '../db.php';
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="style.css" />
  <title>Exam</title>
  <style>

    .navigation:hover {
      color: blue;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <div style="position: fixed; width: 100%; height: 60px; background-color: #32508F; display: flex; align-items: center; justify-content: space-between; padding: 0 17px; box-sizing: border-box; z-index: 999;">
    <div style="display: flex; align-items: center;">
      <img src="../../../Images/new.png" width="50px" alt="Logo" style="vertical-align: middle; margin-right: 10px;" />
      <span style="font-size: 30px; color: #FFFFFF;">POLYCIUM UNIVERSITY</span>
    </div>
  </div>

  <main class="examination-start" role="main" aria-label="Exam start page">
    <img
      src="../../../Images/Bg2.png"
      alt="Background exam banner"
      class="bg-image"
      aria-hidden="true"
    />

    <div class="content-box" aria-live="polite">
      <img
        src="../../../Images/new.png"
        alt="University Logo"
        class="logo"
      />

      <div class="exam-time-text">
        You have 90 Minutes to complete the exam, Good luck!
      </div>

      <div
        class="rules"
        role="region"
        aria-labelledby="rules-title"
        tabindex="0"
      >
        <span class="rules-title" id="rules-title"
          >Rules to follow during all online proctored exams:</span
        >
        <ul>
          <li>No cellphones or other secondary devices in the room or test area</li>
          <li>Your desk/table must be clear except your test-taking device</li>
          <li>No one else can be in the room with you</li>
          <li>No use of additional applications or internet</li>
          <li>No dual screens/monitors</li>
        </ul>
      </div>
    <?php
      $acc_id = (int)$_SESSION['acc_id'];
      $checkRecordQuery = "SELECT * FROM exam WHERE Account_ID = $acc_id;";
      $checkRecordResult = mysqli_query($conn, $checkRecordQuery);
      $hasRecord = false;
      if(mysqli_num_rows($checkRecordResult) > 0){
        $hasRecord = true;
      }
      else{
        $hasRecord = false;
      }
      $disabled = $hasRecord ? "start-disabled" : "start-button";
      $retakeText = $hasRecord ? "Wait for results" : "Start Exam";
    ?>

	<a href="../Exam1/Exam1.php">
      <div
        class="<?= $disabled ?>"
        role="button"
        tabindex="0"
        aria-pressed="false"
        aria-label="Start Exam"
        onclick="startExam()"
        onkeydown="if(event.key==='Enter' || event.key===' ') startExam()"
      >
        <?php echo $retakeText; ?>
      </div>
	  </a>
    </div>
  </main>
<footer style="	background-color:#32508F; color:white; text-align:center;"> ©2025 Polycium University All Rights Reserved.</footer>

  <script>
    function startExam() {
      alert("Exam has started! Good luck.");
    }
  </script>
</body>
</html>
