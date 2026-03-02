<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recipients - Organ Donation</title>
  <style>
    body { margin: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f4f6f9; color: #333; }
    header { background: #008080; padding: 15px 50px; display: flex; justify-content: space-between; align-items: center; color: white; }
    header h1 { margin: 0; font-size: 22px; letter-spacing: 1px; }
   
    .page-title { text-align: center; margin: 40px 0 20px 0; color: #008080; font-size: 28px; }
    .recipient-table { width: 85%; margin: auto; border-collapse: collapse; background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; }
    .recipient-table th, .recipient-table td { padding: 15px; text-align: center; border-bottom: 1px solid #ddd; }
    .recipient-table th { background: #008080; color: white; font-size: 16px; }
    .recipient-table tr:hover { background: #f1f1f1; }
    .btn-container { text-align: center; margin-top: 30px; }
    .btn { background: #ff6b6b; color: white; padding: 12px 25px; border: none; border-radius: 25px; font-size: 16px; cursor: pointer; text-decoration: none; transition: background 0.3s ease; }
    .btn:hover { background: #e63946; }
    footer { background: #222; color: #bbb; text-align: center; padding: 20px; margin-top: 40px; }
  </style>
</head>
<body>
  <header>
    <h1>💌LifeGift - Organ Donation</h1>
    
  </header>

  <h2 class="page-title">Registered Organ Recipients</h2>

  <table class="recipient-table">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Age</th>
      <th>Gender</th>
      <th>Blood Group</th>
      <th>Organ Needed</th>
      <th>City</th>
      <th>Contact</th>
      <th>Status</th>
    </tr>
    <?php
    $sql = "SELECT * FROM recipients ORDER BY id DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row['id']."</td>
                    <td>".$row['name']."</td>
                    <td>".$row['age']."</td>
                    <td>".$row['gender']."</td>
                    <td>".$row['blood_group']."</td>
                    <td>".$row['organ_needed']."</td>
                    <td>".$row['city']."</td>
                    <td>".$row['contact']."</td>
                    <td>".$row['status']."</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='9'>No recipients registered yet.</td></tr>";
    }
    ?>
  </table>

  <div class="btn-container">
    <a href="recipientform.php" class="btn">Apply as Recipient</a>
  </div>

  <footer>
    <p>&copy; 2025 LifeGift - Organ Donation Management</p>
    <p>Hope begins with every donor ❤️</p>
  </footer>
</body>
</html>
