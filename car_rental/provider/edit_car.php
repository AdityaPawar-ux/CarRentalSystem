<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'provider') {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "Invalid car ID.";
    exit();
}

$car_id = intval($_GET['id']);
$provider_id = $_SESSION['user_id'];

// Fetch car details
$stmt = $pdo->prepare("SELECT * FROM cars WHERE id = ? AND provider_id = ?");
$stmt->execute([$car_id, $provider_id]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$car) {
    echo "Car not found.";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $model = htmlspecialchars(trim($_POST['model']));
    $brand = htmlspecialchars(trim($_POST['brand']));
    $price_per_day = floatval($_POST['price_per_day']);
    $status = $_POST['status'];

    // Check if a new image is uploaded
    if ($_FILES['car_image']['name']) {
        $target_dir = "../assets/images/";
        $image_name = basename($_FILES["car_image"]["name"]);
        $target_file = $target_dir . $image_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate image
        $check = getimagesize($_FILES["car_image"]["tmp_name"]);
        if ($check === false) {
            die("File is not an image.");
        }
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
            die("Only JPG, JPEG, and PNG files are allowed.");
        }

        // Upload new image
        if (move_uploaded_file($_FILES["car_image"]["tmp_name"], $target_file)) {
            $stmt = $pdo->prepare("UPDATE cars SET model = ?, brand = ?, price_per_day = ?, status = ?, image = ? WHERE id = ?");
            $stmt->execute([$model, $brand, $price_per_day, $status, $image_name, $car_id]);
        } else {
            echo "Error uploading image.";
            exit();
        }
    } else {
        // Update without changing the image
        $stmt = $pdo->prepare("UPDATE cars SET model = ?, brand = ?, price_per_day = ?, status = ? WHERE id = ?");
        $stmt->execute([$model, $brand, $price_per_day, $status, $car_id]);
    }
    echo "Car details updated successfully!";
    header("refresh:2;url=my_cars.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Car - Provider</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Edit Car Details</h2>
    <form method="post" enctype="multipart/form-data">
        <label>Model:</label>
        <input type="text" name="model" value="<?php echo htmlspecialchars($car['model']); ?>" required><br>

        <label>Brand:</label>
        <input type="text" name="brand" value="<?php echo htmlspecialchars($car['brand']); ?>" required><br>

        <label>Price Per Day (₹):</label>
        <input type="number" name="price_per_day" step="0.01" value="<?php echo htmlspecialchars($car['price_per_day']); ?>" required><br>

        <label>Status:</label>
        <select name="status">
            <option value="available" <?php echo $car['status'] === 'available' ? 'selected' : ''; ?>>Available</option>
            <option value="booked" <?php echo $car['status'] === 'booked' ? 'selected' : ''; ?>>Booked</option>
        </select><br>

        <label>Upload New Image (Optional):</label>
        <input type="file" name="car_image" accept="image/*"><br>

        <button type="submit">Update Car</button>
    </form>
    <a href="my_cars.php">Back to My Cars</a>
</body>
</html>
