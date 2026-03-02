<?php
include("db.php");

// ---------- FORM SUBMISSION ----------
$message = "";
if (isset($_POST['submit'])) {
    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $phone  = $_POST['phone'];
    $blood  = $_POST['blood'];
    $age    = $_POST['age'];

    $sql = "INSERT INTO liver_donors (name, email, phone, blood_group, age) 
            VALUES ('$name', '$email', '$phone', '$blood', '$age')";
    if ($conn->query($sql) === TRUE) {
        $message = "✅ Thank you, $name! Your registration was successful.";
    } else {
        $message = "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Liver Donation Awareness & Registration</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background:url('liver2.jpg');
            margin: 0;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .container {
            background-color:transparent;
            padding: 30px 40px;
            border-radius: 10px;
            max-width: 800px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #2e8b57;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color:white;
            line-height: 1.7;
            margin-bottom: 30px;
        }

        form {
            text-align: left;
            margin-top: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin: 10px 0 5px;
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
            background-color: #28a745;
            color: #fff;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .donor-button:hover {
            background-color: #218838;
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
        <h1>Liver Donation Awareness</h1>

        <p>
            The liver is one of the most vital organs in the human body, responsible for over 500 essential functions including detoxifying harmful substances, producing bile for digestion, and storing energy. 
            Liver donation can be life-saving for individuals suffering from liver failure or chronic liver disease. 
            Living liver donation is possible because the liver can regenerate, making it unique among organs. 
            By becoming a liver donor, you have the chance to give someone a second chance at life.
        </p>

        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, '✅') !== false ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <h2>Register as a Liver Donor</h2>
        <form method="POST" action="">
            <label for="name">Full Name:</label>
            <input type="text" name="name" id="name" required>

            <label for="email">Email Address:</label>
            <input type="email" name="email" id="email" required>

            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" id="phone" required>

            <label for="blood">Blood Group:</label>
            <select name="blood" id="blood" required>
                <option value="">-- Select Blood Group --</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
            </select>

            <label for="age">Age:</label>
            <input type="number" name="age" id="age" min="18" max="65" required>
            <button type="submit" class="donor-button"><a href="donorform.php">Register as liver Donor</a></button>
            
        </form>
    </div>

</body>
</html>
