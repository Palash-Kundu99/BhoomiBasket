<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$userdb = "userdb";

$user_conn = new mysqli($servername, $username, $password, $userdb);

if ($user_conn->connect_error) {
    die("Connection failed: " . $user_conn->connect_error);
}

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$username = $_SESSION['username'];

// Handle quantity update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['proceed_checkout'])) {
    foreach ($_POST['product_name'] as $index => $product_name) {
        $quantity = $_POST['quantity'][$index];

        if ($quantity > 0) {
            // Update quantity
            $sql = "UPDATE cart 
                    SET quantity = ? 
                    WHERE user_id = (SELECT id FROM user WHERE username = ?) AND product_name = ?";
            $stmt = $user_conn->prepare($sql);
            $stmt->bind_param('iss', $quantity, $username, $product_name);
            $stmt->execute();
        } else {
            // Remove item if quantity is 0 or less
            $sql = "DELETE FROM cart 
                    WHERE user_id = (SELECT id FROM user WHERE username = ?) AND product_name = ?";
            $stmt = $user_conn->prepare($sql);
            $stmt->bind_param('ss', $username, $product_name);
            $stmt->execute();
        }
    }

    // Redirect to checkout page
    header('Location: bill.php');
    exit;
}

// Fetch cart items
$sql = "SELECT cart.product_name, cart.quantity 
        FROM cart 
        WHERE cart.user_id = (SELECT id FROM user WHERE username = ?)";
$stmt = $user_conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$cart_result = $stmt->get_result();

$cart_items = [];
while ($row = $cart_result->fetch_assoc()) {
    $cart_items[] = $row;
}

$user_conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
}

body {
    background: linear-gradient(to right, #4c824e, #f5f5f5);
    font-family: 'Arial', sans-serif;
    color: #333;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* Cart Layout */
.cart-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); /* Creates a grid layout */
    gap: 1rem; /* Space between items */
    padding: 1rem;
    width: 100%;
    max-width: 600px;
    margin: 0 auto;
}

.cart-item {
    background-color: rgba(255, 255, 255, 0.5);
    border-radius: 12px;
    padding: 1rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Adjustments for Card and Content */
.card {
    width: 500px; /* Fixed width */
    height: 500px; /* Increased height */
    padding: 1rem; /* Adjusted padding */
    background-color: rgba(255, 255, 255, 0.5);
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    position: fixed; /* Fix the card in place */
    top: 50%; /* Move it halfway down the screen */
    left: 50%; /* Move it halfway across the screen */
    transform: translate(-50%, -50%); /* Center it precisely */
    overflow: auto; /* Adds scrollbars if content overflows */
}

.card-body {
    padding: 0.5rem; /* Adjusted padding */
    overflow: auto; /* Ensures content can scroll if too large */
    height: calc(100% - 2rem); /* Adjust to account for padding */
}




.table {
    border-collapse: collapse;
    width: 100%;
}

.table thead th {
    background-color: #4c824e;
    color: #ffffff;
    font-weight: 700;
    padding: 0.75rem;
    text-align: left;
}

.table tbody tr:nth-child(even) {
    background-color: #f4f4f4;
}

.table tbody tr:hover {
    background-color: #e0e0e0;
}

.table tbody td {
    padding: 0.85rem;
    border-bottom: 1px solid #e0e0e0;
}

.form-control {
    border-radius: 8px;
    border: 1px solid #ccc;
    padding: 0.75rem 1.25rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
    text-align: center;
}

.form-control:focus {
    border-color: #1E90FF;
    box-shadow: 0 0 0 0.2rem rgba(30, 144, 255, 0.25);
}

.btn-custom {
    background-color: #4c824e;
    color: #ffffff;
    border-radius: 8px;
    font-weight: 700;
    padding: 0.75rem 1.5rem;
    border: none;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.btn-custom:hover {
    background-color: #f5f5f5;
    transform: translateY(-2px);
}

.btn-custom:focus, .btn-custom:active {
    box-shadow: 0 0 0 0.2rem rgba(30, 144, 255, 0.5);
    outline: none;
}

.input-group {
    display: flex;
    align-items: center;
    border-radius: 8px;
    overflow: hidden;
}

.input-group .btn {
    border-radius: 0;
    border: 1px solid #ccc;
    background-color: #f4f4f4;
    color: #333;
    width: 40px;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
}

.input-group .btn.red {
    background-color: #FF6F6F;
    color: #fff;
}

.input-group .btn.red:hover {
    background-color: #FF4C4C;
}

.input-group .btn.green {
    background-color: #4CAF50;
    color: #fff;
}

.input-group .btn.green:hover {
    background-color: #45A049;
}

.input-group .form-control {
    border-radius: 0;
    border: 1px solid #ccc;
}

.input-group .btn:first-child {
    border-right: none;
}

.btn-action {
    border: none;
    width: 40px;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
}

.btn-action.red {
    background-color: #FF6F6F;
    color: #fff;
}

.btn-action.red:hover {
    background-color: #FF4C4C;
}

.btn-action.green {
    background-color: #4CAF50;
    color: #fff;
}

.btn-action.green:hover {
    background-color: #45A049;
}

.btn-image {
    border: none;
    background: none;
    padding: 0;
}

.btn-image-icon {
    width: 40px;
    height: auto;
}

.input-group .form-control {
    border-radius: 0;
    border: 1px solid #ccc;
    text-align: center;
}

.btn-image {
    border: none;
    background: none;
    padding: 0;
}

.btn-image-icon {
    width: 80px;
    height: auto;
    transition: transform 0.3s ease;
}

.btn-image-icon:hover {
    transform: scale(1.1);
}


          

    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">𝐘𝐨𝐮𝐫 𝐂𝐚𝐫𝐭</h2>
        </div>
        <div class="card-body">
            <form method="post" action="">
                <?php if (count($cart_items) > 0): ?>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>𝐏𝐫𝐨𝐝𝐮𝐜𝐭</th>
                                <th>𝐐𝐮𝐚𝐧𝐭𝐢𝐭𝐲</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart_items as $index => $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                <td>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-action red" onclick="adjustQuantity(this, -1)">-</button>
                                        <input type="number" name="quantity[]" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="0" class="form-control text-center" readonly>
                                        <button type="button" class="btn btn-action green" onclick="adjustQuantity(this, 1)">+</button>
                                        <input type="hidden" name="product_name[]" value="<?php echo htmlspecialchars($item['product_name']); ?>">
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="text-center">
                        <button type="submit" name="proceed_checkout" class="btn btn-custom">𝐏𝐫𝐨𝐜𝐞𝐞𝐝 𝐭𝐨 𝐂𝐡𝐞𝐜𝐤𝐨𝐮𝐭</button>
                    </div>
                <?php else: ?>
                    <p class="text-center">𝐘𝐨𝐮𝐫 𝐜𝐚𝐫𝐭 𝐢𝐬 𝐞𝐦𝐩𝐭𝐲. <a href="home.php">𝐂𝐨𝐧𝐭𝐢𝐧𝐮𝐞 𝐬𝐡𝐨𝐩𝐩𝐢𝐧𝐠.</a></p>
                <?php endif; ?>
            </form>
        </div>
    </div>

   
    <script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function adjustQuantity(button, delta) {
            var input = button.closest('.input-group').querySelector('input[name="quantity[]"]');
            var newValue = parseInt(input.value) + delta;
            if (newValue >= 0) { // Prevent negative quantities
                input.value = newValue;
            }
        }
    </script>
</body>
</html>
