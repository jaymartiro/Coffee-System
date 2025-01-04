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

    // Validate passwords match
    if ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->fetch()) {
            $error = 'Email already registered';
        } else {
            // Create new account
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
        }

        .logo {
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .logo img {
            height: 80px;
            width: auto;
        }

        .register-container {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            text-align: center;
        }

        h1 {
            color: #000;
            font-size: 2.5rem;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        input {
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            background: white;
            text-align: center;
        }

        input::placeholder {
            color: #666;
        }

        .create-btn {
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: 25px;
            background-color: #000;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .create-btn:hover {
            background-color: #333;
        }

        .error-message {
            color: #ff0000;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .success-message {
            color: #28a745;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .login-link {
            margin-top: 1rem;
            color: #000;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="images/logo.jpg" alt="Boss 2.0 Logo">
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
                <input type="text" name="name" placeholder="FULL NAME" required>
            </div>

            <div class="form-group">
                <input type="email" name="email" placeholder="EMAIL" required>
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="PASSWORD" required 
                       minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                       title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
            </div>

            <div class="form-group">
                <input type="password" name="confirm_password" placeholder="CONFIRM PASSWORD" required>
            </div>

            <div class="form-group">
                <input type="tel" name="contact" placeholder="CONTACT NUMBER" required>
            </div>

            <div class="form-group">
                <input type="text" name="address" placeholder="ADDRESS" required>
            </div>

            <button type="submit" class="create-btn">CREATE ACCOUNT</button>
        </form>

        <a href="login.php" class="login-link">Already have an account? Log in</a>
    </div>
</body>
</html>
