<?php
// Start a new session or resume the existing one
session_start();

// Initialize the response array with a default status of 'error'
$response = ['status' => 'error'];

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the 'action' is set in the POST data
    if (isset($_POST['action'])) {
        // Get the action from the POST data
        $action = $_POST['action'];

        // If the action is 'update'
        if ($action === 'update') {
            // Loop through the quantities in the POST data
            foreach ($_POST['quantities'] as $product_id => $quantity) {
                // If the quantity is 0
                if ($quantity == 0) {
                    // Remove the product from the cart
                    unset($_SESSION['cart'][$product_id]);
                } else {
                    // Otherwise, update the quantity of the product in the cart
                    $_SESSION['cart'][$product_id]['quantity'] = $quantity;
                }
            }
            // Set the status of the response to 'success'
            $response['status'] = 'success';
        } 
        // If the action is 'remove'
        elseif ($action === 'remove') {
            // Get the product id from the POST data
            $product_id = $_POST['product_id'];
            // Remove the product from the cart
            unset($_SESSION['cart'][$product_id]);
            // Set the status of the response to 'success'
            $response['status'] = 'success';
        }
        
        // Calculate the new total
        $total = 0;
        // Loop through the products in the cart
        foreach ($_SESSION['cart'] as $product) {
            // Add the total price of each product to the total
            $total += $product['price'] * $product['quantity'];
        }
        // Add the total to the response
        $response['total'] = $total;
        // Add the count of products in the cart to the response
        $response['cart_count'] = count($_SESSION['cart']);
    }
}

// Encode the response as JSON and output it
echo json_encode($response);

// Terminate the script
exit();
?>