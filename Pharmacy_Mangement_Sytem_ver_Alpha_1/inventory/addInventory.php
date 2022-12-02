<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<link rel="stylesheet" type="text/css" href="../css/jquery_dataTables.css">
<script type="text/javascript" charset="utf8" src="../js/jquery_dataTables.js"></script>
<?php
include "../db.php";
?>
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
</style>
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
              <li class="is-active ">
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

    <section class="panel" style="margin-left: 19.8% ; margin-top: -30px; width: 82.3vw;">
    <?php
    if($_POST["btnAdd"])
    {
        chdir("../Medicine_Image");
        $target_file = basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false)
        {
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $_FILES["image"]["name"]))
            {
                $new_file = explode(".".$imageFileType, $target_file);
                $filename = $new_file[0].date('d-m-y_h_i_s').".".$imageFileType;
                rename($target_file, $filename);
                $insert_image = mysqli_query($Links, "INSERT INTO tblmedicine_image(image_path) VALUES('".$filename."')");
                $insert = mysqli_query($Links, "INSERT INTO tblmedicine(drug_image_id, drugName, scientificName, drugDosage, drugCategory, storageTemperature, no_of_unit_in_package, manufacturer, unitPrice, storageLocation) VALUES(".mysqli_insert_id($Links).", '".strtoupper(trim($_POST["name"]))."', '".strtoupper(trim($_POST["scientificName"]))."', ".trim($_POST["dosage"]).", '".strtoupper(trim($_POST["category"]))."', ".trim($_POST["temperature"]).", ".trim($_POST["unit"]).", '".strtoupper(trim($_POST["manufacturer"]))."', ".trim($_POST["price"]).", '".strtoupper(trim($_POST["location"]))."')");
                if($insert_image && $insert)
                {
                    echo "<script>alert('Drug Inserted success');</script>";
                }
                
            }
            else 
            {
                echo "Fail to move image to server!";
            }
        }
    }
    ?>
    <?php if($_SESSION['roleID'] == 1){ ?>
  <p class="panel-heading" style="background-color:hsl(0, 0%, 88%) ;color:hsl(0, 0%, 21%)">
    Add Inventory
  </p>
  <div class="panel-block" style="height: auto">
    <div  style="height: 900px; width: 87.5vw; padding: 2%;">

    <div style="overflow-y:auto ;overflow-x: hidden;height: 900px;">

<div class="spinner-box loadCenter">

<form method="post" enctype="multipart/form-data">

<div class="field">
  <label class="label" >DRUG MANUFACTURER</label>
  <input type="text" class="is-center input" name="manufacturer" style="width: 100%;" placeholder="Pharmaniage" required/>
</div>

<div class="field">
  <label class="label" >DRUG NAME</label>
  <input type="text" class="is-center input" name="name" style="width: 100%;" placeholder="Panadol" required/>
</div>

<div class="field">
  <label class="label" >SCIENTIFIC NAME</label>
  <input type="text" class="is-center input" name="scientificName" style="width: 100%;" placeholder="Panadol" required/>
</div>

<div class="field">
  <label class="label" >DRUG DOSAGE</label>
  <input type="number" class="is-center input" name="dosage" style="width: 100%;" placeholder="10" required/>
</div>

<div class="field">
  <label class="label">DRUG CATEGORY</label>
  <input type="text" class="is-center input" name="category" style="width: 100%;" placeholder="Antihistamines & Antiallergics" required/>
</div>

<div class="field">
  <label class="label">DRUG UNITS IN PACKAGE</label>
  <input type="number" class="is-center input" name="unit" style="width: 100%;" placeholder="100" required/>
</div>

<div class="field">
  <label class="label">DRUG PRICE(RM)</label>
  <input type="number" step="0.1" class="is-center input" name="price" style="width: 100%;" placeholder="30" required/>
</div>

<div class="field">
  <label class="label">STORAGE TEMPERATURE</label>
  <input type="number" step="0.1" class="is-center input" name="temperature" style="width: 100%;" placeholder="30" required/>
</div>

<div class="field">
  <label class="label">STORAGE LOCATION</label>
  <input type="text" class="is-center input" name="location" style="width: 100%;" placeholder="Room" required/>
</div>

<div class="field">
  <label class="label">DRUG IMAGE</label>
  <input type="file" class="is-center input" name="image" accept="image/*" style="width: 100%;" required/>
</div>


<div style="width: 100%;margin-top: 40px;">
  <input type="submit" class="button is-primary is-fullwidth" name="btnAdd" value="Add">
</div>
</form>
</div>
    </div>
  </div>
  <?php }
    else echo "No privilege to access this page"; ?>
    </section>
</div>