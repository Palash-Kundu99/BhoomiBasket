<?php
session_start(); // Start session to access session variables

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$userdb = "userdb";
$vendordb = "vendordb";

$user_conn = new mysqli($servername, $username, $password, $userdb);
$vendor_conn = new mysqli($servername, $username, $password, $vendordb);

if ($user_conn->connect_error) {
    die("Connection failed: " . $user_conn->connect_error);
}

if ($vendor_conn->connect_error) {
    die("Connection failed: " . $vendor_conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$username = $_SESSION['username'];

// Check if address form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['address'])) {
    // Address form submitted, proceed to display the invoice
    $address = [
        'address' => $_POST['address'],
        'city' => $_POST['city'],
        'state' => $_POST['state'],
        'zip' => $_POST['zip'],
        'phone' => $_POST['phone']
    ];

    // Get user_id from userdb
    $sql = "SELECT id FROM user WHERE username = ?";
    $stmt = $user_conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];
    } else {
        die("User not found");
    }

    // Calculate total amount for the invoice
    $sql = "SELECT cart.product_name, cart.quantity 
            FROM cart 
            WHERE cart.user_id = ?";
    $stmt = $user_conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $cart_result = $stmt->get_result();

    $items = [];
    $total = 0;

    while ($row = $cart_result->fetch_assoc()) {
        $product_name = $row['product_name'];
        $quantity = $row['quantity'];

        // Get selling price from vendordb
        $sql = "SELECT selling_price FROM products WHERE product_name = ?";
        $stmt = $vendor_conn->prepare($sql);
        $stmt->bind_param('s', $product_name);
        $stmt->execute();
        $price_result = $stmt->get_result();

        if ($price_result->num_rows > 0) {
            $price_row = $price_result->fetch_assoc();
            $selling_price = $price_row['selling_price'];
            $subtotal = $quantity * $selling_price;

            $items[] = [
                'product_name' => $product_name,
                'quantity' => $quantity,
                'selling_price' => $selling_price,
                'subtotal' => $subtotal
            ];

            $total += $subtotal;
        }
    }

    // Apply GST and Shipping
    $gst = $total * 0.12;
    $shipping = 15;
    $final_total = $total + $gst + $shipping;

    // Insert the address and amount paid into user_addresses table
    $sql = "INSERT INTO user_addresses (user_id, address, city, state, zip, phone, amount_paid) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $user_conn->prepare($sql);
    $stmt->bind_param('isssssd', $user_id, $address['address'], $address['city'], $address['state'], $address['zip'], $address['phone'], $final_total);
    $stmt->execute();

    $user_conn->close();
    $vendor_conn->close();
} else {
    // Initialize address as null if form has not been submitted
    $address = null;
}
?>

<?php
// (Existing PHP code remains the same)
?>

<?php
// (Existing PHP code remains the same)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .transparent-container {
            background: rgba(255, 255, 255, 0.5); /* White with 80% opacity */
            border-radius: 8px;
            padding: 15px; /* Adjust padding */
            margin: 0 auto; /* Center container */
            max-width: 800px; /* Limit width to make it smaller */
            overflow: hidden; /* Prevent scrolling */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.9); /* Optional: Add shadow for better appearance */
        }

        @media (max-width: 768px) {
            .transparent-container {
                max-width: 100%; /* Full width on smaller screens */
                padding: 10px; /* Adjust padding for smaller screens */
            }
        }

        .confetti-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 9999;
        }

        body {
            background: linear-gradient(to right, #4c824e, #f5f5f5); 
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
          
        }

        .btn-image {
    border: none;
    background: none;
    padding: 0;
}

.btn-image-icon {
    width: 80px; /* Adjust as needed */
    height: auto;
    transition: transform 0.3s ease;
}

.btn-image-icon:hover {
    transform: scale(1.1); /* Optional: slightly enlarges the image on hover */
}
.custom-swal-popup {
    width: 400px; /* Adjust the width */
    padding: 0; /* Remove default padding */
    border-radius: 10px; /* Customize border radius */
    overflow: hidden; /* Prevent content overflow */
}
.modal-content {
    background: linear-gradient(to top, #4c824e, #f5f5f5);  /* Sets the debit card/ credit card background color to white */

}

.form-label{
    backgroundColor:black;
}


    </style>
</head>
<body>
    <section class="py-3 py-md-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-9 col-xl-8 col-xxl-7">
                    <div class="transparent-container"> <!-- Transparent container start -->
                        <?php if ($address === null): ?>
                            <!-- Form for Address Input -->
                            <div class="form-container">
                                <form method="post" action="" class="address-form">
                                    <div class="row gy-3">
                                        <div class="col-12">
                                            <h4>Delivery Details</h4>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="address" class="form-label">Address</label>
                                                <input type="text" id="address" name="address" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="city" class="form-label">City</label>
                                                <input type="text" id="city" name="city" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="state" class="form-label">State</label>
                                                <input type="text" id="state" name="state" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="zip" class="form-label">ZIP Code</label>
                                                <input type="text" id="zip" name="zip" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="phone" class="form-label">Phone Number</label>
                                                <input type="text" id="phone" name="phone" class="form-control" required>
                                            </div>
                                        </div>



                                        <div class="d-flex justify-content-between mt-3">
                                                    <a href="cart.php" class="btn btn-image">
                                                    <img src="img/red.png" alt="Back" class="btn-image-icon">
                                                    </a>
                                         <button type="submit" class="btn btn-image">
                                                    <img src="img/blue.png" alt="Proceed to Checkout" class="btn-image-icon">
                                         </button>
                                        </div>

                                </form>
                            </div>
                        <?php else: ?>
                            <!-- Invoice Details -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="logo-container">
                                        <a class="d-block text-end" href="#!">
                                            <img src="img/Blogo.png" class="img-fluid" alt="BootstrapBrain Logo" width="135" height="20">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h2 class="invoice-heading text-uppercase m-0">Invoice</h2>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h4>From</h4>
                                    <address>
                                        <strong>Your Company</strong><br>
                                        Your Address<br>
                                        City, State, ZIP Code<br>
                                        Country<br>
                                        Phone: Your Phone Number<br>
                                        Email: Your Email Address
                                    </address>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-sm-6 col-md-8">
                                    <h4>Bill To</h4>
                                    <address>
                                        <strong><?php echo htmlspecialchars($username); ?></strong><br>
                                        <?php echo htmlspecialchars($address['address']); ?><br>
                                        <?php echo htmlspecialchars($address['city']); ?>, 
                                        <?php echo htmlspecialchars($address['state']); ?> 
                                        <?php echo htmlspecialchars($address['zip']); ?><br>
                                        Phone: <?php echo htmlspecialchars($address['phone']); ?><br>
                                    </address>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4">
                                    <h4>Invoice Details</h4>
                                    <div><strong>Invoice Number:</strong> 123456</div>
                                    <div><strong>Date:</strong> <?php echo date("Y-m-d"); ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Product Name</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($items as $index => $item): ?>
                                                    <tr>
                                                        <td><?php echo $index + 1; ?></td>
                                                        <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                                        <td><?php echo htmlspecialchars($item['selling_price']); ?></td>
                                                        <td><?php echo htmlspecialchars($item['subtotal']); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <tr>
                                                        <td colspan="3" class="text-end">Subtotal</td>
                                                        <td class="text-end"><?php echo number_format($total, 2); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-end">GST (12%)</td>
                                                        <td class="text-end"><?php echo number_format($gst, 2); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-end">Shipping</td>
                                                        <td class="text-end"><?php echo number_format($shipping, 2); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" colspan="3" class="text-uppercase text-end">Total</th>
                                                        <td class="text-end"><?php echo number_format($final_total, 2); ?></td>
                                                    </tr>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- Amount Paid Section -->
                                    <div class="text-end mt-3">
                                        <h4>Amount Paid: <?php echo number_format($final_total, 2); ?></h4>
                                    </div>
                                    <div class="text-end mt-3">
                                        <button id="submitPayment" class="btn btn-success">Submit Payment</button>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div> <!-- Transparent container end -->
                </div>
            </div>
        </div>
    </section>
    <canvas id="confettiCanvas" class="confetti-canvas"></canvas>
    <script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.0/dist/confetti.browser.min.js"></script>
    <script>
 


 document.addEventListener('DOMContentLoaded', function() {
    const submitPaymentButton = document.querySelector('.btn-success');
    const paymentForm = document.getElementById('paymentForm');

    submitPaymentButton.addEventListener('click', function() {
        // Show the payment modal
        const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
        paymentModal.show();
    });

    paymentForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Handle payment processing logic here

        // After processing the payment, hide the modal
        const paymentModal = bootstrap.Modal.getInstance(document.getElementById('paymentModal'));
        paymentModal.hide();

        // Custom SweetAlert with a fully customized popup
        Swal.fire({
            html: `
<div style="background-image: url('img/thank.jpg'); 
            background-size: cover; 
            background-position: center;
            padding: 90px; 
            text-align: center; 
            color: white; 
            position: relative; 
            height: 300px;"> <!-- Adjust height as needed -->
    
    <p style="color: black; margin-top: 0; position: absolute; top: 10px; left: 50%; transform: translateX(-50%);">
        Payment Successful!
    </p>
    
    <button id="customButton" class="btn btn-primary" style="position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%);">
        OK
    </button>
</div>

            `,
            showConfirmButton: false, // Hide the default confirm button
            customClass: {
                popup: 'custom-swal-popup' // Optional: Add a custom class for further styling
            }
        });

        // Add an event listener to your custom button
        document.getElementById('customButton').addEventListener('click', function() {
            Swal.close(); // Close the SweetAlert popup
            startConfetti(); // Start the confetti animation
        });
    });
});




</script>
<!-- Payment Details Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">𝐄𝐧𝐭𝐞𝐫 𝐏𝐚𝐲𝐦𝐞𝐧𝐭 𝐃𝐞𝐭𝐚𝐢𝐥𝐬</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="paymentForm">
                    <div class="mb-3">
                        <label for="cardNumber" class="form-label">𝘾𝙖𝙧𝙙 𝙉𝙪𝙢𝙗𝙚𝙧</label>
                        <input type="text" class="form-control" id="cardNumber" placeholder="𝟷𝟸𝟹𝟺 𝟻𝟼𝟽𝟾 𝟿𝟶𝟷𝟸 𝟹𝟺𝟻𝟼" required>
                    </div>
                    <div class="mb-3">
                        <label for="expiryDate" class="form-label">𝙀𝙭𝙥𝙞𝙧𝙮 𝘿𝙖𝙩𝙚</label>
                        <input type="text" class="form-control" id="expiryDate" placeholder="𝙼𝙼/𝚈𝚈" required>
                    </div>
                    <div class="mb-3">
                        <label for="cvv" class="form-label">𝘾𝙑𝙑</label>
                        <input type="text" class="form-control" id="cvv" placeholder="𝚌𝚑𝚎𝚌𝚔 𝚌𝚊𝚛𝚍'𝚜 𝚋𝚊𝚌𝚔𝚜𝚒𝚍𝚎" required>
                    </div>
                    <div class="text-end">
    <button type="submit" class="btn btn-primary" 
            style="
                background-color: #4c824e; 
                border: 2px solid black; 
                color: #ffffff; 
                width: 150px; 
                height: 50px; 
                font-size: 16px; 
                border-radius: 8px; 
                transition: background-color 0.3s ease, color 0.3s ease;
            " 
            onmouseover="this.style.backgroundColor='#f5f5f5'; this.style.color='#4c824e';"
            onmouseout="this.style.backgroundColor='#4c824e'; this.style.color='#ffffff';">
            𝐏𝐀𝐘
    </button>
</div>




                </form>
            </div>
        </div>
    </div>
</div>


</body>
</html>

