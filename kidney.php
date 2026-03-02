<?php
include("db.php");

// ---------- Handle Form Submission ----------
$success = "";
if (isset($_POST['submit'])) {
    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $phone  = $_POST['phone'];
    $age    = $_POST['age'];
    $gender = $_POST['gender'];
    $blood  = $_POST['blood'];
    $city   = $_POST['city'];

    $sql = "INSERT INTO kidney_donors (name, email, phone, age, gender, blood_group, city) 
            VALUES ('$name', '$email', '$phone', '$age', '$gender', '$blood', '$city')";

    if ($conn->query($sql) === TRUE) {
        $success = "✅ Thank you for registering as a Kidney Donor!";
    } else {
        $success = "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kidney Donation Awareness</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background:url('kidney1.jpg');
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .container {
            background-color: transparent;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            width: 100%;
            margin-top: 30px;
        }

        h1 {
            color: goldenrod;
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: white;
            line-height: 1.6;
            text-align: center;
            margin-bottom: 25px;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        form {
            width: 100%;
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color:goldenrod;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 15px;
        }

        .submit-btn {
            background-color:goldenrod;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: goldenrod;
        }

        .section-title {
            font-size: 20px;
            margin-top: 30px;
            margin-bottom: 15px;
            text-align: center;
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            display: inline-block;
            padding-bottom: 5px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Kidney Donation Awareness</h1>

        <p>
            The kidneys are vital organs responsible for filtering waste products and excess fluids from the blood. 
            Each person has two kidneys, but it is possible to live a healthy life with just one. Kidney donation, 
            especially from living donors, can save the lives of those suffering from kidney failure or end-stage 
            renal disease. With advancements in medical science, kidney transplants have become a safe and effective 
            treatment. Becoming a kidney donor is a powerful act of generosity that can transform someone's life forever.
        </p>

        <?php if ($success): ?>
            <div class="success"><?= $success ?></div>
        <?php endif; ?>

        <h2 class="section-title">Register as a Kidney Donor</h2>

        <!-- Donor Registration Form -->
        <form method="POST" action="">
            <label>Full Name</label>
            <input type="text" name="name" placeholder="Enter your full name" required>

            <label>Email</label>
            <input type="email" name="email" placeholder="Enter your email" required>

            <label>Phone</label>
            <input type="text" name="phone" placeholder="Enter your phone number" required>

            <label>Age</label>
            <input type="number" name="age" placeholder="Enter your age" required>

            <label>Gender</label>
            <select name="gender" required>
                <option value="">--Select--</option>
                <option>Male</option>
                <option>Female</option>
                <option>Other</option>
            </select>

            <label>Blood Group</label>
            <select name="blood" required>
                <option value="">--Select--</option>
                <option>A+</option>
                <option>A-</option>
                <option>B+</option>
                <option>B-</option>
                <option>O+</option>
                <option>O-</option>
                <option>AB+</option>
                <option>AB-</option>
            </select>

            <label>City</label>
            <input type="text" name="city" placeholder="Enter your city" required>
            <button type="submit" class="submit-btn"><a href="donorform.php">Register as Kidney Donor</a></button>
           
        </form>
    </div>

</body>
</html>
