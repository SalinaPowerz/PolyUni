<?php
date_default_timezone_set('Asia/Manila');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "polyciumuniversity";
$termux = "/data/data/com.termux/files/usr/var/run/mysqld.sock";

// remove mo yung port & termux sa parameter if di ka sa termux
$conn = mysqli_connect($servername, $username, $password, $dbname, 3306, $termux); 

if(!$conn) {
    $db_status = "fail";
    
} else {
    $db_status = "success";
    
}
?>
