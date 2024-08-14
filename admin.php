<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$userdb = "userdb";

$conn = new mysqli($servername, $username, $password, $userdb);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the admin is logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    // Handle record deletion
    if (isset($_POST['delete_id'])) {
        $delete_id = intval($_POST['delete_id']);
        
        // Begin transaction
        $conn->begin_transaction();
        
        try {
            // Delete from cart table
            $delete_cart_sql = "DELETE FROM cart WHERE user_id = (SELECT user_id FROM user_addresses WHERE id = ?)";
            $stmt_cart = $conn->prepare($delete_cart_sql);
            $stmt_cart->bind_param("i", $delete_id);
            $stmt_cart->execute();
            $stmt_cart->close();
            
            // Delete from user_addresses table
            $delete_user_sql = "DELETE FROM user_addresses WHERE id = ?";
            $stmt_user = $conn->prepare($delete_user_sql);
            $stmt_user->bind_param("i", $delete_id);
            $stmt_user->execute();
            $stmt_user->close();
            
            // Commit transaction
            $conn->commit();
            echo '<div class="alert alert-success">Record deleted successfully.</div>';
        } catch (Exception $e) {
            // Rollback transaction if something goes wrong
            $conn->rollback();
            echo '<div class="alert alert-danger">Error deleting record: ' . $e->getMessage() . '</div>';
        }
    }

    // Fetch user addresses with aggregated cart quantities and amount paid
    $sql = "SELECT ua.*, GROUP_CONCAT(CONCAT(c.product_name, ' (', c.quantity, ')') ORDER BY c.product_name SEPARATOR ', ') AS products, ua.amount_paid
            FROM user_addresses ua
            LEFT JOIN cart c ON ua.user_id = c.user_id
            GROUP BY ua.id";
    $result = $conn->query($sql);

    // Handle logout
    if (isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
} else {
    // Handle login
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $admin_password = $_POST['password'];
        
        // Replace 'admin_password' with the actual password you want to use
        if ($admin_password === '390') {
            $_SESSION['admin_logged_in'] = true;
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $error_message = 'Invalid password';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - User Addresses</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 20px;
        }
        .table-container {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .table-container h2 {
            margin-bottom: 20px;
        }
        .table th, .table td {
            text-align: center;
        }
        .product-list {
            text-align: left;
        }
        .btn-delete {
            color: #dc3545;
            border: none;
            background: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true): ?>
            <!-- Admin Login Form -->
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mt-5">
                        <div class="card-body">
                            <h4 class="card-title">Admin Login</h4>
                            <?php if (isset($error_message)): ?>
                                <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
                            <?php endif; ?>
                            <form method="post" action="">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" id="password" name="password" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- User Addresses Table -->
            <div class="table-container">
                <h2>User Addresses</h2>
                <form method="post" action="">
                    <button type="submit" name="logout" class="btn btn-danger mb-3">Logout</button>
                </form>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>State</th>
                            <th>ZIP</th>
                            <th>Phone</th>
                            <th>Products</th> <!-- Aggregated Product Column -->
                            <th>Amount Paid</th> <!-- Amount Paid Column -->
                            <th>Action</th> <!-- Delete Action Column -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                                    <td><?php echo htmlspecialchars($row['city']); ?></td>
                                    <td><?php echo htmlspecialchars($row['state']); ?></td>
                                    <td><?php echo htmlspecialchars($row['zip']); ?></td>
                                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                    <td class="product-list"><?php echo htmlspecialchars($row['products']); ?></td> <!-- Display Aggregated Products -->
                                    <td><?php echo htmlspecialchars($row['amount_paid']); ?></td> <!-- Display Amount Paid -->
                                    <td>
                                        <form method="post" action="">
                                            <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                            <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this record?');">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10">No records found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
