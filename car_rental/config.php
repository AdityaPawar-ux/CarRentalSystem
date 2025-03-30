<?php
// Database configuration
$host = "localhost";
$db_name = "car_rental";
$username = "root"; // Default username for XAMPP/WAMP
$password = "";     // Default password is empty in XAMPP/WAMP

// Create a database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully"; // Debugging purpose
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
