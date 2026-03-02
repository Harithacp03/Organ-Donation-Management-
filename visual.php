<?php
include("db.php"); // Your DB connection file

// ----------- 1️⃣ BLOOD DONORS -----------
$sql1 = "SELECT id FROM blood_donors ORDER BY id ASC";
$res1 = $conn->query($sql1);
$blood_ids = $blood_counts = [];
$count = 0;
if ($res1 && $res1->num_rows > 0) {
    while ($row = $res1->fetch_assoc()) {
        $count++;
        $blood_ids[] = $row['id'];
        $blood_counts[] = $count;
    }
}

// ----------- 2️⃣ ORGAN DONORS -----------
$sql2 = "SELECT donor_id FROM donors ORDER BY donor_id ASC";
$res2 = $conn->query($sql2);
$organ_ids = $organ_counts = [];
$count = 0;
if ($res2 && $res2->num_rows > 0) {
    while ($row = $res2->fetch_assoc()) {
        $count++;
        $organ_ids[] = $row['donor_id'];
        $organ_counts[] = $count;
    }
}

// ----------- 3️⃣ RECIPIENTS -----------
$sql3 = "SELECT id FROM recipients ORDER BY id ASC";
$res3 = $conn->query($sql3);
$recipient_ids = $recipient_counts = [];
$count = 0;
if ($res3 && $res3->num_rows > 0) {
    while ($row = $res3->fetch_assoc()) {
        $count++;
        $recipient_ids[] = $row['id'];
        $recipient_counts[] = $count;
    }
}

// ----------- 4️⃣ USERS -----------
$sql4 = "SELECT id FROM users ORDER BY id ASC";
$res4 = $conn->query($sql4);
$user_ids = $user_counts = [];
$count = 0;
if ($res4 && $res4->num_rows > 0) {
    while ($row = $res4->fetch_assoc()) {
        $count++;
        $user_ids[] = $row['id'];
        $user_counts[] = $count;
    }
}
// Count donors per organ
$counts = [
    'heart' => 0,
    'kidney' => 0,
    'liver' => 0,
    'lungs' => 0,
    'eye' => 0
];

$sqlOrgans = "SELECT organ, COUNT(*) as count FROM donors GROUP BY organ";
$resOrgans = $conn->query($sqlOrgans);
if ($resOrgans && $resOrgans->num_rows > 0) {
    while ($row = $resOrgans->fetch_assoc()) {
        $counts[strtolower($row['organ'])] = $row['count'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>📊 Donation System - Visualization Dashboard</title>
<style>
/* ---------- Global Styles ---------- */
body {
    margin: 0;
    padding: 0;
    font-family: "Segoe UI", Arial, sans-serif;
    background: linear-gradient(135deg, #141e30, #243b55);
    color: #fff;
}
h1 {
    text-align: center;
    margin-top: 30px;
    font-size: 42px;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    animation: fadeIn 1.5s ease-in-out;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ---------- Dashboard Layout ---------- */
.container {
    width: 90%;
    max-width: 1200px;
    margin: 40px auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

.chart-card {
    background: rgba(255,255,255,0.06);
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.4);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.chart-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.6);
}

.chart-card h2 {
    text-align: center;
    font-size: 24px;
    margin-bottom: 20px;
    color: #f8f9fa;
    letter-spacing: 1px;
}

canvas {
    width: 100%;
    height: 350px;
}

/* ---------- Footer ---------- */
footer {
    text-align: center;
    margin: 40px 0;
    font-size: 14px;
    color: #aaa;
    letter-spacing: 0.5px;
}
</style>
</head>
<body>

<h1>📈 Registration Trends Dashboard</h1>

<div class="container">
    <div class="chart-card">
        <h2>🩸 Blood Donors</h2>
        <canvas id="bloodChart"></canvas>
    </div>

    <div class="chart-card">
        <h2>🫀 Organ Donors</h2>
        <canvas id="organChart"></canvas>
    </div>

    <div class="chart-card">
        <h2>👤 Recipients</h2>
        <canvas id="recipientChart"></canvas>
    </div>

    <div class="chart-card">
        <h2>👥 Users</h2>
        <canvas id="userChart"></canvas>
    </div>
    <div class="chart-card">
    <h2>🫀 Organ Donors by Organ</h2>
    <canvas id="organDonutChart"></canvas>
</div>

</div>

<footer>© <?php echo date("Y"); ?> Organ & Blood Donation System. All rights reserved.</footer>

<script src="https://cdn.jsdelivr.net/npm/chart.js">
</script>
<script>
// Pass PHP data to JS
const bloodIDs = <?php echo json_encode($blood_ids); ?>;
const bloodCounts = <?php echo json_encode($blood_counts); ?>;

const organIDs = <?php echo json_encode($organ_ids); ?>;
const organCounts = <?php echo json_encode($organ_counts); ?>;

const recipientIDs = <?php echo json_encode($recipient_ids); ?>;
const recipientCounts = <?php echo json_encode($recipient_counts); ?>;

const userIDs = <?php echo json_encode($user_ids); ?>;
const userCounts = <?php echo json_encode($user_counts); ?>;

const organLabels = ["Heart", "Kidney", "Liver", "Lungs", "Eye"];
const organData = [
    <?php echo $counts['heart']; ?>,
    <?php echo $counts['kidney']; ?>,
    <?php echo $counts['liver']; ?>,
    <?php echo $counts['lungs']; ?>,
    <?php echo $counts['eye']; ?>];

// Shared chart options
const chartOptions = {
    responsive: true,
    scales: {
        x: {
            title: { display: true, text: "Registration Order", color: "#fff" },
            ticks: { color: "#ccc" }
        },
        y: {
            beginAtZero: true,
            title: { display: true, text: "Cumulative Count", color: "#fff" },
            ticks: { color: "#ccc" }
        }
    },
    plugins: {
        legend: { labels: { color: "#fff" } }
    }
};

// 🩸 Blood Donors Chart
new Chart(document.getElementById("bloodChart"), {
    type: "line",
    data: {
        labels: bloodIDs,
        datasets: [{
            label: "Blood Donors",
            data: bloodCounts,
            borderColor: "#e63946",
            backgroundColor: "#ff6b6b",
            tension: 0.3,
            pointRadius: 4,
            pointBackgroundColor: "#fff"
        }]
    },
    options: chartOptions
});

// 🫀 Organ Donors Chart
new Chart(document.getElementById("organChart"), {
    type: "line",
    data: {
        labels: organIDs,
        datasets: [{
            label: "Organ Donors",
            data: organCounts,
            borderColor: "#2a9d8f",
            backgroundColor: "#52b788",
            tension: 0.3,
            pointRadius: 4,
            pointBackgroundColor: "#fff"
        }]
    },
    options: chartOptions
});

// 👤 Recipients Chart
new Chart(document.getElementById("recipientChart"), {
    type: "line",
    data: {
        labels: recipientIDs,
        datasets: [{
            label: "Recipients",
            data: recipientCounts,
            borderColor: "#f4a261",
            backgroundColor: "#e9c46a",
            tension: 0.3,
            pointRadius: 4,
            pointBackgroundColor: "#fff"
        }]
    },
    options: chartOptions
});

// 👥 Users Chart
new Chart(document.getElementById("userChart"), {
    type: "line",
    data: {
        labels: userIDs,
        datasets: [{
            label: "Users",
            data: userCounts,
            borderColor: "#4361ee",
            backgroundColor: "#4895ef",
            tension: 0.3,
            pointRadius: 4,
            pointBackgroundColor: "#fff"
        }]
    },
    options: chartOptions
});


new Chart(document.getElementById("organDonutChart"), {
    type: 'doughnut',
    data: {
        labels: organLabels,
        datasets: [{
            data: organData,
            backgroundColor: ['#e63946', '#f4a261', '#2a9d8f', '#4361ee', '#8ac926'],
            borderColor: '#141e30',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'right', labels: { color: '#fff' } },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `${context.label}: ${context.raw}`;
                    }
                }
            }
        }
    }
});
</script>



</body>
</html>
