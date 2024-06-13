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
    <title>GraphicsLand - Products</title>
</head>
<body>
    <!--Navbar-->
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
      <div class="container">
        <header>
            <center><h1 style="color: darkgreen;">Checkout</h1></center>
        </header>
        <main>
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
                <a class="cancel-btn" href="cart.php">Cancel order</a>
                <a type="submit" class="checkout-btn" href="#">Place Order</a>
            </form>
        </main>
    </div>
    <br>
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
<script src="script.js"></script>
</html>