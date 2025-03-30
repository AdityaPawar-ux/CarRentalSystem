<?php
include("../includes/header.php");
include '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit();
}

// Fetch available cars
$stmt = $pdo->prepare("SELECT * FROM cars WHERE status = 'available'");
$stmt->execute();
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Cars - Car Rental</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-6xl p-8 space-y-6 bg-white shadow-md rounded-lg">
        <h2 class="text-3xl font-bold text-center text-gray-700">Available Cars for Rent</h2>
        
        <?php
        $stmt = $pdo->prepare("SELECT * FROM cars WHERE status = 'available'");
        $stmt->execute();
        $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($cars as $car): ?>
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <?php if ($car['image']): ?>
                        <img src="../assets/images/<?php echo htmlspecialchars($car['image']); ?>" alt="Car Image" class="w-full h-48 object-cover rounded-md">
                    <?php else: ?>
                        <div class="w-full h-48 bg-gray-300 flex items-center justify-center rounded-md">No Image</div>
                    <?php endif; ?>
                    <h3 class="text-xl font-bold mt-4">Model: <?php echo htmlspecialchars($car['model']); ?></h3>
                    <p class="text-gray-600">Brand: <?php echo htmlspecialchars($car['brand']); ?></p>
                    <p class="text-gray-800 font-semibold">Price per Day: ₹<?php echo htmlspecialchars($car['price_per_day']); ?></p>
                    <a href="book_car.php?id=<?php echo $car['id']; ?>" class="mt-4 inline-block bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">Book Now</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php include("../includes/footer.php"); ?>
</body>
</html>
