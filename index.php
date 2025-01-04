<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boss 2.0 - Coffee Shop</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Serif', serif;
            background-image: url('./images/background.jpg');
        }

        .header {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            background-color: transparent;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .logo img {
            height: 50px;
            border-radius: 50%;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .auth-buttons {
            gap: 4rem;
            color: white;
        }

        .sign-in-btn, .join-now-btn {
            padding: 0.7rem 1.5rem;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 500;
        }

        .sign-in-btn {
            background-color: white;
            color: black;
        }

        .join-now-btn {
            background-color: black;
            color: white;
        }

        .hero {
            height: 100vh;
            background-image: url('images/coffee-pour.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            position: relative;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        }

        .hero-text {
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-size: 10rem;
            margin-bottom: 2rem;
            font-weight: 300;
        }

        .products {
            padding: 4rem 2rem;
            background-color: #f5f5f5;
        }

        .section-title {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            color: #333;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .product-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: relative;
            display:flex left;
        }

        .best-seller {
            position: absolute;
            top: 00.5rem;
            left: 0rem;
            background: black;
            width: 70px;
            height:40px;
            color: white;
            padding: 0rem 1rem;
            border-radius: 10px;
            font-size: 1rem;
        }

        .product-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .product-info {
            padding: 1.5rem;
            text-align: center;
        }

        .product-name {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: #333;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 3rem;
            }

            .nav-links {
                display: none;
            }

            .product-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="nav-left">
            <div class="logo">
                <a href="index.php">
                    <img src="images/logo.jpg" alt="Boss 2.0">
                </a>
            </div>
            <div class="nav-links">
                <a href="index.php">Shop at Boss2.0</a>
                <a href="about.php">About us</a>
                <a href="menu.php">Menu</a>
            </div>
        </div>
        <div class="auth-buttons">
            <?php if(isset($_SESSION['user_id'])): ?>
                <span class="welcome-text">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                <a href="logout.php" class="join-now-btn">Logout</a>
            <?php else: ?>
                <a href="user_login.php" class="sign-in-btn">Sign in</a>
                <a href="user_register.php" class="join-now-btn">Join now</a>
            <?php endif; ?>
        </div>
    </header>

    <section class="hero">
        <div class="hero-text">
            <h1 class="hero-title">CaféDreams<br>Brewing</h1>
        </div>
    </section>

    <section class="products">
        <h2 class="section-title">Coffee & Foods Selections</h2>
        <div class="product-grid">
            <div class="product-card">
                <span class="best-seller">Best seller</span>
                <a href="menu.php" class="Caffee Mocha">
                <img src="images/Caffee Mocha.jpg" alt="Caffee Mocha" class="product-image">
                <div class="product-info">
                    <h3 class="product-name">Caffee Mocha</h3>
                </div>
            </div>

            <div class="product-card">
                <img src="images/Caffee Americano.jpg" alt="Caffe Americano" class="product-image">
                <div class="product-info">
                    <h3 class="product-name">Caffe Americano</h3>
                </div>
            </div>

            <div class="product-card">
                <img src="images/Blueberry Calamansi Streussel Muffin.jpg" alt="Blueberry Calamansi Streussel Muffin" class="product-image">
                <div class="product-info">
                    <h3 class="product-name">Blueberry Calamansi Streussel Muffin</h3>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
