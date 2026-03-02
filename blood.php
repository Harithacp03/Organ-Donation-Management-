<?php
 include("db.php");


// ----------- HANDLE FORM SUBMISSION ------------
$successMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname     = $_POST['fullname'];
    $dob          = $_POST['dob'];
    $age          = $_POST['age'];
    $gender       = $_POST['gender'];
    $bloodgroup   = $_POST['bloodgroup'];
    $weight       = $_POST['weight'];
    $phone        = $_POST['phone'];
    $email        = $_POST['email'];
    $address      = $_POST['address'];
    $city         = $_POST['city'];
    $state        = $_POST['state'];
    $pincode      = $_POST['pincode'];
    $lastdonation = $_POST['lastdonation'];
    $medical      = $_POST['medical'];

    $sql = "INSERT INTO blood_donors
        (fullname, dob, age, gender, bloodgroup, weight, phone, email, address, city, state, pincode, lastdonation, medical) 
        VALUES 
        ('$fullname','$dob','$age','$gender','$bloodgroup','$weight','$phone','$email','$address','$city','$state','$pincode','$lastdonation','$medical')";

    if ($conn->query($sql) === TRUE) {
        $successMessage = "🎉 Thank you! Your blood donation registration is successful.";
    } else {
        $successMessage = "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Blood Donation Registration</title>
<style>
body {
    margin: 0;
    font-family: "Segoe UI", sans-serif;
    background: url('blood.jpg');
    color: #fff;
}
header{
    color:white;
    padding:20px 40px;
    text-align:center;
}
h1,h2{
    text-align: center;
    margin: 15px 0;
    font-weight: bold;
}
.container {
    max-width: 900px;
    margin: 20px auto;
    padding: 25px 30px;
    background: #161b22;
    border-radius: 12px;
    box-shadow: 0 0 18px rgba(255, 0, 0, 0.25);
}

/* Blood Donation Info */
.info-box {
    background: #0d1117;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 25px;
    color: #ddd;
}
.info-box h2 {
    color: #e63946;
    margin-bottom: 10px;
}
.info-box ul {
    list-style: none;
    padding-left: 0;
}
.info-box ul li {
    margin-bottom: 8px;
    font-size: 14px;
}

/* Form Styling */
form {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
.full-width { grid-column: span 2; }
label { display: block; font-size: 14px; margin-bottom: 5px; }
input, select, textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #e63946;
    border-radius: 6px;
    background: #0d1117;
    color: #fff;
    font-size: 14px;
}
input:focus, select:focus, textarea:focus { outline: none; border-color: #ff4757; }
.gender-options { display: flex; gap: 15px; margin-top: 8px; font-size: 14px; }
.checkbox { display: flex; align-items: flex-start; gap: 8px; font-size: 14px; margin-top: 10px; }
.actions { grid-column: span 2; display: flex; justify-content: center; gap: 20px; margin-top: 20px; }
.btn { padding: 10px 20px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 14px; }
.btn-submit { background: #e63946; color: #fff; }
.btn-clear { background: #333; color: #fff; }
.btn-submit:hover { background: #ff4757; }
.btn-clear:hover { background: #555; }
.success { background: #2ecc71; color: #fff; padding: 10px; text-align:center; border-radius:6px; margin-bottom: 15px; }
</style>
</head>
<body>
<header><h1>Blood Donation</h1></header>

<div class="container">

<!-- Blood Donation Process Info -->
<div class="info-box">
<h2>💉 Blood Donation Process</h2>
<ul>
<li>Registration and Medical Screening.</li>
<li>Donation (approximately 450 ml of blood).</li>
<li>Rest and Refreshments after donation.</li>
<li>Blood tested for safety and processed for use.</li>
<li>Help save up to 3 lives with a single donation!</li>
</ul>

<h2>🩸 Blood Group Types</h2>
<ul>
<li>A+</li><li>A-</li><li>B+</li><li>B-</li>
<li>AB+</li><li>AB-</li><li>O+</li><li>O-</li>
</ul>
</div>

<!-- Success Message -->
<?php if($successMessage): ?>
    <div class="success"><?php echo $successMessage; ?></div>
<?php endif; ?>

<!-- Registration Form -->
<h2>Blood Donation Registration Form</h2>
<form method="post" action="">
<div>
<label>Full Name *</label>
<input type="text" name="fullname" required>
</div>
<div>
<label>Date of Birth *</label>
<input type="date" name="dob" required>
</div>
<div>
<label>Age *</label>
<input type="number" name="age" min="18" max="65" required>
</div>
<div>
<label>Gender *</label>
<div class="gender-options">
<label><input type="radio" name="gender" value="Female" required> Female</label>
<label><input type="radio" name="gender" value="Male" required> Male</label>
<label><input type="radio" name="gender" value="Other" required> Other</label>
</div>
</div>
<div>
<label>Blood Group *</label>
<select name="bloodgroup" required>
<option value="">Select</option>
<option>A+</option><option>A-</option><option>B+</option><option>B-</option>
<option>AB+</option><option>AB-</option><option>O+</option><option>O-</option>
</select>
</div>
<div>
<label>Weight (kg) *</label>
<input type="number" name="weight" step="0.1" required>
</div>
<div>
<label>Phone Number *</label>
<input type="text" name="phone" required>
</div>
<div>
<label>Email *</label>
<input type="email" name="email" required>
</div>
<div class="full-width">
<label>Address *</label>
<input type="text" name="address" required>
</div>
<div>
<label>City *</label>
<input type="text" name="city" required>
</div>
<div>
<label>State *</label>
<input type="text" name="state" required>
</div>
<div>
<label>Pincode *</label>
<input type="text" name="pincode" required>
</div>
<div>
<label>Last Donation Date</label>
<input type="date" name="lastdonation">
</div>
<div class="full-width">
<label>Medical Conditions</label>
<textarea name="medical" rows="2"></textarea>
</div>
<div class="checkbox full-width">
<input type="checkbox" name="consent" required>
<label>I consent to share my data for blood donation purposes *</label>
</div>
<div class="actions">
<button type="submit" class="btn btn-submit">Submit</button>
<button type="reset" class="btn btn-clear">Clear</button>
<a href="bloodlist.php">view</a>
</div>
</form>
</div>
</body>
</html>
