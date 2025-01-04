<?php
require_once 'db_connect.php';

if (!isset($_GET['id'])) {
    header('Location: menu.php');
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$_GET['id']]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: menu.php');
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM size_prices WHERE product_id = ?");
$stmt->execute([$_GET['id']]);
$sizes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Boss 2.0</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #808080;
        }

        .header {
            background-color: #808080;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo img {
            height: 50px;
        }

        .cart-icon {
            font-size: 1.5rem;
            color: black;
            text-decoration: none;
        }

        .product-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .product-image {
            width: 100%;
            max-width: 500px;
            border-radius: 10px;
        }

        .product-details {
            background: rgba(0, 0, 0, 0.8);
            padding: 2rem;
            border-radius: 10px;
            color: white;
        }

        .product-name {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .product-price {
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }

        .size-options {
            margin-bottom: 2rem;
        }

        .size-options h3 {
            margin-bottom: 1rem;
        }

        .size-icons {
            display: flex;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .size-icon {
            text-align: center;
            cursor: pointer;
        }

        .size-icon img {
            width: 50px;
            height: 50px;
            margin-bottom: 0.5rem;
        }

        .order-form input[type="text"],
        .order-form input[type="number"] {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border-radius: 5px;
            border: none;
        }

        .payment-options {
            margin-bottom: 1rem;
        }

        .payment-option {
            margin-bottom: 0.5rem;
        }

        .purchase-btn {
            width: 100%;
            padding: 1rem;
            background: black;
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1.1rem;
        }

        .purchase-btn:hover {
            background: #333;
        }

        @media (max-width: 768px) {
            .product-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">
            <a href="menu.php">
                <img src="images/logo.jpg" alt="Boss 2.0 Logo">
            </a>
        </div>
        <a href="#" class="cart-icon">🛒</a>
    </header>

    <div class="product-container">
        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
             alt="<?php echo htmlspecialchars($product['name']); ?>" 
             class="product-image">
        
        <div class="product-details">
            <h1 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h1>
            <div class="product-price">Php <?php echo number_format($product['price'], 2); ?></div>

            <form action="process_order.php" method="POST" class="order-form">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                
                <div class="size-options">
                    <h3>Size Options</h3>
                    <div class="size-icons">
                        <?php foreach ($sizes as $size): ?>
                        <div class="size-icon">
                            <label>
                                <input type="radio" name="size" value="<?php echo $size['size']; ?>" required>
                                <img src="images/<?php echo strtolower($size['size']); ?>-cup.png" alt="<?php echo $size['size']; ?>">
                                <div><?php echo $size['size']; ?></div>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div>
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" min="1" value="1" required>
                </div>

                <div>
                    <label for="contact">Contact#:</label>
                    <input type="text" id="contact" name="contact" required>
                </div>

                <div>
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required>
                </div>

                <div>
                    <label for="postal">Postal code:</label>
                    <input type="text" id="postal" name="postal" required>
                </div>

                <div class="payment-options">
                    <h3>Payment:</h3>
                    <div class="payment-option">
                        <input type="radio" id="cod" name="payment" value="cod" required>
                        <label for="cod">Cash on Delivery</label>
                    </div>
                    <div class="payment-option">
                        <input type="radio" id="pickup" name="payment" value="pickup" required>
                        <label for="pickup">Pick up</label>
                    </div>
                </div>

                <button type="submit" class="purchase-btn">Purchase</button>
            </form>
        </div>
    </div>
</body>
</html>
