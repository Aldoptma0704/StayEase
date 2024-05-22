<?php
session_start();
include('Koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['login_user'] = $username;
            $_SESSION['is_admin'] = $row['is_admin'];
            
            // Redirect based on user role
            if ($row['is_admin'] == 1) {
                header("Location: dashboard.php"); // Redirect to admin dashboard
            } else {
                header("Location: HomePage.php"); // Redirect to user homepage
            }
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home Page</title>
    <link rel="stylesheet" type="text/css" href="../CSS/HomePage.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
        <nav>
            <img src="../IMG/Logo.png" alt="Logo">
            <ul>
                <li><a href="HomePage.php"><h4>HOME</h4></a></li>
                <li><a href="history.php"><h4>HISTORY</h4></a></li>
                <li><a href="#"><img src="../IMG/icon.svg" alt=""></a></li>
            </ul>
        </nav>
    </header>

    <div class="hotel-info">
    <h1><b>StayEase Hotel Lampung</b><img src="../IMG/Group 19.png" alt="star"></h1>
    <ul>
        <li><img src="../IMG/PIN.svg" alt="Pin" class="Pin"><p><b>Jl. Kesambi No.7, Lempongsari, Gajah Terbang, Bandar Lampung, 50231, Lampung, Indonesia | <img src="../IMG/Vector 189.svg" alt="Phone" class="Phone"> +62 721 1234567 | <img src="../IMG/Message.svg" alt="Email" class="Email"> stayease.lampung@stayease.com</b></p></li>
    </ul>
</div>


    <div class="welcome_section">
        <img src="../IMG/Group 7.png" alt="Logo" class="logo-image">
    </div>

    <div class="rooms-container">
        <div class="room-info">
            <div class="room-image">
                <img src="../IMG/Property 1=Variant2.svg" alt="Gambar kamar hotel" class="lightbox-trigger">
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
                    <button><p>Refrigerator</p></button>
                    <button><p>Air conditioning</p></button>
                </div>
            </div>
        </div>

        <div class="room-info">
            <div class="room-image">
                <img src="../IMG/Property 1=Default.svg" alt="Gambar kamar hotel" class="lightbox-trigger">
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
                <img src="../IMG/Property 1=Default (1).svg" alt="Gambar kamar hotel" class="lightbox-trigger">
            </div>
            <div class="room-details">
                <h2>Junior Room</h2>
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
                <img src="../IMG/room4.svg" alt="Gambar kamar hotel" class="lightbox-trigger">
            </div>
            <div class="room-details">
                <h2>Executive Suite</h2>
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
                <img src="../IMG/room5.svg" alt="Gambar kamar hotel" class="lightbox-trigger">
            </div>
            <div class="room-details">
                <h2>Executive Suite</h2>
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


    <section class="login-section" id="loginSection"> 
        <h2>
            <span class="text-black">Welcome to</span>
            <span class="text-blue">StayEase</span>
            <span class="text-black">Hotels</span>
        </h2>

        <p>LOGIN TO STAYEASE HOTELS AND START ENJOYING MORE WITH EACH STAY</p>
        <p>Sign in with your email/username and password</p>

        <form action="login.php" method="post"> <!-- Corrected action -->
            <label for="username" class="form-label">Email/username *</label>
            <input type="text" id="username" name="username" class="form-input" required>
            
            <label for="password" class="form-label">Password *</label>
            <input type="password" id="password" name="password" class="form-input" required>

            <button type="submit">LOGIN</button>
        </form>
        <p>Not yet a member? <a href="register.php">Register now</a></p>
        <button type="submit">SIGN UP</button>
    </section>

    <div><?php if(isset($error)) { echo $error; } ?></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../JS/Login.js"></script>
</body>
</html>


<?php
$sarvername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_management";

$conn = new mysqli($sarvername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
