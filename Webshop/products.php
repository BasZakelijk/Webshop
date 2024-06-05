<?php
include 'dbconnection.class.php';
$dbconnect=new Dbconnection();
$sql= 'SELECT * FROM products';
$query= $dbconnect-> prepare($sql);
$query-> execute();
$recset= $query-> fetchAll(2);
//echo '<pre>';
//print_r($recset); 
//echo '</pre>';
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
        <li><a class="active" href="index.html">Home</a></li>
        <li style="float:right"><a href="cart.html">Cart</a></li>
        <li style="float:right"><a href="login.html">Login</a></li>
        <li style="float:right"><a href="products.html">Products</a></li>
      </ul>
      <ul class="line">

      </ul>
      <h1>Products</h1>
      <div class="filter">
        <form action="index.php" method="get">
            <label for="category">Category:</label>
            <select name="category" id="category">
                <option value="">All</option>
                <option value="Category 1">Category 1</option>
                <option value="Category 2">Category 2</option>
                <option value="Category 3">Category 3</option>
            </select>
            <label for="min_price">Min Price:</label>
            <input type="number" name="min_price" id="min_price" step="0.01">
            <label for="max_price">Max Price:</label>
            <input type="number" name="max_price" id="max_price" step="0.01">
            <button type="submit">Filter</button>
        </form>
    </div>
    <div class="products">
        <?php


        //if ($recset->num_rows > 0) {
            foreach($recset as $row) {
                echo "<div class='product'>";
                echo "<h2>" . $row['productname'] . "</h2>";
                echo "<p>Category: " . $row['manufacturer'] . "</p>";
                echo "<p>Price: $" . $row['price'] . "</p>";
                echo "<p>Description: " . $row['description'] . "</p>";
                echo "</div>";
            }
        //} else {
            //echo "No products found.";
        //}
        ?>
    </div>

      
</body>
<script src="script.js"></script>
</html>