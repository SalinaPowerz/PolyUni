<?php
session_start();

// Initialize session arrays if they don't exist or if they're not arrays
if (!isset($_SESSION['exam_start_time']) || !is_array($_SESSION['exam_start_time'])) {
    $_SESSION['exam_start_time'] = array();
}
if (!isset($_SESSION['exam_time_limit']) || !is_array($_SESSION['exam_time_limit'])) {
    $_SESSION['exam_time_limit'] = array();
}

// Check if user is logged in
if (!isset($_SESSION['acc_id'])) {
    header("Location: ../../LogSign/log in/index.php");
    exit();
}

// Database connection
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

// Fetch exam details
$exam = null;
if ($exam_id > 0) {
    $sql = "SELECT * FROM exam WHERE Exam_ID = $exam_id";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $exam = $result->fetch_assoc();
    }
}

// If no exam found, redirect back to overview
if (!$exam) {
    header("Location: ../ExamOverview.php");
    exit();
}

// Fetch questions for this exam
$questions = array();
$sql = "SELECT * FROM questions WHERE Exam_ID = $exam_id ORDER BY Question_ID";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }
}

// Check if user has already taken this exam
$user_id = $_SESSION['acc_id'];
$already_taken = false;
$previous_score = 0;
$previous_total = 0;

$check_sql = "SELECT * FROM exam_results WHERE Examinee_ID = $user_id AND Exam_ID = $exam_id";
$check_result = $conn->query($check_sql);
if ($check_result && $check_result->num_rows > 0) {
    $already_taken = true;
    $previous_result = $check_result->fetch_assoc();
    $previous_score = $previous_result['Grade'];
    $previous_total = $previous_result['Total_Questions'];
}

// Initialize user answers array
$user_answers = array();
$show_preview = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Store user answers from the form
    foreach ($questions as $question) {
        $question_id = $question['Question_ID'];
        if (isset($_POST['question_' . $question_id])) {
            $user_answers[$question_id] = $_POST['question_' . $question_id];
        }
    }
    
    // Check if this is the final submission or just preview
    if (isset($_POST['final_submission'])) {
        // Calculate score
        $score = 0;
        $total_questions = count($questions);
        
        foreach ($questions as $question) {
            $question_id = $question['Question_ID'];
            $user_answer = isset($user_answers[$question_id]) ? $user_answers[$question_id] : '';
            $correct_answer = $question['Correct_Answer'];
            
            if ($user_answer === $correct_answer) {
                $score++;
            }
        }
        
        // Save results to database
        $time_taken = 0;
        $exam_results = "$score/$total_questions";
        
        if ($already_taken) {
            // Update existing record
            $insert_sql = "UPDATE exam_results SET Grade = $score, Exam_Results = '$exam_results', 
                          Total_Questions = $total_questions, Time_Taken = $time_taken
                          WHERE Examinee_ID = $user_id AND Exam_ID = $exam_id";
        } else {
            // Insert new record
            $insert_sql = "INSERT INTO exam_results (Examinee_ID, Exam_ID, Grade, Exam_Results, Total_Questions, Time_Taken) 
                           VALUES ($user_id, $exam_id, $score, '$exam_results', $total_questions, $time_taken)";
        }
        
        if ($conn->query($insert_sql)) {
            // Clear exam timer data from session
            unset($_SESSION['exam_start_time'][$exam_id]);
            unset($_SESSION['exam_time_limit'][$exam_id]);
            
            // Redirect to results page
            header("Location: ../ExamResults/ExamResults.php?exam_id=$exam_id&score=$score&total=$total_questions");
            exit();
        } else {
            $error_message = "Error saving results: " . $conn->error;
        }
    } 
    // Check if this is a request to edit answers (exit preview mode)
    elseif (isset($_POST['edit_answers'])) {
        // Set flag to exit preview mode and show the form
        $show_preview = false;
    }
    else {
        // This is a preview request, show the preview
        $show_preview = true;
    }
}

// Store exam start time in session if not already set for this specific exam
if (!isset($_SESSION['exam_start_time'][$exam_id])) {
    $_SESSION['exam_start_time'][$exam_id] = time();
    $_SESSION['exam_time_limit'][$exam_id] = isset($exam['Exam_Duration']) ? $exam['Exam_Duration'] * 60 : 90 * 60;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($exam['Exam_Name']); ?> Exam</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f5f5f5;
            color: #333;
        }
        
        /* Navigation Bar Styles */
        .navigation-bar {
            position: fixed;
            width: 100%;
            height: 60px;
            background-color: #32508F;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 17px;
            box-sizing: border-box;
            z-index: 1000;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
        }
        
        .logo {
            width: 50px;
            vertical-align: middle;
            margin-right: 10px;
        }
        
        .university-name {
            font-size: 30px;
            color: #FFFFFF;
        }
        
        .nav-links {
            display: flex;
            gap: 12px;
            font-family: Helvetica;
            color: #FFFFFF;
            margin-right: 30px;
        }
        
        .nav-link {
            font-size: 17px;
            color: #FFFFFF;
            text-decoration: none;
            padding: 4px 10px;
        }
        
        .nav-link:hover {
            color: blue;
            font-weight: bold;
        }
        
        .spacer {
            height: 70px;
        }
        
        /* Exam Content Styles */
        .exam-container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .exam-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #32508F;
        }
        
        .exam-title {
            color: #32508F;
            font-size: 24px;
        }
        
        .timer {
            background: #32508F;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
        }
        
        .question {
            margin-bottom: 25px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f9f9f9;
        }
        
        .question-text {
            font-weight: bold;
            margin-bottom: 10px;
            color: #32508F;
        }
        
        .options label {
            display: block;
            margin: 8px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .options label:hover {
            background-color: #e9f0ff;
        }
        
        .options input[type="radio"] {
            margin-right: 10px;
        }
        
        .submit-btn {
            background: #32508F;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            transition: background-color 0.3s;
        }
        
        .submit-btn:hover {
            background: #253d75;
        }
        
        .error {
            color: red;
            margin: 10px 0;
            padding: 10px;
            background: #ffe6e6;
            border: 1px solid red;
            border-radius: 4px;
        }
        
        .info-message {
            color: #32508F;
            margin: 10px 0;
            padding: 10px;
            background: #e9f7ff;
            border: 1px solid #32508F;
            border-radius: 4px;
        }
        
        .time-warning {
            background: #ff9900;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
            display: none;
            margin-bottom: 15px;
        }
        
        .time-critical {
            background: #ff0000;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
            display: none;
            margin-bottom: 15px;
            animation: blink 1s infinite;
        }
        
        /* Preview Styles */
        .preview-container {
            background-color: #f8f9fa;
            border: 2px solid #32508F;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .preview-header {
            color: #32508F;
            text-align: center;
            margin-bottom: 20px;
            font-size: 22px;
        }
        
        .preview-question {
            margin-bottom: 15px;
            padding: 15px;
            background: white;
            border-radius: 5px;
            border-left: 4px solid #32508F;
        }
        
        .preview-answer {
            margin-top: 8px;
            padding: 8px 12px;
            background: #e9f7ff;
            border-radius: 4px;
            font-weight: bold;
        }
        
        .preview-not-answered {
            color: #dc3545;
            font-style: italic;
        }
        
        .preview-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        
        .preview-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        
        .btn-confirm {
            background: #28a745;
            color: white;
        }
        
        .btn-confirm:hover {
            background: #218838;
        }
        
        .btn-edit {
            background: #ffc107;
            color: #212529;
        }
        
        .btn-edit:hover {
            background: #e0a800;
        }
        
        @keyframes blink {
            50% { opacity: 0.7; }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar from nav.html -->
    <div class="navigation-bar">
        <div class="logo-container">
            <img class="logo" src="../../../Images/new.png" width="50px" alt="Logo" />
            <span style="font-family:Times new roman" class="university-name">POLYCIUM UNIVERSITY</span>
        </div>
    </div>
    
    <div class="spacer"></div>

    <div class="exam-container">
        <div class="exam-header">
            <h1 class="exam-title"><?php echo htmlspecialchars($exam['Exam_Name']); ?></h1>
            <div class="timer" id="timer">Time Remaining: Calculating...</div>
        </div>
        
        <div class="time-warning" id="time-warning">
            Warning: Less than 5 minutes remaining!
        </div>
        
        <div class="time-critical" id="time-critical">
            Critical: Less than 1 minute remaining!
        </div>
        
        <?php if ($already_taken): ?>
            <div class="info-message">
                <strong>Note:</strong> You have already taken this exam previously. Your previous score was 
                <?php echo $previous_score; ?> out of <?php echo $previous_total; ?>. 
                Submitting again will update your previous result.
            </div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <?php if ($show_preview): ?>
            <!-- Preview Section -->
            <div class="preview-container">
                <h2 class="preview-header">Exam Preview</h2>
                <p>Please review your answers before final submission:</p>
                
                <?php foreach ($questions as $index => $question): ?>
                    <div class="preview-question">
                        <div class="question-text">
                            <?php echo ($index + 1) . '. ' . htmlspecialchars($question['Question_Text']); ?>
                        </div>
                        <div class="preview-answer">
                            <?php
                            $question_id = $question['Question_ID'];
                            $user_answer = isset($user_answers[$question_id]) ? $user_answers[$question_id] : '';
                            
                            if (!empty($user_answer)) {
                                $options = array(
                                    'A' => $question['Option_A'],
                                    'B' => $question['Option_B'],
                                    'C' => $question['Option_C'],
                                    'D' => $question['Option_D']
                                );
                                
                                echo "Your answer: " . $user_answer . '. ' . htmlspecialchars($options[$user_answer]);
                            } else {
                                echo '<span class="preview-not-answered">Not answered</span>';
                            }
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <div class="preview-buttons">
                    <form method="POST" action="" style="display:inline;">
                        <?php foreach ($questions as $question): ?>
                            <?php
                            $question_id = $question['Question_ID'];
                            if (isset($user_answers[$question_id]) && !empty($user_answers[$question_id])) {
                                echo '<input type="hidden" name="question_' . $question_id . '" value="' . $user_answers[$question_id] . '">';
                            }
                            ?>
                        <?php endforeach; ?>
                        <input type="hidden" name="final_submission" value="1">
                        <button type="submit" class="preview-btn btn-confirm">Confirm Submission</button>
                    </form>
                    <form method="POST" action="" style="display:inline;">
                        <?php foreach ($questions as $question): ?>
                            <?php
                            $question_id = $question['Question_ID'];
                            if (isset($user_answers[$question_id]) && !empty($user_answers[$question_id])) {
                                echo '<input type="hidden" name="question_' . $question_id . '" value="' . $user_answers[$question_id] . '">';
                            }
                            ?>
                        <?php endforeach; ?>
                        <input type="hidden" name="edit_answers" value="1">
                        <button type="submit" class="preview-btn btn-edit">Edit Answers</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <!-- Regular Exam Form -->
            <form id="exam-form" method="POST" action="">
                <?php foreach ($questions as $index => $question): ?>
                    <div class="question">
                        <div class="question-text">
                            <?php echo ($index + 1) . '. ' . htmlspecialchars($question['Question_Text']); ?>
                        </div>
                        <div class="options">
                            <?php 
                            $options = array(
                                'A' => $question['Option_A'],
                                'B' => $question['Option_B'],
                                'C' => $question['Option_C'],
                                'D' => $question['Option_D']
                            );
                            
                            foreach ($options as $key => $value): 
                                if (!empty($value)):
                            ?>
                                <label>
                                    <input type="radio" name="question_<?php echo $question['Question_ID']; ?>" value="<?php echo $key; ?>" 
                                        <?php 
                                        if (isset($user_answers[$question['Question_ID']]) && 
                                            $user_answers[$question['Question_ID']] == $key) {
                                            echo 'checked';
                                        }
                                        ?>
                                        required>
                                    <?php echo $key . '. ' . htmlspecialchars($value); ?>
                                </label>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <button type="submit" class="submit-btn" id="review-btn">Review Answers</button>
            </form>
        <?php endif; ?>
    </div>

    <script>
        // Timer functionality
        const examTimeLimit = <?php echo $_SESSION['exam_time_limit'][$exam_id]; ?>;
        const startTime = <?php echo $_SESSION['exam_start_time'][$exam_id]; ?>;
        let warningShown = false;
        let criticalShown = false;
        let isSubmittingForm = false;
        
        function updateTimer() {
            const now = Math.floor(Date.now() / 1000);
            const elapsed = now - startTime;
            const remaining = examTimeLimit - elapsed;
            
            if (remaining <= 0) {
                document.getElementById('timer').textContent = 'Time is up!';
                // If we're in preview mode, submit the form, otherwise go to preview
                if (document.getElementById('exam-form')) {
                    document.getElementById('exam-form').submit();
                } else {
                    document.querySelector('form').submit();
                }
                return;
            }
            
            // Show warning when less than 5 minutes remain
            if (remaining < 300 && !warningShown) {
                document.getElementById('time-warning').style.display = 'block';
                warningShown = true;
            }
            
            // Show critical warning when less than 1 minute remains
            if (remaining < 60 && !criticalShown) {
                document.getElementById('time-warning').style.display = 'none';
                document.getElementById('time-critical').style.display = 'block';
                criticalShown = true;
            }
            
            const minutes = Math.floor(remaining / 60);
            const seconds = remaining % 60;
            
            document.getElementById('timer').textContent = 
                `Time Remaining: ${minutes}:${seconds.toString().padStart(2, '0')}`;
                
            // Update title as well for when tab is not active
            document.title = `(${minutes}:${seconds.toString().padStart(2, '0')}) <?php echo htmlspecialchars($exam['Exam_Name']); ?> Exam`;
        }
        
        // Update timer every second
        updateTimer();
        setInterval(updateTimer, 1000);
        
        // Prevent accidental refresh - but not for form submission
        window.addEventListener('beforeunload', function(e) {
            // Don't show confirmation if we're submitting the form
            if (isSubmittingForm) {
                return;
            }
            
            const now = Math.floor(Date.now() / 0);
            const elapsed = now - startTime;
            const remaining = examTimeLimit - elapsed;
            
            if (remaining > 0) {
                e.preventDefault();
                e.returnValue = 'Are you sure you want to leave? Your exam progress may be lost.';
                return 'Are you sure you want to leave? Your exam progress may be lost.';
            }
        });
        
        // Add event listener to form submission to prevent confirmation dialog
        document.addEventListener('DOMContentLoaded', function() {
            const examForm = document.getElementById('exam-form');
            const reviewBtn = document.getElementById('review-btn');
            
            if (examForm && reviewBtn) {
                reviewBtn.addEventListener('click', function() {
                    isSubmittingForm = true;
                });
                
                examForm.addEventListener('submit', function() {
                    isSubmittingForm = true;
                });
            }
            
            // Also handle the preview buttons
            const previewForms = document.querySelectorAll('form');
            previewForms.forEach(function(form) {
                form.addEventListener('submit', function() {
                    isSubmittingForm = true;
                });
            });
        });
    </script>
</body>
</html>