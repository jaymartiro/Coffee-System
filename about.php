<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Boss 2.0</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .header {
            background-color: #808080;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .logo img {
            height: 50px;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        .about-container {
            max-width: 1200px;
            margin: 100px auto 50px;
            padding: 2rem;
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            margin-bottom: 4rem;
        }

        .about-image {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .about-text {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #333;
        }

        .spotlight {
            font-size: 3rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 2rem;
            text-align: center;
        }

        .coffee-info {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-top: 3rem;
        }

        .coffee-beans-image {
            width: 100%;
            border-radius: 10px;
            margin-top: 2rem;
        }

        .auth-buttons {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .welcome-text {
            color: white;
            font-weight: 500;
        }

        .sign-in-btn, .join-now-btn, .logout-btn {
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 500;
        }

        .sign-in-btn {
            color: black;
            background-color: white;
        }

        .join-now-btn {
            color: white;
            background-color: black;
        }

        .logout-btn {
            color: white;
            background-color: #dc3545;
        }

        @media (max-width: 768px) {
            .about-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .spotlight {
                font-size: 2rem;
            }

            .about-text {
                font-size: 1rem;
            }

            .welcome-text {
                display: none;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="nav-left">
            <div class="logo">
                <a href="menu.php">
                    <img src="images/logo.jpg" alt="Boss 2.0 Logo">
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
                <a href="logout.php" class="logout-btn" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
            <?php else: ?>
                <a href="user_login.php" class="sign-in-btn">Sign in</a>
                <a href="user_register.php" class="join-now-btn">Join now</a>
            <?php endif; ?>
        </div>
    </header>

    <div class="about-container">
        <div class="about-grid">
            <img src="images/Kenneth Obrador.jpg" alt="Kenneth Obrador" class="about-image">
            <div>
                <p class="about-text">
                    Founded by Kenneth Obrador on November 1 2024, Boss2.0 Coffee Celebrates Philippine 
                    Culture and artistry by showcasing the exquisite flavors of Philippine Coffee 
                    and preserving Filipino tradition.
                </p>
            </div>
        </div>

        <div class="spotlight">
            We put the spotlight on Philippine Coffee.
        </div>

        <div class="coffee-info">
            <p class="about-text">
                Each cup of coffee sold supports local farmers, sourced from Philippine coffee 
                by sourcing premium beans from regions
            </p>
            <img src="images/Philippine Coffee Beans.jpg" alt="Philippine coffee" class="coffee-beans-image">
        </div>
    </div>
</body>
</html> 