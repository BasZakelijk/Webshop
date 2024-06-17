<?php
session_start();
include 'dbconnection.class.php';
$dbconnect = new Dbconnection();
$sql = 'SELECT * FROM products';
$query = $dbconnect->prepare($sql);
$query->execute();
$recset = $query->fetchAll(PDO::FETCH_ASSOC);

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product = null;
    foreach ($recset as $row) {
        if ($row['id'] == $product_id) {
            $product = $row;
            break;
        }
    }
    if ($product) {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$product_id] = [
                'name' => $product['productname'],
                'image' => $product['image'],
                'price' => $product['price'],
                'quantity' => 1
            ];
        }
    }
    header('Location: products.php');
    exit();
}
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
  
<?php include('header.php'); ?>
<center>
    <?php
    foreach ($recset as $row) {
        echo "<div class='product'>";
        echo '<img src="' . $row['image'] . '" style="float: left;">';
        echo "<h2>" . $row['productname'] . "</h2>";
        echo "<a><p>Category: </a>" . $row['manufacturer'] . "</p>";
        echo "<p><a>Price: </a>€" . number_format($row['price'], 2, ',', '') . "</p>";
        echo "<p><a>Stock: </a>" . $row['stock'] . "</p>";
        echo "<p><a>Description: </a>" . $row['description'] . "</p><hr>";
        echo "<form method='POST' action='products.php'>";
        echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
        echo "<button><b>View product</b></button>"; 
        echo "<button type='submit' name='add_to_cart'><b>Add to cart</b></button>"; 
        echo "</form>";
        echo "</div>";
    }
    ?>
    </center>
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
