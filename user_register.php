<?php
session_start();
require_once 'db_connect.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    if ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->fetch()) {
            $error = 'Email already registered';
        } else {
            try {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password, contact, address) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$name, $email, $hashed_password, $contact, $address]);
                
                $success = 'Account created successfully! You can now login.';
            } catch(PDOException $e) {
                $error = 'Error creating account. Please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Boss 2.0</title>
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

        .register-container {
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

        .register-btn {
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

        .register-btn:hover {
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

        .success-message {
            color: #28a745;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            background-color: rgba(40, 167, 69, 0.1);
            padding: 0.5rem;
            border-radius: 5px;
        }

        .login-link {
            margin-top: 1rem;
            color: #000;
            text-decoration: none;
            display: inline-block;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .register-container {
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
    <a href="index.php">
        <img src="images/logo.jpg" alt="Boss 2.0 Logo">
        <a/>
    </div>

    <div class="register-container">
        <h1>CREATE ACCOUNT</h1>

        <?php if ($error): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <input type="text" name="name" placeholder="Full Name" required>
            </div>

            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required 
                       minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                       title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
            </div>

            <div class="form-group">
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            </div>

            <div class="form-group">
                <input type="tel" name="contact" placeholder="Contact Number" required>
            </div>

            <div class="form-group">
                <input type="text" name="address" placeholder="Address" required>
            </div>

            <button type="submit" class="register-btn">Create Account</button>
        </form>

        <a href="user_login.php" class="login-link">Already have an account? Log in</a>
    </div>
</body>
</html> 