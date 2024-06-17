<ul id="line">
    <li><a class="active" href="index.php">Home</a></li>
    <li class="logo">
  <img src="IMG/graphicsland_logo.png" style="width: 170px; cursor:pointer" alt="Logo" onclick="goToIndex()">
</li>

    <li style="float:right"><a href="cart.php">Cart (<span id="cart-count">
        <?php 
            $totalQuantity = 0;
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $item) {
                    $totalQuantity += $item['quantity'];
                }
            }
            echo $totalQuantity; 
        ?>
    </span>)</a></li>
    <?php if (isset($_SESSION['username'])): ?>
        <li style="float:right"><a href="#" id="userMenu">Account</a></li>
    <?php else: ?>
        <li style="float:right"><a href="login.php">Login</a></li>
    <?php endif; ?>
    <li style="float:right"><a href="products.php">Products</a></li>
</ul>
<ul class="line"></ul>