<?php
session_start();
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styleshoppingcart.css">
    <title>GraphicsLand - Shopping cart</title>
</head>
<body>
    <!-- Navbar -->
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

    <!-- Page Content -->
    <div class="container">
        <center><h1 style="color: darkgreen;">Shopping cart</h1></center>
        <main>
            <form id="cart-form">
                <?php
                $total = 0;
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $product_id => $product) {
                        $total += $product['price'] * $product['quantity'];
                        echo "<div class='cart-item' data-product-id='$product_id'>";
                        echo "<div class='item-info'>";
                        echo "<img src='https://via.placeholder.com/150' alt='Product Image'>";
                        echo "<div>";
                        echo "<h2>" . htmlspecialchars($product['name']) . "</h2>";
                        echo "<p>Price: €<span class='item-price'>" . number_format($product['price'], 2, ',', '') . "</span></p>";
                        echo "</div>";
                        echo "</div>";
                        echo "<div class='item-actions'>";
                        echo "<input type='number' name='quantities[$product_id]' value='" . htmlspecialchars($product['quantity']) . "' min='0' onchange='updateCart(this)'>";
                        echo "<button type='button' onclick='removeFromCart($product_id)' class='remove-btn'>Remove</button>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Your cart is empty.</p>";
                }
                ?>
                    <div class="total">
                        <h2>Total: €<span id="total"><?php echo number_format($total, 2, ',', ''); ?></span></h2>
                        <a class="checkout-btn" style="float: right;" href="check.php">Checkout</a>
                    </div>

            </form>
        </main>
    </div>

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

        function removeFromCart(productId) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'cart_action.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        var cartItem = document.querySelector(`.cart-item[data-product-id='${productId}']`);
                        if (cartItem) {
                            cartItem.remove();
                        }
                        document.getElementById('total').textContent = response.total.toFixed(2);
                        document.getElementById('cart-count').textContent = response.cart_count;
                    }
                }
            };
            xhr.send(`action=remove&product_id=${productId}`);
        }

        function updateCart(input) {
            var productId = input.name.match(/\d+/)[0];
            var quantity = input.value;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'cart_action.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        document.getElementById('total').textContent = response.total.toFixed(2);
                        document.getElementById('cart-count').textContent = response.cart_count;
                    }
                }
            };
            xhr.send(`action=update&product_id=${productId}&quantity=${quantity}`);
        }
    </script>
</body>
</html>
