<?php
include("../includes/header.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit();
}

include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id']; // Fetch the logged-in user's ID
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Insert data into the contact table
    $stmt = $pdo->prepare("INSERT INTO contact (user_id, name, email, message) VALUES (?, ?, ?, ?)");
    
    if ($stmt->execute([$user_id, $name, $email, $message])) {
        echo "<p class='text-green-500'>Message sent successfully!</p>";
    } else {
        echo "<p class='text-red-500'>Error sending message. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us - Car Rental</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
<div class="bg-gray-100 min-h-screen flex items-center justify-center" style="background-image: url('../assets/images/bg.jpg'); background-size: cover; background-position: center;">
    <div class="w-full max-w-lg p-8 space-y-6 bg-white bg-opacity-80 shadow-md rounded-lg">
        <h2 class="text-2xl font-bold text-center text-gray-700">Contact Us</h2>
        <p class="text-center text-gray-500">Have questions or feedback? Reach out to us using the form below.</p>

        <form method="post" action="contact.php" class="space-y-4">
            <div>
                <label class="block text-gray-600">Name:</label>
                <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div>
                <label class="block text-gray-600">Email:</label>
                <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div>
                <label class="block text-gray-600">Message:</label>
                <textarea name="message" rows="5" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required></textarea>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Send Message</button>
        </form>

        <p class="text-center text-gray-500">Need immediate support? Call us at <a href="tel:+919876543210" class="text-blue-500 hover:underline">+91 98765 43210</a></p>
    </div>
</div>
<?php include("../includes/footer.php"); ?>
</body>

</html>
