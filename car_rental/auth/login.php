<?php
include("../includes/header.php");
include '../config.php';

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        
        // Redirect based on role
        switch ($_SESSION['role']) {
            case 'admin':
                header("Location: ../admin/dashboard.php");
                exit;
            case 'provider':
                header("Location: ../provider/dashboard.php");
                exit;
            case 'user':
                header("Location: ../user/dashboard.php");
                exit;
            default:
                echo "Invalid role. Please contact support.";
        }
    } else {
        echo "<script>alert('Invalid email or password!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Car Rental</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-overlay {
            background: url('../assets/images/car.jpeg') no-repeat center center/cover;
            filter: blur(5px);
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .fade-in {
            animation: fadeIn 1.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body>
<div class="bg-gray-100 flex items-center justify-center h-screen" style="background: url('../assets/images/car.jpeg') center/cover no-repeat;">
    <div class="w-full max-w-md p-8 space-y-6 bg-white bg-opacity-80 shadow-md rounded-lg border animate-fadeIn">
        <h2 class="text-2xl font-bold text-center text-gray-700">Login to Car Rental</h2>
        <form method="post" action="" class="space-y-4">
            <div>
                <label class="block text-gray-600">Email:</label>
                <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div>
                <label class="block text-gray-600">Password:</label>
                <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Login</button>

            <p class="text-center text-gray-500">Don't have an account? <a href="signup.php" class="text-blue-500 hover:underline">Signup here</a></p>
        </form>
    </div>
</div>
</body>
</html>
