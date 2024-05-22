<?php
session_start();
if (!isset($_SESSION['login_user']) || !$_SESSION['is_admin']) {
    header("location: login.php");
    exit;
}

include('Koneksi.php');

// Handle delete room
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $result = $conn->query("SELECT image FROM rooms WHERE id=$id");
    $row = $result->fetch_assoc();
    if (file_exists($row['image'])) {
        unlink($row['image']);
    }
    $conn->query("DELETE FROM rooms WHERE id=$id");
    header("location: manage_room.php");
    exit;
}

// Handle add/update room
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type'];
    $price = $_POST['price'];
    $availability = $_POST['availability'];
    $image_path = '';

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Create uploads directory if it doesn't exist
        }
        $image_path = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image_path);
    } else {
        $image_path = $_POST['existing_image'];
    }

    if (!empty($_POST['room_id'])) {
        // Update existing room
        $room_id = $_POST['room_id'];
        if ($image_path === '') {
            $stmt = $conn->prepare("UPDATE rooms SET type=?, price=?, availability=? WHERE id=?");
            $stmt->bind_param("sdis", $type, $price, $availability, $room_id);
        } else {
            $stmt = $conn->prepare("UPDATE rooms SET type=?, price=?, availability=?, image=? WHERE id=?");
            $stmt->bind_param("sdisi", $type, $price, $availability, $image_path, $room_id);
        }
    } else {
        // Insert new room
        $stmt = $conn->prepare("INSERT INTO rooms (type, price, availability, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdis", $type, $price, $availability, $image_path);
    }

    $stmt->execute();
    $stmt->close();
    header("location: manage_room.php");
    exit;
}


// Fetch rooms data
$rooms = $conn->query("SELECT * FROM rooms");

if (!$rooms) {
    die("Query failed: " . $conn->error);
}

// Fetch room data for editing
$edit_room = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit_room = $conn->query("SELECT * FROM rooms WHERE id=$id")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kamar</title>
    <link rel="stylesheet" type="text/css" href="../CSS/manage_room.css">
    <!-- JavaScript for confirmation dialog -->
    <script>
        function confirmDelete(id) {
            document.getElementById('deletePopup').style.display = 'flex';
            document.getElementById('confirmDeleteButton').onclick = function() {
                window.location.href = 'manage_room.php?delete=' + id;
            };
        }

        function closePopup() {
            document.getElementById('deletePopup').style.display = 'none';
        }
    </script>
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
        <h2>Kelola Kamar</h2>
        <div class="container-fluid">
            <div class="col-lg-12">
                <div class="row">
                    <!-- Room Form Panel -->
                    <div class="col-md-4">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header">
                                    Room Form
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="room_id" value="<?php echo $edit_room ? $edit_room['id'] : ''; ?>">
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <input type="text" class="form-control" id="type" name="type" placeholder="Enter room type" value="<?php echo $edit_room ? $edit_room['type'] : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="number" class="form-control" id="price" name="price" placeholder="Enter room price" value="<?php echo $edit_room ? $edit_room['price'] : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="availability">Availability</label>
                                        <input type="number" class="form-control" id="availability" name="availability" placeholder="Enter room availability" value="<?php echo $edit_room ? $edit_room['availability'] : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="file" class="form-control" id="image" name="image">
                                        <input type="hidden" name="existing_image" value="<?php echo $edit_room ? $edit_room['image'] : ''; ?>">
                                        <?php if ($edit_room && $edit_room['image']): ?>
                                            <img src="<?php echo $edit_room['image']; ?>" alt="Room Image" style="width:100px;">
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Room Form Panel -->

                    <!-- Room List Panel -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Type</th>
                                            <th>Price</th>
                                            <th>Availability</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($row = $rooms->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['type']; ?></td>
                                            <td><?php echo $row['price']; ?></td>
                                            <td><?php echo $row['availability']; ?></td>
                                            <td><img src="<?php echo $row['image']; ?>" alt="Room Image" style="width:100px;"></td>
                                            <td>
                                                <a href="manage_room.php?edit=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                                                <button onclick="confirmDelete(<?php echo $row['id']; ?>)" class="btn btn-danger">Delete</button>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Room List Panel -->
                </div>
            </div>
        </div>
    </main>

    <!-- Popup container -->
    <div id="deletePopup" class="popup-container">
        <div class="popup-content">
            <h2>Apakah Anda yakin ingin menghapus kamar ini?</h2>
            <div class="button-container">
                <button id="confirmDeleteButton">Yakin</button>
                <button onclick="closePopup()">Tidak</button>
            </div>
        </div>
    </div>

</body>
</html>
