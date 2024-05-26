<?php
session_start();
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir pemesanan
    $fullname = isset($_POST['fullName']) ? $conn->real_escape_string($_POST['fullName']) : '';
    $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
    $country_code = isset($_POST['countryCode']) ? $conn->real_escape_string($_POST['countryCode']) : '';
    $phone = isset($_POST['mobileNumber']) ? $conn->real_escape_string($_POST['mobileNumber']) : '';
    $bedtype = isset($_POST['bedType']) ? $conn->real_escape_string($_POST['bedType']) : '';
    $check_in = isset($_POST['check_in']) ? $conn->real_escape_string($_POST['check_in']) : '';
    $check_out = isset($_POST['check_out']) ? $conn->real_escape_string($_POST['check_out']) : '';
    $room_id = isset($_POST['room_id']) ? $conn->real_escape_string($_POST['room_id']) : '';

    // Memastikan tidak ada field yang kosong
    if (empty($fullname) || empty($email) || empty($country_code) || empty($phone) || empty($bedtype) || empty($check_in) || empty($check_out) || empty($room_id)) {
        echo "Please fill in all required fields.";
    } else {
        // Menyiapkan statement SQL untuk memasukkan data pemesanan ke dalam tabel bookings
        $stmt = $conn->prepare("INSERT INTO bookings (fullname, email, phone, bed_type, room_id, check_in, check_out) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            // Bind parameter ke statement
            $stmt->bind_param("ssssiss", $fullname, $email, $country_code . $phone, $bedtype, $room_id, $check_in, $check_out);
            // Melakukan eksekusi statement
            if ($stmt->execute()) {
                // Jika berhasil, redirect ke halaman pembayaran
                header("Location: pay.php");
                exit();
            } else {
                // Jika gagal, tampilkan pesan error
                echo "Error: " . $stmt->error;
            }
            // Menutup statement
            $stmt->close();
        } else {
            // Jika gagal menyiapkan statement, tampilkan pesan error
            echo "Error: Unable to prepare statement.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accommodation Booking</title>
    <link rel="stylesheet" href="../CSS/Booking.css">
    <style>
        /* Tambahkan CSS tambahan disini */
    </style>
</head>
<body>
<header>
    <nav>
        <img src="../IMG/Logo.png" alt="Logo" class="logo">
        <ul>
            <li class="spacer"></li>
            <li><a href="Regist.html" class="home">Home</a></li>
            <li><a href="#" class="history">History</a></li>
        </ul>
        <img src="../IMG/Phone.svg" alt="Phone" class="phone-icon">
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
            <div>Check-in: Thu, 09 May 2024 - 3:00 PM</div>
            <div>Check-out: Fri, 10 May 2024 - 12:00 PM</div>
            <div>Superior Room</div>
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
        <form method="POST" action="pay.php">
            <div class="form-group">
                <label for="fullName">Full Name</label>
                <input type="text" id="fullName" name="fullName" placeholder="As in Passport/Official ID Card (without title/special characters)">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="We will send the e-voucher to this email.">
            </div>
            <div class="form-group mobile-group">
                <label for="mobileNumber">Mobile Number</label>
                <select id="countryCode" name="countryCode">
                    <option value="+62">+62 Indonesia</option>
                    <!-- Tambahkan opsi negara lain sesuai kebutuhan -->
                </select>
                <input type="text" id="mobileNumber" name="mobileNumber" placeholder="0812345678">
            </div>
            <div class="form-group">
                <label for="bedType">Bed Type</label>
                <select id="bedType" name="bedType">
                    <option value="1 King Bed">1 King Bed</option>
                    <option value="2 Twin Bed">2 Twin Bed</option>
                </select>
            </div>
            <div class="price-details">
                <div>Room Price: Rp 99</div>
                <div>(1x) Superior Room (1 night)</div>
                <div>Other Taxes and Fees: Rp 99</div>
                <div class="line"></div>
                <div>Total Price: Rp 198</div>
            </div>
            <div class="continue-button">
                <button type="submit" id="continueButton">CONTINUE TO PAYMENT</button>
            </div>
        </form>
    </div>
</div>

<div class="overlay" id="confirmationOverlay">
    <div class="overlay-content">
        <p>Are the details correct?</p>
        <button class="overlay-button" id="proceedButton">Proceed</button>
    </div>

    </div>
<script>
    document.getElementById('continueButton').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('confirmationOverlay').style.display = 'flex';
    });
    document.getElementById('proceedButton').addEventListener('click', function() {
    document.getElementById('confirmationOverlay').style.display = 'none';
    // Redirect ke halaman pembayaran (pay.php)
    window.location.href = 'pay.php';
    });
</script>

</body>
</html>
