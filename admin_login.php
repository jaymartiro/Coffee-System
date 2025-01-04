<?php
session_start();
require_once 'db_connect.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_email'] = $admin['email'];
        header('Location: admin_dashboard.php');
        exit();
    } else {
        $error = 'Invalid email or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Boss 2.0</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #808080;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .logo {
            margin-bottom: 2rem;
        }

        .logo img {
            height: 100px;
            width: auto;
        }

        .login-container {
            width: 90%;
            max-width: 400px;
            text-align: center;
        }

        h1 {
            color: #000;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        input {
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            background: white;
            text-align: center;
            outline: none;
        }

        input::placeholder {
            color: #666;
            text-transform: uppercase;
        }

        .login-btn {
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: 25px;
            background-color: #000;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
            text-transform: uppercase;
            margin-top: 1rem;
        }

        .login-btn:hover {
            background-color: #333;
        }

        .error-message {
            color: #ff0000;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            background-color: rgba(255, 0, 0, 0.1);
            padding: 0.5rem;
            border-radius: 5px;
        }

        @media (max-width: 480px) {
            .login-container {
                width: 95%;
            }

            h1 {
                font-size: 2rem;
                margin-bottom: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="images/logo.jpg" alt="Boss 2.0 Logo">
    </div>

    <div class="login-container">
        <h1>ADMIN LOG IN</h1>

        <?php if ($error): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" class="login-btn">Log In</button>
        </form>
    </div>
</body>
</html>