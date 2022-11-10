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
                $filename = $new_file[0].date('d-m-y_h:i:s').".".$imageFileType;
                rename($target_file, $filename);
                $insert_image = mysqli_query($Links, "INSERT INTO tblmedicine_image(image_path) VALUES('".$filename."')");
                echo "INSERT INTO tblmedicine(drug_image_id, drugName, scientificName, drugDosage, drugCategory, storageTemperature, no_of_unit_in_package, manufacturer, unitPrice, storageLocation) VALUES(".mysqli_insert_id($Links).", '".$_POST["name"]."', '".$_POST["scientificName"]."', ".$_POST["dosage"].", '".$_POST["category"]."', ".$_POST["temperature"].", ".$_POST["unit"].", '".$_POST["manufacturer"]."', ".$_POST["price"].", '".$_POST["location"]."')";
                $insert = mysqli_query($Links, "INSERT INTO tblmedicine(drug_image_id, drugName, scientificName, drugDosage, drugCategory, storageTemperature, no_of_unit_in_package, manufacturer, unitPrice, storageLocation) VALUES(".mysqli_insert_id($Links).", '".$_POST["name"]."', '".$_POST["scientificName"]."', ".$_POST["dosage"].", '".$_POST["category"]."', ".$_POST["temperature"].", ".$_POST["unit"].", '".$_POST["manufacturer"]."', ".$_POST["price"].", '".$_POST["location"]."')");
                if($insert_image && $insert)
                {
                    echo "Inserted";
                }
                
            }
            else 
            {
                echo "Fail to move image to server!";
            }
        }
    }
    ?>
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
  <input type="file" class="is-center input" name="image" style="width: 100%;" required/>
</div>


<div style="width: 100%;margin-top: 40px;">
  <input type="submit" class="button is-primary is-fullwidth" name="btnAdd" value="Add">
</div>
</form>
</div>
    </div>
  </div>
    </section>
</div>