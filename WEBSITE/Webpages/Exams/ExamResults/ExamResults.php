<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['acc_id'])) {
    header("Location: ../../LogSign/log in/index.php");
    exit();
}

// Get results from URL parameters
$exam_id = isset($_GET['exam_id']) ? intval($_GET['exam_id']) : 0;
$score = isset($_GET['score']) ? intval($_GET['score']) : 0;
$total = isset($_GET['total']) ? intval($_GET['total']) : 0;

// Calculate percentage
$percentage = $total > 0 ? round(($score / $total) * 100, 2) : 0;

// Database connection to get exam name
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "polyciumuniversity";

$conn = new mysqli($servername, $username, $password, $dbname);
$exam_name = "Exam";

if ($exam_id > 0) {
    $sql = "SELECT Exam_Name FROM exam WHERE Exam_ID = $exam_id";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $exam = $result->fetch_assoc();
        $exam_name = $exam['Exam_Name'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Results</title>
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
        
        .results-container {
            max-width: 800px;
            margin: 80px auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        .results-header {
            margin-bottom: 30px;
            color: #32508F;
        }
        
        .score-circle {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: #32508F;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
            font-size: 24px;
            font-weight: bold;
        }
        
        .percentage {
            font-size: 32px;
        }
        
        .score-details {
            margin: 20px 0;
            font-size: 18px;
        }
        
        .back-btn {
            background: #32508F;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            text-decoration: none;
            display: inline-block;
        }
        
        .back-btn:hover {
            background: #253d75;
        }
        
        .navigation {
            position: fixed;
            top: 0;
            width: 100%;
            background: #32508F;
            color: white;
            padding: 15px 20px;
            z-index: 1000;
        }
        
        .navigation img {
            vertical-align: middle;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="navigation">
        <img src="../../../Images/new.png" width="40px" alt="Logo">
        <span style="font-size: 24px;">POLYCIUM UNIVERSITY</span>
    </div>

    <div class="results-container">
        <div class="results-header">
            <h1><?php echo htmlspecialchars($exam_name); ?> - Exam Results</h1>
        </div>
        
        <div class="score-circle">
            <span class="percentage"><?php echo $percentage; ?>%</span>
            <span>Score</span>
        </div>
        
        <div class="score-details">
            <p>You scored <strong><?php echo $score; ?></strong> out of <strong><?php echo $total; ?></strong> questions</p>
        </div>
        
        <a href="../ExamOverview.php" class="back-btn">Back to Exams</a>
    </div>
</body>
</html>