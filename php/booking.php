<?php
session_start();
include('Koneksi.php');

// Memeriksa apakah data formulir pemesanan telah dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan data yang dikirimkan dari formulir
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $country_code = $_POST['country_code'];
    $phone = $_POST['phone'];
    $bedtype = $_POST['bedtype'];
    $check_in = $_POST['check_in']; // Mengambil nilai check-in dari formulir
    $check_out = $_POST['check_out']; // Mengambil nilai check-out dari formulir

    // Memeriksa apakah room_id ada dalam URL parameter
    if(isset($_GET['room_id'])) {
        $room_id = $_GET['room_id'];

        // Menyiapkan pernyataan SQL untuk menyimpan data pemesanan
        $sql = "INSERT INTO bookings (fullname, email, phone, bed_type, room_id, booking_date, check_in, check_out) 
                VALUES ('$fullname', '$email', '$country_code $phone', '$bedtype', '$room_id', NOW(), '$check_in', '$check_out')";

        // Menjalankan pernyataan SQL
        if ($conn->query($sql) === TRUE) {
            // Jika penyimpanan berhasil, Anda dapat mengarahkan pengguna ke halaman terima kasih atau halaman konfirmasi pemesanan
            header("Location: thank_you.php");
            exit();
        } else {
            // Jika terjadi kesalahan dalam penyimpanan data, Anda dapat menampilkan pesan kesalahan atau mengarahkan pengguna kembali ke halaman pemesanan dengan pesan kesalahan
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        // Jika room_id tidak ada dalam URL parameter, kembalikan pengguna ke halaman pemesanan
        header("Location: booking.php");
        exit();
    }
} else {
    // Jika pengguna mencoba mengakses halaman ini tanpa mengirimkan data formulir, Anda dapat mengarahkan mereka kembali ke halaman pemesanan
    header("Location: booking.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accommodation Booking</title>
    <link rel="stylesheet" href="../CSS/Booking.css">
</head>
<body>
<header>
    <nav>
        <img src="../IMG/Logo.png" alt="Logo" class="logo">
        <ul>
            <li class="spacer"></li>
            <li><a href="HomePage.php" class="home">Home</a></li>
            <li><a href="#" class="history">History</a></li>
        </ul>
        <img src="../IMG/Photo by Grigore Ricky.png" alt="Phone" class="phone-icon">
    </nav>
</header>

<div class="container">
    <div class="left-column">
        <div class="hotel-info">
            <img src="../IMG/Property 1.svg" alt="StayEase Hotel Lampung">
            <div>StayEase Hotel Lampung</div>
            <div>Jl. Kesambi No.7, Lempongsari, Gajah Terbang, Bandar Lampung, 50231, Lampung, Indonesia</div>
        </div>
        <div class="line"></div>
        <div class="booking-details">
            <div>My booking</div>
            <div>Occupancy: 1 room</div>
            <div>Check-in: <?php echo date('D, d M Y', strtotime($_POST['check_in'])); ?> - 3:00 PM</div>
            <div>Check-out: <?php echo date('D, d M Y', strtotime($_POST['check_out'])); ?> - 12:00 PM</div>
            <div><?php echo $_POST['bedtype']; ?></div>
            <div>Without Breakfast</div>
            <div class="line"></div>
            <div>Room(s) held for 00:15:00</div>
        </div>
    </div>

    <div class="right-column">
        <div class="logo">
            <h2><img src="../IMG/Bosst.svg" alt="Company Logo"> Your booking is guaranteed for a limited time only.</h2>
        </div>
        <p>Make sure all the details on this page are correct before proceeding to payment.</p>
        <form action="confirmation.php" method="POST">
            <div class="form-group">
                <label for="fullName">Full Name</label>
                <input type="text" id="fullName" name="fullname" placeholder="As in Passport/Official ID Card (without title/special characters)" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="We will send the e-voucher to this email." required>
            </div>
            <div class="form-group mobile-group">
                <label for="mobileNumber">Mobile Number</label>
                <select id="countryCode" name="country_code">
                    <option value="+62">+62 Indonesia</option>
                    <option value="+1">+1 United States</option>
                    <!-- Add more options as needed -->
                </select>
                <input type="tel" id="mobileNumber" name="phone" placeholder="0812345678" required>
            </div>
            <div class="form-group">
                <label for="bedType">Bed Type</label>
                <select id="bedType" name="bedtype" required>
                    <option value="1 King Bed">1 King Bed</option>
                    <option value="2 Twin Bed">2 Twin Bed</option>
                    <!-- Add more options as needed -->
                </select>
            </div>
            <!-- Harga kamar dan tipe kamar dapat dihapus jika tidak digunakan -->
            <div class="price-details">
                <!-- <div>Room Price: Rp <?php echo $room_data['price_per_night']; ?></div>
                <div>(1x) <?php echo $room_data['room_type']; ?> (1 night)</div> -->
                <!-- Add other price details here if needed -->
            </div>
            <div class="continue-button">
                <button type="submit" class="overlay-button">CONTINUE TO PAYMENT</button>
            </div>
        </form>
    </div>
</div>

<div class="overlay" id="confirmationOverlay">
    <div class="overlay-content">
        <p>Are the details correct?</p>
        <button type="button" class="overlay-button" id="proceedButton">Proceed</
        
<button type="button" class="overlay-button" id="proceedButton">Proceed</button>
</div>

</div>
<script>
    document.getElementById('continueButton').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('confirmationOverlay').style.display = 'flex';
    });

    document.getElementById('proceedButton').addEventListener('click', function() {
        document.getElementById('confirmationOverlay').style.display = 'none';
        // Add the code to proceed to payment here
        alert('Proceeding to payment...');
    });
</script>
</body>
</html>