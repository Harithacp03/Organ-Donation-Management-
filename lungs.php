<?php
include("db.php");

// ---------- FORM SUBMISSION ----------
$message = "";
if (isset($_POST['submit'])) {
    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $phone  = $_POST['phone'];
    $age    = $_POST['age'];
    $gender = $_POST['gender'];
    
    $sql = "INSERT INTO lungs_donors (name, email, phone, age, gender) 
            VALUES ('$name', '$email', '$phone', '$age', '$gender')";
    if ($conn->query($sql) === TRUE) {
        $message = "✅ Thank you, $name! Your registration as a lung donor was successful.";
    } else {
        $message = "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lungs Donation Awareness & Registration</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background:url('lungs1.jpg');
            margin: 0;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .container {
            background:transparent;
            padding: 30px 40px;
            border-radius: 10px;
            max-width: 700px;
            width: 100%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #d35400;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: white;
            line-height: 1.7;
            margin-bottom: 25px;
        }

        form {
            text-align: left;
            margin-top: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin: 10px 0 5px;
            font-size:  #d35400;
            color:goldenrod;
        }

        input, select {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .donor-button {
            width: 100%;
            background-color: #e67e22;
            color: #fff;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .donor-button:hover {
            background-color: #d35400;
        }

        .message {
            font-size: 16px;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 6px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Lungs Donation Awareness</h1>

        <p>
          Lungs awareness involves understanding the vital role lungs play in delivering oxygen to the body and removing carbon dioxide, 
          recognizing how to protect them from harm (such as air pollution and smoking), and promoting healthy habits like exercise 
          and vaccination to prevent illness.
        </p>

        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, '✅') !== false ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <h2>Register as a Lung Donor</h2>
        <form method="POST" action="">
            <label for="name">Full Name:</label>
            <input type="text" name="name" id="name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="phone">Phone:</label>
            <input type="text" name="phone" id="phone" required>

            <label for="age">Age:</label>
            <input type="number" name="age" id="age" min="18" max="65" required>

            <label for="gender">Gender:</label>
            <select name="gender" id="gender" required>
                <option value="">--Select--</option>
                <option>Male</option>
                <option>Female</option>
                <option>Other</option>
            </select>
            <button type="submit" class="donor-button"><a href="donorform.php">Register as Lungs Donor</a></button>
   
        </form>
    </div>

</body>
</html>
