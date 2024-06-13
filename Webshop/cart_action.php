<?php
session_start();

$response = ['status' => 'error'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action === 'update') {
            foreach ($_POST['quantities'] as $product_id => $quantity) {
                if ($quantity == 0) {
                    unset($_SESSION['cart'][$product_id]);
                } else {
                    $_SESSION['cart'][$product_id]['quantity'] = $quantity;
                }
            }
            $response['status'] = 'success';
        } elseif ($action === 'remove') {
            $product_id = $_POST['product_id'];
            unset($_SESSION['cart'][$product_id]);
            $response['status'] = 'success';
        }
        
        // Calculate new total
        $total = 0;
        foreach ($_SESSION['cart'] as $product) {
            $total += $product['price'] * $product['quantity'];
        }
        $response['total'] = $total;
        $response['cart_count'] = count($_SESSION['cart']);
    }
}

echo json_encode($response);
exit();
?>
