<!-- Start of the navigation bar -->
<ul id="line">
    <!-- Home link -->
    <li><a class="active" href="index.php">Home</a></li>
    <!-- Logo image with a click event that calls the goToIndex function -->
    <li class="logo">
        <img src="IMG/graphicsland_logo.png" style="width: 190px; cursor:pointer" alt="Logo" onclick="goToIndex()">
    </li>

    <!-- Cart link with the total quantity of items in the cart -->
    <li style="float:right"><a href="cart.php">Cart (<span id="cart-count">
        <?php 
            // Initialize total quantity to 0
            $totalQuantity = 0;
            // Check if the cart exists in the session
            if (isset($_SESSION['cart'])) {
                // Loop through each item in the cart
                foreach ($_SESSION['cart'] as $item) {
                    // Add the quantity of the current item to the total quantity
                    $totalQuantity += $item['quantity'];
                }
            }
            // Display the total quantity
            echo $totalQuantity; 
        ?>
    </span>)</a></li>
    <!-- If the user is logged in, display the Account link, otherwise display the Login link -->
    <?php if (isset($_SESSION['username'])): ?>
        <li style="float:right"><a href="#" id="userMenu">Account</a></li>
    <?php else: ?>
        <li style="float:right"><a href="login.php">Login</a></li>
    <?php endif; ?>
    <!-- Products link -->
    <li style="float:right"><a href="products.php">Products</a></li>
</ul>
<!-- Decorative line -->
<ul class="line"></ul>