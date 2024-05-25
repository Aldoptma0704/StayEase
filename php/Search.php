<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fungsi untuk mengambil data kamar dari database dengan filter
function getFilteredRooms($conn, $checkIn, $checkOut, $roomType) {
    $sql = "SELECT * FROM rooms WHERE type LIKE ?";
    $stmt = $conn->prepare($sql);
    $roomType = "%" . $roomType . "%";
    $stmt->bind_param("s", $roomType);
    $stmt->execute();
    $result = $stmt->get_result();
    $rooms = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rooms[] = $row;
        }
    }
    return $rooms;
}

// Mendapatkan nilai dari POST request
$checkIn = $_POST['check-in'];
$checkOut = $_POST['check-out'];
$roomType = $_POST['rooms'];

// Ambil kamar yang difilter dari database
$rooms = getFilteredRooms($conn, $checkIn, $checkOut, $roomType);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contoh Halaman HTML dan CSS</title>
    <link rel="stylesheet" href="../CSS/Search.css">
</head>
<body>
    <header>
      <nav>
          <img src="../IMG/Logo.png" alt="Logo" class="logo">
          <ul>
              <li class="spacer"></li>
              <li><a href="Home Page.php" class="home" id="Home">Home</a></li>
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
    <img style="margin-top: 100px;" class="star-image" src="../IMG/Star.png" alt="Star" width="20" height="20">
  </div>
  <div class="hotel-details">
    <div class="detail-item">
      <img src="../IMG/Pin.svg" alt="Address">
      <p><span>Jl. Kesambi No.7, Lempongsari, Gajah Terbang, Bandar Lampung 50231, Lampung, Indonesia |</span></p>
    </div>
    <div class="detail-item">
      <img src="../IMG/Phone.svg" alt="Phone">
      <p>+62 721 1234567|</p>
    </div>
    <div class="detail-item">
      <img src="../IMG/Message.svg" alt="Email">
      <p>stayease.lampung@stayease.com</p>
    </div>
  </div>
  
  <div class="form-container" id="search-form">
        <form action="Home Page.php" method="post">
            <div class="form-group">
                <label for="check-in">Check-in</label>
                <div>
                    <img src="../IMG/Calender.svg" alt="Calendar Logo" class="calendar-logo">
                    <input type="date" id="check-in" name="check-in" value="<?php echo isset($check_in) ? $check_in : '2024-01-01'; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="check-out">Check-out</label>
                <div>
                    <img src="../IMG/Calender.svg" alt="Calendar Logo" class="calendar-logo">
                    <input type="date" id="check-out" name="check-out" value="<?php echo isset($check_out) ? $check_out : '2024-01-02'; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="rooms">Rooms</label>
                <select id="rooms" name="rooms">
                    <?php
                    $selected = isset($rooms) ? $rooms : 1;
                    for ($i = 1; $i <= 5; $i++) {
                        echo "<option value=\"$i\"" . ($i == $selected ? " selected" : "") . ">$i</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="search-button">SEARCH</button>
        </form>
    </div>
  
  <div class="rooms-container">
    <div class="room-info" data-room-type="Superior Room" data-rooms="1">
      <div class="room-image">
        <img src="../IMG/Property 1.svg" alt="Gambar kamar hotel" class="lightbox-trigger">
        <h2 style="margin-right: 20px ;">Lobby Bar And Lounge</h2>
        <div class="buttons">
            <button><p>Shower</p></button>
            <button><p>Wheelchair Access</p></button>
            <button><p>Refrigerator</p></button>
            <button><p>Air conditioning</p></button>
          </div>
      </div>
      <div class="room-details">
        <h2>Superior Room</h2>
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
        <div class="room-description">
          <div class="description-column">
            <h3>Room Facilities</h3>
            <ul>
              <li>Air conditioning</li>
              <li>Blackout curtains</li>
              <li>Complimentary bottled water</li>
              <li>Electric kettle</li>
              <li>Minibar</li>
              <li>Refrigerator</li>
            </ul>
          </div>
          <div class="description-column">
            <h3>Bathroom Amenities</h3>
            <ul>
              <li>Private bathroom</li>
              <li>Shower</li>
              <li>Toiletries</li>
              <li>Towels</li>
              <li>Hair dryer</li>
              <li>Hydromassage shower head</li>
            </ul>
          </div>
          <div class="room-options">
            <div class="option">
              <p style="font-weight: bold;">Without Breakfast</p>
              <p style="margin-top: -15px;">Free Cancellation before 10 May 2024, 13:59</p>
              <p class="price" style="margin-top: -15px;">Rp 99/ night</p>
              <p style="text-align: right; margin-right: 10px;">3 rooms remaining</p>
              <button style="margin-top: -15px; margin-left: 150px;">Book Now</button>
            </div>
            <div class="option">
                <p style="font-weight: bold;">Breakfast included for 2 pax</p>
                <p style="margin-top: -15px;">Free Cancellation before 10 May 2024, 13:59</p>
                <p class="price" style="margin-top: -15px;">Rp 99/ night</p>
                <button style="margin-top: -15px; margin-left: 150px;">Book Now</button>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="room-info" data-room-type="Deluxe Room" data-rooms="2">
    <div class="room-image">
      <img src="../IMG/Property 2.svg" alt="Gambar kamar hotel" class="lightbox-trigger">
      <h2 style="margin-right: 20px ;">Lobby Bar And Lounge</h2>
      <div class="buttons">
          <button><p>Shower</p></button>
          <button><p>Refrigerator</p></button>
          <button><p>Air conditioning</p></button>
        </div>
    </div>
    <div class="room-details">
      <h2>Deluxe Room</h2>
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
      <div class="room-description">
        <div class="description-column">
          <h3>Room Facilities</h3>
          <ul>
            <li>Air conditioning</li>
            <li>Blackout curtains</li>
            <li>Complimentary bottled water</li>
            <li>Electric kettle</li>
            <li>Minibar</li>
            <li>Refrigerator</li>
          </ul>
        </div>
        <div class="description-column">
          <h3>Bathroom Amenities</h3>
          <ul>
            <li>Private bathroom</li>
            <li>Shower</li>
            <li>Toiletries</li>
            <li>Towels</li>
            <li>Hair dryer</li>
            <li>Hydromassage shower head</li>
          </ul>
        </div>
        <div class="room-options">
          <div class="option">
            <p style="font-weight: bold;">Without Breakfast</p>
            <p style="margin-top: -15px;">Free Cancellation before 10 May 2024, 13:59</p>
            <p class="price" style="margin-top: -15px;">Rp 99/ night</p>
            <p style="text-align: right; margin-right: 10px;">3 rooms remaining</p>
            <button style="margin-top: -15px; margin-left: 150px;">Book Now</button>
          </div>
          <div class="option">
              <p style="font-weight: bold;">Breakfast included for 2 pax</p>
              <p style="margin-top: -15px;">Free Cancellation before 10 May 2024, 13:59</p>
              <p class="price" style="margin-top: -15px;">Rp 99/ night</p>
              <button style="margin-top: -15px; margin-left: 150px;">Book Now</button>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  
<div class="room-info" data-room-type="Junior Suite" data-rooms="3">
  <div class="room-image">
    <img src="../IMG/Property 3.svg" alt="Gambar kamar hotel" class="lightbox-trigger">
    <h2 style="margin-right: 20px ;">Lobby Bar And Lounge</h2>
    <div class="buttons">
        <button><p>Shower</p></button>
        <button><p>Refrigerator</p></button>
        <button><p>Air conditioning</p></button>
      </div>
  </div>
  <div class="room-details">
    <h2>Junior suite</h2>
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
    <div class="room-description">
      <div class="description-column">
        <h3>Room Facilities</h3>
        <ul>
          <li>Air conditioning</li>
          <li>Blackout curtains</li>
          <li>Complimentary bottled water</li>
          <li>Electric kettle</li>
          <li>Minibar</li>
          <li>Refrigerator</li>
        </ul>
      </div>
      <div class="description-column">
        <h3>Bathroom Amenities</h3>
        <ul>
          <li>Private bathroom</li>
          <li>Shower</li>
          <li>Toiletries</li>
          <li>Towels</li>
          <li>Hair dryer</li>
          <li>Hydromassage shower head</li>
        </ul>
      </div>
      <div class="room-options">
        <div class="option">
          <p style="font-weight: bold;">Without Breakfast</p>
          <p style="margin-top: -15px;">Free Cancellation before 10 May 2024, 13:59</p>
          <p class="price" style="margin-top: -15px;">Rp 99/ night</p>
          <p style="text-align: right; margin-right: 10px;">3 rooms remaining</p>
          <button style="margin-top: -15px; margin-left: 150px;">Book Now</button>
        </div>
        <div class="option">
            <p style="font-weight: bold;">Breakfast included for 2 pax</p>
            <p style="margin-top: -15px;">Free Cancellation before 10 May 2024, 13:59</p>
            <p class="price" style="margin-top: -15px;">Rp 99/ night</p>
            <button style="margin-top: -15px; margin-left: 150px;">Book Now</button>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
  
<div class="room-info" data-room-type="Executive Suite" data-rooms="4">
  <div class="room-image">
    <img src="../IMG/Property 3.svg" alt="Gambar kamar hotel" class="lightbox-trigger">
    <h2 style="margin-right: 20px ;">Lobby Bar And Lounge</h2>
    <div class="buttons">
        <button><p>Shower</p></button>
        <button><p>Refrigerator</p></button>
        <button><p>Air conditioning</p></button>
      </div>
  </div>
  <div class="room-details">
    <h2>Executive suite</h2>
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
    <div class="room-description">
      <div class="description-column">
        <h3>Room Facilities</h3>
        <ul>
          <li>Air conditioning</li>
          <li>Blackout curtains</li>
          <li>Complimentary bottled water</li>
          <li>Electric kettle</li>
          <li>Minibar</li>
          <li>Refrigerator</li>
        </ul>
      </div>
      <div class="description-column">
        <h3>Bathroom Amenities</h3>
        <ul>
          <li>Private bathroom</li>
          <li>Shower</li>
          <li>Toiletries</li>
          <li>Towels</li>
          <li>Hair dryer</li>
          <li>Hydromassage shower head</li>
        </ul>
      </div>
      <div class="room-options">
        <div class="option">
          <p style="font-weight: bold;">Without Breakfast</p>
          <p style="margin-top: -15px;">Free Cancellation before 10 May 2024, 13:59</p>
          <p class="price" style="margin-top: -15px;">Rp 99/ night</p>
          <p style="text-align: right; margin-right: 10px;">3 rooms remaining</p>
          <button style="margin-top: -15px; margin-left: 150px;">Book Now</button>
        </div>
        <div class="option">
            <p style="font-weight: bold;">Breakfast included for 2 pax</p>
            <p style="margin-top: -15px;">Free Cancellation before 10 May 2024, 13:59</p>
            <p class="price" style="margin-top: -15px;">Rp 99/ night</p>
            <button style="margin-top: -15px; margin-left: 150px;">Book Now</button>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
  
<div class="room-info">
  <div class="room-image">
    <img src="../IMG/Property 3.svg" alt="Gambar kamar hotel" class="lightbox-trigger">
    <h2 style="margin-right: 20px ;">Deluxe Room</h2>
    <div class="buttons">
        <button><p>Shower</p></button>
        <button><p>Refrigerator</p></button>
        <button><p>Air conditioning</p></button>
      </div>
  </div>
  <div class="room-details">
    <h2>Deluxe Room</h2>
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
    <div class="room-description">
      <div class="description-column">
        <h3>Room Facilities</h3>
        <ul>
          <li>Air conditioning</li>
          <li>Blackout curtains</li>
          <li>Complimentary bottled water</li>
          <li>Electric kettle</li>
          <li>Minibar</li>
          <li>Refrigerator</li>
        </ul>
      </div>
      <div class="description-column">
        <h3>Bathroom Amenities</h3>
        <ul>
          <li>Private bathroom</li>
          <li>Shower</li>
          <li>Toiletries</li>
          <li>Towels</li>
          <li>Hair dryer</li>
          <li>Hydromassage shower head</li>
        </ul>
      </div>
      <div class="room-options">
        <div class="option">
          <p style="font-weight: bold;">Without Breakfast</p>
          <p style="margin-top: -15px;">Free Cancellation before 10 May 2024, 13:59</p>
          <p class="price" style="margin-top: -15px;">Rp 99/ night</p>
          <p style="text-align: right; margin-right: 10px;">3 rooms remaining</p>
          <button style="margin-top: -15px; margin-left: 150px;">Book Now</button>
        </div>
        <div class="option">
            <p style="font-weight: bold;">Breakfast included for 2 pax</p>
            <p style="margin-top: -15px;">Free Cancellation before 10 May 2024, 13:59</p>
            <p class="price" style="margin-top: -15px;">Rp 99/ night</p>
            <button style="margin-top: -15px; margin-left: 150px;">Book Now</button>
        </div>
        </div>
        </div>
      </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../JS/Search.js"></script> <!-- Include JavaScript file -->
</body>  
</html>
