<?php
$servername = "localhost";
$username = "username";
$password = "password";
$db_name = "dbpharmacy";

// Create connection
$conn = new mysqli($servername, $username, $password, $db_name);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
else{
    // echo "Connection successful";
}
?>