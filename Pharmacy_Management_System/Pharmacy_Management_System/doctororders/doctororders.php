<head>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <link rel="stylesheet" type="text/css" href="../css/jquery_dataTables.css">
  <script type="text/javascript" charset="utf8" src="../js/jquery_dataTables.js"></script>
<style>
.bootstrap-wrapper {font-family:sans-serif;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}

.menu-list{
  border-radius: 2px;
  width: 100%;
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

  .img:hover{
      transform:scale(5.0);
    }

</style>
<script>
  $(document).ready( function () {
    $.noConflict(true);
    $('#drug_table').DataTable();

    //add button in table
    $(".btnAdd").click(function(){
      var id = $(this).val();
      $.ajax({
        url: "../ajax/ajax.php",
        method: "POST", 
        data: {action: "addStock", id: $(this).val()},
        success: function(result){
          result = JSON.parse(result);
          $("#drugID").val(id);
          $("#drugName").val(result[0]);
          $("#drugManufacturer").val(result[1]);
          $("#drugImage").attr("src", "../Medicine_Image/" + result[2]);
        }
      });
    });

    //add button in modal
    $(".btnAdd2").click(function(){
      $.ajax({
        url: "../ajax/ajax.php",
        method: "POST", 
        data: $('form').serialize() + '&action=addStock2',
        success: function(result){
          alert(result);
          $("form")[0].reset();
        }
      });
    });

    //remove button in table
    $(".btnRemove").click(function(){
      $.ajax({
        url: "../ajax/ajax.php",
        method: "POST", 
        data: {action: "remove", id: $(this).val()},
        success: function(result){
          $(".tblDrug > tbody").html("");
          $(".tblDrug").find("tbody").append(result);
        }
      });
    });

  });
</script>
</head>
<?php
      include "../menu/menu.php";
      ?>
        <div style="margin-top: 0%; width:85vw;">
            <div>
              <div style="margin-top: 0.8%; height:900px;">
                <section class="section columns">
                  <div class="column is-full-desktop is-full-mobile" style="margin-left: 18.5%; margin-top: 4%">
                    <!-- <app-search-supplier-window></app-search-supplier-window> -->
                    <div class="tabs is-toggle is-fullwidth">
                      <ul>
                        <li class="is-active ">
                          <a href="doctororders.php">
                            <!-- <span class="icon is-small"><i class="fas fa-music" aria-hidden="true"></i></span> -->
                            <span>New Orders</span>
                          </a>
                        </li>
                        <li >
                          <a href="verifyorder.php">
                            <!-- <span class="icon is-small"><i class="fas fa-image" aria-hidden="true"></i></span> -->
                            <span>Verified Orders</span>
                          </a>
                        </li>
                        <li>
                          <a href="pickeduporder.php">
                            <!-- <span class="icon is-small"><i class="fas fa-music" aria-hidden="true"></i></span> -->
                            <span>Picked Up Orders</span>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </section>
                <section class="panel" style="margin-left: 19.8% ; margin-top: -30px; width: 82.3vw;">
  <p class="panel-heading" style="background-color:hsl(0, 0%, 88%) ;color:hsl(0, 0%, 21%)">
    Add new stock
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
                      echo '<img class="img" src="../Medicine_Image/'.$row2["image_path"].' ">';
                    }
                    echo '</td>
                    <td class="level-right">
                      <nobr><button value="'.$row["DrugID"].'" class="btnAdd button is-small is-primary" style="font-weight: bold;margin-right: 1%;" type="button" data-toggle="modal" data-backdrop="false" data-target="#exampleModalLong">Add </button>
                      <button class="btnRemove button is-small is-danger" value="'.$row["DrugID"].'" style="font-weight: bold;" type="button" data-toggle="modal" data-backdrop="false" data-target="#removeModal">Remove</button></nobr>
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


<!-- Add Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add new stock</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form>
        <input type="hidden" name="drugID" id="drugID">
        <div class="field">
          <label class="label" >DRUG IMAGE</label>
          <img src='' id="drugImage" width="200px" height="200px">
        </div>

        <div class="field">
          <label class="label" >DRUG NAME</label>
          <input type="text" class="is-center input" id="drugName" style="width: 100%; cursor:not-allowed;" readonly/>
        </div>

        <div class="field">
          <label class="label" >DRUG MANUFACTURER</label>
          <input type="text" class="is-center input" id="drugManufacturer" style="width: 100%;cursor:not-allowed;" readonly/>
        </div>

        <div class="field">
          <label class="label" >BATCH NO</label>
          <input type="text" class="is-center input" name="batchNo" style="width: 100%;" placeholder="307002" required/>
        </div>

        <div class="field">
          <label class="label" >DRUG MANUFACTURER DATE</label>
          <input type="date" class="is-center input" name="manufacturerDate" style="width: 100%;" required/>
        </div>

        <div class="field">
          <label class="label" >DRUG EXPIRY DATE</label>
          <input type="date" class="is-center input" name="expiryDate" style="width: 100%;" required/>
        </div>

        <div class="field">
          <label class="label" >QUANTITY</label>
          <input type="number" step="1" class="is-center input" name="quantity" style="width: 100%;" placeholder="100" required/>
        </div>
      </form>
      </div>
      <div class="modal-footer" style="text-align:center;">
          <button class="btnAdd2 button is-primary" style="font-weight: bold;margin-right: 1%;" type="submit" data-toggle="modal" data-backdrop="false" data-target="#exampleModalLong">Add </button>
      </div>
    </div>
  </div>
</div>

<!-- Remove Modal -->
<div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="removeModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="removeModal">Remove stock</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="drugTable">
      <table id="drug_table" class="tblDrug table is-full" style="width: 100%;">
        <thead style="font-weight: bold;">
          <td>BATCH NO</td>
          <td>MANUFACTURER DATE</td>
          <td >EXPIRY DATE</td>
          <td >QUANTITY</td>
          <td></td>

        </thead>
        <tbody>
          <div id="tr_row"></div>
        </tbody>
      </table>
      </div>
    </div>
  </div>
</div>