<?php
session_start();

$servername = "localhost";
$username = "chaitu";
$password = "RAJIVCHAITU143";
$dbname = "smarteducation";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash the password
$enteredOtp = $_POST['otp'];

// You need to get 'dob' from POST data
$dob = $_POST['dob'];

if ($enteredOtp == $_SESSION['otp'] && time() - $_SESSION['otp_time'] <= 180) { // changed from 300 to 180
    
    // Insert user data into the database
    $stmt = $conn->prepare("INSERT INTO users (name, email, dob, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $dob, $hashed_password);
    $stmt->execute();

    echo "<script>alert('Sign up successful!'); window.location.href='login.html';</script>";
} else {
    // OTP is incorrect or expired, show an error message and redirect back to sign-up page
    echo "<script>alert('The OTP entered is incorrect or expired.'); window.location.href='signup.html';</script>";
}
?>
