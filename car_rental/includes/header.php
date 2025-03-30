<?php
session_start();
?>
<nav class="bg-gray-500 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo Image -->
        <a href="../index.php">
            <img src="../assets/images/icon.png" alt="Car Rental Logo" class="h-10">
        </a>
        
        <ul class="flex space-x-6">
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <li><a href="../admin/dashboard.php" class="text-white hover:text-yellow-400">Dashboard</a></li>
                    <li><a href="../admin/view_users.php" class="text-white hover:text-yellow-400">View Users</a></li>
                    <li><a href="../admin/view_bookings.php" class="text-white hover:text-yellow-400">View Bookings</a></li>
                    <li><a href="../auth/logout.php" class="text-white hover:text-red-400">Logout</a></li>
                <?php elseif ($_SESSION['role'] === 'provider'): ?>
                    <li><a href="../provider/dashboard.php" class="text-white hover:text-yellow-400">Dashboard</a></li>
                    <li><a href="../provider/add_car.php" class="text-white hover:text-yellow-400">Add Car</a></li>
                    <li><a href="../provider/my_cars.php" class="text-white hover:text-yellow-400">My Cars</a></li>
                    <li><a href="../provider/manage_bookings.php" class="text-white hover:text-yellow-400">View Bookings</a></li>
                    <li><a href="../auth/logout.php" class="text-white hover:text-red-400">Logout</a></li>
                <?php elseif ($_SESSION['role'] === 'user'): ?>
                    <li><a href="../user/dashboard.php" class="text-white hover:text-yellow-400">Dashboard</a></li>
                    <li><a href="../user/rent_car.php" class="text-white hover:text-yellow-400">Rent a Car</a></li>
                    <li><a href="../user/my_bookings.php" class="text-white hover:text-yellow-400">My Bookings</a></li>
                    <li><a href="../auth/logout.php" class="text-white hover:text-red-400">Logout</a></li>
                <?php endif; ?>
            <?php else: ?>
                <li><a href="../index.php" class="text-white hover:text-yellow-400">Home</a></li>
                <li><a href="../about.php" class="text-white hover:text-yellow-400">About</a></li>
                <li><a href="../contact.php" class="text-white hover:text-yellow-400">Contact</a></li>
                <li><a href="../auth/login.php" class="text-white hover:text-green-400">Login</a></li>
                <li><a href="../auth/signup.php" class="text-white hover:text-green-400">Signup</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
