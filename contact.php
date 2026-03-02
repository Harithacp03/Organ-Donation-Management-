<?php
include 'db.php';

$message_sent = false;

// Check form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data safely
    $name    = $conn->real_escape_string($_POST['name']);
    $email   = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);
    $city    = $conn->real_escape_string($_POST['city']);

    // Insert into feedbacks table
    $sql = "INSERT INTO contactss (name, email, subject, message, city) 
            VALUES ('$name', '$email', '$subject', '$message', '$city')";

    if ($conn->query($sql) === TRUE) {
        $message_sent = true;
    } else {
        echo "❌ Error inserting feedback: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feedback - Organ Donation</title>
  <style>
    body { margin:0; font-family:Arial,Helvetica,sans-serif; background:url('home.jpg'); color:#333; }
    header { background:#008080; padding:15px 50px; display:flex; justify-content:space-between; align-items:center; color:white; }
    header h1 { margin:0; font-size:22px; letter-spacing:1px; }
    nav a { color:white; text-decoration:none; margin-left:20px; font-weight:bold; }
    nav a:hover { text-decoration:underline; }

    .contact-container { width:600px; max-width:90%; margin:40px auto; background:white; padding:30px; border-radius:12px; box-shadow:0 6px 15px rgba(0,0,0,0.1); }
    .contact-container h2 { text-align:center; margin-bottom:25px; color:#008080; }

    label { font-weight:bold; display:block; margin:10px 0 5px; }
    input, textarea { width:100%; padding:12px; border:1px solid #ccc; border-radius:6px; margin-bottom:15px; font-size:14px; }
    input:focus, textarea:focus { border-color:#008080; outline:none; box-shadow:0 0 6px rgba(0,128,128,0.3); }

    .btn { width:100%; background:#ff6b6b; color:white; padding:14px; border:none; border-radius:25px; font-size:16px; cursor:pointer; transition:0.3s; }
    .btn:hover { background:#e63946; }

    .success-msg { background:#d4edda; color:#155724; padding:12px; border-radius:6px; margin-bottom:15px; text-align:center; }

    footer { background:#222; color:#bbb; text-align:center; padding:20px; margin-top:40px; }
  </style>
</head>
<body>

<header>
  <h1>💌LifeGift - Organ Donation</h1>
  <nav>
    <a href="homepage.html">Home</a>
    <a href="index.html">Donors</a>
    <a href="contact.php">Contact</a>
  </nav>
</header>

<div class="contact-container">
  <h2>Contact Us</h2>

  <?php if ($message_sent): ?>
    <div class="success-msg">✅ Your feedback has been submitted successfully!</div>
  <?php endif; ?>

  <form method="POST" action="">
    <label for="name">Your Name</label>
    <input type="text" id="name" name="name" placeholder="Enter your name" required>

    <label for="email">Your Email</label>
    <input type="email" id="email" name="email" placeholder="Enter your email" required>

    <label for="subject">Subject</label>
    <input type="text" id="subject" name="subject" placeholder="Enter subject" required>

    <label for="message">Feedback Message</label>
    <textarea id="message" name="message" rows="5" placeholder="Write your message here..." required></textarea>
    
    <label for="city">City</label>
    <input type="text" id="city" name="city" placeholder="Enter your city" required>

    <button type="submit" class="btn">Send Feedback</button>
  </form>
</div>

<footer>
  <p>&copy; 2025 LifeGift - Organ Donation Management</p>
  <p>Saving lives through connections ❤️</p>
</footer>

</body>
</html>
