<?php
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate quantity
    $quantity = (int)$_POST['quantity'];
    if ($quantity < 1 || $quantity > 10) {
        die("Invalid quantity. Please select between 1 and 10 items.");
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO orders (customer_name, product_id, size, quantity, contact, address, postal_code, payment_method) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $_POST['name'], // Add name field to your cart.php form
            $_POST['product_id'],
            $_POST['size'],
            $quantity,
            $_POST['contact'],
            $_POST['address'],
            $_POST['postal'],
            $_POST['payment']
        ]);

        // Redirect to order list instead of confirmation
        header('Location: order_list.php');
        exit();
    } catch (PDOException $e) {
        echo "Error processing order: " . $e->getMessage();
    }
}
?>
