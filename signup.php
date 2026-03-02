<?php
session_start();
include 'db.php'; // include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username        = trim($_POST['username']);
    $email           = trim($_POST['email']);
    $password        = trim($_POST['password']);
    

    // check password match
   // if ($password !== $confirmPassword) {
     //   echo "Passwords do not match!";
       // exit;
    //}

    // hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // insert into database securely
    $sql  = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        header("Location:homepage.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>