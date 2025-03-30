<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Total Bookings
$stmt = $pdo->prepare("SELECT COUNT(*) AS total_bookings FROM bookings");
$stmt->execute();
$total_bookings = $stmt->fetch(PDO::FETCH_ASSOC)['total_bookings'];

// Booking Status Report
$status_stmt = $pdo->prepare("SELECT status, COUNT(*) AS count FROM bookings GROUP BY status");
$status_stmt->execute();
$status_data = $status_stmt->fetchAll(PDO::FETCH_ASSOC);

// Revenue Report
$revenue_stmt = $pdo->prepare("
    SELECT SUM(DATEDIFF(end_date, start_date) * cars.price_per_day) AS total_revenue
    FROM bookings 
    JOIN cars ON bookings.car_id = cars.id 
    WHERE bookings.status = 'completed'
");
$revenue_stmt->execute();
$total_revenue = $revenue_stmt->fetch(PDO::FETCH_ASSOC)['total_revenue'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reports - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Admin Reports</h2>
    <a href="dashboard.php">Back to Dashboard</a>

    <h3>Total Bookings</h3>
    <p>Total Number of Bookings: <strong><?php echo $total_bookings; ?></strong></p>

    <h3>Booking Status Report</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Status</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($status_data as $data): ?>
            <tr>
                <td><?php echo htmlspecialchars($data['status']); ?></td>
                <td><?php echo htmlspecialchars($data['count']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Revenue Report</h3>
    <p>Total Revenue from Completed Bookings: <strong>₹<?php echo $total_revenue ? $total_revenue : '0'; ?></strong></p>
</body>
</html>
