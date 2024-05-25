<?php
session_start();
include('Koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $room_type = $_POST['rooms'];

    // Query untuk mendapatkan kamar yang tersedia sesuai dengan tipe kamar yang dipilih
    $sql = "SELECT * FROM rooms WHERE room_type = '$room_type' AND id NOT IN (
                SELECT room_id FROM bookings 
                WHERE (check_in <= '$check_out' AND check_out >= '$check_in')
            )";

    $result = $conn->query($sql);
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
            <li><a href="Regist.html" class="home" id="Home">Home</a></li>
            <li><a href="#" class="history">History</a></li>
        </ul>
        <img src="../IMG/Phone.svg" alt="Phone" class="phone-icon">
    </nav>
</header>

<div class="form-container">
  <form action="search_results.php" method="POST">
    <div class="form-group">
        <label for="check-in">Check-in</label>
        <div>
            <img src="../img/Calender.svg" alt="Calendar Logo" class="calendar-logo">
            <input type="date" id="check-in" name="check_in" value="2024-01-01">
        </div>
    </div>

    <div class="form-group">
        <label for="check-out">Check-out</label>
        <div>
            <img src="../img/Calender.svg" alt="Calendar Logo" class="calendar-logo">
            <input type="date" id="check-out" name="check_out" value="2024-01-02">
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
        while($row = $result->fetch_assoc()) {
            echo "<div class='room-info'>";
            echo "<div class='room-image'><p>" . $row['description'] . "</p></div>";
            echo "<div class='room-details'><h2>" . $row['room_type'] . "</h2><p class='price'>Rp " . $row['price_per_night'] . "/ night</p>";
            echo "<div class='features'>";
            echo "<div class='feature'><p>" . $row['bed_type'] . "</p></div>";
            echo "<div class='feature'><p>" . $row['max_guests'] . " guests</p></div>";
            echo "<div class='feature'><p>" . $row['area'] . " m²</p></div>";
            echo "</div>";
            echo "<div class='buttons'><button><p>Shower</p></button><button><p>Refrigerator</p></button><button><p>Air conditioning</p></button></div>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "Tidak ada kamar yang tersedia untuk tanggal yang dipilih.";
    }
}
?>
</div>

<h2>Key Features</h2>
<div class="footer">
  <div class="feature-column">
    <button>
      <div class="feature-content">
        <img src="../IMG/Meeting rooms.svg" alt="Meeting Rooms">
        <p>Meeting rooms</p>
      </div>
    </button>
  </div>
  <div class="feature-column">
    <button>
      <div class="feature-content">
        <img src="../IMG/person max. capacity.svg" alt="1,500 person max. capacity">
        <p>1,500 person max. capacity</p>
      </div>
    </button>
  </div>
  <div class="feature-column">
    <button>
      <div class="feature-content">
        <img src="../IMG/Ballroom pre-function area.svg" alt="Ballroom pre-function area">
        <p>Ballroom pre-function area</p>
      </div>
    </button>
  </div>
  <div class="feature-column">
    <button>
      <div class="feature-content">
        <img src="../IMG/Catering Service.svg" alt="Catering Service">
        <p>Catering Service</p>
      </div>
    </button>
  </div>
  <div class="feature-column">
    <button>
      <div class="feature-content">
        <img src="../IMG/Free Wi-Fi.svg" alt="Free Wi-Fi">
        <p>Free Wi-Fi</p>
      </div>
    </button>
  </div>
  <div class="feature-column">
    <button>
      <div class="feature-content">
        <img src="../IMG/Wedding and event coordinator.svg" alt="Wedding and event coordinator">
        <p>Wedding and event coordinator</p>
      </div>
    </button>
  </div>
  <div class="feature-column">
    <button>
      <div class="feature-content">
        <img src="../IMG/Reception.svg" alt="Reception">
        <p>Reception</p>
      </div>
    </button>
  </div>
  <div class="feature-column">
    <button>
      <div class="feature-content">
        <img src="../IMG/Theater.svg" alt="Theater">
        <p>Theater</p>
      </div>
    </button>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../JS/Home Page.js"></script> <!-- Include JavaScript file -->
</body>
</html>
