<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<link rel="stylesheet" type="text/css" href="../css/jquery_dataTables.css">
<script type="text/javascript" charset="utf8" src="../js/jquery_dataTables.js"></script>
<head>
<script>
  $(document).ready( function () {
    $.noConflict(true);
    $('#archive_table').DataTable();

    $(".btnRemove").click(function(){
      var choice = confirm("Are you sure want to remove from archive?");
      if(choice)
      {
        $.ajax({
          url: "../ajax/ajax.php",
          method: "POST", 
          data: {action: "unarchiveUser", id: $(".btnRemove").attr("id")} ,
          success: function(result){
            alert(result);
            location.reload();
          }
        });
      }
    });
  });

</script>
</head>
<?php
include "../menu/menu.php";
echo "<script type='text/javascript'> console.log('Role ID: " .  $_SESSION['roleID'] . "' ); </script>";
?>
<div class="container">
<div style="margin-top: 0%; width:88%;">
    <div style="margin-top: 0.8%; height:900px;">
      <section class="section columns">
        <div class="column is-full-desktop is-full-mobile" style="margin-left: 18.5%; margin-top: 4%">
          <div class="tabs is-toggle is-fullwidth">
            <ul>
              <li>
                <a href="emp.php">
                  <span>Employees</span>
                </a>
              </li>
              <li>
                <a href="pharma.php">
                  <span>Pharmacists</span>
                </a>
              </li>
              <li class="is-active">
                <a href="inactive.php">
                  <span>Inactive Users</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </section>

      
<section class="panel" style="margin-left: 19.8% ; margin-top: -30px; width: 96.5%;">
<?php if($_SESSION['roleID'] == 1 || $_SESSION["roleID"] == 2){ ?>
  <p class="panel-heading" style="background-color:hsl(0, 0%, 88%) ;color:hsl(0, 0%, 21%)">
  Pharmacist List
  </p>
  <div class="panel-block" style="height: auto">
    <div  style="height: 660px; width: 87.5vw; padding: 0%;">
    <div style="overflow-y:auto ;overflow-x: hidden;height: 500px;">
                <table id="archive_table" class="table is-full" style="width: 100%;">
                  <thead style="font-weight: bold;">
                    <td> ID</td>
                    <td> NAME</td>
                    <td> EMAIL</td>
                    <td>DATE JOINED</td>
                    <td>SALARY (RM)</td>
                    <td>ROLE</td>
                    <td></td>
                  </thead>

                  <tbody>
                  <?php 
                  $sql = mysqli_query($Links, "SELECT * FROM user WHERE roleID!=1 AND status='1'");
                  if(mysqli_num_rows($sql) > 0)
                  {
                    for($i = 0; $i < mysqli_num_rows($sql); $i++)
                    {
                      $row = mysqli_fetch_array($sql);
                      echo '<tr>
                      <td style="width: 20%;">'.$row["id"].'</td>
                      <td style="width: 20%;">'.$row["Name"].'</td>
                      <td style="width: 20%;">'.$row["Email"].'</td>
                      <td style="width: 20%;">'.$row["Date_joined"].'</td>
                      <td style="width: 20%;">'.$row["Salary"].'</td>
                      <td style="width: 20%;">'.$row["job"].'</td>';
                      if($_SESSION['roleID'] == 1){
                        echo'
                        <td class="level-right">
                          <button class="btnRemove button is-small is-danger" style="font-weight: bold;" id="'.$row["id"].'">Re-activate</button></nobr>
                        </td>
                        </tr>
                        ';
                      }
                    }
                  }
                  ?>
                  </tbody>
                </table>
          <br>
      </div>
  </div>
    </div>
  </div>
    </section>
</div>


  <?php }
  else echo "No privilege to access this page"; ?>
</div>
