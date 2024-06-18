<?php
// Start a new session or resume the existing one
session_start();

// Check if the cart exists in the session and count the number of items, otherwise set the count to 0
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>

<?php
// Include the database connection file
require 'dbconnection.class.php';

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    // If user is already logged in, redirect to the home page
    header('Location: index.php');
    exit();
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the username and password from the POST data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username exists in the database
    $pdo = new dbconnection();
    $stmt = $pdo->prepare('SELECT id, username, password FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // If the user exists and the password is correct
    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        // Redirect to home page
        header('Location: index.php');
        exit();
    } else {
        // Invalid credentials or account does not exist
        $error_message = 'Invalid username or password.';
    }
}
?>

<!-- HTML code starts here -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>GraphicsLand - Login</title>
</head>
<body>
<!-- Include the header -->
<?php include('header.php'); ?>

    <center>
    <div class="main">
        <h3 id="white">Enter your login credentials</h3>
        <!-- If there is an error message, display it -->
        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <!-- Login form -->
        <form action="login.php" method="post">
            <label for="username">Full name:</label>
            <input type="text" id="username" name="username" placeholder="Enter your Full name" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your Password" required>

            <div class="wrap">
                <button style="background-color: darkgreen;" type="submit" id="submit">
                    <b>Submit</b>
                </button>
            </div>
        </form>
        <p id="white">Not registered? 
            <a class="createaccount" href="create.php">Create an account</a>
        </p>
    </div>
    </center>
    <!-- Popup for logged-in user options -->
    <div id="userPopup" class="popup">
        <span class="popup-close" onclick="closePopup()">&times;</span>
        <div class="popup-header">Welcome, <a id="userMenu"><?php echo htmlspecialchars($_SESSION['username']); ?></a></div>
        <button onclick="window.location.href='logout.php'">Logout</button>
    </div>

    <script>
        // Add event listener to user menu
        document.getElementById('userMenu').addEventListener('click', function() {
            // Display the user popup when the user menu is clicked
            document.getElementById('userPopup').style.display = 'block';
        });

        // Function to close the user popup
        function closePopup() {
            document.getElementById('userPopup').style.display = 'none';
        }

        // Close the user popup when clicking outside of it
        window.onclick = function(event) {
            if (event.target == document.getElementById('userPopup')) {
                document.getElementById('userPopup').style.display = 'none';
            }
        }
    </script>
</body>
<script src="script.js"></script>
</html>