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
  });
</script>
</head>
<?php
include "../menu/menu.php";
?>
<div >
  <div style="margin-top: 0%; width:85vw;">
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

              <li class="is-active ">
                <a href="inventoryList.php">
                  <!-- <span class="icon is-small"><i class="fas fa-music" aria-hidden="true"></i></span> -->
                  <span>Inventory List</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </section>

    <section class="panel" style="margin-left: 19.8% ; margin-top: -30px; width: 82.3vw;">
  <p class="panel-heading" style="background-color:hsl(0, 0%, 88%) ;color:hsl(0, 0%, 21%)">
    Inventory List
  </p>
  <div class="panel-block" style="height: auto">
    <div  style="height: 660px; width: 87.5vw; padding: 0%;">
    <div style="overflow-y:auto ;overflow-x: hidden;height: 500px;">
  <table class="table is-full menu-list"  >
    <tbody>

      <div class="spinner-box loadCenter is-center">
      </div>
        <tr  >
                <table id="drug_table" class="table is-full" style="width: 100%;">
                  <thead style="font-weight: bold;">
                    <td>DRUG MANUFACTURER</td>
                    <td>DRUG NAME</td>
                    <td >DRUG DOSAGE</td>
                    <td >DRUG CATEGORY</td>
                    <td >DRUG UNITS IN PACKAGE</td>
                    <td >DRUG PRICE(RM)</td>
                    <td >DRUG IMAGE</td>
                    <td></td>

                  </thead>
                  <tbody>
                  <?php 
                  $sql = mysqli_query($Links, "SELECT * FROM tblmedicine");
                  if(mysqli_num_rows($sql) > 0)
                  {
                    for($i = 0; $i < mysqli_num_rows($sql); $i++)
                    {
                      $row = mysqli_fetch_array($sql);
                      echo '<tr>
                      <td style="width: 20%;">'.$row["manufacturer"].'</td>
                      <td style="width: 20%;">'.$row["drugName"].'</td>
                      <td style="width: 20%;">'.$row["drugDosage"].'</td>
                      <td style="width: 20%;">'.$row["drugCategory"].'</td>
                      <td style="width: 20%;">'.$row["no_of_unit_in_package"].'</td>
                      <td style="width: 20%;">'.$row["unitPrice"].'</td>
                      <td style="width: 20%;">';
                      $get_image = mysqli_query($Links, "SELECT * FROM tblmedicine_image WHERE drug_image_id = ".$row["drug_image_id"]."");
                      if(mysqli_num_rows($get_image) > 0)
                      {
                        $row2 = mysqli_fetch_array($get_image);
                        echo '<img id="img" src="../Medicine_Image/'.$row2["image_path"].' ">';
                      }
                      echo '</td>
                      <td class="level-right">
                        <nobr><button class="button is-small is-primary" style="font-weight: bold;margin-right: 1%;">Edit </button>
                        <button class="button is-small is-danger" style="font-weight: bold;" (click)="onDelete(supplier.id)" >Delete</button></nobr>
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