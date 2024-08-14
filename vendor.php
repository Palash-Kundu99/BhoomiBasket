<?php
session_start();

// Check if vendor is logged in
if (!isset($_SESSION['vendor_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vendorDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$vendor_id = $_SESSION['vendor_id'];

// Fetch vendor's name
$vendor_name = '';
$stmt = $conn->prepare("SELECT username FROM vendors WHERE id = ?");
$stmt->bind_param("i", $vendor_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $vendor = $result->fetch_assoc();
    $vendor_name = htmlspecialchars($vendor['username']);
}

// Handle form submission for adding a new product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $regular_price = $_POST['regular_price'];
    $selling_price = $_POST['selling_price'];
    $description = $_POST['description'];

    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image = $target_file;

        $stmt = $conn->prepare("INSERT INTO products (vendor_id, product_name, regular_price, selling_price, image, description)
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $vendor_id, $product_name, $regular_price, $selling_price, $image, $description);

        if ($stmt->execute()) {
            $_SESSION['message'] = 'New product added successfully!';
        } else {
            $_SESSION['message'] = 'Error: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = 'Sorry, there was an error uploading your file.';
    }
    header("Location: vendor.php");
    exit();
}

// Handle product deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_product'])) {
    $product_id = $_POST['product_id'];
    $stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (file_exists($row['image'])) {
            unlink($row['image']);
        }
    }

    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    if ($stmt->execute()) {
        $_SESSION['message'] = 'Product deleted successfully!';
    } else {
        $_SESSION['message'] = 'Error deleting product: ' . $stmt->error;
    }
    $stmt->close();
    header("Location: vendor.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Dashboard</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a>
                        <img src="img/Blogo.png" alt="Logo" width="60" height="60" style="max-width: 100%; height: auto;">
                    </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    Welcome, <?php echo $vendor_name; ?>
                </span>
                <form action="index.php" method="post" class="ml-3">
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </nav>
    </header>
    
    <!-- Main Layout -->
    <main style="margin-top: 58px;">
        <div class="container mt-4">
            <div class="row">
                <div class="col-lg-4">
                    <!-- Accordion -->
                    <div class="accordion" id="vendorAccordion">
                        <!-- Product List Section -->
                        <div class="card">
                            <div class="card-header" id="headingProductList">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseProductList" aria-expanded="true" aria-controls="collapseProductList">
                                    𝗣𝗿𝗼𝗱𝘂𝗰𝘁 𝗟𝗶𝘀𝘁

                                    </button>
                                </h5>
                            </div>
                            <div id="collapseProductList" class="collapse show" aria-labelledby="headingProductList" data-parent="#vendorAccordion">
                                <div class="card-body">
                                    <!-- Product list content here -->
                                    <?php
                                    // Reconnect to the database to fetch and display products
                                    $conn = new mysqli($servername, $username, $password, $dbname);
                                    $stmt = $conn->prepare("SELECT * FROM products WHERE vendor_id = ?");
                                    $stmt->bind_param("i", $vendor_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<div class='d-flex align-items-center mb-3 p-3 border rounded'>";
                                            echo "<img src='" . htmlspecialchars($row['image']) . "' alt='Product Image' class='img-thumbnail' style='width: 150px; height: 150px; object-fit: cover;'>";
                                            echo "<div class='ml-3'>";
                                            echo "<h5>" . htmlspecialchars($row['product_name']) . "</h5>";
                                            echo "<p>Regular Price: ₹" . number_format($row['regular_price'], 2) . "</p>";
                                            echo "<p>Selling Price: ₹" . number_format($row['selling_price'], 2) . "</p>";
                                            echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                                            echo "<form action='vendor.php' method='post' class='mt-2'>";
                                            echo "<input type='hidden' name='delete_product' value='1'>";
                                            echo "<input type='hidden' name='product_id' value='" . htmlspecialchars($row['id']) . "'>";
                                            echo "<button type='submit' class='btn btn-danger'>Delete</button>";
                                            echo "</form>";
                                            echo "</div>";
                                            echo "</div>";
                                        }
                                    } else {
                                        echo "<p>List Your First Product</p>";
                                    }

                                    $stmt->close();
                                    $conn->close();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Accordion -->
                </div>

                <div class="col-lg-8">
                    <!-- Add Product Form -->
                    <div class="form-container mb-4 p-4 bg-light rounded shadow">
                        <h1 class="mb-4">𝗔𝗱𝗱 𝗮 𝘆𝗼𝘂𝗿 𝗽𝗿𝗼𝗱𝘂𝗰𝘁</h1>
                        <form action="vendor.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="add_product" value="1">
                            <div class="form-group">
                                <label for="product_name">𝐏𝐫𝐨𝐝𝐮𝐜𝐭 𝐍𝐚𝐦𝐞:</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" required>
                            </div>
                            <div class="form-group">
                                <label for="regular_price">𝐑𝐞𝐠𝐮𝐥𝐚𝐫 𝐏𝐫𝐢𝐜𝐞:</label>
                                <input type="text" class="form-control" id="regular_price" name="regular_price" required>
                            </div>
                            <div class="form-group">
                                <label for="selling_price">𝐒𝐞𝐥𝐥𝐢𝐧𝐠 𝐏𝐫𝐢𝐜𝐞:</label>
                                <input type="text" class="form-control" id="selling_price" name="selling_price" required>
                            </div>
                            <div class="form-group">
                                <label for="image">𝐈𝐦𝐚𝐠𝐞:</label>
                                <input type="file" class="form-control" id="image" name="image" required>
                            </div>
                            <div class="form-group">
                                <label for="description">𝐃𝐞𝐬𝐜𝐫𝐢𝐩𝐭𝐢𝐨𝐧:</label>
                                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">【Ｓｕｂｍｉｔ】</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Main Layout -->

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="vendor.js"></script>
</body>
</html>

