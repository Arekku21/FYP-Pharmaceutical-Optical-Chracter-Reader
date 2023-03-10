<?php
/*
Log-Out
*/

// Start the Session (Important!)
session_start();

// Your Login Page
$login_page = "../login.php";
// Destroy the session!
session_destroy();

// Finally, redirect your user to the log-in page in case they wanted to log-in again
header("Location: $login_page");
?>