<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vendorDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO vendors (username, password) VALUES ('$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        // Set success message
        session_start();
        $_SESSION['message'] = "Registration successful! You can now log in.";
        
        // Redirect to v.php with hash to show login section
        header("Location: http://localhost/f1/v.php#login-section");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
