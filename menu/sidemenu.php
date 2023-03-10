<!DOCTYPE html>
<html>
<head>

  <style>
  .menu-list {
      line-height: 530%;
      border-radius: 2px;
      color: white;
      display: block;
      padding: 5px;
    }

    .btn {
      color: #00000;
      background-color: #353935;
      border-radius: 33px;
      height: 66px;
      margin-top: 3px;
      align:center;
      padding-left:12px;
    }


    .middle {
        display: block;
        margin-left: 15%;
        margin-right: auto;
        width: 50%;
        margin-bottom:30px;
        margin-top:30px;
    }

    :active {
      color: black;
    }

    .freeze {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  /* background-color: rgba(0, 0, 0, 0.5); Change the color and opacity as needed */
  z-index: 9999;
}
  </style>
  <script>
  $(document).ready(function(){
    // $('body').addClass('freeze');
  });
  </script>
</head>

<body>
  <?php
// Start the session (Important!)

session_start();
error_reporting(0);
// Your Login Page

$login_page = "../login.php";



// Check if user is logged in

if($_SESSION['logged_in'] !== True){



// Redirect to Your Login Page to Prevent Unauthorized Access

header("Location: $login_page");
}
  ?>
  <div style="min-width: 270px; width: 15%; position: fixed; background-color: #000000; z-index: 1;">
  <!-- style="margin-left: 0%; margin-top: 30%; width: 100%;"  -->
    <aside class="menu" style="margin-left: 0%; margin-top: 10%; width: 123%;" >
        <img src="../image/logo.png" width="142" height="40" class="middle" >
        

  <!-- Pharmacist Dashboard -->
  <ul class="menu-list" style="width: 80%;">
    <li class="newclass :hover">
      <a class="btn" onMouseOver="this.style.color='black'" onMouseOut="this.style.color='white'" href="../menu/dashboard.php" style="color:white; text-align: left;"><span class="icon"><i class="fa fa-tachometer-alt fa-lg" style="margin-right: 7px;"></i></span> Dashboard</a>
    </li>
    <li class="newclass :hover">
      <a class="btn" onMouseOver="this.style.color='black'" onMouseOut="this.style.color='white'" href="../pos/pos.php" style="color:white; text-align: left"><span class="icon"><i class="fa fa-puzzle-piece fa-lg" style="margin-right: 7px;"></i></span> PoS</a>
    </li>
    <li class="newclass :hover">
      <a class="btn" onMouseOver="this.style.color='black'" onMouseOut="this.style.color='white'" href="../report/dailyReport.php" style="color:white; text-align: left"><span class="icon"><i class="fa fa-folder-open" style="margin-right: 7px;"></i></span> Sales Report</a>
    </li>
    <li class="newclass :hover">
      <a class="btn" onMouseOver="this.style.color='black'" onMouseOut="this.style.color='white'" href="../inventory/addInventory.php" style="color:white; text-align: left"><span class="icon"><i class="fab fa-y-combinator fa-lg " style="margin-right:7px;"></i></span> Inventory</a>
    </li>
    <li class="newclass :hover">
      <a class="btn" onMouseOver="this.style.color='black'" onMouseOut="this.style.color='white'" href="../employee/addEmployee.php" style="color:white; text-align: left"><span class="icon"><i class="fa fa-users" style="margin-right: 7px;"></i></span> Employee</a>
    </li>
    <!-- <li class="newclass :hover">
      <a class="btn" onMouseOver="this.style.color='black'" onMouseOut="this.style.color='white'" href="http://localhost:5000/index" style="color:white; text-align: left"><span class="icon"><i class="fa fa-camera" style="margin-right: 7px;"></i></span>Retraining Pipeline</a>
    </li> -->
    <li class="newclass :hover">
      <a class="btn" onMouseOver="this.style.color='black'" onMouseOut="this.style.color='white'" href="../retraining/retraining.php" style="color:white; text-align: left"><span class="icon"><i class="fa fa-camera" style="margin-right: 7px;"></i></span>Retraining Pipeline</a>
    </li>
  </ul>
  <br>

  </aside>
  </div>
</body>

</html>