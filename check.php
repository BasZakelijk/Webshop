<?php
session_start(); // Start the session to access session variables

// Get the count of items in the cart or set to 0 if cart is empty
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming POST data is sanitized and validated
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $country = $_POST['country'];
    $bank = $_POST['bank'];

    // Validate product_id for each item in the cart before proceeding
    foreach ($_SESSION['cart'] as $product_id => $item) {
        if (!isset($product_id) || is_null($product_id)) {
            echo "Error: product_id is missing or null for one of the items.";
            exit; // Stop script execution if any product_id is invalid
        }
    }

    // Proceed with database operations if all product_ids are valid
    $conn = new mysqli("localhost", "u173298p199184_graphicsland", "8H;Y\"?xqbhCzN0\"!5Z]ATOnucH", "u173298p199184_graphicsland"); // Create a new connection to the database
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error); // Handle connection error
    }

    $conn->begin_transaction(); // Start a database transaction

    // Prepare and execute the SQL statement to insert the order details
    $sql = "INSERT INTO orders (name, email, address, city, state, zip, country, bank) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $name, $email, $address, $city, $state, $zip, $country, $bank);
    $stmt->execute();
    $orderId = $stmt->insert_id; // Get the ID of the newly inserted order

    // Insert each item in the cart into the order_items table
    foreach ($_SESSION['cart'] as $product_id => $item) {
        $sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $orderId, $product_id, $item['quantity']);
        $stmt->execute();
    }
    
    $conn->commit(); // Commit the transaction
    $_SESSION['cart'] = []; // Clear the cart
    echo "<div class='placed'>Order placed successfully!</div>";

    // Close the statement and connection
    $stmt->close();
    $conn->close();
    // Redirect or notify the user accordingly
} else {
    // Handle GET request or other methods if necessary
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS file -->
    <title>GraphicsLand - Products</title>
</head>
<body>
<?php include('header.php'); ?> <!-- Include header file -->

    <ul class="line"></ul>
      <div class="container">
        <header>
            <center><h1 style="color: darkgreen;">Checkout</h1></center>
        </header>
        <main>
            <!-- Checkout form -->
            <form action="#" method="POST">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" required>
                </div>
                
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" required>
                </div>
                
                <div class="form-group">
                    <label for="state">State</label>
                    <input type="text" id="state" name="state" required>
                </div>
                
                <div class="form-group">
                    <label for="zip">ZIP Code</label>
                    <input type="text" id="zip" name="zip" required>
                </div>
                
                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" id="country" name="country" required>
                </div>

                <div class="form-group">
                    <label for="bank">Select Bank</label>
                    <select id="bank" style="border: 3px solid darkgreen;" class="bankselect" name="bank" required>
                        <option value="" disabled selected></option>
                        <option value="bank1">ABN</option>
                        <option value="bank2">ASN</option>
                        <option value="bank3">ING</option>
                        <option value="bank4">RABO</option>
                    </select>
                </div>
                <br>
                <button class="cancel-btn" href="cart.php">Cancel order</button> <!-- Button to cancel the order -->
                <button type="submit" class="checkout-btn">Place Order</button> <!-- Button to place the order -->
            </form>
        </main>
    </div>
    
    <div id="userPopup" class="popup">
        <span class="popup-close" onclick="closePopup()">&times;</span> <!-- Close button for the popup -->
        <div class="popup-header">Welcome, <a id="userMenu"><?php echo htmlspecialchars($_SESSION['username']); ?></a></div> <!-- Display the username -->
        <button onclick="window.location.href='logout.php'">Logout</button> <!-- Logout button -->
    </div>

    <script>
        // Event listener to show the popup when the user menu is clicked
        document.getElementById('userMenu').addEventListener('click', function() {
            document.getElementById('userPopup').style.display = 'block';
        });

        // Function to close the popup
        function closePopup() {
            document.getElementById('userPopup').style.display = 'none';
        }

        // Event listener to close the popup if the user clicks outside of it
        window.onclick = function(event) {
            if (event.target == document.getElementById('userPopup')) {
                document.getElementById('userPopup').style.display = 'none';
            }
        }
    </script>
</body>
<script src="script.js"></script>
</html>
