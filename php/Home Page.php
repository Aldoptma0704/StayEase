<?php
// Koneksi ke database
$sarvername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_management";

$conn = new mysqli($sarvername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: ".$conn->connect_error);
}

// Fungsi untuk mengambil data kamar dari database
function getRooms($conn) {
    $sql = "SELECT * FROM rooms";
    $result = $conn->query($sql);
    $rooms = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $rooms[] = $row;
        }
    }
    return $rooms;
}

// Fungsi untuk menampilkan opsi kamar pada elemen select di halaman web
function displayRoomOptions($rooms) {
    foreach ($rooms as $room) {
        echo "<option value='".$room['type']."'>".$room['type']."</option>";
    }
}

// Fungsi untuk menampilkan kamar-kamar pada halaman web
function displayRooms($rooms) {
    foreach ($rooms as $room) {
        echo "<div class='room-info'>";
        echo "<div class='room-details'>";
        echo "<h2>".$room['type']."</h2>";
        echo "<p class='price'>Rp ".$room['price']."/night</p>";
        // Tambahkan informasi dan tombol-tombol lainnya di sini sesuai kebutuhan
        echo "</div>";
        echo "</div>";
    }
}

// Ambil semua kamar dari database
$rooms = getRooms($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>StayEase Hotels</title>
  <link rel="stylesheet" href="../CSS/Home Page.css">
</head>
<body>
  <header>
    <nav>
      <img src="../IMG/Logo.png" alt="Logo" class="logo">
      <ul>
          <li><a href="Home Page.html" class="home" id="Home">Home</a></li>
          <div class="spacer"></div>
          <li><a href="#" class="history">History</a></li>
      </ul>
      <img src="../IMG/icon.svg" alt="Profile" class="icon">
  </nav>
</header>

<div class="lightbox">
  <span class="prev">&lt;</span>
  <span class="next">&gt;</span>
  <img class="lightbox-image" src="../IMG/Slide.svg" alt="Slide">
</div>
  

<div class="header">
  <h2 style="margin-top: 100px;">StayEase Hotel Lampung</h2>
  <img style="margin-top: 100px;" class="star-image" src="../img/Star.png" alt="Star" width="20" height="20">
</div>
<div class="hotel-details">
  <div class="detail-item">
    <img src="../img/Pin.svg" alt="Address">
    <p><span>Jl. Kesambi No.7, Lempongsari, Gajah Terbang, Bandar Lampung 50231, Lampung, Indonesia |</span></p>
  </div>
  <div class="detail-item">
    <img src="../img/Phone.svg" alt="Phone">
    <p>+62 721 1234567|</p>
  </div>
  <div class="detail-item">
    <img src="../img/Message.svg" alt="Email">
    <p>stayease.lampung@stayease.com</p>
  </div>
</div>

<div class="form-container">
  <form method="POST" action="search.php">
    <div class="form-group">
        <label for="check-in">Check-in</label>
        <div>
            <img src="../img/Calender.svg" alt="Calendar Logo" class="calendar-logo">
            <input type="date" id="check-in" name="check-in" value="2024-01-01">
        </div>
    </div>

    <div class="form-group">
        <label for="check-out">Check-out</label>
        <div>
            <img src="../img/Calender.svg" alt="Calendar Logo" class="calendar-logo">
            <input type="date" id="check-out" name="check-out" value="2024-01-02">
        </div>
    </div>

    <div class="form-group">
      <label for="rooms">Rooms</label>
      <select id="rooms" name="rooms">
          <?php displayRoomOptions($rooms); ?>
      </select>
    </div>

    <button type="submit" class="search-button">SEARCH</button>
  </form>
</div>


  <button class="search-button" onclick="handleSearch()">SEARCH</button>
</div>

<div class="welcome_section">
  <img class="logo-image" src="../img/Room & Suites.png" alt="Logo">
</div>

<div class="container">
  <div class="large-box">
      <div class="image-container">
          <img src="../img/Slide.svg" alt="Hotel Interior 1" class="lightbox-trigger">
          <div class="lightbox">
              <img src="../img/Slide.svg" alt="Hotel Interior 1" class="lightbox-image">
          </div>
      </div>
  </div>
  <div class="small-box">
      <div class="box">
          <div class="image-container">
              <img src="../img/Slide1.svg" alt="Hotel Interior 2" class="lightbox-trigger">
              <div class="lightbox">
                  <img src="../img/Slide1.svg" alt="Hotel Interior 2" class="lightbox-image">
              </div>
          </div>
      </div>
      <div class="box">
          <div class="image-container">
              <img src="../img/Slide2.svg" alt="Hotel Gym" class="lightbox-trigger">
              <div class="lightbox">
                  <img src="../img/Slide2.svg" alt="Hotel Gym" class="lightbox-image">
              </div>
          </div>
      </div>
  </div>
  <div class="small-box">
    <div class="box">
        <div class="image-container">
            <img src="../img/Slide3.svg" alt="Hotel Interior 2" class="lightbox-trigger">
            <div class="lightbox">
                <img src="../img/Slide3.svg" alt="Hotel Interior 2" class="lightbox-image">
            </div>
        </div>
    </div>
    <div class="box">
        <div class="image-container">
            <img src="../img/Slide4.svg" alt="Hotel Gym" class="lightbox-trigger">
            <div class="lightbox">
                <img src="../img/Slide4.svg" alt="Hotel Gym" class="lightbox-image">
            </div>
        </div>
    </div>
</div>
<div class="small-box">
  <div class="box">
      <div class="image-container">
          <img src="../img/Slide5.svg" alt="Hotel Interior 2" class="lightbox-trigger">
          <div class="lightbox">
              <img src="../img/Slide5.svg" alt="Hotel Interior 2" class="lightbox-image">
          </div>
      </div>
  </div>
  <div class="box">
      <div class="image-container">
          <img src="../IMG/Slide1.svg" alt="Hotel Gym" class="lightbox-trigger">
          <div class="lightbox">
              <img src="../IMG/Slide1.svg" alt="Hotel Gym" class="lightbox-image">
          </div>
      </div>
  </div>
</div>
</div>

<div class="welcome_section">
  <img class="logo-image" src="../IMG/Room & Suites.png" alt="Logo">
</div>
<div class="rooms-container">
  <div class="room-info">
    <div class="room-image">
      <img src="../IMG/Property 3.svg" alt="Gambar kamar hotel" class="lightbox-trigger">
      <p>Lobby Bar And Lounge</p>
    </div>
    <div class="room-details">
      <h2>Superior Room</h2>
      <p class="price">Rp 99/ night</p>
      <div class="features">
        <div class="feature">
          <img src="../IMG/Mask group.svg" alt="Twin Bed">
          <p>2 Twin Bed Or 1 King Bed</p>
        </div>
        <div class="feature">
          <img src="../IMG/Mask group (1).svg" alt="Guests">
          <p>2 guests</p>
        </div>
        <div class="feature">
          <img src="../IMG/Mask group (2).svg" alt="Area">
          <p>32.0 m²</p>
        </div>
      </div>
      <div class="buttons">
        <button><p>Shower</p></button>
        <button><p>Wheelchair Access</p></button>
        <button><p>Refrigerator</p></button>
        <button><p>Air conditioning</p></button>
      </div>
    </div>
  </div>

  <div class="room-info">
    <div class="room-image">
      <img src="../IMG/Property 2.svg" alt="Gambar kamar hotel" class="lightbox-trigger">
      <p>Lobby Bar And Lounge</p>
    </div>
    <div class="room-details">
      <h2>Deluxe Room</h2>
      <p class="price">Rp 99/ night</p>
      <div class="features">
        <div class="feature">
          <img src="../IMG/Mask group.svg" alt="Twin Bed">
          <p>2 Twin Bed Or 1 King Bed</p>
        </div>
        <div class="feature">
          <img src="../IMG/Mask group (1).svg" alt="Guests">
          <p>2 guests</p>
        </div>
        <div class="feature">
          <img src="../IMG/Mask group (2).svg" alt="Area">
          <p>32.0 m²</p>
        </div>
      </div>
      <div class="buttons">
        <button><p>Shower</p></button>
        <button><p>Refrigerator</p></button>
        <button><p>Air conditioning</p></button>
      </div>
    </div>
  </div>

  <div class="room-info">
    <div class="room-image">
      <img src="../IMG/Property 1.svg" alt="Gambar kamar hotel" class="lightbox-trigger">
      <p>Lobby Bar And Lounge</p>
    </div>
    <div class="room-details">
      <h2>Junior Room</h2>
      <p class="price">Rp 99/ night</p>
      <div class="features">
        <div class="feature">
          <img src="../IMG/Mask group.svg" alt="Twin Bed">
          <p>1 King Bed </p>
        </div>
        <div class="feature">
          <img src="../IMG/Mask group (1).svg" alt="Guests">
          <p>2 guests</p>
        </div>
        <div class="feature">
          <img src="../IMG/Mask group (2).svg" alt="Area">
          <p>44.0 m²</p>
        </div>
      </div>
      <div class="buttons">
        <button><p>Shower</p></button>
        <button><p>Refrigerator</p></button>
        <button><p>Air conditioning</p></button>
      </div>
    </div>
  </div>

  <div class="room-info">
    <div class="room-image">
      <img src="../IMG/Property 4.svg" alt="Gambar kamar hotel" class="lightbox-trigger">
      <p>Lobby Bar And Lounge</p>
    </div>
    <div class="room-details">
      <h2>Executive suite</h2>
      <p class="price">Rp 99/ night</p>
      <div class="features">
        <div class="feature">
          <img src="../IMG/Mask group.svg" alt="Twin Bed">
          <p>2 Twin Bed Or 1 King Bed</p>
        </div>
        <div class="feature">
          <img src="../IMG/Mask group (1).svg" alt="Guests">
          <p>2 guests</p>
        </div>
        <div class="feature">
          <img src="../IMG/Mask group (2).svg" alt="Area">
          <p>44.0 m²</p>
        </div>
      </div>
      <div class="buttons">
        <button><p>Shower</p></button>
        <button><p>Refrigerator</p></button>
        <button><p>Air conditioning</p></button>
      </div>
    </div>
  </div>

  <div class="room-info">
    <div class="room-image">
      <img src="../IMG/Property 1.svg" alt="Gambar kamar hotel" class="lightbox-trigger">
      <p>Lobby Bar And Lounge</p>
    </div>
    <div class="room-details">
      <h2>Executive Studio</h2>
      <p class="price">Rp 99/ night</p>
      <div class="features">
        <div class="feature">
          <img src="../IMG/Mask group.svg" alt="Twin Bed">
          <p>2 Twin Bed Or 1 King Bed</p>
        </div>
        <div class="feature">
          <img src="../IMG/Mask group (1).svg" alt="Guests">
          <p>2 guests</p>
        </div>
        <div class="feature">
          <img src="../IMG/Mask group (2).svg" alt="Area">
          <p>32.0 m²</p>
        </div>
      </div>
      <div class="buttons">
        <button><p>Shower</p></button>
        <button><p>Refrigerator</p></button>
        <button><p>Air conditioning</p></button>
      </div>
    </div>
  </div>
    </div>
  </div>
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
