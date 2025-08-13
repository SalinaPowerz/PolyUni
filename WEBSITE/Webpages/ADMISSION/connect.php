<?php
$conn = new mysqli('localhost', 'root', '', 'polyciumuniversity');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>