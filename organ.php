<?php
include("db.php");

// ---------- FETCH DONOR COUNTS ----------
$organs = ['heart', 'kidney', 'liver', 'lungs', 'eye'];
$counts = [];

foreach ($organs as $organ) {
    $table = $organ . "_donors"; // table names: heart_donors, kidney_donors, etc.
    $result = $conn->query("SELECT COUNT(*) as total FROM $table");
    $row = $result->fetch_assoc();
    $counts[$organ] = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Organ Donor Statistics - LifeGift</title>
<style>
body {
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    background: #f4f6f9;
    color: #333;
    margin: 0;
    padding: 20px;
}

h1 {
    text-align: center;
    color: #008080;
    margin-bottom: 40px;
}

table {
    width: 80%;
    margin: auto;
    border-collapse: collapse;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    background: white;
}

th, td {
    padding: 15px 20px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #008080;
    color: white;
    font-size: 18px;
}

tr:hover {
    background-color: #f1f1f1;
}

.caption {
    font-size: 20px;
    margin-bottom: 15px;
    text-align: center;
    color: #333;
}
</style>
</head>
<body>

<h1>Registered Organ Donors</h1>
<div class="caption">Current Count of Donors per Organ</div>

<table>
    <tr>
        <th>Organ</th>
        <th>Number of Donors</th>
    </tr>
    <tr>
        <td>Heart</td>
        <td><?php echo $counts['heart']; ?></td>
    </tr>
    <tr>
        <td>Kidney</td>
        <td><?php echo $counts['kidney']; ?></td>
    </tr>
    <tr>
        <td>Liver</td>
        <td><?php echo $counts['liver']; ?></td>
    </tr>
    <tr>
        <td>Lungs</td>
        <td><?php echo $counts['lungs']; ?></td>
    </tr>
    <tr>
        <td>Eye</td>
        <td><?php echo $counts['eye']; ?></td>
    </tr>
</table>

</body>
</html>
