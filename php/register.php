<?php
include 'Koneksi.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $mobilePhone = $_POST['mobilePhone'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $birthDate = $_POST['birthDate'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate passwords
    if ($password !== $confirmPassword) {
        $message = "Passwords do not match.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, mobile_phone, email, username, birth_date, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $firstName, $lastName, $mobilePhone, $email, $username, $birthDate, $hashedPassword);

        // Execute the statement
        if ($stmt->execute()) {
            $message = "New record created successfully";

            // Start session and set email value
            session_start();
            $_SESSION['email'] = $email;

            // Redirect to verification page after displaying success message
            header("Location: verification.php");
            exit(); // Ensure to exit after header redirection
        } else {
            $message = "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>StayEase Hotels</title>
  <link rel="stylesheet" href="../CSS/register.css">
</head>
<body>
  <header>
    <nav>
        <img src="../IMG/Logo.png" alt="Logo">
        <ul>
          <li><button class="login-button" id="loginBtn">LOGIN</button></li>
          <li><button class="signup-button">SIGN UP</button></li>
      </ul>          
    </nav>
  </header>
 
  <div class="container">
      <h2>Activate Your Account</h2>
      <?php if ($message): ?>
          <p><?php echo $message; ?></p>
      <?php endif; ?>
      <form action="register.php" method="post">
          <label for="firstName">Profile Information</label>
          <input type="text" id="firstName" name="firstName" placeholder="First Name" required>
          <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>
          <input type="tel" id="mobilePhone" name="mobilePhone" placeholder="Mobile Phone" required>
          <input type="email" id="email" name="email" placeholder="Email" required>
          <input type="text" id="username" name="username" placeholder="Username" required>
          <label for="birthDate">Birth Date (MM-DD-YY)</label>
          <input type="date" id="birthDate" name="birthDate" required>
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Create Password" required 
                 pattern="(?=.*[a-zA-Z])(?=.*[0-9!$#%]).{8,}" 
                 title="At least 8 characters long, case sensitive, can contain !$#%, no spaces">
          <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required
                 pattern="(?=.*[a-zA-Z])(?=.*[0-9!$#%]).{8,}" 
                 title="At least 8 characters long, case sensitive, can contain !$#%, no spaces">
          <div class="detail-item">
              <img src="../IMG/attention-circle.svg" alt="Attention">
              <p>At least 8 characters long, case sensitive, can contain !$#%, no spaces</p>
          </div>
          <input type="submit" value="SIGN UP">
      </form>
  </div>
</body>
</html>
