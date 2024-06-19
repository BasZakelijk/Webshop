<?php
// Start the session
session_start();

// Check if the cart exists in the session and count the items, otherwise set the count to 0
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Set the character encoding for the document -->
    <meta charset="UTF-8">
    <!-- Set the viewport to scale for mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link to the main stylesheet -->
    <link rel="stylesheet" href="style.css">
    <!-- Link to the shopping cart specific stylesheet -->
    <link rel="stylesheet" href="styleshoppingcart.css">
    <!-- Set the title of the document -->
    <title>GraphicsLand - Shopping cart</title>
</head>
<body>
<!-- Include the header file -->
<?php include('header.php'); ?>


    <!-- Page Content -->
    <div class="container">
        <!-- Page title -->
        <center><h1 style="color: darkgreen;">Shopping cart</h1></center>
        <main>
            <!-- Form for the shopping cart -->
            <form id="cart-form">
                <?php
                // Initialize total price
                $total = 0;
                // Check if the cart exists and is not empty
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    // Loop through each product in the cart
                    foreach ($_SESSION['cart'] as $product_id => $product) {
                        // Add the product's total price to the total
                        $total += $product['price'] * $product['quantity'];
                        // Output the product information
                        echo "<div class='cart-item' data-product-id='$product_id'>";
                        echo "<div class='item-info'>";
                        echo '<img src="' . $product['image'] . '" style="float: left;">';
                        echo "<div>";
                        echo "<h2>" . htmlspecialchars($product['name']) . "</h2>";
                        echo "<p>Price: <a>€</a><span class='item-price'>" . number_format($product['price'], 2, ',', '') . "</span></p>";
                        echo "</div>";
                        echo "</div>";
                        echo "<div class='item-actions'>";
                        echo "<input type='number' name='quantities[$product_id]' value='" . htmlspecialchars($product['quantity']) . "' min='0' onchange='updateCart(this)'>";
                        echo "<button type='button' onclick='removeFromCart($product_id)' class='remove-btn'>Remove</button>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    // If the cart is empty, output a message
                    echo "<p>Your cart is empty.</p>";
                }
                ?>
                    <!-- Output the total price -->
                    <div class="total">
                        <h2>Total: €<span id="total"><?php echo number_format($total, 2, ',', ''); ?></span></h2>
                        <!-- Checkout button -->
                        <a class="checkout-btn" style="float: right;" href="check.php">Checkout</a>
                    </div>

            </form>
        </main>
    </div>

    <!-- Popup for logged-in user options -->
    <div id="userPopup" class="popup">
        <!-- Close button for the popup -->
        <span class="popup-close" onclick="closePopup()">&times;</span>
        <!-- Popup header -->
        <div class="popup-header">Welcome, <a id="userMenu"><?php echo htmlspecialchars($_SESSION['username']); ?></a></div>
        <!-- Logout button -->
        <button onclick="window.location.href='logout.php'">Logout</button>
    </div>

    <script>
        // Add an event listener to the user menu to open the popup
        document.getElementById('userMenu').addEventListener('click', function() {
            document.getElementById('userPopup').style.display = 'block';
        });

        // Function to close the popup
        function closePopup() {
            document.getElementById('userPopup').style.display = 'none';
        }

        // Add an event listener to the window to close the popup when clicked outside of it
        window.onclick = function(event) {
            if (event.target == document.getElementById('userPopup')) {
                document.getElementById('userPopup').style.display = 'none';
            }
        }

        // Function to remove an item from the cart
        function removeFromCart(productId) {
            // Create a new XMLHttpRequest
            var xhr = new XMLHttpRequest();
            // Open a POST request to the cart action page
            xhr.open('POST', 'cart_action.php', true);
            // Set the request header
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            // Add an event listener for when the state changes
            xhr.onreadystatechange = function () {
                // Check if the request is done and was successful
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Parse the response
                    var response = JSON.parse(xhr.responseText);
                    // Check if the status is success
                    if (response.status === 'success') {
                        // Remove the item from the page
                        var cartItem = document.querySelector(`.cart-item[data-product-id='${productId}']`);
                        if (cartItem) {
                            cartItem.remove();
                        }
                        // Update the total price and cart count
                        document.getElementById('total').textContent = response.total.toFixed(2);
                        document.getElementById('cart-count').textContent = response.cart_count;
                    }
                }
            };
            // Send the request with the action and product id
            xhr.send(`action=remove&product_id=${productId}`);
        }

        // Function to update the cart
        function updateCart(input) {
            // Get the product id, quantity, and old quantity
            var productId = input.name.match(/\d+/)[0];
            var quantity = parseInt(input.value);
            var oldQuantity = parseInt(input.getAttribute('data-old-quantity') || '0');
            // Get the price of the item
            var price = parseFloat(document.querySelector(`.cart-item[data-product-id='${productId}'] .item-price`).textContent.replace(',', '.'));

            // Calculate the new total price on the client side
            var oldTotal = parseFloat(document.getElementById('total').textContent.replace(',', '.'));
            var newTotal = oldTotal - (oldQuantity * price) + (quantity * price);
            // Update the total price
            document.getElementById('total').textContent = newTotal.toFixed(2).replace('.', ',');

            // Update the old quantity
            input.setAttribute('data-old-quantity', quantity);

            // If the quantity is 0, remove the item from the cart
            if (quantity === 0) {
                removeFromCart(productId);
                return;
            }

            // Update the total price on the server side
            var xhr = new XMLHttpRequest();
            // Open a POST request to the cart action page
            xhr.open('POST', 'cart_action.php', true);
            // Set the request header
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            // Add an event listener for when the state changes
            xhr.onreadystatechange = function () {
                // Check if the request is done and was successful
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Parse the response
                    var response = JSON.parse(xhr.responseText);
                    // Check if the status is success
                    if (response.status === 'success') {
                        // Update the cart count
                        document.getElementById('cart-count').textContent = response.cart_count;
                    }
                }
            };
            // Send the request with the action, product id, and quantity
            xhr.send(`action=update&product_id=${productId}&quantity=${quantity}`);
        }
    </script>
</body>
<!-- Include the main script file -->
<script src="script.js"></script>
</html>
