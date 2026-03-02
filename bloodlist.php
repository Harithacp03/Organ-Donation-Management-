<?php include("db.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bloodlist Page - Organ Donation</title>
  <style>
    body { margin:0; font-family:Arial,Helvetica,sans-serif; background:#f4f6f9; color:#333; }
    header { background:#008080; padding:15px 50px; display:flex; justify-content:space-between; align-items:center; color:white; }
    nav a { color:white; text-decoration:none; margin-left:20px; font-weight:bold; }
    nav a:hover { text-decoration:underline; }
    .page-title { text-align:center; margin:40px 0 20px; color:#008080; font-size:28px; }
    table { width:90%; margin:auto; border-collapse:collapse; background:white; box-shadow:0 4px 12px rgba(0,0,0,0.1); }
    th, td { padding:15px; text-align:center; border-bottom:1px solid #ddd; }
    th { background:#008080; color:white; }
    tr:hover { background:#f1f1f1; }
    .btn { display:inline-block; margin:30px auto; background:#ff6b6b; color:white; padding:12px 25px; border:none; border-radius:25px; font-size:16px; text-decoration:none; }
    .btn:hover { background:#e63946; }
    .btn-container { text-align:center; }
    
  </style>
</head>
<body>

<header>
  <h1>LifeGift - Blood Donation</h1>
  <nav>
    <a href="homepage.html">Home</a>
    <a href="blood.php">Donors</a>
    <a href="bloodlist.php">view</a>
  </nav>
</header>

<h2 class="page-title">Registered Blood Donors</h2>

<table>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Age</th>
    <th>Gender</th>
    <th>Blood Group</th>
    <th>City</th>
  </tr>

  <?php
  $sql = "SELECT * FROM blood_donors ORDER BY id DESC";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
          echo "<tr>
                  <td>".$row['id']."</td>
                  <td>".$row['fullname']."</td>
                  <td>".$row['age']."</td>
                  <td>".$row['gender']."</td>
                  <td>".$row['bloodgroup']."</td>
                  <td>".$row['city']."</td>
                 
                </tr>";
 
      }
  } else {
      echo "<tr><td colspan='9'>No blood donors registered yet</td></tr>";
  }
  ?>
</table>

<div class="btn-container">
  <a href="blood.php" class="btn">Register as a  Blood Donor</a>
</div>

</body>
</html>
