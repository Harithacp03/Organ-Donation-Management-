<?php include 'db.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $blood = $_POST['blood'];
    $organ = $_POST['organ'];
    $city = $_POST['city'];
    $contact = $_POST['contact'];
    $status = $_POST['status'];
    $message = $_POST['message'];

    $sql = "INSERT INTO recipients (name, age, gender, blood_group, organ_needed, city, contact, status, message) 
            VALUES ('$name', '$age', '$gender', '$blood', '$organ', '$city', '$contact', '$status', '$message')";

    if ($conn->query($sql) === TRUE) {
        header("Location: recipient.php"); // Redirect after form submission
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recipient Registration - Organ Donation</title>
  <style>
    body { margin: 0; font-family: Arial, Helvetica, sans-serif; background: #f4f6f9; color: #333; }
    header { background: #008080; padding: 15px 50px; display: flex; justify-content: space-between; align-items: center; color: white; }
    header h1 { margin: 0; font-size: 22px; letter-spacing: 1px; }
    nav a { color: white; text-decoration: none; margin-left: 20px; font-weight: bold; }
    nav a:hover { text-decoration: underline; }
    .form-container { width: 500px; max-width: 90%; margin: 40px auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 6px 15px rgba(0,0,0,0.1); }
    .form-container h2 { text-align: center; margin-bottom: 25px; color: #008080; }
    label { font-weight: bold; display: block; margin: 10px 0 5px; }
    input, select, textarea { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; margin-bottom: 15px; font-size: 14px; }
    input:focus, select:focus, textarea:focus { border-color: #008080; outline: none; box-shadow: 0 0 6px rgba(0,128,128,0.3); }
    .btn { width: 100%; background: #ff6b6b; color: white; padding: 14px; border: none; border-radius: 25px; font-size: 16px; cursor: pointer; transition: background 0.3s ease; }
    .btn:hover { background: #e63946; }
    footer { background: #222; color: #bbb; text-align: center; padding: 20px; margin-top: 40px; }
  </style>
</head>
<body>
  <header>
    <h1>💌LifeGift - Organ Donation</h1>
    <nav>
      <a href="homepage.html">Home</a>
      <a href="recipient.php">Recipients</a>
      <a href="recipientform.php">Recipient Register</a>
    </nav>
  </header>

  <div class="form-container">
    <h2>Recipient Registration Form</h2>
    <form method="POST" action="">
      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" required>

      <label for="age">Age</label>
      <input type="number" id="age" name="age" required>

      <label for="gender">Gender</label>
      <select id="gender" name="gender" required>
        <option value="">-- Select Gender --</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
      </select>

      <label for="blood">Blood Group</label>
      <select id="blood" name="blood" required>
        <option value="">-- Select Blood Group --</option>
        <option>O+</option><option>O-</option><option>A+</option><option>A-</option>
        <option>B+</option><option>B-</option><option>AB+</option><option>AB-</option>
      </select>

      <label for="organ">Organ Needed</label>
      <select id="organ" name="organ" required>
        <option value="">-- Select Organ --</option>
        <option>Kidney</option><option>Liver</option><option>Heart</option><option>Lungs</option><option>Eyes</option>
      </select>

      <label for="city">City</label>
      <input type="text" id="city" name="city" required>

      <label for="contact">Contact Number</label>
      <input type="tel" id="contact" name="contact" required>

      <label for="status">Current Health Status</label>
      <select id="status" name="status" required>
        <option value="">-- Select Status --</option>
        <option>Waiting</option><option>Matched</option><option>Critical</option>
      </select>

      <label for="message">Additional Notes (Optional)</label>
      <textarea id="message" name="message" rows="4"></textarea>

      <button type="submit" class="btn">Submit Application</button>
    </form>
  </div>

  <footer>
    <p>&copy; 2025 LifeGift - Organ Donation Management</p>
    <p>Together, we give hope ❤️</p>
  </footer>
</body>
</html>
