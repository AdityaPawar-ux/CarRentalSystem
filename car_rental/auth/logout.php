<?php
session_start();
session_destroy(); // Destroy all sessions
header("Location: ../auth/login.php"); // Redirect to login
exit();
?>