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
             header("Location: admindashboard.php");
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
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <style>
    /* General page style */
    body {
      font-family: Arial, sans-serif;
      background:black;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    /* Container box */
    .login-container {
      background:transparent;
      padding: 30px;
      border-radius: 12px;
      box-shadow:none;
      width: 350px;
      text-align: center;
    }

    .login-container h2 {
      margin-bottom: 20px;
      color:wheat;
    }

    /* Input fields */
    .login-container input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
      outline: none;
      font-size: 16px;
    }

    .login-container input:focus {
      border-color: #4facfe;
    }

    /* Button */
    .login-container button {
      width: 90%;
      padding: 12px;
      background: #4facfe;
      border: blueviolet;
      color: white;
      font-size: 16px;
      font-weight: bold;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s;
    }

    .login-container button:hover {
      background: #00c6ff;
      align-items: center;
    }

    /* Extra links */
    .login-container p {
      margin-top: 15px;
      font-size: 14px;
      color: wheat;
    }

    .login-container a {
      color: #4facfe;
      text-decoration: none;
    }

    .login-container a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <form action="admin.php" method="POST">
      <input type="text" name="username" placeholder="Enter Username" required>
      <input type="password" name="password" placeholder="Enter Password" required><br><br>
      <button type="submit">Login</button>
    </form>
   
  </div>
</body>
</html>