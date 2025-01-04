<?php
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $stmt = $pdo->prepare("INSERT INTO cart_items (product_id, size, quantity, contact, address, postal_code, payment_method) 
                          VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['product_id'],
        $_POST['size'],
        $_POST['quantity'],
        $_POST['contact'],
        $_POST['address'],
        $_POST['postal'],
        $_POST['payment']
    ]);
}

// Get product details
$product_id = $_GET['id'] ?? null;
if ($product_id) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Boss 2.0</title>
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
            align-items: center;
        }

        .logo img {
            height: 50px;
            margin-right: 1rem;
        }

        .menu-text {
            color: black;
            font-size: 1.2rem;
            text-decoration: none;
        }

        .cart-icon {
            margin-left: auto;
            font-size: 1.5rem;
            color: black;
            text-decoration: none;
        }

        .cart-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 10px;
            color: white;
        }

        .product-image {
            width: 100%;
            max-width: 500px;
            border-radius: 10px;
        }

        .product-details {
            padding: 2rem;
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
            width: 40px;
            height: 40px;
            margin-bottom: 0.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.5rem;
            border-radius: 5px;
            border: none;
        }

        .payment-options {
            margin: 1rem 0;
        }

        .payment-option {
            margin: 0.5rem 0;
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
            margin-top: 1rem;
        }

        .purchase-btn:hover {
            background: #333;
        }

        @media (max-width: 768px) {
            .cart-container {
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
      
        
    </header>

    <div class="cart-container">
        <?php if ($product): ?>
        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
             alt="<?php echo htmlspecialchars($product['name']); ?>" 
             class="product-image">
        
        <div class="product-details">
            <h1 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h1>
            <div class="product-price">Php <?php echo number_format($product['price'], 2); ?></div>

            <form action="process_order.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                <div class="size-options">
                    <h3>Size Options</h3>
                    <div class="size-icons">
                        <div class="size-icon">
                            <input type="radio" name="size" value="Small" id="small" required>
                            <label for="small">
                                
                                <div>Small</div>
                            </label>
                        </div>
                        <div class="size-icon">
                            <input type="radio" name="size" value="Medium" id="medium">
                            <label for="medium">
                             
                                <div>Medium</div>
                            </label>
                        </div>
                        <div class="size-icon">
                            <input type="radio" name="size" value="Large" id="large">
                            <label for="large">
                               
                                <div>Large</div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" 
                           id="quantity" 
                           name="quantity" 
                           min="1" 
                           max="10" 
                           value="1" 
                           required
                           oninput="validateQuantity(this)">
                    <small class="quantity-warning" style="color: #ff6b6b; display: none;">
                        Maximum quantity is 10 items
                    </small>
                </div>

                <div class="form-group">
                    <label for="contact">Contact#:</label>
                    <input type="text" id="contact" name="contact" required>
                </div>

                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required>
                </div>

                <div class="form-group">
                    <label for="postal">Postal code:</label>
                    <input type="text" id="postal" name="postal" required>
                </div>

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="payment-options">
                    <h3>Payment:</h3>
                    <div class="payment-option">
                        <input type="radio" id="cod" name="payment" value="cod" required>
                        <label for="cod">CASH ON DELIVERY</label>
                    </div>
                    <div class="payment-option">
                        <input type="radio" id="pickup" name="payment" value="pickup">
                        <label for="pickup">GCASH</label>
                    </div>
                </div>

                <button type="submit" class="purchase-btn">Purchase</button>
            </form>
        </div>
        <?php else: ?>
            <p>No product selected.</p>
        <?php endif; ?>
    </div>

    <script>
    function validateQuantity(input) {
        const max = 10;
        const warningElement = input.parentElement.querySelector('.quantity-warning');
        
        // Force the input to be within limits
        if (input.value > max) {
            input.value = max;
            warningElement.style.display = 'block';
        } else if (input.value < 1) {
            input.value = 1;
        } else {
            warningElement.style.display = 'none';
        }
    }
    </script>
</body>
</html>
