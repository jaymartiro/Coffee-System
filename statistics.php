<?php
require_once 'db_connect.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Get orders by status for pie chart
$stmt = $pdo->query("
    SELECT status, COUNT(*) as count 
    FROM orders 
    GROUP BY status
");
$orders_by_status = $stmt->fetchAll();

// Prepare data for Chart.js
$labels = [];
$data = [];
$backgroundColor = [
    'pending' => '#ffa500',
    'completed' => '#28a745',
    'cancelled' => '#dc3545'
];
$colors = [];

foreach ($orders_by_status as $status) {
    $labels[] = ucfirst($status['status']);
    $data[] = $status['count'];
    $colors[] = $backgroundColor[$status['status']] ?? '#808080';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics - Boss 2.0</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 600px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 2rem;
        }
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
        }r
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
    <h1>Order Statistics</h1>
    <div class="chart-container">
        <canvas id="ordersPieChart"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('ordersPieChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: <?php echo json_encode($colors); ?>,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Orders by Status'
                    }
                }
            }
        });
    </script>
</body>
</html>
