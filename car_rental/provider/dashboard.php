<?php
include '../includes/header.php';
include '../config.php';

if ($_SESSION['role'] !== 'provider') {
    header("Location: ../auth/login.php");
    exit();
}

// Fetch provider's cars from database
$stmt = $pdo->prepare("SELECT * FROM cars WHERE provider_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Provider Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto py-12 px-6">
        <h1 class="text-3xl font-bold mb-8">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

        <h2 class="text-2xl font-semibold mb-4">My Cars</h2>

        <?php if (count($cars) > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($cars as $car): ?>
                    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-transform transform hover:scale-105">
                    <img src="../assets/images/<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['model']); ?>" class="w-full h-48 object-cover rounded-md mb-4">
                        <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($car['model']); ?></h3>
                        <p class="text-gray-600">Model: <?php echo htmlspecialchars($car['model']); ?></p>
                        <p class="text-gray-600">Price: ₹<?php echo htmlspecialchars($car['price_per_day']); ?> / day</p>
                        <p class="text-gray-600">Status: <?php echo htmlspecialchars($car['status']); ?></p>
                        <a href="edit_car.php?id=<?php echo $car['id']; ?>" class="inline-block mt-4 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Edit</a>
                        <a href="delete_car.php?id=<?php echo $car['id']; ?>" class="inline-block mt-4 bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Delete</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-600">No cars added yet. <a href="add_car.php" class="text-blue-500">Add a Car</a></p>
        <?php endif; ?>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>