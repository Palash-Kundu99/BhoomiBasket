<?php
session_start(); // Start session to access session variables

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vendorDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="home.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Navigation Bar -->
    <header>
        <nav>
            <ul>
                <li><a href="/f1/index.php">Home</a></li>
                <li><a href="#">Profile</a></li>
                
                <li><a href="index.php">Logout</a></li>
                <a href="cart.php" style="display: flex; align-items: center;">
                    <img src="img/cart.png" alt="Cart" style="width: 29px; height: 29px; margin-right: 10px;">
                    <span id="cart-count" style="font-size: 16px; color: white;">0</span>
                </a>
            </ul>
            <div class="welcome-message">
                Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
            </div>
        </nav>
    </header>

    <div class="product-container">
        <h1>Available Products</h1>
        <div class="row">
            <?php
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='product-card' data-product-id='" . htmlspecialchars($row['id']) . "' data-product-name='" . htmlspecialchars($row['product_name']) . "' data-product-price='" . htmlspecialchars($row['selling_price']) . "'>";
                    echo "<img src='" . htmlspecialchars($row['image']) . "' alt='Product Image'>";
                    echo "<div class='product-details'>";
                    echo "<h2>" . htmlspecialchars($row['product_name']) . "</h2>";
                    echo "<p class='price'>Regular Price: ₹" . number_format($row['regular_price'], 2) . "</p>";
                    echo "<p class='price'>Selling Price: ₹" . number_format($row['selling_price'], 2) . "</p>";
                    echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                    echo "<div class='cart-controls'>";
                    echo "<button class='remove-from-cart' data-product-id='" . htmlspecialchars($row['id']) . "'>-</button>";
                    

                    echo "<button class='add-to-cart' data-product-id='" . htmlspecialchars($row['id']) . "'>+</button>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No products found</p>";
            }

            $conn->close();
            ?>
            
        </div>
    </div>
    
    <script src="home.js"></script>
</body>
</html>
