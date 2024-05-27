<?php
session_start();
include('Koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $check_in_raw = $_POST['check_in'];
    $check_out_raw = $_POST['check_out'];
    $room_type = $_POST['rooms'];

    // Validasi dan format tanggal
    $check_in = DateTime::createFromFormat('Y-m-d', $check_in_raw);
    $check_out = DateTime::createFromFormat('Y-m-d', $check_out_raw);

    if (!$check_in || !$check_out) {
        echo "Invalid date format. Please enter dates in YYYY-MM-DD format.";
    } else {
        $check_in = $check_in->format('Y-m-d');
        $check_out = $check_out->format('Y-m-d');

        $room_type = $conn->real_escape_string($room_type);

        // Query untuk memeriksa ketersediaan kamar berdasarkan tanggal check-in, check-out, dan tipe kamar
        $sql = "
            SELECT *
            FROM rooms
            WHERE room_type = '$room_type'
              AND id NOT IN (
                SELECT room_id
                FROM room_availability
                WHERE date BETWEEN '$check_in' AND '$check_out'
                  AND is_available = 0
              )";
        
        $result = $conn->query($sql);
        
        // Menampilkan hasil pencarian
        if ($result->num_rows > 0) {
            echo "<h2>Kamar Tersedia</h2>";
            while ($row = $result->fetch_assoc()) {
                echo "<p>Kamar " . $row['room_type'] . " tersedia.</p>";
            }
        } else {
            echo "<p>Tidak ada kamar yang tersedia untuk tanggal dan tipe kamar yang dipilih.</p>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayEase Hotels</title>
    <link rel="stylesheet" href="../CSS/search_results.css">
</head>
<body>
<header>
    <nav>
        <img src="../IMG/Logo.png" alt="Logo" class="logo">
        <ul>
            <li class="spacer"></li>
            <li><a href="HomePage.php" class="home" id="Home">Home</a></li>
            <li><a href="#" class="history">History</a></li>
        </ul>
        <img src="../IMG/Photo by Grigore Ricky.png" alt="Phone" class="phone-icon">
    </nav>
</header>

<div class="form-container">
    <form action="search_results.php" method="POST">
        <div class="form-group">
            <label for="check-in">Check-in</label>
            <div>
                <img src="../img/Calender.svg" alt="Calendar Logo" class="calendar-logo">
                <input type="date" id="check-in" name="check_in" value="<?php echo isset($_POST['check_in']) ? $_POST['check_in'] : '2024-01-01'; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="check-out">Check-out</label>
            <div>
                <img src="../img/Calender.svg" alt="Calendar Logo" class="calendar-logo">
                <input type="date" id="check-out" name="check_out" value="<?php echo isset($_POST['check_out']) ? $_POST['check_out'] : '2024-01-02'; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="rooms">Rooms</label>
            <select id="rooms" name="rooms">
                <option value="Superior Room">Superior Room</option>
                <option value="Deluxe Room">Deluxe Room</option>
                <option value="Junior Room">Junior Room</option>
                <option value="Executive Suite">Executive Suite</option>
                <option value="Executive Studio">Executive Studio</option>
            </select>
        </div>

        <button type="submit" class="search-button">SEARCH</button>
    </form>
</div>

<!-- Daftar kamar tersedia -->
<div class="available-rooms">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($result)) {
        if ($result->num_rows > 0) {
            echo "<h2>Kamar Tersedia</h2>";
            while ($row = $result->fetch_assoc()) {
                echo "<div class='room-info'>";
                echo "<div class='room-image'>";
                $images = explode(',', $row['image']);
                foreach ($images as $image) {
                    echo "<img src='$image' alt='Room Image' class='room-image'>";
                }
                echo "</div>"; // Close room-image div
                echo "<div class='room-details'>";
                echo "<h2>" . $row['room_type'] . "</h2>";
                echo "<div class='description'>";
                echo "<p>Description:</p>";
                echo "<p>" . $row['description'] . "</p>"; // Deskripsi kamar dari database
                echo "</div>"; // Close description div
                echo "<div class='description-details'>";
                // Tampilkan harga kamar dari database
                echo "<p>Harga: Rp " . $row['price_per_night'] . "/night</p>";
                echo "</div>"; // Close description-details div
                echo "<div class='room-features'>";
                echo "<div class='feature'><img src='../IMG/Mask group.svg' alt='Bed Icon'><p>2 Twin Bed Or 1 King Bed</p></div>";
                echo "<div class='feature'><img src='../IMG/Mask group (1).svg' alt='Guests Icon'><p>2 guests</p></div>";
                echo "<div class='feature'><img src='../IMG/Mask group (2).svg' alt='Area Icon'><p>32.00 m²</p></div>";
                echo "</div>"; // Close room-features div
                echo "<div class='buttons'>";
                // Tambahkan tombol "Book Now" yang mengarah ke booking.php
                echo "<button><a href='booking.php?room_id=" . $row['id'] . "&check_in=" . $check_in . "&check_out=" . $check_out . "' class='book-now-button'>Book Now</a></buttin>";
                echo "</div>"; // Close buttons div
                echo "</div>"; // Close room-details div
                echo "</div>"; // Close room-info div
            }
        } else {
            echo "<p>Tidak ada kamar yang tersedia untuk tanggal yang dipilih.</p>";
        }
    }
    ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../JS/Home Page.js"></script> <!-- Include JavaScript file -->
</body>
</html>
