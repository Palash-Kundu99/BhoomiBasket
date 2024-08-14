<?php
session_start();

$host = 'localhost'; 
$db = 'userdb'; 
$user = 'root'; 
$pass = ''; 
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$message = '';
$form = 'register'; // Default to registration form

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['register'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if (!empty($username) && !empty($password)) {
            $stmt = $pdo->prepare('SELECT id FROM user WHERE username = ?');
            $stmt->execute([$username]);
            if ($stmt->rowCount() > 0) {
                $message = "Username already exists. Please choose a different username.";
            } else {
                $passwordHash = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $pdo->prepare('INSERT INTO user (username, password) VALUES (?, ?)');
                $stmt->execute([$username, $passwordHash]);
                $message = "Registration successful! Please log in.";
                $form = 'login'; // Switch to login form after registration
            }
        } else {
            $message = "Please fill in all fields.";
        }
    } elseif (isset($_POST['login'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if (!empty($username) && !empty($password)) {
            $stmt = $pdo->prepare('SELECT id, password FROM user WHERE username = ?');
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $user['id']; // Store user ID in session
                header('Location: /f1/home.php'); // Redirect to a dashboard or home page
                exit;
            } else {
                $message = "Invalid username or password.";
            }
        } else {
            $message = "Please fill in all fields.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="user.css">
    <title>User Registration and Login</title>
    <script>
        function toggleForm() {
            const registerForm = document.getElementById('register-form');
            const loginForm = document.getElementById('login-form');
            const toggleLink = document.getElementById('toggle-link');

            if (registerForm.style.display === 'none') {
                registerForm.style.display = 'block';
                loginForm.style.display = 'none';
                toggleLink.textContent = 'Already registered? Log in here';
            } else {
                registerForm.style.display = 'none';
                loginForm.style.display = 'block';
                toggleLink.textContent = 'Not registered? Register here';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const message = '<?php echo htmlspecialchars($message, ENT_QUOTES, "UTF-8"); ?>';
            const form = '<?php echo $form; ?>';
            if (message) {
                const messageElement = document.getElementById('message');
                messageElement.textContent = message;
                messageElement.style.display = 'block';

                // Automatically switch to login form immediately after showing the message
                if (form === 'login') {
                    toggleForm(); // Instantly switch to login form
                }
            }
        });
    </script>
</head>
<body>
    <!-- Navbar -->
    <nav>
        <ul>
            <li><a href="/f1/index.php">Home</a></li>
            <li><a href="/f1/#about-us">About</a></li>
            <li><a href="/f1/#featured-products">Explore</a></li>
            <li><a href="/f1/#contact">Contact</a></li>
        </ul>
    </nav>
    <div class="container">
        <div class="form-container">
            <div id="message" class="message" style="display: none;"></div>
            <div id="register-form">
                <h2>Register</h2>
                <form action="user.php" method="POST">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" name="register">Register</button>
                </form>
                <p><a href="javascript:void(0);" id="toggle-link" onclick="toggleForm()">Already registered? Log in here</a></p>
            </div>
            <div id="login-form" style="display: none;">
                <h2>Login</h2>
                <form action="user.php" method="POST">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" name="login">Login</button>
                </form>
                <p><a href="javascript:void(0);" id="toggle-link" onclick="toggleForm()">Not registered? Register here</a></p>
            </div>
        </div>
    </div>
</body>
</html>
