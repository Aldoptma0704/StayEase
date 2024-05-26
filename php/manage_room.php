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
    $description = $_POST['description'];
    $price = $_POST['price'];
    $bed_type = $_POST['bed_type'];
    $max_guests = $_POST['max_guests'];
    $area = $_POST['area'];
    $image_paths = [];

    // Handle multiple image uploads
    if (isset($_FILES['images'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['images']['error'][$key] == UPLOAD_ERR_OK) {
                $target_file = $target_dir . basename($_FILES['images']['name'][$key]);
                move_uploaded_file($tmp_name, $target_file);
                $image_paths[] = $target_file;
            }
        }
    }

    // If updating an existing room
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

        $stmt = $conn->prepare("UPDATE rooms SET room_type=?, description=?, price_per_night=?, bed_type=?, max_guests=?, area=?, image=? WHERE id=?");
        $stmt->bind_param("ssdsdssi", $type, $description, $price, $bed_type, $max_guests, $area, $image_paths, $room_id);
        $stmt->execute();
        $stmt->close();
    } else {
        // Insert new room
        $image_paths = implode(',', $image_paths);
        $stmt = $conn->prepare("INSERT INTO rooms (room_type, description, price_per_night, bed_type, max_guests, area, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsdss", $type, $description, $price, $bed_type, $max_guests, $area, $image_paths);
        $stmt->execute();
        $room_id = $stmt->insert_id;
        $stmt->close();
    }

    // Handle room availability based on check-in and check-out dates
    $checkin_date = $_POST['checkin_date'];
    $checkout_date = $_POST['checkout_date'];
    $period = new DatePeriod(
        new DateTime($checkin_date),
        new DateInterval('P1D'),
        (new DateTime($checkout_date))->modify('+1 day')
    );
    
    foreach ($period as $date) {
        $formatted_date = $date->format('Y-m-d');
        $stmt = $conn->prepare("REPLACE INTO room_availability (room_id, date, is_available) VALUES (?, ?, 1)");
        $stmt->bind_param("is", $room_id, $formatted_date);
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
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo $edit_room ? $edit_room['description'] : ''; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo $edit_room ? $edit_room['price_per_night'] : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="bed_type">Bed Type</label>
                                        <input type="text" class="form-control" id="bed_type" name="bed_type" value="<?php echo $edit_room ? $edit_room['bed_type'] : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="max_guests">Max Guests</label>
                                        <input type="number" class="form-control" id="max_guests" name="max_guests" value="<?php echo $edit_room ? $edit_room['max_guests'] : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="area">Area</label>
                                        <input type="number" step="0.01" class="form-control" id="area" name="area" value="<?php echo $edit_room ? $edit_room['area'] : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="images">Images</label>
                                        <input type="file" class="form-control-file" id="images" name="images[]" multiple>
                                        <?php if ($edit_room && !empty($edit_room['image'])): ?>
                                            <div class="existing-images">
                                                <p>Existing Images:</p>
                                                <?php 
                                                $images = explode(',', $edit_room['image']);
                                                foreach ($images as $image): ?>
                                                    <img src="<?php echo $image; ?>" alt="Room Image" width="100">
                                                <?php endforeach; ?>
                                                <input type="hidden" name="existing_images" value="<?php echo implode(',', $images); ?>">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="checkin_date">Check-in Date</label>
                                        <input type="date" class="form-control" id="checkin_date" name="checkin_date" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="checkout_date">Check-out Date</label>
                                        <input type="date" class="form-control" id="checkout_date" name="checkout_date" value="">
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Room List Panel -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                Room List
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Bed Type</th>
                                            <th>Max Guests</th>
                                            <th>Area</th>
                                            <th>Image</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($room = $rooms->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo $room['room_type']; ?></td>
                                                <td><?php echo $room['description']; ?></td>
                                                <td><?php echo $room['price_per_night']; ?></td>
                                                <td><?php echo $room['bed_type']; ?></td>
                                                <td><?php echo $room['max_guests']; ?></td>
                                                <td><?php echo $room['area']; ?></td>
                                                <td>
                                                    <?php 
                                                        $images = explode(',', $room['image']);
                                                        foreach ($images as $image): 
                                                    ?>
                                                    <img src="<?php echo $image; ?>" alt="Room Image" width="100">
                                                    <?php endforeach; ?>
                                                </td>
                                                <td>
                                                    <a href="manage_room.php?edit=<?php echo $room['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                                    <button onclick="confirmDelete(<?php echo $room['id']; ?>, true)" class="btn btn-danger btn-sm">Delete</button>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


    </main>
     
        <!-- Delete Confirmation Popup -->
        <div id="deletePopup" class="popup">
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
