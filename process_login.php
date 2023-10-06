<?php
// Start or resume the session
session_start();

// Establish a database connection (replace with your MySQL credentials)
$servername = "localhost";
$username = "chaitu";
$password = "RAJIVCHAITU143";
$dbname = "smarteducation";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user input from the login form (validate and sanitize inputs)
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Query the database using prepared statements
$stmt = $conn->prepare("SELECT name, dob, email, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    // User found, verify the password
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        // Password is correct, store the user's details in the session
        $_SESSION['name'] = $row['name'];
        $_SESSION['dob'] = $row['dob'];
        $_SESSION['email'] = $row['email'];
        
        // Calculate age from dob
        $dob = new DateTime($row['dob']);
        $now = new DateTime();
        $age = $now->diff($dob)->y;
        $_SESSION['age'] = $age;

        // Verify session data (for debugging)
        var_dump($_SESSION);

        // Redirect to the home page
        header("Location: home.html");
        exit;
    } else {
        echo "Incorrect password. <a href='login.html'>Try again</a>";
    }
} else {
    echo "User not found. <a href='login.html'>Try again</a>";
}

// Close the database connection
$stmt->close();
$conn->close();
?>
