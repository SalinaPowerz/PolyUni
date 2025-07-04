<?php
  include '../db.php';
  session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Submitting Exam...</title>
</head>
<body>
  <h2>Finalizing your exam...</h2>
  <form id="submitForm" action="submitScore.php" method="POST">
    <input type="hidden" name="acc_id" id="acc-id" value="<?php echo $_SESSION['acc_id']?>">
    <input type="hidden" name="firstExamScore" id="firstExamScore">
    <input type="hidden" name="secondExamScore" id="secondExamScore">
    <input type="hidden" name="exam_score" id="finalScore">
    <input type="hidden" name="examResult" id="examResult">
  </form>

  <script>
    const macroskillsAnswers = [
      "B", "A", "A", "C", "B", "B", "A", "A", "B", "B",
      "B", "D", "B", "B", "B", "B", "D", "B", "B", "A",
      "B", "B", "A", "B", "B", "B", "B", "B", "B", "C",
      "B", "B", "C", "B", "A", "B", "B", "B", "C", "B"
    ];
    const mathAnswers = [
      "A", "C", "B", "B", "C", "C", "D", "C", "A", "A",
      "A", "A", "D", "B", "B", "C", "A", "A", "B", "A",
      "A", "B", "B", "A", "A", "A", "A", "B", "A", "B",
      "A", "B", "A", "B", "A", "B", "A", "B", "B", "A"
    ];
    let answers1 = [];
    let answers2 = [];
    let firstExamScore = 0;
    let secondExamScore = 0;
    let finalScore = 0;


    for (let i = 1; i <= 40; i++) {
      const ans1 = localStorage.getItem("q" + i);
      answers1.push(ans1);
    }
    for (let i = 1; i <= 40; i++) {
      const ans2 = localStorage.getItem("p" + i);
      answers2.push(ans2);
    }


    for (let i = 0; i < macroskillsAnswers.length; i++) {
      if (macroskillsAnswers[i] === answers1[i]) {
        firstExamScore++;
      }
    }

    // --- Score Exam 2 ---
    for (let i = 0; i < mathAnswers.length; i++) {
      if (mathAnswers[i] === answers2[i]) {
        secondExamScore++;
      }
    }

    finalScore = firstExamScore + secondExamScore;
    const examResult = finalScore >= 60 ? "passed" : "failed";

    // Fill form fields
    document.getElementById("firstExamScore").value = firstExamScore;
    document.getElementById("secondExamScore").value = secondExamScore;
    document.getElementById("finalScore").value = finalScore;
    document.getElementById("examResult").value = examResult;

    // --- Automatically submit the form ---
    document.getElementById("submitForm").submit();
  </script>
</body>
</html>