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
<?php
include "../menu/menu.php";
?>
<script>
  $(document).ready( function () {
    $.noConflict(true);
    $('#drug_table').DataTable();

    $(".btnShowEdit").click(function(){
      var id = $(this).attr("id");
      $.ajax({
        url: "../ajax/ajax.php",
        method: "POST", 
        data: {action: "showEditModal", id: id},
        success: function(result){
          $(".btnEditDrug").attr("id", id);
          result = JSON.parse(result);
          $("[name=name]").val(result[1]);
          $("[name=manufacturer]").val(result[0]);
          $("[name=scientificName]").val(result[2]);
          $("[name=dosage]").val(result[3]);
          $("[name=category]").val(result[4]);
          $("[name=unit]").val(result[6]);
          $("[name=price]").val(result[7]);
          $("[name=temperature]").val(result[5]);
          $("[name=location]").val(result[8]);
          $(".showImg").attr("src", "../Medicine_Image/" + result[9]);
        }
      });
    });

    $(".btnEditDrug").click(function(){
      var id = $(this).attr("id");
      var file_data = $('#image').prop('files')[0]; 
      var form_data = new FormData();
      form_data.append('image', file_data);
      form_data.append('manufacturer', $(".manufacturer").val());
      form_data.append('name', $(".name").val());
      form_data.append('scientificName', $(".scientificName").val());
      form_data.append('dosage', $(".dosage").val());
      form_data.append('category', $(".category").val());
      form_data.append('unit', $(".unit").val());
      form_data.append('price', $(".price").val());
      form_data.append('temperature', $(".temperature").val());
      form_data.append('location', $(".location").val());
      form_data.append('action', 'editDrug');
      form_data.append('id', id);
      $.ajax({
        url: "../ajax/ajax.php",
        method: "POST",
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        success: function(result){
          alert(result);
        }
      });
    });

    $(".btnRemoveDrug").click(function(){
      var id = $(this).attr("id");
      var choice = confirm("Are you sure want to remove?");
      if(choice)
      {
        $.ajax({
          url: "../ajax/ajax.php",
          method: "POST",
          data: {action: "deleteDrug", id: id},
          success: function(result){
            alert(result);
            location.reload();
          }
        });
      }
    });


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
          $("#stockForm")[0].reset();
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
          //remove button in table
          $(".btnRemove2").click(function(){
            var choice = confirm("Are you sure want to remove?");
            if(choice)
            {
              $.ajax({
                url: "../ajax/ajax.php",
                method: "POST", 
                data: {action: "remove2", id: $(".btnRemove2").attr("id")} ,
                success: function(result){
                  alert(result);
                  location.reload();
                }
              });
            }
          });
        }
      });
    });

    //remove button in table
    $(".btnRemove").click(function(){
      $.ajax({
        url: "../ajax/ajax.php",
        method: "POST", 
        data: {action: "getDrugInfo", id: $(this).val()},
        success: function(result){
          result = JSON.parse(result);
          $("#drugInfo").text(result[0] + " - " + result[1]);
        }
      });
    });
  });
</script>
</head>
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

              <li class="is-active ">
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
                  <span>Expiring Soon</span>
                </a>
              </li>

              <li>
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
    Inventory List
  </p>
  <div class="panel-block" style="height: auto">
    <div  style="height: 660px; width:96.5%; padding: 0%;">
    <div style="overflow-y:auto ;overflow-x: hidden;height: 500px;">
  <table class="table is-full"  >
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
                    <?php if($_SESSION['roleID'] == 1 || $_SESSION['roleID'] == 2){ ?>
                    <td></td>
                    <?php } ?>
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
                      <td style="width: 20%;">'.ucwords(strtolower($row["manufacturer"])).'</td>
                      <td style="width: 20%;">'.ucwords(strtolower($row["drugName"])).'</td>
                      <td style="width: 20%;">'.$row["drugDosage"].'</td>
                      <td style="width: 20%;">'.ucwords(strtolower($row["drugCategory"])).'</td>
                      <td style="width: 20%;">'.$row["no_of_unit_in_package"].'</td>
                      <td style="width: 20%;">'.$row["unitPrice"].'</td>
                      <td style="width: 20%;">';
                      $get_image = mysqli_query($Links, "SELECT * FROM tblmedicine_image WHERE drug_image_id = ".$row["drug_image_id"]."");
                      if(mysqli_num_rows($get_image) > 0)
                      {
                        $row2 = mysqli_fetch_array($get_image);
                        echo '<img id="img" src="../Medicine_Image/'.$row2["image_path"].' ">';
                      }
                      if($_SESSION['roleID'] == 1 || $_SESSION['roleID'] == 2)
                      { 
                        echo '</td>
                        <td class="level-right">
                          <button class="btnShowEdit button is-small is-primary" id="'.$row["DrugID"].'" style="font-weight: bold;margin-right: 1%;" type="button" data-toggle="modal" data-backdrop="false" data-target="#editModal">Edit Drug</button>
                          <button class="btnRemoveDrug button is-small is-danger" id="'.$row["DrugID"].'" style="font-weight: bold;">Delete Drug</button>
                          <button value="'.$row["DrugID"].'" class="btnAdd button is-small is-info" style="font-weight: bold;margin-right: 1%;" type="button" data-toggle="modal" data-backdrop="false" data-target="#exampleModalLong">Add Stock</button>
                        <button class="btnRemove button is-small is-warning" value="'.$row["DrugID"].'" style="font-weight: bold;" type="button" data-toggle="modal" data-backdrop="false" data-target="#removeModal">Remove Stock</button>
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
        </tr>
      </div>
    </tbody>
  </table>
  </div>
    </div>
  </div>
    </section>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModal">Edit Drug</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" enctype="multipart/form-data">

          <div class="field">
            <label class="label" >DRUG MANUFACTURER</label>
            <input type="text" class="manufacturer is-center input" name="manufacturer" style="width: 100%;" required/>
          </div>

          <div class="field">
            <label class="label" >DRUG NAME</label>
            <input type="text" class="name is-center input" name="name" style="width: 100%;"required/>
          </div>

          <div class="field">
            <label class="label" >SCIENTIFIC NAME</label>
            <input type="text" class="scientificName is-center input" name="scientificName" style="width: 100%;" required/>
          </div>

          <div class="field">
            <label class="label" >DRUG DOSAGE</label>
            <input type="number" class="dosage is-center input" name="dosage" style="width: 100%;" required/>
          </div>

          <div class="field">
            <label class="label">DRUG CATEGORY</label>
            <input type="text" class="category is-center input" name="category" style="width: 100%;" required/>
          </div>

          <div class="field">
            <label class="label">DRUG UNITS IN PACKAGE</label>
            <input type="number" class="unit is-center input" name="unit" style="width: 100%;" required/>
          </div>

          <div class="field">
            <label class="label">DRUG PRICE(RM)</label>
            <input type="number" step="0.1" class="price is-center input" name="price" style="width: 100%;" required/>
          </div>

          <div class="field">
            <label class="label">STORAGE TEMPERATURE</label>
            <input type="number" step="0.1" class="temperature is-center input" name="temperature" style="width: 100%;" required/>
          </div>

          <div class="field">
            <label class="label">STORAGE LOCATION</label>
            <input type="text" class="location is-center input" name="location" style="width: 100%;" required/>
          </div>

          <div class="field">
            <label class="label">DRUG IMAGE</label>
            <div style="text-align:center;"><img class="showImg" accept="image/*" style="width: 200px;"/></div><br>
            <input type="file" class="is-center input" name="image" id="image" style="width: 100%;"/>
          </div>

          <div style="width: 100%;margin-top: 40px;">
            <input type="submit" class="btnEditDrug button is-primary is-fullwidth" name="btnEditDrug" value="Edit">
          </div>
        </form>
      </div>
    </div>
  </div>
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
      <form id="stockForm">
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
        <h5 class="modal-title" id="removeModal">Remove stock <b>(<span id="drugInfo"></span>)</b></h5>
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