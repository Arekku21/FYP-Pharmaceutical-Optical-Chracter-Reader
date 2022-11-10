<?php
// session_start();
error_reporting(0);
date_default_timezone_set("Asia/Kuala_Lumpur");
$Links = mysqli_connect("localhost", "username", "password") or die(mysqli_error());
if($Links)
{
    mysqli_select_db($Links, "dbpharmacy");
}
else echo "Unable to connect to databse";
?>