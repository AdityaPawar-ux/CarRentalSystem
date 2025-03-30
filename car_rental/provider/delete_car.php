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

// Check if the car belongs to the provider
$stmt = $pdo->prepare("SELECT image FROM cars WHERE id = ? AND provider_id = ?");
$stmt->execute([$car_id, $provider_id]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$car) {
    echo "Car not found.";
    exit();
}

// Delete the car image if it exists
if (!empty($car['image']) && file_exists("../assets/images/" . $car['image'])) {
    unlink("../assets/images/" . $car['image']);
}

// Delete car from database
$stmt = $pdo->prepare("DELETE FROM cars WHERE id = ? AND provider_id = ?");
if ($stmt->execute([$car_id, $provider_id])) {
    echo "Car deleted successfully!";
} else {
    echo "Error deleting car.";
}

header("refresh:2;url=my_cars.php");
?>
