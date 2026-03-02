<?php
include("db.php");

// --- Handle Form Submission ---
$successMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $age       = $_POST['age'];
    $gender    = $_POST['gender'];
    $email     = $_POST['email'];
    $phone     = $_POST['phone'];
    $city      = $_POST['city'];

    $sql = "INSERT INTO heart_donors (full_name, age, gender, email, phone, city) 
            VALUES ('$full_name', '$age', '$gender', '$email', '$phone', '$city')";

    if ($conn->query($sql) === TRUE) {
        $successMessage = "❤️ Thank you for registering as a heart donor!";
    } else {
        $successMessage = "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Heart Donation Awareness</title>
    <style>
        /* 🌟 Internal CSS */
        body {
            font-family: 'Segoe UI', sans-serif;
            background:url('heart1.jpg');
            margin: 0;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .container {
            background: transparent;
            padding: 30px 40px;
            border-radius: 10px;
            max-width: 700px;
            width: 100%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color:  #e74c3c;
            margin-bottom: 25px;
        }

        p {
            font-size: 16px;
            color: white;
            line-height: 1.7;
            margin-bottom: 30px;
        }

        .success {
            background:wheat;
            color: #155724;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        form {
            text-align: left;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            color:goldenrod;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }

        input:focus, select:focus {
            border-color: #c0392b;
            outline: none;
        }

        .submit-btn {
            display: block;
            width: 100%;
            background-color: #e74c3c;
            color: #fff;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            margin-top: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .submit-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Heart Donation Awareness</h1>

    <p>
        The heart is the vital organ responsible for pumping blood throughout the body, supplying oxygen and nutrients to tissues. 
        Heart transplants are often the only hope for patients with end-stage heart failure or severe heart disease. 
        While heart donation can only occur from deceased donors, it remains one of the most precious and life-saving gifts a person can give. 
        Each heart donor offers a second chance at life for someone waiting desperately for a transplant.
    </p>

    <?php if ($successMessage): ?>
        <div class="success"><?= $successMessage ?></div>
    <?php endif; ?>

    <!-- ❤️ Heart Donor Registration Form -->
    <form method="POST" action="">
        <label>Full Name</label>
        <input type="text" name="full_name" placeholder="Enter your full name" required>

        <label>Age</label>
        <input type="number" name="age" placeholder="Enter your age" required>

        <label>Gender</label>
        <select name="gender" required>
            <option value="">-- Select --</option>
            <option>Male</option>
            <option>Female</option>
            <option>Other</option>
        </select>

        <label>Email</label>
        <input type="email" name="email" placeholder="Enter your email" required>

        <label>Phone Number</label>
        <input type="text" name="phone" placeholder="Enter your phone number" required>

        <label>City</label>
        <input type="text" name="city" placeholder="Enter your city" required>

        <button type="submit" class="submit-btn"><a href="donorform.php">Register as Heart Donor</a></button>
              
    </form>
</div>

</body>
</html>
