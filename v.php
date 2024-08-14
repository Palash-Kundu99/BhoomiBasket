<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join as Vendor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('img/ven.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            display: flex;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            width: 430px;
            max-width: 100%;
            padding: 60px;
            box-sizing: border-box;
            position: absolute;
            right: 100px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 2;
        }
        .form-container {
            display: flex;
            flex-direction: column;
            gap: 40px;
        }
        h2 {
            margin: 0 0 20px;
            font-size: 24px;
            text-align: center;
            color: #333;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #4cae4c;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            color: green;
           
            border: 1px solid #c3e6cb;
            border-radius: 5px;
        }
        p {
            text-align: center;
        }
        a {
            color: #5bc0de;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        #toggle-link {
            color: #000;
            text-decoration: none;
        }
        #toggle-link:hover {
            text-decoration: underline;
        }
        /* Navbar styles */
        nav {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 3;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-around;
        }
        nav ul li {
            margin: 0;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
        }
        nav ul li a:hover {
            background-color: #555;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php#about-us">About</a></li>
            <li><a href="index.php#featured-products">Explore</a></li>
            <li><a href="index.php#contact">Contact</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="form-container">
            <?php
            if (isset($_SESSION['message'])) {
                echo '<div class="message">' . htmlspecialchars($_SESSION['message']) . '</div>';
                unset($_SESSION['message']);
            }
            ?>
            <div class="form-section" id="register-section" style="display: none;">
                <h2>Register</h2>
                <form action="register.php" method="post">
                    <label for="reg-username">Username:</label>
                    <input type="text" id="reg-username" name="username" required>
                    <label for="reg-password">Password:</label>
                    <input type="password" id="reg-password" name="password" required>
                    <button type="submit">Register</button>
                </form>
                <p>Already registered? <a href="#login-section" onclick="showLogin()">Login here</a></p>
            </div>
            <div class="form-section" id="login-section">
                <h2>Login</h2>
                <form action="login.php" method="post">
                    <label for="login-username">Username:</label>
                    <input type="text" id="login-username" name="username" required>
                    <label for="login-password">Password:</label>
                    <input type="password" id="login-password" name="password" required>
                    <button type="submit">Login</button>
                </form>
                <p>Not registered yet? <a href="#register-section" onclick="showRegister()">Register here</a></p>
            </div>
        </div>
    </div>
    
    <script>
        function showLogin() {
            document.getElementById('register-section').style.display = 'none';
            document.getElementById('login-section').style.display = 'block';
        }

        function showRegister() {
            document.getElementById('login-section').style.display = 'none';
            document.getElementById('register-section').style.display = 'block';
        }

        window.onload = function() {
            showLogin(); // Automatically show the login section when the page loads
        };
    </script>
    
</body>

</html>
