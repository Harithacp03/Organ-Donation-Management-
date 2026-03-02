<?php include("db.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Donor Registration - Organ Donation</title>
  <style>
    body { font-family: Arial, sans-serif; background:#f4f6f9; margin:0; }
    header { background:#008080; padding:15px 50px; display:flex; justify-content:space-between; color:white; }
    nav a { color:white; text-decoration:none; margin-left:20px; font-weight:bold; }
    nav a:hover { text-decoration:underline; }
    .form-container { width:500px; max-width:90%; margin:40px auto; background:white; padding:30px; border-radius:12px; box-shadow:0 6px 15px rgba(0,0,0,0.1); }
    .form-container h2 { text-align:center; margin-bottom:25px; color:#008080; }
    label { font-weight:bold; display:block; margin:10px 0 5px; }
    input, select, textarea { width:100%; padding:12px; margin-bottom:15px; border:1px solid #ccc; border-radius:6px; }
    .btn { width:100%; background:#ff6b6b; color:white; padding:14px; border:none; border-radius:25px; font-size:16px; cursor:pointer; }
    .btn:hover { background:#e63946; }
  </style>
</head>
<body>

<header>
  <h1>💌LifeGift - Organ Donation</h1>
  <nav>
    <a href="homepage.html">Home</a>
    <a href="donor.php">Donors</a>
    <a href="donorform.php">Register</a>
  </nav>
</header>

<div class="form-container">
  <h2>Donor Registration Form</h2>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $name = $_POST['name'];
      $age = $_POST['age'];
      $gender = $_POST['gender'];
      $blood = $_POST['blood'];
      $organ = $_POST['organ'];
      $city = $_POST['city'];
      $contact = $_POST['contact'];
      $message = $_POST['message'];

      $sql = "INSERT INTO donors (name, age, gender, blood_group, organ, city, contact, message)
              VALUES ('$name','$age','$gender','$blood','$organ','$city','$contact','$message')";

      if ($conn->query($sql) === TRUE) {
          echo "<p style='color:green; text-align:center;'>Registration successful! <a href='donor.php'>View Donors</a></p>";
      } else {
          echo "<p style='color:red; text-align:center;'>Error: " . $conn->error . "</p>";
      }
  }
  ?>

  <form method="POST" action="">
    <label>Full Name</label>
    <input type="text" name="name" required>

    <label>Age</label>
    <input type="number" name="age" required>

    <label>Gender</label>
    <select name="gender" required>
      <option value="">-- Select Gender --</option>
      <option>Male</option>
      <option>Female</option>
      <option>Other</option>
    </select>

    <label>Blood Group</label>
    <select name="blood" required>
      <option value="">-- Select Blood Group --</option>
      <option>O+</option><option>O-</option>
      <option>A+</option><option>A-</option>
      <option>B+</option><option>B-</option>
      <option>AB+</option><option>AB-</option>
    </select>

    <label>Organ to Donate</label>
    <select name="organ" required>
      <option value="">-- Select Organ --</option>
      <option>Kidney</option><option>Liver</option><option>Heart</option>
      <option>Lungs</option><option>Eyes</option>
    </select>

    <label>City</label>
    <input type="text" name="city" required>

    <label>Contact Number</label>
    <input type="tel" name="contact" required>

    <label>Additional Notes (Optional)</label>
    <textarea name="message" rows="3"></textarea>

    <button type="submit" class="btn">Submit Registration</button>
  </form>
</div>

</body>
</html>
