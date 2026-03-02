<?php
include("db.php");

// ---- Handle Form Submission ----
$successMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $age       = $_POST['age'];
    $gender    = $_POST['gender'];
    $email     = $_POST['email'];
    $phone     = $_POST['phone'];
    $city      = $_POST['city'];

    // Insert into database
    $sql = "INSERT INTO eye_donors (full_name, age, gender, email, phone, city) 
            VALUES ('$full_name', '$age', '$gender', '$email', '$phone', '$city')";

    if ($conn->query($sql) === TRUE) {
        $successMessage = "🎉 Thank you for registering as an eye donor!";
    } else {
        $successMessage = "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Eye Donation Awareness</title>
    <style>
        /* 🌟 Internal CSS Styling */
        body {
            font-family: 'Segoe UI', sans-serif;
            background:url('eye1.jpg');
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
            color: black;
            margin-bottom: 25px;
            font-size: 32px;
        }

        p {
            font-size: 16px;
            color:white;
            line-height: 1.7;
            margin-bottom: 30px;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: bold;
            text-align: center;
        }

        form {
            text-align: left;
        }

        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
            color: goldenrod;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            box-sizing: border-box;
        }

        input:focus, select:focus {
            border-color: #1e90ff;
            outline: none;
        }

        .submit-btn {
            display: block;
            width: 100%;
            background-color: #007bff;
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
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Eye Donation Awareness</h1>

    <p>
        Eye donation is a noble act that can restore vision to individuals suffering from corneal blindness. 
        Only the cornea, the clear front part of the eye, is transplanted — not the entire eye. 
        One eye donor can help up to two people regain their sight. Eye donation is usually done after death 
        and must be performed within a few hours. By pledging your eyes, you can give someone the precious 
        gift of vision and a new perspective on life.
    </p>

    <?php if ($successMessage): ?>
        <div class="success"><?= $successMessage ?></div>
    <?php endif; ?>

    <!-- ✅ Eye Donor Registration Form -->
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
        <button type="submit" class="submit-btn"><a href="donorform.php">Register as Eye Donor</a></button>
      
    </form>
</div>

</body>
</html>
