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
    
    // Hapus ketersediaan kamar terlebih dahulu
    $conn->query("DELETE FROM room_availability WHERE room_id=$id");

    // Hapus kamar
    $conn->query("DELETE FROM rooms WHERE id=$id");
    
    header("location: manage_room.php");
    exit;
}

// Handle add/update room
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type'];
    $price = $_POST['price'];
    $availability = $_POST['availability'];
    $image_paths = [];

    // Handle multiple image uploads
    if (isset($_FILES['images'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Create uploads directory if it doesn't exist
        }
        
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['images']['error'][$key] == UPLOAD_ERR_OK) {
                $target_file = $target_dir . basename($_FILES['images']['name'][$key]);
                move_uploaded_file($tmp_name, $target_file);
                $image_paths[] = $target_file;
            }
        }
    }

    // If updating an existing room, retain the old images and add new ones
    if (!empty($_POST['room_id'])) {
        $room_id = $_POST['room_id'];
        if (empty($image_paths)) {
            $image_paths = $_POST['existing_images'];
        } else {
            if (!empty($_POST['existing_images'])) {
                $existing_images = explode(',', $_POST['existing_images']);
                $image_paths = array_merge($existing_images, $image_paths);
            }
            $image_paths = implode(',', $image_paths);
        }

        $stmt = $conn->prepare("UPDATE rooms SET room_type=?, price_per_night=?, availability=?, image=? WHERE id=?");
        $stmt->bind_param("sdisi", $type, $price, $availability, $image_paths, $room_id);
        $stmt->execute();
        $stmt->close();
    } else {
        // Insert new room
        $image_paths = implode(',', $image_paths);
        $stmt = $conn->prepare("INSERT INTO rooms (room_type, price_per_night, availability, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdis", $type, $price, $availability, $image_paths);
        $stmt->execute();
        $room_id = $stmt->insert_id;
        $stmt->close();
    }

    // Handle room availability based on dates
    $dates = $_POST['dates'];
    $availabilities = $_POST['availabilities'];
    foreach ($dates as $index => $date) {
        $is_available = isset($availabilities[$index]) ? 1 : 0;
        $stmt = $conn->prepare("REPLACE INTO room_availability (room_id, date, is_available) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $room_id, $date, $is_available);
        $stmt->execute();
    }
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
    $availability_result = $conn->query("SELECT * FROM room_availability WHERE room_id=$id");
    $availability_data = [];
    while ($row = $availability_result->fetch_assoc()) {
        $availability_data[] = $row;
    }
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
                                        <select class="form-control custom-select" id="type" name="type">
                                            <option value="Superior Room" <?php if($edit_room && $edit_room['room_type'] == 'Superior Room') echo 'selected'; ?>>Superior Room</option>
                                            <option value="Deluxe Room" <?php if($edit_room && $edit_room['room_type'] == 'Deluxe Room') echo 'selected'; ?>>Deluxe Room</option>
                                            <option value="Junior Room" <?php if($edit_room && $edit_room['room_type'] == 'Junior Room') echo 'selected'; ?>>Junior Room</option>
                                            <option value="Executive Suite" <?php if($edit_room && $edit_room['room_type'] == 'Executive Suite') echo 'selected'; ?>>Executive Suite</option>
                                            <option value="Executive Studio" <?php if($edit_room && $edit_room['room_type'] == 'Executive Studio') echo 'selected'; ?>>Executive Studio</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="number" class="form-control" id="price" name="price" placeholder="Enter room price" value="<?php echo $edit_room ? $edit_room['price_per_night'] : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="availability">Availability</label>
                                        <input type="number" class="form-control" id="availability" name="availability" placeholder="Enter room availability" value="<?php echo $edit_room ? $edit_room['availability'] : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Images</label>
                                        <input type="file" class="form-control" id="image" name="images[]" multiple>
                                        <input type="hidden" name="existing_images" value="<?php echo $edit_room ? $edit_room['image'] : ''; ?>">
                                        <?php if ($edit_room && $edit_room['image']): ?>
                                            <?php 
                                                $images = explode(',', $edit_room['image']); 
                                                foreach ($images as $img): 
                                            ?>
                                                <img src="<?php echo $img; ?>" alt="Room Image" class="room-image">
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                    <!-- Ketersediaan Kamar Berdasarkan Tanggal -->
                                    <div class="form-group">
                                        <label for="dates">Dates (YYYY-MM-DD)</label>
                                        <input type="text" class="form-control" id="dates" name="dates[]" placeholder="Enter dates separated by commas">
                                    </div>
                                    <div class="form-group">
                                        <label for="availabilities">Availabilities (1 for available, 0 for not available)</label>
                                        <input type="text" class="form-control" id="availabilities" name="availabilities[]" placeholder="Enter availabilities separated by commas">
                                    </div>
                                    <!-- Akhir dari Ketersediaan Kamar Berdasarkan Tanggal -->
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
                                            <th>Images</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($row = $rooms->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['room_type']; ?></td>
                                            <td><?php echo $row['price_per_night']; ?></td>
                                            <td><?php echo $row['availability']; ?></td>
                                            <td>
                                                <?php 
                                                    $images = explode(',', $row['image']); 
                                                    foreach ($images as $img): 
                                                ?>
                                                    <img src="<?php echo $img; ?>" alt="Room Image" class="room-image">
                                                <?php endforeach; ?>
                                            </td>
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

    <script>
        // JavaScript untuk input tanggal dan ketersediaan
        document.addEventListener('DOMContentLoaded', function() {
            // Implementasi tambahan jika diperlukan
        });
    </script>
</body>
</html>
