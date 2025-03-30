<?php
include '../config.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'provider') {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $model = htmlspecialchars(trim($_POST['model']));
    $brand = htmlspecialchars(trim($_POST['brand']));
    $price_per_day = floatval($_POST['price_per_day']);
    $provider_id = $_SESSION['user_id'];

    // Handle image upload
    $target_dir = "../assets/images/";
    $image_name = basename($_FILES["car_image"]["name"]);
    $target_file = $target_dir . $image_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is an actual image
    $check = getimagesize($_FILES["car_image"]["tmp_name"]);
    if ($check === false) {
        die("File is not an image.");
    }

    // Allow only certain image formats
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
        die("Only JPG, JPEG, and PNG files are allowed.");
    }

    // Move the uploaded file to the images directory
    if (move_uploaded_file($_FILES["car_image"]["tmp_name"], $target_file)) {
        // Insert car details into database
        $stmt = $pdo->prepare("INSERT INTO cars (provider_id, model, brand, price_per_day, image) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$provider_id, $model, $brand, $price_per_day, $image_name])) {
            echo "Car added successfully!";
        } else {
            echo "Error adding car.";
        }
    } else {
        echo "Error uploading image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add Car - Provider</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="bg-gray-100 min-h-screen flex items-center justify-center">
  <div class="bg-white shadow-lg rounded-lg p-8 max-w-lg w-full">
    <h2 class="text-3xl font-semibold text-center mb-6">Add a New Car</h2>
    <form method="post" enctype="multipart/form-data" class="space-y-4">
      <div>
        <label class="block text-gray-700 font-medium">Model</label>
        <input type="text" name="model" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300" required>
      </div>

      <div>
        <label class="block text-gray-700 font-medium">Brand</label>
        <input type="text" name="brand" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300" required>
      </div>

      <div>
        <label class="block text-gray-700 font-medium">Price Per Day (₹)</label>
        <input type="number" name="price_per_day" step="0.01" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300" required>
      </div>

      <div>
        <label class="block text-gray-700 font-medium">Upload Car Image</label>
        <input type="file" name="car_image" accept="image/*" class="w-full border rounded-lg p-2" required>
      </div>

      <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600">Add Car</button>
    </form>

    <div class="text-center mt-4">
      <a href="my_cars.php" class="text-blue-500 hover:underline">Manage My Cars</a>
    </div>
  </div>
</div>
</html>
