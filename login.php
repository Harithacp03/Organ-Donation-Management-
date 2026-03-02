<?php
include 'db.php'; // include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // fetch user by username
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // verify password with hash
        if (password_verify($password, $row['password'])) {
            echo "Login successful! Welcome " . $row['username'];
            session_start();
            $_SESSION['username'] = $row['username'];
             header("Location: homepage.html");
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "Invalid username!";
    }
    $stmt->close();
}
$conn->close();
?>