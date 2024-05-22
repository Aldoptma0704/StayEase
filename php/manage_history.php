<?php
session_start();
if (!isset($_SESSION['login_user']) || !$_SESSION['is_admin']) {
    header("location: login.php");
}

include('Koneksi.php');

// Handle delete booking
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM bookings WHERE id=$id");
}

// Fetch bookings data
$bookings = $conn->query("SELECT bookings.*, users.username FROM bookings JOIN users ON bookings.user_id = users.id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Riwayat</title>
    <link rel="stylesheet" type="text/css" href="../CSS/manage_history.css">
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
        <a href="dashboard.php"><img src="../IMG/material-symbols_dashboard-outline.svg" alt="Dashboard">Dashboard</a>
        <a href="manage_room.php"><img src="../IMG/ic_baseline-room-preferences.svg" alt="Rooms">Kelola Kamar</a>
        <a href="manage_users.php"><img src="../IMG/fa6-solid_user-group.svg" alt="Users">Kelola Pengguna<img src="../IMG/oui_arrow-up.svg" alt="" class="arrow">   </a>
        <a href="manage_history.php"><img src="../IMG/material-symbols_history.svg" alt="History">Kelola Riwayat</a>
    </div>
    <h2>Kelola Riwayat</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Room Type</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $bookings->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['room_type']; ?></td>
            <td><?php echo $row['check_in']; ?></td>
            <td><?php echo $row['check_out']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td>
                <a href="edit_booking.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a href="manage_bookings.php?delete=<?php echo $row['id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
