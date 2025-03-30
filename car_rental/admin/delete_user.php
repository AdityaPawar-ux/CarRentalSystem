<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Validate and get user ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid user ID!";
    exit();
}

$user_id = intval($_GET['id']);

// Prevent admin from deleting themselves
if ($user_id == $_SESSION['user_id']) {
    echo "You cannot delete your own account!";
    exit();
}

try {
    // Delete the user (Contact queries will be deleted due to ON DELETE CASCADE)
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$user_id]);

    echo "User deleted successfully!";
    header("Location: view_users.php");
    exit();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
