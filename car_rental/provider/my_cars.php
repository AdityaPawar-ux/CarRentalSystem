<?php
include("../includes/header.php");
include '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'provider') {
    header("Location: ../auth/login.php");
    exit();
}

$provider_id = $_SESSION['user_id'];

// Fetch provider's cars
$stmt = $pdo->prepare("SELECT * FROM cars WHERE provider_id = ?");
$stmt->execute([$provider_id]);
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Cars - Provider</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto p-8">
        <h2 class="text-3xl font-bold text-blue-600 mb-8">Your Cars</h2>

        <div class="overflow-x-auto mt-6">
            <table class="w-full bg-white shadow-md rounded-lg">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="p-4">Image</th>
                        <th class="p-4">Model</th>
                        <th class="p-4">Brand</th>
                        <th class="p-4">Price Per Day</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cars as $car): ?>
                    <tr class="border-b">
                        <td class="p-4">
                            <?php if ($car['image']): ?>
                                <img src="../assets/images/<?php echo htmlspecialchars($car['image']); ?>" alt="Car Image" class="w-32 h-24 object-cover rounded">
                            <?php else: ?>
                                <span class="text-gray-400">No Image</span>
                            <?php endif; ?>
                        </td>
                        <td class="p-4"> <?php echo htmlspecialchars($car['model']); ?> </td>
                        <td class="p-4"> <?php echo htmlspecialchars($car['brand']); ?> </td>
                        <td class="p-4">₹<?php echo htmlspecialchars($car['price_per_day']); ?> </td>
                        <td class="p-4"> <?php echo htmlspecialchars($car['status']); ?> </td>
                        <td class="p-4 space-x-2">
                            <a href="edit_car.php?id=<?php echo $car['id']; ?>" class="text-yellow-500 hover:underline">Edit</a>
                            <a href="delete_car.php?id=<?php echo $car['id']; ?>" onclick="return confirm('Are you sure?')" class="text-red-500 hover:underline">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>