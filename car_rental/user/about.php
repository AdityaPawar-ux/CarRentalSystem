<?php
// if ($_SESSION['role'] !== 'user') {
//     header("Location: ../auth/login.php");
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Us - Car Rental System</title>
  <link rel="stylesheet" href="assets/css/style.css" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
  <?php include '../includes/header.php'; ?>

  <div class="container mx-auto p-8">
    <h1 class="text-4xl font-bold mb-4">About Us</h1>
    <p class="text-gray-700 mb-6">Welcome to Car Rental System, your one-stop destination for renting your favorite cars at affordable prices. We offer a wide range of vehicles to suit all your travel needs.</p>

    <h2 class="text-2xl font-semibold mb-4">Why Choose Us?</h2>
    <ul class="list-disc ml-8 mb-6">
      <li>Wide range of vehicles from economy to luxury</li>
      <li>Competitive pricing with no hidden charges</li>
      <li>Easy booking process</li>
      <li>24/7 customer support</li>
    </ul>

    <h2 class="text-2xl font-semibold mb-4">Our Mission</h2>
    <p class="text-gray-700 mb-6">Our mission is to provide reliable, affordable, and quality car rental services to ensure you have the best travel experience possible.</p>

    <a href="contact.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Contact Us</a>
  </div>

  <?php include '../includes/footer.php'; ?>
</body>
</html>