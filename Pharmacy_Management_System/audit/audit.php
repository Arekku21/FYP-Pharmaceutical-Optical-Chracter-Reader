<?php
include "../menu/menu.php";
?>

<script>
        /* When the user clicks on the button, 
        toggle between hiding and showing the dropdown content */
            function myFunction() {
                document.getElementById("myDropdown").classList.toggle("show");
            }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                    for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                        if (openDropdown.classList.contains('show')) {
                            openDropdown.classList.remove('show');
                        }
                }
            }
        }
        </script>

// say page is out of access for non-admin users

<?php if($_SESSION['roleID'] != 1){ ?>
  <p style="font-size:28px;margin:300px;">
    This page is out of access for non-admin users.
  </p>

  <?php 
    } else {
  ?>

<html>
<head>
<style>

.dropbtn {
  background-color: #04AA6D;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

.dropbtn:hover, .dropbtn:focus {
  background-color: #3e8e41;
}

.dropdown {
  float: right;
  margin-right:1%;
  margin-top:5%;
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  overflow: auto;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  right: 0;
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}


    
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 70%;
  margin-left:20%;
  margin-top:5%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<div class="dropdown">
  <button onclick="myFunction()" class="dropbtn">Sort Logs</button>
  <div id="myDropdown" class="dropdown-content">

    <a href="audit.php?dir=role_asc">Role (Ascending)</a> 
    <a href="audit.php?dir=role_desc">Role (Descending)</a> 
    <a href="audit.php?dir=time_asc">TimeStamp (Ascending)</a> 
    <a href="audit.php?dir=time_desc">TimeStamp (Descending)</a> 
  </div>
</div>

<table>
  <thead>
    <th>User</th>
    <th>Date Stamp</th>
    <th>Activity</th>
    <th>User Role</th>
  </thead>
  

  <tbody>
    <?php 
    switch($_GET['dir'])
    {

        case "role_asc":
          $orderBy = " ORDER BY role ASC";
          break;
      
        case "role_desc":
          $orderBy = " ORDER BY role DESC";
          break;

        case "time_asc":
          $orderBy = " ORDER BY date ASC";
          break;

        case "time_desc":
          $orderBy = " ORDER BY date DESC";
          break;
        
        default:
          $orderBy = " ORDER BY role ASC";
          break;
      }
      
    $cmd = "SELECT * FROM logs" . $orderBy;
    $sql = mysqli_query($Links, $cmd);
      if(mysqli_num_rows($sql) > 0)
      {
          for($i = 0; $i < mysqli_num_rows($sql); $i++)
          {
              $row = mysqli_fetch_array($sql);
              echo '<tr>
              <td style="width: 20%;">'.$row["email"].'</td>
              <td style="width: 20%;">'.$row["date"].'</td>
              <td style="width: 20%;">'.$row["action"].'</td>
              ';

              if($_SESSION['roleID'] == 1){
                  echo'
                      <td style="width: 20%;">Admin</td>
                  ';
              }

              if($_SESSION['roleID'] == 2){
                  echo'
                      <td style="width: 20%;">Employee</td>
                  ';
              }

              if($_SESSION['roleID'] == 3){
                  echo'
                      <td style="width: 20%;">Pharmacist</td>
                  ';
              }
            }
        }
    ?>

  </tbody>

</table>

</body>
</html>

<?php 
}
?>