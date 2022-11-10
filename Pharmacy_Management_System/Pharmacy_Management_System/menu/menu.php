<!DOCTYPE html>
<html>
<head>
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="https://www.gstatic.com/charts/loader.js"></script>
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
        <link rel="icon" type="image/x-icon" href="favicon.ico">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
        <link href="css/index.css" rel="stylesheet"/>
  <style>
  /* .menu-list {
      line-height: 530%;
      border-radius: 2px;
      color: hsl(0, 0%, 87%);
      display: block;
      padding: 10px;
      background-color: hsl(0, 0%, 29%);

    }

    .btn {
      color: hsl(0, 0%, 86%);
      background-color: hsl(0, 0%, 16%);
      border-radius: 3px;
      height: 88px;
    }

    .newclass :hover {
      background-color: HSL(171, 100%, 40%);
      color: hsl(0, 100%, 100%);
    }

    .cashierStyle {
      height: 135px;
      width: 208px;
      padding-top: 25px;
    }

    .assistantPharmacistStyle {
      height: 105px;
      width: 208px;
      padding-top: 12px;
    }

    :active {
      color: white;
    } */
  </style>
</head>

<body>
  <?php
  include "../db.php";
  include "header.php";
  include "sidemenu.php";
  ?>

  <!-- Assistant Pharmacist Dashboard -->
  <!-- <ul class="menu-list" style="width: 100%;" *ngIf="ApharmacistRole">
    <li class="newclass :hover">
      <a class="btn assistantPharmacistStyle" routerLink="/"><span class="icon" style="padding: 9px;"><i
            class="fa fa-tachometer-alt fa-lg" style="margin-right: 7px;"></i></span>Dashboard</a>
    </li>
    <li class="newclass :hover">
      <a class="btn assistantPharmacistStyle" routerLink="/doctororders"><span class="icon"><i
            class="fa fa-user-md fa-lg " style="margin-right: 7px;"></i></span>Doctor Orders</a>
    </li>
    <li class="newclass :hover">
      <a class="btn assistantPharmacistStyle" routerLink="/pos"><span class="icon"><i class="fa fa-puzzle-piece fa-lg"
            style="margin-right: 7px;"></i></span>PoS</a>
    </li>
    <li class="newclass :hover">
      <a class="btn assistantPharmacistStyle" routerLink="/suppliers"><span class="icon"><i class="fa fa-truck fa-lg"
            style="margin-right:7px;"></i></span>Suppliers</a>
    </li> -->
    <!-- <li class="newclass :hover" >
    <a class="btn" routerLink="/predictionreport"><span class="icon"><i class="fa fa-bar-chart-o fa-lg" style="margin-right: 7px;"></i></span>Prediction Report</a>
  </li> -->
    <!-- <li class="newclass :hover">
      <a class="btn assistantPharmacistStyle" routerLink="/salesreport"><span class="icon"><i
            class="fa fa-line-chart fa-lg" style="margin-right: 7px;"></i></span>Sales Report</a>
    </li>
    <li class="newclass :hover">
      <a class="btn assistantPharmacistStyle" routerLink="/inventory"><span class="icon"><i
            class="fab fa-y-combinator fa-lg " style="margin-right:7px;"></i></span>Inventory</a>
    </li>
    <li class="newclass :hover">
      <a class="btn assistantPharmacistStyle" routerLink="/expoutofstock"><span class="icon"><i
            class="fa fa-exclamation-triangle fa-lg" style="margin-right: 7px;"></i></span> Expired</a>
    </li>
    <li class="newclass :hover">
      <a class="btn assistantPharmacistStyle" routerLink="/outofstock"><span class="icon"><i
            class="fa fa-exclamation-triangle fa-lg" style="margin-right: 7px;"></i></span> Out of Stock</a>
    </li>
  </ul><br> -->


  <!-- Cashier Dashboard -->
  <!-- <ul class="menu-list" style="width: 100%;" *ngIf="CashierRole">
    <li class="newclass :hover">
      <a class="btn cashierStyle" routerLink="/"><span class="icon" style="padding: 9px;"><i
            class="fa fa-tachometer-alt fa-lg" style="margin-right: 7px;"></i></span>Dashboard</a>
    </li>
    <li class="newclass :hover">
      <a class="btn cashierStyle" routerLink="/doctororders"><span class="icon"><i class="fa fa-user-md fa-lg "
            style="margin-right: 7px;"></i></span>Doctor Orders</a>
    </li>
    <li class="newclass :hover">
      <a class="btn cashierStyle" routerLink="/pos"><span class="icon"><i class="fa fa-puzzle-piece fa-lg"
            style="margin-right: 7px;"></i></span>PoS</a>
    </li> -->
    <!-- <li class="newclass :hover" >
    <a class="btn" routerLink="/suppliers"><span class="icon"><i class="fa fa-truck fa-lg" style="margin-right:7px;"></i></span>Suppliers</a>
  </li> -->
    <!-- <li class="newclass :hover" >
    <a class="btn" routerLink="/predictionreport"><span class="icon"><i class="fa fa-bar-chart-o fa-lg" style="margin-right: 7px;"></i></span>Prediction Report</a>
  </li> -->
    <!-- <li class="newclass :hover" >
    <a class="btn" routerLink="/salesreport"><span class="icon"><i class="fa fa-line-chart fa-lg" style="margin-right: 7px;"></i></span>Sales Report</a>
  </li> -->
    <!-- <li class="newclass :hover">
      <a class="btn cashierStyle" routerLink="/inventory"><span class="icon"><i class="fab fa-y-combinator fa-lg "
            style="margin-right:7px;"></i></span>Inventory</a>
    </li>
    <li class="newclass :hover">
      <a class="btn cashierStyle" routerLink="/expoutofstock"><span class="icon"><i
            class="fa fa-exclamation-triangle fa-lg" style="margin-right: 7px;"></i></span> Expired</a>
    </li>
    <li class="newclass :hover">
      <a class="btn cashierStyle" routerLink="/outofstock"><span class="icon"><i
            class="fa fa-exclamation-triangle fa-lg" style="margin-right: 7px;"></i></span> Out of Stock</a>
    </li>
  </ul><br> -->


  <!-- <p class="menu-label" *ngIf="!userIsAuthenticated"
    style="color: azure; padding-top: 5%;padding-left: 5%;padding-right: 5%; text-align: center;">
    Some admin functionalities <br> may not be accessible
  </p> -->






</body>

</html>