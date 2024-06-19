<?php
// Start a new session or resume the existing one
session_start();

// Check if the cart exists in the session, if it does, count the items, otherwise set the count to 0
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>

<?php
// Include the database connection class
require 'dbconnection.class.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the password and confirm password match
    if ($password !== $confirm_password) {
        echo 'Passwords do not match.';
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Create a new database connection
        $pdo = new dbconnection();

        // Prepare the SQL statement
        $stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');

        // Execute the SQL statement with the form data
        $stmt->execute([$username, $email, $hashed_password]);
    } catch (PDOException $e) {
        // Check if the error is a duplicate entry error
        if ($e->errorInfo[1] == 1062) {
            echo 'Username or email already exists.';
        } else {
            echo 'An error occurred.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>GraphicsLand - Create account</title>
</head>
<body>
<ul id="line">
        <li><a class="active" href="index.php">Home</a></li>
        <li class="logo"><img src="IMG/graphicsland_logo.png" style="width: 170px;" alt="Logo"></li>
        <li style="float:right"><a href="cart.php">Cart (<span id="cart-count"><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></span>)</a></li>
        <?php if (isset($_SESSION['username'])): ?>
            <li style="float:right"><a href="#" id="userMenu">Account</a></li>
        <?php else: ?>
            <li style="float:right"><a href="login.php">Login</a></li>
        <?php endif; ?>
        <li style="float:right"><a href="products.php">Products</a></li>
    </ul>
    <ul class="line"></ul>
    <center>
    <div class="main">
        <h3 id="white">Create an account</h3>
        <form action="create.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your Username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your Email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your Password" required>

            <label for="confirm_password">Repeat password:</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Repeat your Password" required>

            <div class="wrap">
                <button style="background-color: darkgreen;" type="submit" id="submit">
                    <b>Submit</b>
                </button>
            </div>
        </form>
        <p id="white">Have an account? 
            <a class="createaccount" href="login.php">Login</a>
        </p>
    </div>
    <br>
    </center>
    <!-- Popup for logged-in user options -->
    <div id="userPopup" class="popup">
        <span class="popup-close" onclick="closePopup()">&times;</span>
        <div class="popup-header">Welcome, <a id="userMenu"><?php echo htmlspecialchars($_SESSION['username']); ?></a></div>
        <button onclick="window.location.href='logout.php'">Logout</button>
        <button onclick="window.location.href='purchase_history.php'">Purchase History</button>
    </div>

    <script>
        document.getElementById('userMenu').addEventListener('click', function() {
            document.getElementById('userPopup').style.display = 'block';
        });

        function closePopup() {
            document.getElementById('userPopup').style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('userPopup')) {
                document.getElementById('userPopup').style.display = 'none';
            }
        }
        </script>
</body>
</html>