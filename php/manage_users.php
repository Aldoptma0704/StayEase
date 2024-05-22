<?php
session_start();
if (!isset($_SESSION['login_user']) || !$_SESSION['is_admin']) {
    header("location: login.php");
    exit;
}

include('Koneksi.php');

// Handle delete user
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$id");
    header("location: manage_users.php");
    exit;
}

// Fetch users data
$users = $conn->query("SELECT * FROM users");

if (!$users) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kelola Pengguna</title>
<link rel="stylesheet" type="text/css" href="../CSS/manage_users.css">
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
        <a href="manage_users.php"><img src="../IMG/fa6-solid_user-group.svg" alt="Users">Kelola Pengguna<img src="../IMG/oui_arrow-up.svg" alt="" class="arrow"></a>
        <a href="manage_history.php"><img src="../IMG/material-symbols_history.svg" alt="History">Kelola Riwayat</a>
    </div>
    <main>
        <h2>Kelola Pengguna</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            <?php while($row = $users->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                    <a href="edit_user.php?id=<?php echo $row['id']; ?>"><button>Edit</button></a>
                    <button onclick="confirmDelete(<?php echo $row['id']; ?>)">Delete</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </main>

    <!-- Popup container -->
    <div id="deletePopup" class="popup-container">
        <div class="popup-content">
            <h2>Apakah Anda yakin ingin menghapusnya?</h2>
            <div class="button-container">
                <button id="confirmDeleteButton">Yakin</button>
                <button onclick="closePopup()">Tidak</button>
            </div>
        </div>
    </div>

<script>
    function openPopup() {
        document.getElementById("deletePopup").style.display = "flex";
    }

    function closePopup() {
        document.getElementById("deletePopup").style.display = "none";
    }

    function confirmDelete(id) {
        openPopup();
        document.getElementById("confirmDeleteButton").onclick = function() {
            window.location.href = `manage_users.php?delete=${id}`;
        }
    }
</script>
</body>
</html>
