<?php
    /*
    Log-Out
    */
    require ("../login.php");
    // Start the Session (Important!)
    session_start();

    // Your Login Page
    $login_page = "../login.php";
    // Destroy the session!

    $log = "User logged out";
    $role =   $_SESSION['roleID'];
    $email = $_SESSION['email'];
    $logger = "INSERT INTO logs(role, email, action) VALUES ('$role', '$email', '$log')";
    $result = mysqli_query($Links, $logger);

    session_destroy();

    // Finally, redirect your user to the log-in page in case they wanted to log-in again
    header("Location: $login_page");

?>