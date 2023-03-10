<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<link rel="stylesheet" type="text/css" href="../css/jquery_dataTables.css">
<script type="text/javascript" charset="utf8" src="../js/jquery_dataTables.js"></script>
<head>
<style>

  .menu-list{
    border-radius: 2px;
    width: 220%;
    display: block;
    padding: 10px;
    }
    .btn{
      width: 100%;
      color:hsl(0, 0%, 21%);
      background-color: hsl(0, 0%, 88%);
      border-radius: 3px;
    }
    .newclass :hover{
      background-color: hsl(0, 0%, 21%);
      color: hsl(0, 0%, 88%);
    }

    #img:hover{
      transform:scale(5.0);
    }

</style>
<script>
  $(document).ready( function () {
    $.noConflict(true);
    $('#drug_table').DataTable();

    $(".btnRemove").click(function(){
      var choice = confirm("Are you sure want to remove?");
      if(choice)
      {
        $.ajax({
          url: "../ajax/ajax.php",
          method: "POST", 
          data: {action: "deleteDrugStock", id: $(".btnRemove").attr("id")} ,
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
?>
<div class="container">
  <div style="margin-top: 0%; width:88%;">
    <div style="margin-top: 0.8%; height:900px;">
      <section class="section columns">
        <div class="column is-full-desktop is-full-mobile" style="margin-left: 18.5%; margin-top: 4%">
          <div class="tabs is-toggle is-fullwidth">
            <ul>
              <li >
                <a href="addInventory.php">
                  <span>Add new Inventory</span>
                </a>
              </li>

              <li>
                <a href="inventoryList.php">
                  <span>Inventory List</span>
                </a>
              </li>

              <li>
                <a href="outofstock.php">
                  <span>Out of Stock</span>
                </a>
              </li>

              <li>
                <a href="expiringSoon.php">
                  <span>Expire Soon</span>
                </a>
              </li>

              <li class="is-active ">
                <a href="expired.php">
                  <span>Expired Drugs</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </section>

    <section class="panel" style="margin-left: 19.8% ; margin-top: -30px; width: 96.5%;">
  <p class="panel-heading" style="background-color:hsl(0, 0%, 88%) ;color:hsl(0, 0%, 21%)">
    Drug List
  </p>
  <div class="panel-block" style="height: auto">
    <div  style="height: 660px; width: 87.5vw; padding: 0%;">
    <div style="overflow-y:auto ;overflow-x: hidden;height: 500px;">
  <table class="table is-ful"  >
    <tbody>

      <div class="spinner-box loadCenter is-center">
      </div>
        <tr  >
                <table id="drug_table" class="table is-full" style="width: 100%;">
                  <thead style="font-weight: bold;">
                    <td>BATCH NO</td>
                    <td>DRUG MANUFACTURER</td>
                    <td>DRUG NAME</td>
                    <td>MANUFACTURER DATE</td>
                    <td>EXPIRY DATE</td>
                    <td >DRUG IMAGE</td>
                    <td></td>

                  </thead>
                  <tbody>
                  <?php 
                  $sql = mysqli_query($Links, "SELECT * FROM tblmedicine, tblstored_drug WHERE tblmedicine.DrugID = tblstored_drug.DrugID AND tblstored_drug.expiryDate < '".date('Y-m-d')."'");
                  if(mysqli_num_rows($sql) > 0)
                  {
                    for($i = 0; $i < mysqli_num_rows($sql); $i++)
                    {
                      $row = mysqli_fetch_array($sql);
                      echo '<tr>
                      <td style="width: 20%;">'.$row["batchNo"].'</td>
                      <td style="width: 20%;">'.ucwords(strtolower($row["manufacturer"])).'</td>
                      <td style="width: 20%;">'.ucwords(strtolower($row["drugName"])).'</td>
                      <td style="width: 20%;">'.$row["manufacturerDate"].'</td>
                      <td style="width: 20%;">'.$row["expiryDate"].'</td>
                      <td style="width: 20%;">';
                      $get_image = mysqli_query($Links, "SELECT * FROM tblmedicine_image WHERE drug_image_id = ".$row["drug_image_id"]."");
                      if(mysqli_num_rows($get_image) > 0)
                      {
                        $row2 = mysqli_fetch_array($get_image);
                        echo '<img id="img" src="../Medicine_Image/'.$row2["image_path"].' ">';
                      }
                      echo '</td>
                      <td class="level-right">
                        <button class="btnRemove button is-small is-danger" style="font-weight: bold;" id="'.$row["batchNo"].'">Delete</button>
                      </td>
                      </tr>
                      ';
                    }
                  }
                  ?>
                  </tbody>
                </table>
          <br>
        </tr>
      </div>
    </tbody>
  </table>
  </div>
    </div>
  </div>
    </section>
</div>