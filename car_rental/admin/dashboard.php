<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
        }
        .sidebar {
            width: 250px;
            background-color: #222;
            color: white;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 15px 20px;
            display: block;
            color: white;
            text-decoration: none;
            transition: background 0.3s;
        }
        .sidebar a:hover {
            background-color: #3498db;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
        .header {
            background-color: #3498db;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .card {
            background-color: white;
            margin-top: 20px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="view_users.php">Manage Users</a>
        <a href="view_bookings.php">View Bookings</a>
        <a href="drivers.php"> Drivers</a> <!-- New Manage Drivers Section -->
        <a href="../user/about.php" class="text-white hover:text-yellow-400">About</a>
        <a href="query.php" class="text-white hover:text-yellow-400">Queries</a>
        <a href="../auth/logout.php">Logout</a>
    </div>

    <div class="content">
        <div class="header">
            <h1>Welcome, Admin!</h1>
        </div>

        <div class="card">
            <h3>Manage Users</h3>
            <p>View, edit, or delete user accounts.</p>
            <a href="view_users.php" style="color: #3498db;">Go to Manage Users</a>
        </div>

        <div class="card">
            <h3>View Bookings</h3>
            <p>Review all car rental bookings and their statuses.</p>
            <a href="view_bookings.php" style="color: #3498db;">Go to View Bookings</a>
        </div>

        <div class="card">
            <h3> Manage Drivers</h3> <!-- New Card for Managing Drivers -->
            <p>View, add, or remove drivers.</p>
            <a href="drivers.php" style="color: #3498db;">Go to Manage Drivers</a>
        </div>
    </div>
</body>
</html>
