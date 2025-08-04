<?php
  include '../db.php';
  session_start();
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  
  $examinee_id = (int)$_SESSION['acc_id'];
  $examScore = (int)$_POST['exam_score'];
  $examResult = $examScore >= 60 ? "passed" : "failed";
  
  
  $saveExamQuery = "INSERT INTO exam VALUES($examinee_id, $examScore, '$examResult');";
  header("Location: ../Exam1/Exam1.php");
?>