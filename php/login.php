<?php
session_start();
include('Koneksi.php');
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (!empty($username) && !empty($password)) {
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
    } else {
        $error = "Please enter both username and password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <link rel="stylesheet" type="text/css" href="../CSS/Login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
        <nav>
            <img src="../IMG/Logo.png" alt="Logo">
            <ul>
                <li><button class="login-button" id="loginBtn">LOGIN</button></li>
                <li><a href="register.php"><button class="signup-button">SIGN UP</button></a></li>
            </ul>
        </nav>
    </header>

    <div class="hotel-info">
        <div class="carousel">
            <div class="image-container">
                <img src="../img/Slide.svg" alt="Hotel Image" class="lightbox-trigger">
                <div class="lightbox">
                    <span class="prev">&#10094;</span>
                    <img src="Slide.svg" alt="Hotel Image" class="lightbox-image">
                    <span class="next">&#10095;</span>
                    <p>Another Room</p>
                </div>
            </div>

            <div class="image-container">
                <img src="../img/slide2.svg" alt="Hotel Image" class="lightbox-trigger">
                <div class="lightbox">
                    <span class="prev">&#10094;</span>
                    <img src="slide2.svg" alt="Hotel Image" class="lightbox-image">
                    <p>Another Room</p>
                </div>
            </div>
        </div>

        <div class="hotel-details">
            <h2>StayEase Hotel Lampung</h2>
            <img src="../IMG/Group 19.png" alt="Star" class="star-image">
            <div class="detail-item">
                <img src="../IMG/Message.svg" alt="Email">
                <p>stayease.lampung@stayease.com</p>
            </div>
            <div class="detail-item">
                <img src="../IMG/Vector 189.svg" alt="Phone">
                <p>+62 721 12345667</p>
            </div>
            <div class="detail-item">
                <img src="../IMG/Pin.svg" alt="Address">
                <p>Jl. Kesambi No.7, Lempongsari,<br>Gajah Terbang, Bandar Lampung 50231<br>Lampung, Indonesia</p>
            </div>
        </div>
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
