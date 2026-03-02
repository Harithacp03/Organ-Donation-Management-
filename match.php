<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Donor-Recipient Matches - Organ Donation</title>
  <style>
    body { margin:0; font-family:Arial,Helvetica,sans-serif; background:#f4f6f9; color:#333; }
    header { background:#008080; padding:15px 50px; display:flex; justify-content:space-between; align-items:center; color:white; }
    header h1 { margin:0; font-size:22px; letter-spacing:1px; }
    

    .page-title { text-align:center; margin:40px 0 20px 0; color:#008080; font-size:28px; }

    table { width:90%; margin:auto; border-collapse:collapse; background:white; box-shadow:0 4px 12px rgba(0,0,0,0.1); border-radius:8px; overflow:hidden; }
    th, td { padding:15px; text-align:center; border-bottom:1px solid #ddd; }
    th { background:#008080; color:white; font-size:16px; }
    tr:hover { background:#f1f1f1; }

    .btn-container { text-align:center; margin-top:30px; }
    .btn { background:#ff6b6b; color:white; padding:12px 25px; border:none; border-radius:25px; font-size:16px; cursor:pointer; text-decoration:none; transition: background 0.3s ease; }
    .btn:hover { background:#e63946; }

    footer { background:#222; color:#bbb; text-align:center; padding:20px; margin-top:40px; }
  </style>
</head>
<body>

<header>
  <h1>💌LifeGift - Organ Donation</h1>
 
</header>

<h2 class="page-title">Potential Donor-Recipient Matches</h2>

<table>
  <tr>
    <th>Donor Name</th>
    <th>Recipient Name</th>
    <th>Blood Group</th>
    <th>Organ</th>
    <th>Donor City</th>
    <th>Recipient City</th>
    <th>Status</th>
  </tr>

<?php
// Query to find matches based on organ and blood group

// Helpful during debugging (remove in production)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Your SELECT query
$sql = "SELECT d.name AS donor_name, r.name AS recipient_name, d.blood_group, d.organ, d.city AS donor_city, r.city AS recipient_city, r.status 
        FROM donors d 
        INNER JOIN recipients r 
        ON d.organ = r.organ_needed AND d.blood_group = r.blood_group
        ORDER BY r.status DESC";

// Run query and check for errors
$result = $conn->query($sql);
if ($result === false) {
    // Query failed — show DB error (helpful for debugging)
    echo "<tr><td colspan='7'>Query error: " . htmlspecialchars($conn->error) . "</td></tr>";
} else {
    // Optional: clear previous matches so we don't duplicate on each page load
    // $conn->query("TRUNCATE TABLE matches");

    // Prepare insert (use prepared statement to avoid SQL injection)
    $insert_stmt = $conn->prepare("INSERT INTO matching (donor_name, recipient_name, blood_group, organ, donor_city, recipient_city, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$insert_stmt) {
        echo "<tr><td colspan='7'>Prepare failed: " . htmlspecialchars($conn->error) . "</td></tr>";
    } else {
        if ($result->num_rows > 0) {               // <-- correct property name: num_rows
            while ($row = $result->fetch_assoc()) {
                // Insert match
                $insert_stmt->bind_param(
                    "sssssss",
                    $row['donor_name'],
                    $row['recipient_name'],
                    $row['blood_group'],
                    $row['organ'],
                    $row['donor_city'],
                    $row['recipient_city'],
                    $row['status']
                );
                $insert_stmt->execute();

                // Output table row
                echo "<tr>
                        <td>".htmlspecialchars($row['donor_name'])."</td>
                        <td>".htmlspecialchars($row['recipient_name'])."</td>
                        <td>".htmlspecialchars($row['blood_group'])."</td>
                        <td>".htmlspecialchars($row['organ'])."</td>
                        <td>".htmlspecialchars($row['donor_city'])."</td>
                        <td>".htmlspecialchars($row['recipient_city'])."</td>
                        <td>".htmlspecialchars($row['status'])."</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No matching donors found for any recipient.</td></tr>";
        }
        $insert_stmt->close();
    }

    $result->free();
}
?>

</table>

<div class="btn-container">
  <a href="donor.php" class="btn">View Donors</a>
  <a href="recipient.php" class="btn">View Recipients</a>
</div>

<footer>
  <p>&copy; 2025 LifeGift - Organ Donation Management</p>
  <p>Matching lives, saving lives ❤️</p>
</footer>

</body>
</html>
