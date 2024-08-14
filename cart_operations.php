<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$action = isset($_POST['action']) ? $_POST['action'] : '';
$product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];

if ($action == 'add') {
    if (empty($product_name) || $quantity <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid input data']);
        exit;
    }

    $sql = "SELECT id, quantity FROM cart WHERE product_name = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $product_name, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $new_quantity = $row['quantity'] + $quantity;
        $sql = "UPDATE cart SET quantity = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $new_quantity, $row['id']);
        $stmt->execute();
    } else {
        $sql = "INSERT INTO cart (product_name, quantity, user_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sii', $product_name, $quantity, $user_id);
        $stmt->execute();
    }

} elseif ($action == 'remove') {
    if (empty($product_name)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input data']);
        exit;
    }

    $sql = "SELECT id, quantity FROM cart WHERE product_name = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $product_name, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $new_quantity = $row['quantity'] - $quantity;

        if ($new_quantity > 0) {
            $sql = "UPDATE cart SET quantity = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ii', $new_quantity, $row['id']);
            $stmt->execute();
        } else {
            $sql = "DELETE FROM cart WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $row['id']);
            $stmt->execute();
        }
    }
}

$sql = "SELECT SUM(quantity) as count FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$cartCount = $row['count'] ?: 0;

$conn->close();

echo json_encode(['success' => true, 'cartCount' => $cartCount]);
?>
