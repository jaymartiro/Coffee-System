<?php
require_once 'db_connect.php';

// Get total orders
$stmt = $pdo->query("SELECT COUNT(*) as total FROM orders");
$total_orders = $stmt->fetch()['total'];

// Get total revenue
$stmt = $pdo->query("
    SELECT SUM(o.quantity * p.price) as total 
    FROM orders o 
    JOIN products p ON o.product_id = p.id
");
$total_revenue = $stmt->fetch()['total'];

// Get orders by status
$stmt = $pdo->query("
    SELECT status, COUNT(*) as count 
    FROM orders 
    GROUP BY status
");
$orders_by_status = $stmt->fetchAll();

// Get recent orders
$stmt = $pdo->query("
    SELECT 
        o.*,
        p.name as dish_name,
        p.price,
        (o.quantity * p.price) as total_price
    FROM orders o
    JOIN products p ON o.product_id = p.id
    WHERE o.status = 'pending'
    ORDER BY o.order_date DESC
    LIMIT 5
");
$recent_orders = $stmt->fetchAll();
?>

<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Boss 2.0</title>
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

        .dashboard {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
        }

        .sidebar {
            background-color: #333;
            color: white;
            padding: 2rem;
        }

        .logo {
            margin-bottom: 2rem;
        }

        .logo img {
            height: 50px;
        }

        .nav-links {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 0.5rem;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .nav-links a:hover {
            background-color: #444;
        }

        .main-content {
            padding: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .stat-card h3 {
            color: #666;
            margin-bottom: 0.5rem;
        }

        .stat-card .value {
            font-size: 1.8rem;
            font-weight: bold;
            color: #333;
        }

        .recent-orders {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .recent-orders h2 {
            margin-bottom: 1rem;
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-table th,
        .order-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .status-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            color: white;
            font-size: 0.9rem;
        }

        .status-pending { background-color: #ffa500; }
        .status-completed { background-color: #28a745; }
        .status-cancelled { background-color: #dc3545; }

        .view-all-btn {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.8rem 1.5rem;
            background-color: #333;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .view-all-btn:hover {
            background-color: #444;
        }

        .header {
            background-color: #808080;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .welcome-text {
            color: white;
            font-weight: 500;
        }

        .logout-btn {
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        @media (max-width: 768px) {
            .header {
                padding: 1rem;
            }

            .welcome-text {
                display: none;
            }
        }

        .action-btn {
            padding: 0.3rem 0.8rem;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            margin: 0 0.2rem;
        }

        .action-btn.accept {
            background-color: #28a745;
        }

        .action-btn.decline {
            background-color: #dc3545;
        }

        .action-btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">
            <a href="admin_dashboard.php">
                <img src="images/logo.jpg" alt="Boss 2.0 Logo">
            </a>
        </div>
        <div class="admin-info">
            <span class="welcome-text">Welcome, Admin <?php echo htmlspecialchars($_SESSION['admin_email']); ?></span>
            <a href="admin_logout.php" class="logout-btn" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
        </div>
    </header>

    <div class="dashboard">
        <div class="sidebar">
            <div class="logo">
                <a href="dash_board.php">
                    <a/>
                <img src="images/logo.jpg" alt="Boss 2.0 Logo">
            </div>
            <nav class="nav-links">
                <a href="statistics.php">Statistics</a>
                <a href="admin_dashboard.php">Dashboard</a>
                <a href="order_list.php">Orders</a>
                <a href="menu.php">Menu</a>
               
            </nav>
        </div>

        <div class="main-content">
            <h1>Dashboard</h1>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Orders</h3>
                    <div class="value"><?php echo $total_orders; ?></div>
                </div>
                
                <div class="stat-card">
                    <h3>Total Revenue</h3>
                    <div class="value">Php <?php echo number_format($total_revenue, 2); ?></div>
                </div>

                <?php foreach ($orders_by_status as $status): ?>
                <div class="stat-card">
                    <h3><?php echo ucfirst($status['status']); ?> Orders</h3>
                    <div class="value"><?php echo $status['count']; ?></div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="recent-orders">
                <h2>Recent Orders</h2>
                <table class="order-table">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($recent_orders as $order): ?>
                    <tr>
                        <td>#<?php echo $order['id']; ?></td>
                        <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['dish_name']); ?></td>
                        <td>Php <?php echo number_format($order['total_price'], 2); ?></td>
                        <td>
                            <span class="status-badge status-<?php echo htmlspecialchars($order['status'] ?? 'pending'); ?>">
                                <?php echo ucfirst(htmlspecialchars($order['status'] ?? 'pending')); ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($order['status'] === 'pending'): ?>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                <button type="submit" name="action" value="accept" class="action-btn accept">Accept</button>
                                <button type="submit" name="action" value="decline" class="action-btn decline">Decline</button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <a href="order_list.php" class="view-all-btn">View All Orders</a>
            </div>
        </div>
    </div>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['action'])) {
    $order_id = $_POST['order_id'];
    $action = $_POST['action'];
    $new_status = ($action === 'accept') ? 'completed' : 'cancelled';
    
    $update_stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $update_stmt->execute([$new_status, $order_id]);
    
    header("Location: admin_dashboard.php");
    exit();
}
