<?php
session_start();

// Clear all admin session variables
unset($_SESSION['admin_id']);
unset($_SESSION['admin_email']);
session_destroy();

// Redirect to admin login page
header("Location: admin_login.php");
exit();
?> 