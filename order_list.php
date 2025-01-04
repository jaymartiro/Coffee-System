<?php
require_once 'db_connect.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all orders
$stmt = $pdo->query("
    SELECT 
        o.*,
        p.name as dish_name,
        p.price,
        p.image_url
    FROM orders o
    JOIN products p ON o.product_id = p.id
    ORDER BY o.order_date DESC
");
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Orders - Boss 2.0</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
        }

        .header {
            background-color: #808080;
            padding: 1rem;
        }

        .logo img {
            height: 50px;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 2rem;
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }

        .order-table th,
        .order-table td {
            border: 1px solid #ddd;
            padding: 1rem;
            text-align: left;
        }

        .order-table th {
            background-color: #f5f5f5;
        }

        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            background-color: #000;
            color: white;
            font-size: 0.9rem;
        }

        .order-now-btn {
            display: block;
            width: 200px;
            margin: 2rem auto;
            padding: 1rem;
            background-color: #000;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
        }

        .order-now-btn:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">
            <a href="admin_dashboard.php">
                <a/>
            <a href="menu.php">
                <img src="images/logo.jpg" alt="Boss 2.0 Logo">
            </a>
        </div>
    </header>

    <div class="container">
        <h1>List of orders</h1>

        <table class="order-table">
            <tr>
                <th>Name</th>
                <th>Contact#</th>
                <th>Address</th>
                <th>Dish name</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                <td><?php echo htmlspecialchars($order['contact']); ?></td>
                <td><?php echo htmlspecialchars($order['address']); ?></td>
                <td><?php echo htmlspecialchars($order['dish_name']); ?></td>
                <td>Php <?php echo number_format($order['price'], 2); ?></td>
                <td><?php echo htmlspecialchars($order['quantity']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <table class="order-table">
            <tr>
                <th>Image</th>
                <th>Payment</th>
                <th>Status</th>
            </tr>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td>
                    <img src="<?php echo htmlspecialchars($order['image_url']); ?>" 
                         alt="<?php echo htmlspecialchars($order['dish_name']); ?>"
                         class="product-image">
                </td>
                <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                <td><span class="status-badge">New order</span></td>
            </tr>
            <?php endforeach; ?>
        </table>

        
    </div>
</body>
</html>
