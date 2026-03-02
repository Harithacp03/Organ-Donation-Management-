<?php
$host = "localhost";
$user = "root";   // change if your MySQL user is different
$pass = "";       // change if your MySQL password is set
$db   = "organdonationn";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("DB Connection Failed: " . $conn->connect_error);
}
?>
