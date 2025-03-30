<?php
include '../config.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Check if email already exists
    $checkEmail = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $checkEmail->execute([$email]);

    if ($checkEmail->rowCount() > 0) {
        echo "Email already exists!";
    } else {
        // Insert new user
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$name, $email, $password, $role])) {
            echo "Registration successful! <a href='login.php'>Login Here</a>";
        } else {
            echo "Error during registration.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Car Rental</title>
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
<?php include '../includes/header.php'; ?>
<div class="bg-gray-100 flex items-center justify-center min-h-screen" style="background-image: url('../assets/images/car.jpeg'); background-size: cover; background-position: center; background: blur(5px);">

    <div class="bg-overlay"></div>
    <div class="bg-white bg-opacity-80 p-8 rounded-lg shadow-lg max-w-md w-full text-center fade-in">
        <h2 class="text-2xl font-bold text-blue-600 mb-6">Signup</h2>
        <form method="post" action="">
            <div class="mb-4">
                <label class="block text-gray-700">Name:</label>
                <input type="text" name="name" required class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700">Email:</label>
                <input type="email" name="email" required class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700">Password:</label>
                <input type="password" name="password" required class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700">Role:</label>
                <select name="role" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="user">User</option>
                    <option value="provider">Provider</option>
                </select>
            </div>
            
            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700 transition duration-300">Signup</button>
            <p class="text-center text-gray-600 mt-4">Already have an account? <a href="login.php" class="text-blue-500">Login here</a></p>
        </form>
    </div>
</body>
</html>
