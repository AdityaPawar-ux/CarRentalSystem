<?php
include("../includes/header.php");
include '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit();
}

// Fetch messages from contact table
$stmt = $pdo->query('SELECT * FROM contact ORDER BY created_at DESC');
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin - Contact Queries</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="bg-gray-100 min-h-screen p-8">
    <h2 class="text-3xl font-bold text-gray-700 mb-8">Contact Queries</h2>


    <div class="overflow-x-auto">
        <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-700 text-white">
                <tr>
                    <th class="p-4">ID</th>
                    <th class="p-4">Name</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Message</th>
                    <th class="p-4">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $msg): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4"><?php echo htmlspecialchars($msg['id']); ?></td>
                        <td class="p-4"><?php echo htmlspecialchars($msg['name']); ?></td>
                        <td class="p-4"><?php echo htmlspecialchars($msg['email']); ?></td>
                        <td class="p-4"><?php echo nl2br(htmlspecialchars($msg['message'])); ?></td>
                        <td class="p-4"><?php echo htmlspecialchars($msg['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>