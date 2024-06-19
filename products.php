<?php
// Start a new session or resume the existing one
session_start();

// Include the database connection file
include 'dbconnection.class.php';

// Create a new database connection
$dbconnect = new Dbconnection();

// SQL query to select all products
$sql = 'SELECT * FROM products';

// Prepare the SQL query
$query = $dbconnect->prepare($sql);

// Execute the SQL query
$query->execute();

// Fetch all the results as an associative array
$recset = $query->fetchAll(PDO::FETCH_ASSOC);

// Handle Add to Cart
// Check if the request method is POST and if the add_to_cart button was clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    // Get the product id from the POST data
    $product_id = $_POST['product_id'];
    $product = null;

    // Loop through the products
    foreach ($recset as $row) {
        // If the product id matches the id from the POST data
        if ($row['id'] == $product_id) {
            // Set the product to the current row
            $product = $row;
            break;
        }
    }

    // If the product was found
    if ($product) {
        // If the product is already in the cart
        if (isset($_SESSION['cart'][$product_id])) {
            // Increase the quantity by 1
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } else {
            // Otherwise, add the product to the cart with a quantity of 1
            $_SESSION['cart'][$product_id] = [
                'name' => $product['productname'],
                'image' => $product['image'],
                'price' => $product['price'],
                'quantity' => 1
            ];
        }
    }

    // Redirect to the products page
    header('Location: products.php');
    exit();
}
?>

<!-- HTML code starts here -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>GraphicsLand - Products</title>
</head>
<body>
<!-- Include the header -->
<?php include('header.php'); ?>
<center>
    <?php
    // Loop through the products
    foreach ($recset as $row) {
        // Display the product information
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