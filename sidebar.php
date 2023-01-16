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
      background-color: #B00020;
    }

    .btn {
      color: #00000;
      background-color: #150050;
      border-radius: 33px;
      height: 66px;
      margin-top: 3px;
      align:center;
      padding-left:12px;
    }

    .newclass :hover {
      background-color: #150050;
      color: #6200EE;
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

  </style>
</head>

<body>
  <div style="min-width: 270px; width: 15%; position: fixed; background-color: #000000;">
  <!-- style="margin-left: 0%; margin-top: 30%; width: 100%;"  -->
    <aside class="menu" style="margin-left: 0%; margin-top: 10%; width: 123%;" >
        <img src="image/logo.png" width="142" height="40" class="middle" >
        

  <!-- Pharmacist Dashboard -->
  <ul class="menu-list" style="width: 80%;">

    <li class="newclass :hover">
      <a class="btn" routerLink="/" style="color:white;"><span class="icon"><i class="fa fa-tachometer-alt fa-lg" style="margin-right: 7px;"></i></span> Dashboard</a>
    </li>
    <li class="newclass :hover">
      <a class="btn" href="../doctororders/doctororders.php" style="color:white;"><span class="icon"><i class="fa fa-user-md fa-lg " style="margin-right: 7px;"></i></span> Doctor Orders</a>
    </li>
    <li class="newclass :hover">
      <a class="btn" href="../pos/pos.php" style="color:white;"><span class="icon"><i class="fa fa-puzzle-piece fa-lg" style="margin-right: 7px;"></i></span> PoS</a>
    </li>
    <li class="newclass :hover">
      <a class="btn" href="../report/salesreport.php" style="color:white;"><span class="icon"><i class="fa fa-folder-open" style="margin-right: 7px; color:white;"></i></span> Sales Report</a>
    </li>
    <li class="newclass :hover">
      <a class="btn" href="../inventory/addInventory.php" style="color:white;"><span class="icon"><i class="fab fa-y-combinator fa-lg " style="margin-right:7px;"></i></span> Inventory</a>
    </li>
    <li class="newclass :hover">
      <a class="btn" href="../expired/expired.php" style="color:white;"><span class="icon"><i class="fa fa-exclamation-triangle fa-lg" style="margin-right: 7px;"></i></span> Expired</a>
    </li>
    <li class="newclass :hover">
      <a class="btn" routerLink="/outofstock" style="color:white;"><span class="icon"><i class="fa fa-exclamation-triangle fa-lg" style="margin-right: 7px;"></i></span> Out of Stock</a>
    </li>
    <li class="newclass :hover">
      <a class="btn" routerLink="/outofstock" style="color:white;"><span class="icon"><i class="fa fa-users" style="margin-right: 7px; color: white;"></i></span> Employee</a>
    </li>
    <li class="newclass :hover">
      <a class="btn" routerLink="/outofstock" style="color:white;"><span class="icon"><i class="fa fa-camera" style="margin-right: 7px;"></i></span> POCR </a>
    </li>
  </ul><br>

  </aside>
  </div>
</body>

</html>