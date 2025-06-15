<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Manila');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "polyciumuniversity";
$termux = "/data/data/com.termux/files/usr/var/run/mysqld.sock";

// remove mo yung port & termux sa parameter if di ka sa termux
$conn = mysqli_connect($servername, $username, $password, $dbname, 3306, $termux); 

if(!$conn) {
   // echo "ayaw";//
    $db_status = "fail";
    
} else {
   // echo "all goods";//
    $db_status = "success";
    
}
?>
