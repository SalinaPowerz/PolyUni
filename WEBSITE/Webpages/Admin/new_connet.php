<?php
session_start();
require_once 'connect.php';

$sql = "SELECT * FROM admission_form";
$result = $conn->query($sql);

if(!$result){
    die("Invalid query: ".$conn->error);
}

?>