<?php
// Start session with proper configuration at the very beginning
session_set_cookie_params([
    'lifetime' => 86400, // 24 hours
    'path' => '/',
    'domain' => '',
    'secure' => false,    // Set to true if using HTTPS
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start();

// Database connection - replace with your actual credentials
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "polyciumuniversity"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in - use the same session variable as form.php
if (!isset($_SESSION['acc_id'])) {
    error_log("Redirecting to login: acc_id not set in session");
    header("Location: ../LogSign/log in/index.php");
    exit();
}

$user_id = $_SESSION['acc_id'];
error_log("Account ID from session: " . $user_id);

// Fetch all available exams
$exams_query = "SELECT * FROM exam";
$exams_result = mysqli_query($conn, $exams_query);

// Check for query errors
if (!$exams_result) {
    die("Error fetching exams: " . mysqli_error($conn));
}

// Create an array to track which exams the user has completed
$completed_exams = array();
$completion_query = "SELECT Exam_ID FROM exam_results WHERE Examinee_ID = $user_id";
$completion_result = mysqli_query($conn, $completion_query);

if ($completion_result) {
    while ($row = mysqli_fetch_assoc($completion_result)) {
        $completed_exams[] = $row['Exam_ID'];
    }
}

// Store in session for other pages to use
$_SESSION['completed_exams'] = $completed_exams;
?>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="globals.css" />
    <link rel="stylesheet" href="style.css" />
    <style>
      .subject-table {
        position: absolute;
        top: 120px;
        left: 330px;
        width: 1000px;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
      }
      
      .subject-table th, .subject-table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
      }
      
      .subject-table th {
        background-color: #32508F;
        color: white;
        font-size: 18px;
      }
      
      .subject-table tr:nth-child(even) {
        background-color: #f2f2f2;
      }
      
      .subject-table tr:hover {
        background-color: #e6e6e6;
      }
      
      .take-exam-btn {
        background-color: #32508F;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        display: block;
        margin: 0 auto;
      }
      
      .take-exam-btn:hover {
        background-color: #253d75;
      }
      
      .take-exam-btn:disabled {
        background-color: #cccccc;
        cursor: not-allowed;
      }
      
      .table-title {
        position: absolute;
        top: 55px;
        left: 330px;
        font-family: "Konkhmer Sleokchher-Regular", Helvetica;
        font-weight: bold;
        color: #000000;
        font-size: 24px;
      }
      
      /* New style to make action column narrower and center content */
      .subject-table th:nth-child(4),
      .subject-table td:nth-child(4) {
        width: 120px; /* Reduced width for action column */
        text-align: center; /* Center content in action column */
      }
      
      .status-completed {
        color: green;
        font-weight: bold;
      }
      
      .status-available {
        color: #32508F;
        font-weight: bold;
      }
      
      /* Debug info - can be removed after fixing 
      .debug-info {
        position: fixed;
        bottom: 10px;
        right: 10px;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 10px;
        border-radius: 5px;
        font-size: 12px;
        z-index: 1000;
      }
      */
    </style>
  </head>
  <body>
    
    <?php
    /* Display debug info 
    if (isset($_SESSION['acc_id'])) {
        echo '<div class="debug-info">';
        echo 'Account ID: ' . $_SESSION['acc_id'] . '<br>';
        echo 'Session ID: ' . session_id() . '<br>';
        echo 'Completed Exams: ' . count($completed_exams);
        echo '</div>';
    }
    */
    ?>
    
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
          <!-- Removed the School Year text-wrapper -->
          <div class="rectangle-3"></div>
          <a href="../Admission/form.php"><div class="nav"><div class="about highlight">Profile</div></div></a>
          <a href="../Exams/ExamOverview.php"><div class="about-wrapper"><div class="about highlight">Exams</div></div></a>
          <a href="../Dashboard/Dash.php"><div class="div-wrapper"><div class="about highlight">Dashboard</div></div></a>
          <a href="../LogSign/logout.php"><div class="logout-wrapper"><div class="about highlight logout">Logout</div></div></a>
          <div class="rectangle-4"></div>
          
          <!-- Subject Selection Table -->
          <div class="table-title">Select a Subject to Take Exam</div>
          <table class="subject-table">
            <thead>
              <tr>
                <th>Subject</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (mysqli_num_rows($exams_result) > 0) {
                  mysqli_data_seek($exams_result, 0); // Reset pointer
                  while ($exam = mysqli_fetch_assoc($exams_result)) {
                      $is_completed = in_array($exam['Exam_ID'], $completed_exams);
                      $status_class = $is_completed ? 'status-completed' : 'status-available';
                      $status_text = $is_completed ? 'Completed' : 'Available';
                      
                      echo "<tr>
                        <td>{$exam['Exam_Name']}</td>
                        <td>{$exam['Exam_Description']}</td>
                        <td class='{$status_class}'>{$status_text}</td>
                        <td>";
                      
                      if ($is_completed) {
                          echo "<button class='take-exam-btn' disabled>Exam Taken</button>";
                      } else {
                          echo "<button class='take-exam-btn' onclick=\"takeExam('{$exam['Exam_Name']}', {$exam['Exam_ID']})\">Take Exam</button>";
                      }
                      
                      echo "</td>
                      </tr>";
                  }
              } else {
                  echo "<tr><td colspan='4'>No exams available.</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <script>
      document.querySelector('.logout').addEventListener('click', function (e) {
        e.preventDefault();
        if (confirm('Are you sure you want to logout?')) {
          alert('Logging out...');
          window.location.href = '../LogSign/logout.php';
        }
      });
      
      function takeExam(subject, examId) {
        alert(`Starting ${subject} exam...`);
        // Redirect to exam page for the selected subject
        window.location.href = `../Exams/ExamStart/ExamStart.php?exam_id=${examId}`;
      }
    </script>
  </body>
</html>