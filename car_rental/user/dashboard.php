<?php
include("../includes/header.php");
if ($_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Car Rental</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Hero Section -->
    <section class="relative w-full h-[60vh] bg-center bg-cover flex items-center justify-center" 
        style="background-image: url('../assets/images/Am.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="text-center text-white px-4">
                <h1 class="text-5xl font-bold mb-4">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
                <p class="text-xl mb-6">Find your perfect ride with our premium car rental service.</p>
                <a href="rent_car.php" class="bg-blue-500 text-white px-6 py-3 rounded-lg text-lg hover:bg-blue-600 transition">Rent a Car</a>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-12 px-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Available Cars for Rent</h2>

        <?php
        include '../config.php';
        $stmt = $pdo->query("SELECT * FROM cars WHERE status='Available'");
        $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach ($cars as $car): ?>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-transform transform hover:scale-105">
                    <img src="../assets/images/<?php echo htmlspecialchars($car['image']); ?>" 
                         alt="<?php echo htmlspecialchars($car['model']); ?>" 
                         class="w-full h-40 object-cover rounded-md mb-4">
                    <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($car['model']); ?></h3>
                    <p class="text-gray-600">Brand: <?php echo htmlspecialchars($car['brand']); ?></p>
                    <p class="text-gray-600">Price per Day: ₹<?php echo htmlspecialchars($car['price_per_day']); ?></p>
                    <a href="rent_car.php?car_id=<?php echo $car['id']; ?>" 
                       class="inline-block mt-4 bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
                        Rent Now
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="max-w-7xl mx-auto mt-12">
    <div class="bg-blue-500 text-white text-center py-6 px-4 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold">Welcome to Car Rental Management System</h2>
        <p class="text-lg mt-2">Find the best car for you, from old to the latest model cars.</p>
    </div>
</div>

    </div>

<?php include("../includes/footer.php"); ?>
</body>
</html>
