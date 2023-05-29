<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
    <!-- <link href="../css/index.css" rel="stylesheet"/> -->
</head>

<body>
    <?php
    error_reporting(0);
    session_start();
    include "../db.php";
    include "sidemenu.php";

    include "header.php";

    // Your Login Page
    $login_page = "../login.php";

    echo "<script type='text/javascript'> console.log('Role: " .  $_SESSION['roleID'] . $log['action'] ."' ); </script>";

    // Check if user is logged in
    if($_SESSION['logged_in'] !== True)
    {
      // Redirect to Your Login Page to Prevent Unauthorized Access
      header("Location: $login_page");
    }
    ?>
</body>

</html>