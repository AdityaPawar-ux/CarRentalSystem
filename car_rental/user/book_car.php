<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "Invalid car ID.";
    exit();
}

$car_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Check if car is available
$stmt = $pdo->prepare("SELECT * FROM cars WHERE id = ? AND status = 'available'");
$stmt->execute([$car_id]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$car) {
    echo "Car is not available.";
    exit();
}

// Handle booking
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Insert booking details into database
    $stmt = $pdo->prepare("INSERT INTO bookings (user_id, car_id, start_date, end_date, status) VALUES (?, ?, ?, ?, 'booked')");
    if ($stmt->execute([$user_id, $car_id, $start_date, $end_date])) {
        // Update car status
        $pdo->prepare("UPDATE cars SET status = 'booked' WHERE id = ?")->execute([$car_id]);
        echo "<script>alert('Booking successful!');</script>";

        // Notify Provider
        $provider_stmt = $pdo->prepare("SELECT provider_id FROM cars WHERE id = ?");
        $provider_stmt->execute([$car_id]);
        $provider_id = $provider_stmt->fetchColumn();

        $message = "Your car {$car['model']} has been booked by User ID: {$user_id} from {$start_date} to {$end_date}.";
        $notify_stmt = $pdo->prepare("INSERT INTO notifications (provider_id, car_id, user_id, message) VALUES (?, ?, ?, ?)");
        $notify_stmt->execute([$provider_id, $car_id, $user_id, $message]);
    } else {
        echo "<script>alert('Error booking the car.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Car - <?php echo htmlspecialchars($car['model']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-6xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Car Details & Image -->
            <div class="space-y-4">
                <h2 class="text-3xl font-bold text-gray-800"><?php echo htmlspecialchars($car['model']); ?></h2>
                <img src="../assets/images/<?php echo $car['image']; ?>" alt="Car Image" class="rounded-lg shadow-lg w-full h-64 object-cover">
                <p class="text-gray-700"><strong>Brand:</strong> <?php echo htmlspecialchars($car['brand']); ?></p>
                <p class="text-gray-700"><strong>Price per Day:</strong> ₹<?php echo htmlspecialchars($car['price_per_day']); ?></p>                
            </div>

            <!-- Booking Form -->
            <div class="bg-gray-50 p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Book This Car</h3>
                <form method="post" class="space-y-4">
                    <div>
                        <label class="text-gray-600 font-medium">Start Date:</label>
                        <input type="date" name="start_date" required class="w-full p-2 border rounded-lg">
                    </div>

                    <div>
                        <label class="text-gray-600 font-medium">End Date:</label>
                        <input type="date" name="end_date" required class="w-full p-2 border rounded-lg">
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">Confirm Booking</button>
                </form>
                <a href="rent_car.php" class="block text-center text-blue-500 mt-4 hover:underline">← Back to Cars</a>
            </div>
        </div>
    </div>
</body>
</html>