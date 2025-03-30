<?php
include("../includes/header.php");
include '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user bookings
$stmt = $pdo->prepare("SELECT b.*, c.model, c.brand, c.image 
                        FROM bookings b
                        JOIN cars c ON b.car_id = c.id
                        WHERE b.user_id = ?");
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - Car Rental</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    
    <div class="bg-gray-100 flex items-center justify-center min-h-screen">
        <div class="w-full max-w-6xl p-8 space-y-6 bg-white shadow-md rounded-lg">
        <h2 class="text-3xl font-bold text-center text-gray-700">My Bookings</h2>
        
        <?php
        $user_id = $_SESSION['user_id'];
        $stmt = $pdo->prepare("SELECT b.*, c.model, c.brand, c.image FROM bookings b JOIN cars c ON b.car_id = c.id WHERE b.user_id = ?");
        $stmt->execute([$user_id]);
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-3 px-4 border-b">Image</th>
                        <th class="py-3 px-4 border-b">Model</th>
                        <th class="py-3 px-4 border-b">Brand</th>
                        <th class="py-3 px-4 border-b">Start Date</th>
                        <th class="py-3 px-4 border-b">End Date</th>
                        <th class="py-3 px-4 border-b">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td class="py-3 px-4 border-b">
                                <?php if ($booking['image']): ?>
                                    <img src="../assets/images/<?php echo htmlspecialchars($booking['image']); ?>" alt="Car Image" class="w-24 h-16 object-cover rounded-md">
                                <?php else: ?>
                                    <p>No Image</p>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($booking['model']); ?></td>
                            <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($booking['brand']); ?></td>
                            <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($booking['start_date']); ?></td>
                            <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($booking['end_date']); ?></td>
                            <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($booking['status']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php include("../includes/footer.php"); ?>
</body>

</html>
