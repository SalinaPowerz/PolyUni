<?php
// Simulate database data
header('Content-Type: application/json');

$schedule = [
    "examSchedule" => "August 20, 2025",
    "applicationPeriod" => "September 1 - September 30, 2025"
];

echo json_encode($schedule);
?>