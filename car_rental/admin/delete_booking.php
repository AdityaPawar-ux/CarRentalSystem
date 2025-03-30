<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "<div class='error'>Invalid booking ID.</div>";
    exit();
}

$booking_id = intval($_GET['id']);

// Delete booking
$stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
if ($stmt->execute([$booking_id])) {
    echo "<div class='success'>Booking deleted successfully!</div>";
} else {
    echo "<div class='error'>Error deleting booking.</div>";
}
header("refresh:2;url=view_bookings.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Delete Booking</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            text-align: center;
            padding-top: 100px;
        }
        .success {
            color: #28a745;
            font-size: 18px;
            padding: 10px;
        }
        .error {
            color: #dc3545;
            font-size: 18px;
            padding: 10px;
        }
    </style>
</head>
<body>
</body>
</html>
