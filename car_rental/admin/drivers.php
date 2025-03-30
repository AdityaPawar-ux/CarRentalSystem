<?php
session_start();
include '../config.php'; // Include database connection

// Handle Add Driver
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_driver'])) {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));

    // Check if email already exists
    $checkEmail = $pdo->prepare("SELECT * FROM drivers WHERE email = ?");
    $checkEmail->execute([$email]);

    if ($checkEmail->rowCount() > 0) {
        echo "<script>alert('Driver email already exists!');</script>";
    } else {
        // Insert new driver
        $stmt = $pdo->prepare("INSERT INTO drivers (name, email, phone) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $email, $phone])) {
            echo "<script>alert('Driver added successfully!'); window.location.href='drivers.php';</script>";
        } else {
            echo "<script>alert('Error adding driver.');</script>";
        }
    }
}

// Handle Delete Driver
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM drivers WHERE id = ?");
    if ($stmt->execute([$delete_id])) {
        echo "<script>alert('Driver deleted successfully!'); window.location.href='drivers.php';</script>";
    } else {
        echo "<script>alert('Error deleting driver.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Drivers - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: auto;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
            text-align: center;
            padding: 8px;
        }
        th {
            background: #333;
            color: white;
        }
        .btn {
            padding: 5px 10px;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-delete {
            background: red;
        }
        .btn-add {
            background: green;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Manage Drivers</h2>

    <!-- Add Driver Form -->
    <form method="post" action="">
        <input type="text" name="name" placeholder="Driver Name" required>
        <input type="email" name="email" placeholder="Driver Email" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <button type="submit" name="add_driver" class="btn btn-add">Add Driver</button>
    </form>

    <!-- Driver List Table -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch all drivers from the database
            $stmt = $pdo->prepare("SELECT * FROM drivers ORDER BY id DESC");
            $stmt->execute();
            $drivers = $stmt->fetchAll();

            foreach ($drivers as $driver) {
                echo "<tr>
                        <td>{$driver['id']}</td>
                        <td>{$driver['name']}</td>
                        <td>{$driver['email']}</td>
                        <td>{$driver['phone']}</td>
                        <td>
                            <a href='drivers.php?delete_id={$driver['id']}' class='btn btn-delete' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
