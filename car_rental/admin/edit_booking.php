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

// Fetch booking details
$stmt = $pdo->prepare("SELECT * FROM bookings WHERE id = ?");
$stmt->execute([$booking_id]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    echo "<div class='error'>Booking not found.</div>";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE bookings SET start_date = ?, end_date = ?, status = ? WHERE id = ?");
    if ($stmt->execute([$start_date, $end_date, $status, $booking_id])) {
        echo "<div class='success'>Booking updated successfully!</div>";
    } else {
        echo "<div class='error'>Error updating booking.</div>";
    }
    header("refresh:2;url=view_bookings.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Booking</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 400px;
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #2980b9;
        }
        .success {
            color: #28a745;
        }
        .error {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <form method="post">
        <h2>Edit Booking</h2>
        <label>Start Date:</label>
        <input type="date" name="start_date" value="<?php echo $booking['start_date']; ?>" required><br>

        <label>End Date:</label>
        <input type="date" name="end_date" value="<?php echo $booking['end_date']; ?>" required><br>

        <label>Status:</label>
        <select name="status">
            <option value="booked" <?php echo $booking['status'] === 'booked' ? 'selected' : ''; ?>>Booked</option>
            <option value="completed" <?php echo $booking['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
            <option value="cancelled" <?php echo $booking['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
        </select><br>

        <button type="submit">Update Booking</button>
    </form>
    <a href="view_bookings.php">Back to Bookings</a>
</body>
</html>