<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Fetch all cars
$stmt = $pdo->prepare("
    SELECT c.*, u.name AS provider_name, b.user_id, u2.name AS booked_by
    FROM cars c
    JOIN users u ON c.provider_id = u.id
    LEFT JOIN bookings b ON c.id = b.car_id
    LEFT JOIN users u2 ON b.user_id = u2.id
");
$stmt->execute();
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>View All Cars</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        img {
            width: 150px;
            height: 100px;
            object-fit: cover;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 10px;
        }
    </style>
</head>
<body>
    <h2>All Cars</h2>
    <a href="dashboard.php">Back to Dashboard</a>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Model</th>
                <th>Brand</th>
                <th>Price Per Day</th>
                <th>Status</th>
                <th>Provider</th>
                <th>Booked By</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cars as $car): ?>
            <tr>
                <td>
                    <?php if ($car['image']): ?>
                        <img src="../assets/images/<?php echo htmlspecialchars($car['image']); ?>" alt="Car Image">
                    <?php else: ?>
                        <p>No Image</p>
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($car['model']); ?></td>
                <td><?php echo htmlspecialchars($car['brand']); ?></td>
                <td>₹<?php echo htmlspecialchars($car['price_per_day']); ?></td>
                <td><?php echo htmlspecialchars($car['status']); ?></td>
                <td><?php echo htmlspecialchars($car['provider_name']); ?></td>
                <td>
                <?php echo $car['booked_by'] ? htmlspecialchars($car['booked_by']) : 'Not Booked'; ?>
            </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
