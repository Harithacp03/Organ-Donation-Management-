<?php
// admin_dashboard.php
include 'db.php'; // your DB connection (must set $conn)

// === Aggregate counts ===
$total_donors = $conn->query("SELECT COUNT(*) AS total FROM donors")->fetch_assoc()['total'] ;
$total_recipients = $conn->query("SELECT COUNT(*) AS total FROM recipients")->fetch_assoc()['total'];
$total_matches = $conn->query("SELECT COUNT(*) AS total FROM matching")->fetch_assoc()['total'];
$total_users = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'] ;
$total_feedback = $conn->query("SELECT COUNT(*) AS total FROM contactss")->fetch_assoc()['total'] ;

// === Donors by organ (example pulled from donors table if organ column exists) ===
$organs = ['heart','kidney','liver','lungs','eye'];
$organ_counts = [];
foreach ($organs as $organ) {
    // try both organ-specific tables and `donors` organ column
    // Prefer donors table organ column if your DB stores organ there
    $res = $conn->query("SELECT COUNT(*) AS total FROM donors WHERE LOWER(organ) = '".$conn->real_escape_string($organ)."'");
    if ($res) {
        $row = $res->fetch_assoc();
        $organ_counts[$organ] = intval($row['total']);
    } else {
        // fallback to organ-specific table
        $table = $organ . "_donors";
        $r = @$conn->query("SELECT COUNT(*) AS total FROM $table");
        $organ_counts[$organ] = $r ? intval($r->fetch_assoc()['total']) : 0;
    }
}

// === Dataset for chart: donors vs recipients over months (simple example from created_at if exists) ===
$months = [];
$donor_month_counts = [];
$recipient_month_counts = [];
// Build last 6 months labels
for ($i = 5; $i >= 0; $i--) {
    $label = date('M Y', strtotime("-$i month"));
    $months[] = $label;
    // Assuming `created_at` columns exist with DATETIME
    $m = date('Y-m', strtotime("-$i month"));
    $dres = $conn->query("SELECT COUNT(*) AS total FROM donors ");
    $rres = $conn->query("SELECT COUNT(*) AS total FROM recipients ");
    $donor_month_counts[] = $dres ? intval($dres->fetch_assoc()['total']) : 0;
    $recipient_month_counts[] = $rres ? intval($rres->fetch_assoc()['total']) : 0;
}

// === Fetch table rows (limit for pagination / performance) ===
$donors_result = $conn->query("SELECT donor_id, name, age, gender, blood_group, organ, city FROM donors ORDER BY donor_id DESC LIMIT 100");
$recipients_result = $conn->query("SELECT id, name, age, gender, blood_group, organ_needed, city, status FROM recipients ORDER BY id DESC LIMIT 100");
$blood_donors_result = $conn->query("SELECT id, fullname, age, gender, bloodgroup, city FROM blood_donors ORDER BY id DESC LIMIT 100");
$users_result = $conn->query("SELECT id, username, email FROM users ORDER BY id DESC LIMIT 100");
$contactss_result = $conn->query("SELECT id, name, email, subject, message FROM contactss ORDER BY id DESC LIMIT 100");

// For safe embedding into JS
$js_months = json_encode($months);
$js_donors_month = json_encode($donor_month_counts);
$js_recipients_month = json_encode($recipient_month_counts);
$js_organ_counts = json_encode(array_values($organ_counts));
$js_organs_labels = json_encode(array_map('ucfirst', array_keys($organ_counts)));
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>LifeGift — Admin Dashboard</title>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
  :root{
    --bg:#f4f6f9; --card:#fff; --accent:#0f9d9a; --muted:#6b7280; --text:#0f172a;
    --sidebar:#06343a;
  }
  [data-theme="dark"]{
    --bg:#0b1220; --card:#071226; --accent:#22c1c3; --muted:#94a3b8; --text:#e6eef6; --sidebar:#031018;
  }

  *{box-sizing:border-box}
  body{margin:0;font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial;color:var(--text);background:var(--bg);-webkit-font-smoothing:antialiased}
  .app{display:flex;min-height:100vh}

/* Sidebar */
  .sidebar{
    width:220px;background:linear-gradient(180deg,var(--sidebar), #06343a 60%);color:white;padding:18px 14px;position:fixed;left:0;top:0;bottom:0;display:flex;flex-direction:column;gap:18px;
  }
  .brand{display:flex;align-items:center;gap:10px;font-weight:700}
  .brand .logo{width:42px;height:42px;border-radius:8px;background:linear-gradient(135deg,#15c3be,#066d6c);display:flex;align-items:center;justify-content:center;color:white;font-weight:800}
  nav{display:flex;flex-direction:column;gap:6px;margin-top:6px}
  .nav-item{padding:10px;border-radius:8px;color:rgba(255,255,255,0.9);text-decoration:none;display:flex;justify-content:space-between;align-items:center;font-weight:600}
  .nav-item:hover{background:rgba(255,255,255,0.04)}
  .nav-item.active{background:rgba(255,255,255,0.08)}

/* Main area */
  .main{margin-left:240px;padding:28px;flex:1}
  .topbar{display:flex;justify-content:space-between;align-items:center;gap:16px;margin-bottom:20px}
  .search{flex:1;display:flex;align-items:center;background:var(--card);padding:8px 12px;border-radius:10px;box-shadow:0 2px 8px rgba(2,6,23,0.06)}
  .search input{border:0;background:transparent;outline:none;font-size:14px;width:100%}
  .top-controls{display:flex;gap:10px;align-items:center}

/* Cards */
  .cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:20px}
  .card{background:var(--card);padding:18px;border-radius:12px;box-shadow:0 6px 18px rgba(2,6,23,0.06);display:flex;flex-direction:column;gap:8px;min-height:100px}
  .card .title{font-size:13px;color:var(--muted);font-weight:600}
  .card .value{font-size:28px;font-weight:800;color:var(--accent)}
  .card .sub{font-size:12px;color:var(--muted)}

/* Charts + layout */
  .panel{display:grid;grid-template-columns:2fr 1fr;gap:16px;margin-bottom:20px}
  .panel .chart-card{background:var(--card);padding:18px;border-radius:12px;box-shadow:0 6px 18px rgba(2,6,23,0.06)}
  .small-cards{display:grid;gap:12px;grid-auto-rows:min-content}

/* Table sections */
  .table-section{background:var(--card);padding:14px;border-radius:12px;box-shadow:0 6px 18px rgba(2,6,23,0.06);margin-bottom:16px}
  table{width:100%;border-collapse:collapse}
  th,td{padding:10px;text-align:left;border-bottom:1px solid rgba(0,0,0,0.06);font-size:13px}
  th{font-weight:700;color:var(--muted)}
  tr:hover td{background:rgba(15,157,154,0.03)}
  .tables-controls{display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;gap:10px}

/* small utilities */
  .pill{display:inline-block;padding:6px 10px;border-radius:999px;background:linear-gradient(90deg, rgba(15,157,154,0.12), rgba(15,157,154,0.06));color:var(--accent);font-weight:700}
  .muted{color:var(--muted)}
  .btn{padding:8px 12px;border-radius:8px;border:0;background:var(--accent);color:white;font-weight:700;cursor:pointer}

/* Responsive */
  @media (max-width:900px){
    .panel{grid-template-columns:1fr}
    .sidebar{position:relative;width:100%;height:auto;flex-direction:row;gap:10px;padding:12px}
    .main{margin-left:0;padding:16px}
  }
</style>
</head>
<body>

<div class="app" id="app" data-theme="light">

  <!-- SIDEBAR -->
  <aside class="sidebar" role="navigation" aria-label="Sidebar">
    <div class="brand">
      
      <div>
        <div style="font-size:15px">💌LifeGift</div>
        <div style="font-size:12px;color:rgba(255,255,255,0.75)">Admin Panel</div>
      </div>
    </div>

    <nav>
      <a href="#" class="nav-item active" data-target="overview">Overview</a>
      <a href="#" class="nav-item" data-target="donors">Donors</a>
      <a href="#" class="nav-item" data-target="recipients">Recipients</a>
      <a href="#" class="nav-item" data-target="blood-donors">Blood Donors</a>
      <a href="#" class="nav-item" data-target="users">Users</a>
      <a href="#" class="nav-item" data-target="organs">Organs</a>
    </nav>

    <div style="margin-top:auto">
      <button id="themeToggle" class="btn" style="width:100%">Toggle Dark</button>
      <div style="margin-top:10px;font-size:12px;color:rgba(255,255,255,0.7)">Signed in as <strong>Admin</strong></div>
    </div>
  </aside>

  <!-- MAIN -->
  <main class="main">

    <div class="topbar">
      <div class="search">
        <svg style="width:18px;height:18px;margin-right:8px;opacity:0.6" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 21l-4.35-4.35"></path><circle cx="10.5" cy="10.5" r="6.5"></circle></svg>
        <input id="globalSearch" placeholder="Search tables: type name, city, blood group..." />
      </div>

      <div class="top-controls">
        <div class="pill">Live</div>
        <div class="muted">Welcome back, Admin</div>
        <a href="index.html" class="btn" style="background:transparent;color:var(--text);border:1px solid rgba(0,0,0,0.06)">Logout</a>
      </div>
    </div>

    <!-- CARDS -->
    <h2 style="margin:0 0 12px 0;color:var(--accent)">Overview</h2>
    <div class="cards">
      <div class="card">
        <div class="title">Total Donors</div>
        <div class="value" data-count="<?php echo intval($total_donors); ?>">0</div>
        <div class="sub">All registered organ donors</div>
        
      </div>

      <div class="card">
        <div class="title">Total Recipients</div>
        <div class="value" data-count="<?php echo intval($total_recipients); ?>">0</div>
        <div class="sub">Waiting & registered recipients</div>
       
      </div>

      <div class="card">
        <div class="title">Successful Matches</div>
        <div class="value" data-count="<?php echo intval($total_matches); ?>">0</div>
        <div class="sub">Confirmed matches</div>
        <a href="match.php">Matched list</a>
      </div>

      <div class="card">
        <div class="title">Users</div>
        <div class="value" data-count="<?php echo intval($total_users); ?>">0</div>
        <div class="sub">Admin & staff accounts</div>
      </div>

      <div class="card">
        <div class="title">Feedback</div>
        <div class="value" data-count="<?php echo intval($total_feedback); ?>">0</div>
        <div class="sub">Messages & inquiries</div>
      </div>
    </div>

    <!-- CHARTS -->
    <div class="panel">
      <div class="chart-card">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
          <div><strong>Donors vs Recipients</strong><div class="muted" style="font-size:12px">Last 6 months</div></div>
          <div class="muted">Overview</div>
        </div>
        <canvas id="trendChart" height="160"></canvas>
      </div>

      <div class="small-cards">
        <div class="chart-card">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
            <div><strong>Organs distribution</strong><div class="muted" style="font-size:12px">Donors by organ</div></div>
            <div class="muted">Realtime</div>
          </div>
          <canvas id="organChart" height="160"></canvas>
        </div>

        <div class="chart-card" style="display:flex;flex-direction:column;gap:10px;align-items:center;justify-content:center">
          <div style="font-weight:700">Quick actions</div>
          <div style="display:flex;gap:8px">
            <a href="donorform.php" class="btn">Add Donor</a>
            <a href="recipientform.php" class="btn" style="background:#ff7a59">Add Recipient</a>
          </div>
        </div>
      </div>
    </div>

    <!-- TABLE SECTIONS (each can be targeted by sidebar) -->
    <section id="overview" class="section">
      <div class="table-section">
        <div class="tables-controls">
          <strong>Recent Donors</strong>
          <div class="muted">Showing latest 100</div>
        </div>
        <table id="donorsTable">
          <thead><tr><th>ID</th><th>Name</th><th>Age</th><th>Gender</th><th>Blood</th><th>Organ</th><th>City</th><th>Registered</th></tr></thead>
          <tbody>
            <?php if ($donors_result && $donors_result->num_rows>0) {
              while($r=$donors_result->fetch_assoc()){
                echo "<tr>
                        <td>".$r['donor_id']."</td>
                        <td>".htmlspecialchars($r['name'])."</td>
                        <td>".htmlspecialchars($r['age'])."</td>
                        <td>".htmlspecialchars($r['gender'])."</td>
                        <td>".htmlspecialchars($r['blood_group'])."</td>
                        <td>".htmlspecialchars($r['organ'])."</td>
                        <td>".htmlspecialchars($r['city'])."</td>
                        <td>".(isset($r['created_at'])?htmlspecialchars($r['created_at']):'')."</td>
                      </tr>";
              }
            } else {
              echo "<tr><td colspan='8' class='muted'>No donors registered yet</td></tr>";
            } ?>
          </tbody>
        </table>
      </div>
    </section>

    <section id="donors" class="section" style="display:none">
      <div class="table-section">
        <strong>Donors</strong>
        <div class="muted">Full list (limited preview)</div>
        <table id="donorsTable2">
          <thead><tr><th>ID</th><th>Name</th><th>Age</th><th>Gender</th><th>Blood</th><th>Organ</th><th>City</th></tr></thead>
          <tbody>
            <?php
            // reuse first result set by querying again
            $res = $conn->query("SELECT donor_id, name, age, gender, blood_group, organ, city FROM donors ORDER BY donor_id DESC LIMIT 500");
            if ($res && $res->num_rows>0) {
              while($r=$res->fetch_assoc()){
                echo "<tr>
                        <td>".$r['donor_id']."</td>
                        <td>".htmlspecialchars($r['name'])."</td>
                        <td>".htmlspecialchars($r['age'])."</td>
                        <td>".htmlspecialchars($r['gender'])."</td>
                        <td>".htmlspecialchars($r['blood_group'])."</td>
                        <td>".htmlspecialchars($r['organ'])."</td>
                        <td>".htmlspecialchars($r['city'])."</td>
                      </tr>";
              }
            } else {
              echo "<tr><td colspan='7' class='muted'>No donors</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </section>

    <section id="recipients" class="section" style="display:none">
      <div class="table-section">
        <strong>Recipients</strong>
        <div class="muted">Latest recipients</div>
        <table id="recipientsTable">
          <thead><tr><th>ID</th><th>Name</th><th>Age</th><th>Gender</th><th>Blood</th><th>Organ</th><th>City</th><th>Status</th></tr></thead>
          <tbody>
            <?php
            if ($recipients_result && $recipients_result->num_rows>0){
              while($r=$recipients_result->fetch_assoc()){
                echo "<tr>
                        <td>".$r['id']."</td>
                        <td>".htmlspecialchars($r['name'])."</td>
                        <td>".htmlspecialchars($r['age'])."</td>
                        <td>".htmlspecialchars($r['gender'])."</td>
                        <td>".htmlspecialchars($r['blood_group'])."</td>
                        <td>".htmlspecialchars($r['organ_needed'])."</td>
                        <td>".htmlspecialchars($r['city'])."</td>
                        <td>".htmlspecialchars($r['status'])."</td>
                      </tr>";
              }
            } else {
              echo "<tr><td colspan='8' class='muted'>No recipients</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </section>

    <section id="blood-donors" class="section" style="display:none">
      <div class="table-section">
        <strong>Blood Donors</strong>
        <table id="bloodDonorsTable">
          <thead><tr><th>ID</th><th>Name</th><th>Age</th><th>Gender</th><th>Blood Group</th><th>City</th></tr></thead>
          <tbody>
            <?php
            if ($blood_donors_result && $blood_donors_result->num_rows>0){
              while($r=$blood_donors_result->fetch_assoc()){
                echo "<tr>
                        <td>".$r['id']."</td>
                        <td>".htmlspecialchars($r['fullname'])."</td>
                        <td>".htmlspecialchars($r['age'])."</td>
                        <td>".htmlspecialchars($r['gender'])."</td>
                        <td>".htmlspecialchars($r['bloodgroup'])."</td>
                        <td>".htmlspecialchars($r['city'])."</td>
                      </tr>";
              }
            } else {
              echo "<tr><td colspan='6' class='muted'>No blood donors</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </section>

    <section id="users" class="section" style="display:none">
      <div class="table-section">
        <strong>Users</strong>
        <table id="usersTable">
          <thead><tr><th>ID</th><th>Username</th><th>Email</th></tr></thead>
          <tbody>
            <?php
            if ($users_result && $users_result->num_rows>0){
              while($r=$users_result->fetch_assoc()){
                echo "<tr>
                        <td>".$r['id']."</td>
                        <td>".htmlspecialchars($r['username'])."</td>
                        <td>".htmlspecialchars($r['email'])."</td>
                      </tr>";
              }
            } else {
              echo "<tr><td colspan='3' class='muted'>No users</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </section>

    <section id="contactss" class="section" style="display:none">
      <div class="table-section">
        <strong>Feedback & Contacts</strong>
        <table id="contactssTable">
          <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Subject</th><th>Message</th></tr></thead>
          <tbody>
            <?php
            if ($contactss_result && $contactss_result->num_rows>0){
              while($r=$contactss_result->fetch_assoc()){
                echo "<tr>
                        <td>".$r['id']."</td>
                        <td>".htmlspecialchars($r['name'])."</td>
                        <td>".htmlspecialchars($r['email'])."</td>
                        <td>".htmlspecialchars($r['subject'])."</td>
                        <td style='max-width:400px;white-space:normal'>".htmlspecialchars($r['message'])."</td>
                      </tr>";
              }
            } else {
              echo "<tr><td colspan='5' class='muted'>No feedback yet</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </section>

    <section id="organs" class="section" style="display:none">
      <div class="table-section">
        <strong>Organ Counts</strong>
        <table>
          <thead><tr><th>Organ</th><th>Number of Donors</th></tr></thead>
          <tbody>
            <?php foreach ($organ_counts as $o => $c) {
              echo "<tr><td>".ucfirst($o)."</td><td>".intval($c)."</td></tr>";
            } ?>
          </tbody>
        </table>
      </div>
    </section>

    <footer style="margin-top:24px;color:var(--muted);font-size:13px">
      &copy; <?php echo date('Y'); ?> LifeGift — Organ Donation Admin Dashboard
    </footer>

  </main>
</div>

<script>
/* ========== Theme toggle ========== */
const app = document.getElementById('app');
const themeToggle = document.getElementById('themeToggle');
let theme = localStorage.getItem('lg_theme') || 'light';
app.setAttribute('data-theme', theme);
themeToggle.addEventListener('click', ()=> {
  theme = (theme === 'light') ? 'dark' : 'light';
  app.setAttribute('data-theme', theme);
  localStorage.setItem('lg_theme', theme);
});

/* ========== Animated counters ========== */
document.querySelectorAll('.card .value').forEach(el=>{
  const target = parseInt(el.getAttribute('data-count') || 0,10);
  let start = 0;
  const step = Math.max(1, Math.round(target / 60));
  const id = setInterval(()=>{
    start += step;
    if (start >= target) {
      el.textContent = target;
      clearInterval(id);
    } else {
      el.textContent = start;
    }
  }, 12);
});

/* ========== Charts using Chart.js ========== */
const months = <?php echo $js_months; ?>;
const donorsMonthly = <?php echo $js_donors_month; ?>;
const recipientsMonthly = <?php echo $js_recipients_month; ?>;
const organsCounts = <?php echo $js_organ_counts; ?>;
const organsLabels = <?php echo $js_organs_labels; ?>;

const ctx = document.getElementById('trendChart').getContext('2d');
const trendChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: months,
    datasets: [
      { label: 'Donors', data: donorsMonthly, fill:false, tension:0.3, borderWidth:2, borderColor: 'rgba(15,157,154,0.9)', pointRadius:3 },
      { label: 'Recipients', data: recipientsMonthly, fill:false, tension:0.3, borderWidth:2, borderColor: 'rgba(20,130,255,0.9)', pointRadius:3 }
    ]
  },
  options: {
    responsive:true,
    plugins:{legend:{position:'top'}},
    scales:{y:{beginAtZero:true}}
  }
});

const ctx2 = document.getElementById('organChart').getContext('2d');
const organChart = new Chart(ctx2, {
  type: 'doughnut',
  data: {
    labels: organsLabels,
    datasets:[{data: organsCounts, hoverOffset:6}]
  },
  options:{
    responsive:true,
    plugins:{legend:{position:'bottom'}}
  }
});

/* ========== Sidebar navigation (show/hide sections) ========== */
document.querySelectorAll('.nav-item').forEach(item=>{
  item.addEventListener('click', (e)=>{
    e.preventDefault();
    document.querySelectorAll('.nav-item').forEach(i=>i.classList.remove('active'));
    item.classList.add('active');
    const target = item.getAttribute('data-target');
    document.querySelectorAll('.section').forEach(s=> s.style.display = 'none');
    const el = document.getElementById(target);
    if (el) el.style.display = 'block';
    window.scrollTo({top:0, behavior:'smooth'});
  });
});

/* ========== Global search across tables (simple client-side filter) ========== */
const globalSearch = document.getElementById('globalSearch');
globalSearch.addEventListener('input', ()=> {
  const q = globalSearch.value.trim().toLowerCase();
  if (!q) {
    document.querySelectorAll('table tbody tr').forEach(tr=> tr.style.display = '');
    return;
  }
  document.querySelectorAll('table tbody tr').forEach(tr=>{
    const text = tr.innerText.toLowerCase();
    tr.style.display = text.includes(q) ? '' : 'none';
  });
});

/* ========== Optional: lightweight column sort (clickable th) ========== */
document.querySelectorAll('table').forEach(table=>{
  table.querySelectorAll('th').forEach((th, idx)=>{
    th.style.cursor = 'pointer';
    th.addEventListener('click', ()=> {
      const tbody = table.querySelector('tbody');
      const rows = Array.from(tbody.querySelectorAll('tr')).filter(r=> r.style.display !== 'none');
      const asc = !th.classList.contains('asc');
      // remove sort classes
      table.querySelectorAll('th').forEach(h=> h.classList.remove('asc','desc'));
      th.classList.add(asc ? 'asc' : 'desc');

      rows.sort((a,b)=>{
        const A = a.children[idx].innerText.trim().toLowerCase();
        const B = b.children[idx].innerText.trim().toLowerCase();
        return (A === B) ? 0 : (A > B ? 1 : -1);
      });
      if (!asc) rows.reverse();
      rows.forEach(r => tbody.appendChild(r));
    });
  });
});
</script>

</body>
</html>