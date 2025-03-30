<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Fetch all bookings with user and car info
$stmt = $pdo->prepare("SELECT b.*, u.name AS user_name, c.model, c.brand, c.image 
                        FROM bookings b
                        JOIN users u ON b.user_id = u.id
                        JOIN cars c ON b.car_id = c.id");
$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>View All Bookings</title>
    <!-- <link rel="stylesheet" href="../assets/css/style.css"> -->
    <style>/* View Bookings Page Styling */
/* General Styles */
body {
  font-family: Arial, sans-serif;
  background-color: #f4f7fa;
  margin: 0;
  padding: 0;
}

.container {
  background-color: #fff;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  width: 90%;
  max-width: 900px;
  margin: 50px auto;
}

h2 {
  color: #007bff;
  text-align: center;
}

/* Table Styling */
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

th, td {
  border: 1px solid #ddd;
  padding: 12px;
  text-align: center;
}

th {
  background-color: #007bff;
  color: white;
}

tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}

/* Image Styling */
.car-image {
  width: 150px;
  height: 100px;
  object-fit: cover;
  border-radius: 8px;
}

/* Status Styling */
.status {
  padding: 8px 12px;
  border-radius: 20px;
  color: white;
  font-weight: bold;
}

.status.booked {
  background-color: #ffc107;
}

.status.completed {
  background-color: #28a745;
}

.status.cancelled {
  background-color: #dc3545;
}

/* Buttons Styling */
a {
  color: #007bff;
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}

.btn {
  display: inline-block;
  padding: 8px 12px;
  border-radius: 5px;
  text-decoration: none;
  color: #fff;
  margin-right: 5px;
  transition: background-color 0.3s;
}

.edit-btn { background-color: #f39c12; }
.delete-btn { background-color: #e74c3c; }

.edit-btn:hover { background-color: #e67e22; }
.delete-btn:hover { background-color: #c0392b; }
    </style>
</head>
<body>
    <h2>All Bookings</h2>
    <a href="dashboard.php">Back to Dashboard</a>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Model</th>
                <th>Brand</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>User</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $booking): ?>
            <tr>
                <td>
                    <?php if ($booking['image']): ?>
                        <img src="../assets/images/<?php echo htmlspecialchars($booking['image']); ?>" alt="Car Image">
                    <?php else: ?>
                        <p>No Image</p>
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($booking['model']); ?></td>
                <td><?php echo htmlspecialchars($booking['brand']); ?></td>
                <td><?php echo htmlspecialchars($booking['start_date']); ?></td>
                <td><?php echo htmlspecialchars($booking['end_date']); ?></td>
                <td><?php echo htmlspecialchars($booking['status']); ?></td>
                <td><?php echo htmlspecialchars($booking['user_name']); ?></td>
                <td>
                    <a href="edit_booking.php?id=<?php echo $booking['id']; ?>" class="action-btn edit-btn">Edit</a>
                    <a href="delete_booking.php?id=<?php echo $booking['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>