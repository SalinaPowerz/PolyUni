<?php
$servername="localhost";
$username="root";
$password="";
$dbname="polyciumuniversity";

$conn = new msqli ($servername, $username, $password, $dbname);
 if($conn->connect_error){
    echo "connection failed";
}

if($_SERVER["REQUEST_METHOD"]=="POST")

?>