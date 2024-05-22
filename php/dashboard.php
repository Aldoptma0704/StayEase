<?php
session_start();
if (!isset($_SESSION['login_user'])) {
    header("location: login.php");
}

include('Koneksi.php');

// Fetch data for dashboard
$monthly_earnings = 0; // Dummy value, calculate based on your needs
$annual_earnings = 0; // Dummy value, calculate based on your needs
$user_count = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];

if (!$_SESSION['is_admin']) {
    header("location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../CSS/dashboard.css">
</head>
<body>
    <header>
        <nav>
            <img src="../IMG/Logo.png" alt="Logo">
            <ul>
                <li><h3>ADMIN</h3></li>
                <li><img src="../IMG/Photo by Grigore Ricky.png" alt="Profile Picture" class="profile-pic"></li>
            </ul>
        </nav>
    </header>
    <div class="sidebar">
        <a href="dashboard.php"><img src="../IMG/material-symbols_dashboard-outline.svg" alt="Dashboard">Dashboard<img src="../IMG/oui_arrow-up.svg" alt="" class="arrow"></a>
        <a href="manage_room.php"><img src="../IMG/ic_baseline-room-preferences.svg" alt="Rooms">Kelola Kamar</a>
        <a href="manage_users.php"><img src="../IMG/fa6-solid_user-group.svg" alt="Users">Kelola Pengguna</a>
        <a href="manage_history.php"><img src="../IMG/material-symbols_history.svg" alt="History">Kelola Riwayat</a>
    </div>
    <main>
        <h2>Dashboard</h2>
        <div class="card">
            <p>Monthly Earnings: <br>Rp.<?php echo $monthly_earnings; ?> <img src="../IMG/lets-icons_date-fill.svg" alt="Date"> </p>
        </div>
        <div class="card">
            <p>Annual Earnings: <br>Rp.<?php echo $annual_earnings; ?> <img src="../IMG/material-symbols_attach-money.svg" alt="Money"></p>
        </div>
        <div class="card">
            <p>Total Registered Users: <br> <?php echo $user_count; ?> <img src="../IMG/heroicons_user-group-16-solid.svg" alt="Users"></p>
        </div>
        <canvas id="earningOverview"></canvas>
    </main>
</body>
</html>
