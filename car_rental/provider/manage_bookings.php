<?php
include("../includes/header.php");
include '../config.php';

if ($_SESSION['role'] !== 'provider') {
    header("Location: ../auth/login.php");
    exit();
}

$provider_id = $_SESSION['user_id'];

// Fetch bookings for provider's cars
$stmt = $pdo->prepare("
    SELECT b.*, 
       u.name AS user_name, 
       c.model, 
       c.brand,
       CASE WHEN b.status IS NULL OR b.status = '' THEN 'Pending' ELSE b.status END AS status
FROM bookings b
JOIN cars c ON b.car_id = c.id
JOIN users u ON b.user_id = u.id
WHERE c.provider_id = ?

");
$stmt->execute([$provider_id]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle Approve or Reject
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        $update_stmt = $pdo->prepare("UPDATE bookings SET status = 'Approved' WHERE id = ?");
    } elseif ($action === 'reject') {
        $update_stmt = $pdo->prepare("UPDATE bookings SET status = 'Rejected' WHERE id = ?");
    }
    $update_stmt->execute([$booking_id]);
    header("Location: manage_bookings.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto py-12">
        <h2 class="text-3xl font-bold mb-6">Manage Bookings</h2>
        
        <div class="overflow-x-auto mt-8">
            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="py-3 px-4">User</th>
                        <th class="py-3 px-4">Car Model</th>
                        <th class="py-3 px-4">Brand</th>
                        <th class="py-3 px-4">Start Date</th>
                        <th class="py-3 px-4">End Date</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr class="border-b">
                            <td class="py-4 px-4"> <?php echo htmlspecialchars($booking['user_name']); ?> </td>
                            <td class="py-4 px-4"> <?php echo htmlspecialchars($booking['model']); ?> </td>
                            <td class="py-4 px-4"> <?php echo htmlspecialchars($booking['brand']); ?> </td>
                            <td class="py-4 px-4"> <?php echo htmlspecialchars($booking['start_date']); ?> </td>
                            <td class="py-4 px-4"> <?php echo htmlspecialchars($booking['end_date']); ?> </td>
                            <td class="py-4 px-4"> <?php echo htmlspecialchars($booking['status']); ?> </td>
                            <td class="py-4 px-4">
                                <?php if (strtolower(trim($booking['status'])) === 'pending'): ?>
                                    <form method="post" class="flex gap-2">
                                        <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                        <button type="submit" name="action" value="approve" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Approve</button>
                                        <button type="submit" name="action" value="reject" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">Reject</button>
                                    </form>
                                <?php else: ?>
                                    <?php echo htmlspecialchars($booking['status']); ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>