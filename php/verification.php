<?php
session_start();
$email = $_SESSION['email'];

// Check if email is available in session
if (!$email) {
    // Redirect to another page if email is not available
    header("Location: register.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link rel="stylesheet" href="../CSS/verification.css">
</head>
<body>
    <header>
        <nav>
            <img src="../IMG/Logo.png" alt="Logo">         
        </nav>
    </header>

    <div class="container">
        <h2 style="text-align: center;">VERIFICATION</h2>
        <img src="../IMG/verify.svg" alt="Verification Image" style="display: block; margin: 0 auto; width: 200px; height: auto;">
        <p style="text-align: center;">Verify your email</p>
        <p style="text-align: center;">We have sent an email to <?php echo $email; ?> to confirm the validity of your email address. After receiving the email, follow the link provided to complete your registration.</p>
        <form action="confirmation.php" method="post" style="text-align: center;">
            <input type="hidden" name="email" value="<?php echo $email; ?>">
            <button type="submit">Confirm Email</button>
        </form>
    </div>
</body>
</html>

