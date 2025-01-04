<?php
require_once 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Menu - Boss 2.0</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: white;
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

        .auth-buttons button {
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            border: none;
            cursor: pointer;
            margin-left: 1rem;
        }

        .sign-in {
            background: white;
            color: black;
        }

        .join-now {
            background: black;
            color: white;
        }

        .menu-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        h1 {
            text-align: center;
            font-size: 3rem;
            margin-bottom: 2rem;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 2rem;
        }

        .category {
            background: #808080;
            padding: 2rem;
            border-radius: 10px;
        }

        .category-title {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: #000;
        }

        .product {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 8px;
        }

        .product img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 1rem;
        }

        .product-info {
            flex-grow: 1;
        }

        .product-name {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .product-price {
            color: #fff;
        }

        .add-to-cart {
            background: none;
            border: none;
            cursor: pointer;
            color: white;
            font-size: 1.5rem;
        }

        @media (max-width: 1024px) {
            .menu-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .menu-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">
            <a href="index.php">
                <img src="images/logo.jpg" alt="Boss 2.0 Logo">
            </a>
        </div>
        <div class="auth-buttons">
                
        </div>
    </header>

    <div class="menu-container">
        <h1>Our menu</h1>
        
        <div class="menu-grid">
            <!-- Hot Coffee Section -->
            <div class="category">
                <h2 class="category-title">Hot coffee</h2>
                <?php
                $stmt = $pdo->prepare("SELECT * FROM products WHERE category = 'hot_coffee'");
                $stmt->execute();
                while($product = $stmt->fetch()) {
                    ?>
                    <div class="product">
                        <a href="product_details.php?id=<?php echo $product['id']; ?>">
                            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </a>
                        <div class="product-info">
                            <div class="product-name"><?php echo htmlspecialchars($product['name']); ?></div>
                            <div class="product-price">Php <?php echo number_format($product['price'], 2); ?></div>
                        </div>
                        <a href="cart.php?id=<?php echo $product['id']; ?>" class="add-to-cart">🛒</a>
                    </div>
                    <?php
                }
                ?>
            </div>

            <!-- Cold Coffee Section -->
            <div class="category">
                <h2 class="category-title">Cold coffee</h2>
                <?php
                $stmt = $pdo->prepare("SELECT * FROM products WHERE category = 'cold_coffee'");
                $stmt->execute();
                while($product = $stmt->fetch()) {
                    ?>
                    <div class="product">
                        <a href="product_details.php?id=<?php echo $product['id']; ?>">
                            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </a>
                        <div class="product-info">
                            <div class="product-name"><?php echo htmlspecialchars($product['name']); ?></div>
                            <div class="product-price">Php <?php echo number_format($product['price'], 2); ?></div>
                        </div>
                        <a href="cart.php?id=<?php echo $product['id']; ?>" class="add-to-cart">🛒</a>
                    </div>
                    <?php
                }
                ?>
            </div>

            <!-- Foods Section -->
            <div class="category">
                <h2 class="category-title">Foods</h2>
                <?php
                $stmt = $pdo->prepare("SELECT * FROM products WHERE category = 'foods'");
                $stmt->execute();
                while($product = $stmt->fetch()) {
                    ?>
                    <div class="product">
                        <a href="product_details.php?id=<?php echo $product['id']; ?>">
                            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </a>
                        <div class="product-info">
                            <div class="product-name"><?php echo htmlspecialchars($product['name']); ?></div>
                            <div class="product-price">Php <?php echo number_format($product['price'], 2); ?></div>
                        </div>
                        <a href="cart.php?id=<?php echo $product['id']; ?>" class="add-to-cart">🛒</a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>