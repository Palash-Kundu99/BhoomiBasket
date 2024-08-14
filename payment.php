<?php
session_start(); // Start session to access session variables

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$username = $_SESSION['username'];

// Get user_id from userdb
$sql = "SELECT id FROM user WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_id = $row['id'];
} else {
    die("User not found");
}

// Insert address into user_addresses table
$sql = "INSERT INTO user_addresses (user_id, address, city, state, zip, phone) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('isssss', $user_id, $_POST['address'], $_POST['city'], $_POST['state'], $_POST['zip'], $_POST['phone']);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Address saved successfully
    header('Location: admin.php'); // Redirect to admin page
    exit;
} else {
    die("Failed to save address");
}

$conn->close();
?>
