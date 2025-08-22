<?php
session_start();

// Database connection - use the same connection as in ExamOverview.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "polyciumuniversity";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get exam ID from URL parameter
$exam_id = isset($_GET['exam_id']) ? intval($_GET['exam_id']) : 0;

// Fetch exam details from database
$exam = null;
$exam_time = 90; // Default time

if ($exam_id > 0) {
    $sql = "SELECT * FROM exam WHERE Exam_ID = $exam_id";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $exam = $result->fetch_assoc();
        $exam_time = isset($exam['Exam_Duration']) ? $exam['Exam_Duration'] : 90;
    }
}

// If no exam found, redirect back to overview
if (!$exam) {
    header("Location: ../ExamOverview.php");
    exit();
}

// Store exam info in session for the actual exam page
$_SESSION['current_exam_id'] = $exam_id;
$_SESSION['current_exam_name'] = $exam['Exam_Name'];
$_SESSION['exam_time_limit'] = $exam_time;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="style.css" />
  <title><?php echo htmlspecialchars($exam['Exam_Name']); ?> Exam</title>
  <style>
    .navigation:hover {
      color: blue;
      font-weight: bold;
    }
    
    .exam-title {
      position: absolute;
      top: 120px;
      left: 125px;
      width: 657px;
      font-family: "KonkhmerSleokchher-Regular", sans-serif, Arial, sans-serif;
      font-weight: 600;
      font-size: 30px;
      text-align: center;
      color: #32508F;
      z-index: 3;
    }
    
    .exam-description {
      margin-top: 20px;
      padding: 15px;
      background-color: #f5f5f5;
      border-left: 4px solid #32508F;
      border-radius: 4px;
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
      
      <div class="exam-title">
        <?php echo htmlspecialchars($exam['Exam_Name']); ?> Exam
      </div>

      <div class="exam-time-text">
        You have <?php echo $exam_time; ?> Minutes to complete the exam, Good luck!
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
        
        <?php if (!empty($exam['Exam_Description'])): ?>
        <div class="exam-description">
          <strong>Exam Description:</strong><br>
          <?php echo htmlspecialchars($exam['Exam_Description']); ?>
        </div>
        <?php endif; ?>
      </div>

      <button
        class="start-button"
        type="button"
        tabindex="0"
        aria-pressed="false"
        aria-label="Start Exam"
        onclick="startExam()"
        onkeydown="if(event.key==='Enter' || event.key===' ') startExam()"
      >
        Start Exam
      </button>
    </div>
  </main>
  
  <footer style="background-color:#32508F; color:white; text-align:center;">
    ©2025 Polycium University All Rights Reserved.
  </footer>

  <script>
function startExam() {
    alert("<?php echo htmlspecialchars($exam['Exam_Name']); ?> exam has started! Good luck.");
    // Redirect to the exam template
    window.location.href = "../ExamTemplate/Exam.php?exam_id=<?php echo $exam_id; ?>";
}
  </script>
</body>
</html>